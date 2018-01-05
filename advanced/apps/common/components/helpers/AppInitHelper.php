<?php defined('MW_PATH') || exit('No direct script access allowed');



class AppInitHelper
{
    private static $_entryScriptUrl;

    private static $_baseUrl;

    /**
     * AppInitHelper::getEntryScriptUrl()
     *
     * Inspired from Yii
     *
     * @return string
     */
    public static function getEntryScriptUrl()
    {
        if(self::$_entryScriptUrl === null)
        {
            $scriptName = basename($_SERVER['SCRIPT_FILENAME']);

            if (basename($_SERVER['SCRIPT_NAME']) === $scriptName) {
                self::$_entryScriptUrl = $_SERVER['SCRIPT_NAME'];
            } elseif (basename($_SERVER['PHP_SELF']) === $scriptName) {
                self::$_entryScriptUrl = $_SERVER['PHP_SELF'];
            } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $scriptName) {
                self::$_entryScriptUrl = $_SERVER['ORIG_SCRIPT_NAME'];
            } elseif (($pos = strpos($_SERVER['PHP_SELF'],'/'.$scriptName)) !== false) {
                self::$_entryScriptUrl = substr($_SERVER['SCRIPT_NAME'],0,$pos).'/'.$scriptName;
            } elseif (isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT']) === 0) {
                self::$_entryScriptUrl = str_replace('\\','/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
            } else {
                throw new Exception('Unable to determine the entry script URL.');
            }
        }
        return self::$_entryScriptUrl;
    }

    /**
     * AppInitHelper::getBaseUrl()
     *
     * @param mixed $appendThis
     * @return string
     */
    public static function getBaseUrl($appendThis = null)
    {
        if(self::$_baseUrl === null) {
            self::$_baseUrl = rtrim(dirname(self::getEntryScriptUrl()),'\\/');
        }
        return self::$_baseUrl . (!empty($appendThis) ? '/' . trim($appendThis, '/') : null);
    }

    /**
     * AppInitHelper::noMagicQuotes()
     *
     * @return
     */
    public static function noMagicQuotes()
    {
        static $hasRan = false;

        if ($hasRan || !get_magic_quotes_gpc()) {
            return;
        }

        $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
        while (list($key, $val) = each($process)) {
            foreach ($val as $k => $v) {
                unset($process[$key][$k]);
                if (is_array($v)) {
                    $process[$key][stripslashes($k)] = $v;
                    $process[] = &$process[$key][stripslashes($k)];
                } else {
                    $process[$key][stripslashes($k)] = stripslashes($v);
                }
            }
        }
        unset($process);
        $hasRan = true;
    }

    /**
     * AppInitHelper::fixRemoteAddress()
     *
     * @return
     */
    public static function fixRemoteAddress()
    {
        static $hasRan = false;
        if ($hasRan) {
            return;
        }
        $hasRan = true;

        // keep a reference
        $_SERVER['ORIGINAL_REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];

        $keys = array(
            'HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED'
        );

        foreach ($keys as $key) {
            if (empty($_SERVER[$key])) {
                continue;
            }
            $ips = explode(',', $_SERVER[$key]);
            $ips = array_map('trim', $ips);
            foreach ($ips as $ip) {
                if (self::isValidIp($ip)) {
                    return $_SERVER['REMOTE_ADDR'] = $ip;
                }
            }
        }
    }

    /**
     * AppInitHelper::isValidIp()
     *
     * @param string $ip
     * @return bool
     */
    public static function isValidIp($ip)
    {
        return FilterVarHelper::ip($ip);
    }

    /**
     * AppInitHelper::isModRewriteEnabled()
     *
     * @return bool
     */
    public static function isModRewriteEnabled()
    {
        return CommonHelper::functionExists('apache_get_modules') ? in_array('mod_rewrite', apache_get_modules()) : true;
    }

    /**
     * AppInitHelper::isSecureConnection()
     *
     * @return bool
     */
    public static function isSecureConnection()
    {
        return !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'off');
    }

    /**
     * AppInitHelper::simpleCurlPost()
     *
     * @param string $requestUrl
     * @param array $postData
     * @param int $timeout
     * @return array
     */
    public static function simpleCurlPost($requestUrl, array $postData = array(), $timeout = 30)
    {
        return self::makeRemoteRequest($requestUrl, array(
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_POST           => count($postData),
            CURLOPT_POSTFIELDS     => http_build_query($postData, '', '&'),
        ));
    }

    /**
     * AppInitHelper::simpleCurlGet()
     *
     * @since 1.2
     * @param string $requestUrl
     * @param int $timeout
     * @return array
     */
    public static function simpleCurlGet($requestUrl, $timeout = 30)
    {
        return self::makeRemoteRequest($requestUrl, array(
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_TIMEOUT        => $timeout,
        ));
    }

    /**
     * AppInitHelper::simpleCurlPut()
     *
     * @param string $requestUrl
     * @param array $postData
     * @param int $timeout
     * @return array
     */
    public static function simpleCurlPut($requestUrl, array $postData = array(), $timeout = 30)
    {
        return self::makeRemoteRequest($requestUrl, array(
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_CUSTOMREQUEST  => "PUT",
            CURLOPT_POSTFIELDS     => http_build_query($postData, '', '&'),
        ));
    }

    /**
     * AppInitHelper::makeRemoteRequest()
     *
     * @param string $requestUrl
     * @param array $curlOptions
     * @return array
     * @since 1.3.5.9
     */
    public static function makeRemoteRequest($requestUrl, array $curlOptions = array())
    {
        if (!CommonHelper::functionExists('curl_exec')) {
            return array('status' => 'error', 'message' => 'cURL not available, please install cURL and try again!');
        }

        $ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_AUTOREFERER , true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if (ini_get('open_basedir') == '' && ini_get('safe_mode') != 'On') {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }

        foreach ($curlOptions as $key => $value) {
            curl_setopt($ch, $key, $value);
        }

        $body        = curl_exec($ch);
        $curlCode    = curl_errno($ch);
        $curlMessage = curl_error($ch);

        curl_close($ch);

        if ($curlCode !== 0) {
            return array('status' => 'error', 'message' => $curlMessage);
        }

        return array('status' => 'success', 'message' => $body);
    }

    /**
     * AppInitHelper::findPhpCliPath()
     *
     * @since 1.3.3.1
     * @return string
     */
    public static function findPhpCliPath()
    {
        return CommonHelper::findPhpCliPath();
    }
}
