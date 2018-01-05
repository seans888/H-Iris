<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class OptionCommand extends ConsoleCommand 
{
    public function actionGet_option($name, $default = null)
    {
        exit((string)Yii::app()->options->get($name, $default));
    }
    
    public function actionSet_option($name, $value)
    {
        Yii::app()->options->set($name, $value);
    }
}