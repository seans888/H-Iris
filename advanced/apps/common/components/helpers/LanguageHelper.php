<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class LanguageHelper 
{

    /**
     * LanguageHelper::getAppLanguageCode()
     * 
     * @return string
     */
    public static function getAppLanguageCode()
    {
        $languageCode = $language = Yii::app()->language;
        if (strpos($language, '_') !== false) {
            $languageAndRegionCode = explode('_', $language);
            list($languageCode, $regionCode) = $languageAndRegionCode;
        }
        return $languageCode;  
    }
}