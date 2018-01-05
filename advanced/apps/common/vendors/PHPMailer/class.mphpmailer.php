<?php if ( ! defined('MW_PATH')) exit('No direct script access allowed');

if (!class_exists('PHPMailer', false)) {
    require_once dirname(__FILE__) . '/class.phpmailer.php';
} 

class MPHPMailer extends PHPMailer
{
    protected $_logData = array();

    /**
     * MPHPMailer::addLog()
     * 
     * @param mixed $log
     * @return
     */
    public function addLog($log)
    {
        if (is_array($log)) {
            foreach ($log as $l) {
                $this->addLog($l);
            }
            return $this;
        }
        $this->_logData[] = $log;
        return $this;
    }
    
    /**
     * MPHPMailer::getLogs()
     * 
     * @param bool $clear
     * @return
     */
    public function getLogs($clear = true)
    {
        // maybe this gets too verbose ?
        if (is_object($this->smtp) && count($this->smtp->getLogs(false)) > 0) {
            $this->addLog($this->smtp->getLogs());
        }
            
        $logs = $this->_logData = array_unique($this->_logData);
        
        if ($clear) {
            $this->clearLogs();
        }
        
        return $logs;
    }
    
    /**
     * MPHPMailer::getLog()
     * 
     * @param string $glue
     * @param bool $clear
     * @return
     */
    public function getLog($glue = "\n", $clear = true)
    {
        return implode($glue, $this->getLogs($clear));
    }
    
    /**
     * MPHPMailer::clearLogs()
     * 
     * @return
     */
    public function clearLogs()
    {
        $this->_logData = array();
        if (is_object($this->smtp)) {
            $this->smtp->clearLogs();
        }
        return $this;
    }
    
    /**
     * PHPMailer::edebug()
     * Override parent implementation
     * 
     * Output debugging info via user-defined method.
     * Only if debug output is enabled.
     * @see PHPMailer::$Debugoutput
     * @see PHPMailer::$SMTPDebug
     * @param string $str
     */
    protected function edebug($str)
    {
        if (!$this->SMTPDebug) {
            return;
        }
        
        if ($this->Debugoutput == 'logger') {
            $this->addLog(preg_replace('/[\r\n]+/', '', strip_tags($str))); 
        } else {
            parent::edebug($str);
        }
    }
    
    /**
     * PHPMailer::getSMTPInstance()
     * Override parent implementation
     * 
     * Get an instance to use for SMTP operations.
     * Override this function to load your own SMTP implementation
     * @return SMTP
     */
    public function getSMTPInstance()
    {
        if (!is_object($this->smtp)) {
            $this->smtp = new MSMTP;
        }
        return $this->smtp;
    }
    
    /**
     * Generate a DKIM signature.
     * @access public
     * @param string $signheader Header
     * @throws phpmailerException
     * @return string
     */
    public function DKIM_Sign($signheader)
    {
        if (!defined('PKCS7_TEXT')) {
            if ($this->exceptions) {
                throw new phpmailerException($this->lang("signing") . ' OpenSSL extension missing.');
            }
            return '';
        }
        if (strpos($this->DKIM_private, '-----BEGIN RSA PRIVATE KEY-----') === 0) {
            $privKeyStr = $this->DKIM_private;
        } else {
            $privKeyStr = file_get_contents($this->DKIM_private);
        }
        if ($this->DKIM_passphrase != '') {
            $privKey = openssl_pkey_get_private($privKeyStr, $this->DKIM_passphrase);
        } else {
            $privKey = $privKeyStr;
        }
        if (openssl_sign($signheader, $signature, $privKey)) {
            return base64_encode($signature);
        }
        return '';
    }
    
    /**
     * Prepare a message for sending.
     * @throws phpmailerException
     * @return bool
     */
    public function preSend()
    {
        try {
            $this->mailHeader = "";
            if ((count($this->to) + count($this->cc) + count($this->bcc)) < 1) {
                throw new phpmailerException($this->lang('provide_address'), self::STOP_CRITICAL);
            }

            // Set whether the message is multipart/alternative
            if (!empty($this->AltBody)) {
                $this->ContentType = 'multipart/alternative';
            }

            $this->error_count = 0; // reset errors
            $this->setMessageType();
            // Refuse to send an empty message unless we are specifically allowing it
            if (!$this->AllowEmpty and empty($this->Body)) {
                throw new phpmailerException($this->lang('empty_message'), self::STOP_CRITICAL);
            }

            $this->MIMEHeader = $this->createHeader();
            $this->MIMEBody = $this->createBody();

            // To capture the complete message when using mail(), create
            // an extra header list which createHeader() doesn't fold in
            if ($this->Mailer == 'mail') {
                if (count($this->to) > 0) {
                    $this->mailHeader .= $this->addrAppend("To", $this->to);
                } else {
                    $this->mailHeader .= $this->headerLine("To", "undisclosed-recipients:;");
                }
                $this->mailHeader .= $this->headerLine(
                    'Subject',
                    $this->encodeHeader($this->secureHeader(trim($this->Subject)))
                );
            }

            // Sign with DKIM if enabled
            if (!empty($this->DKIM_domain)
                && !empty($this->DKIM_private)
                && !empty($this->DKIM_selector)
                && !empty($this->DKIM_domain)
                && (strpos($this->DKIM_private, '-----BEGIN RSA PRIVATE KEY-----') === 0 || file_exists($this->DKIM_private))) {
                $header_dkim = $this->DKIM_Add(
                    $this->MIMEHeader . $this->mailHeader,
                    $this->encodeHeader($this->secureHeader($this->Subject)),
                    $this->MIMEBody
                );
                $this->MIMEHeader = rtrim($this->MIMEHeader, "\r\n ") . self::CRLF .
                    str_replace("\r\n", "\n", $header_dkim) . self::CRLF;
            }
            return true;

        } catch (phpmailerException $exc) {
            $this->setError($exc->getMessage());
            if ($this->exceptions) {
                throw $exc;
            }
            return false;
        }
    }
}