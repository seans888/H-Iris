<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class AccessHelper
{   
    // shortcut method
    public static function hasRouteAccess($route)
    {
        $app = Yii::app();
        if ($app->apps->isAppName('backend') && $app->hasComponent('user') && $app->user->getId() && $app->user->getModel()) {
            return (bool)$app->user->getModel()->hasRouteAccess($route);
        }
        return true;
    }
}