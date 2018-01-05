<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class HelloCommand extends ConsoleCommand 
{
    public function actionIndex() 
    {
        echo 'Hello World!' . "\n";
    }
}