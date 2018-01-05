<?php if ( ! defined('MW_PATH')) exit('No direct script access allowed');



class MailerDummyMailer extends MailerAbstract
{
    /**
     * MailerDummyMailer::send()
     *
     * Implements the parent abstract method
     *
     * @param mixed $params
     * @return bool
     */
    public function send($params = array())
    {
        $this->reset();

        $plugins = isset($params['mailerPlugins']) ? $params['mailerPlugins'] : array();
        $plugins['loggerPlugin'] = true;

        if (isset($plugins['antiFloodPlugin']) && is_array($plugins['antiFloodPlugin'])) {
            $data       = $plugins['antiFloodPlugin'];
            $sendAtOnce = isset($data['sendAtOnce']) && $data['sendAtOnce'] > 0 ? $data['sendAtOnce'] : 100;
            $pause      = isset($data['pause']) && $data['pause'] > 0 ? $data['pause'] : 30;

            if ($this->_sentCounter >= $sendAtOnce && (($this->_sentCounter % $sendAtOnce) == 0)) {
                sleep($pause);
            }
        }

        if (isset($plugins['throttlePlugin']) && is_array($plugins['throttlePlugin'])) {
            $data      = $plugins['throttlePlugin'];
            $perMinute = isset($data['perMinute']) && $data['perMinute'] > 0 ? $data['perMinute'] : 60;
            usleep(floor((60 / $perMinute) * 1000));
        }

        $this->addLog('OK');
        $this->_messageId = md5(StringHelper::uniqid());
        $this->_sentCounter++;

        $this->reset(false);

        return true;
    }

    /**
     * MailerDummyMailer::getEmailMessage()
     *
     * Implements the parent abstract method
     *
     * @param mixed $params
     * @return mixed
     */
    public function getEmailMessage($params = array())
    {
        return StringHelper::random(rand(0, 1000));
    }

    /**
     * MailerDummyMailer::reset()
     *
     * Implements the parent abstract method
     *
     * @return MailerDummyMailer
     */
    public function reset($resetLogs = true)
    {
        if ($resetLogs) {
            $this->clearLogs();
        }
        return $this;
    }

    /**
     * MailerDummyMailer::getName()
     *
     * Implements the parent abstract method
     *
     * @return string
     */
    public function getName()
    {
        return 'DummyMailer';
    }

    /**
     * MailerDummyMailer::getDescription()
     *
     * Implements the parent abstract method
     *
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('mailer', 'System testing mailer, only simulate sending.');
    }
}
