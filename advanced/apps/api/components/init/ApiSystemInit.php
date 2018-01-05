<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class ApiSystemInit extends CApplicationComponent 
{
    protected $_hasRanOnBeginRequest = false;
    protected $_hasRanOnEndRequest = false;
    
    public function init()
    {
        parent::init();
        
        // hook into events and add our methods.
        Yii::app()->attachEventHandler('onBeginRequest', array($this, 'runOnBeginRequest'));
        Yii::app()->attachEventHandler('onEndRequest', array($this, 'runOnEndRequest'));
    }
    
    public function runOnBeginRequest(CEvent $event)
    {
        if ($this->_hasRanOnBeginRequest) {
            return;
        }
        
        // no cookies for this app.
        ini_set('session.use_cookies', '0');
        
        // and mark the event as completed.
        $this->_hasRanOnBeginRequest = true;
    }
    
    public function runOnEndRequest(CEvent $event)
    {
        if ($this->_hasRanOnEndRequest) {
            return;
        }
        
        // and mark the event as completed.
        $this->_hasRanOnEndRequest = true;
    }
}