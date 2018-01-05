<?php defined('MW_PATH') || exit('No direct script access allowed');


 
abstract class PaymentHandlerAbstract extends CApplicationComponent
{
    // the extension instance for easy access
    public $extension;
    
    // the controller calling the handler
    public $controller;

    abstract public function renderPaymentView();
    
    abstract public function processOrder();
}
