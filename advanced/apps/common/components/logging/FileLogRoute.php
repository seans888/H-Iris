<?php defined('MW_PATH') || exit('No direct script access allowed');



class FileLogRoute extends CFileLogRoute 
{
    /**
     * Formats a log message given different fields.
     * @param string $message message content
     * @param integer $level message level
     * @param string $category message category
     * @param integer $time timestamp
     * @return string formatted message
     */
    protected function formatLogMessage($message, $level, $category, $time)
    {
        if (!MW_IS_CLI) {
            $ip = Yii::app()->request->getUserHostAddress();
            return @date('Y/m/d H:i:s', $time)." [$level] [$category] [$ip] $message\n";
        }
        return @date('Y/m/d H:i:s', $time)." [$level] [$category] $message\n";
    }
}