<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class HtmlHelper extends CHtml
{
    /**
     * @param $text
     * @param string $url
     * @param array $htmlOptions
     * @return string
     */
    public static function accessLink($text, $url='#', $htmlOptions = array())
    {
        $fallbackText = false;
        if (isset($htmlOptions['fallbackText'])) {
            $fallbackText = (bool)$htmlOptions['fallbackText'];
            unset($htmlOptions['fallbackText']);
        }
        
        $app = Yii::app();
        if (is_array($url) && $app->apps->isAppName('backend') && $app->hasComponent('user') && $app->user->getId() && $app->user->getModel()) {
            if (!$app->user->getModel()->hasRouteAccess($url[0])) {
                return $fallbackText ? $text : '';
            }
        }
        
        return self::link($text, $url, $htmlOptions);
    }
}