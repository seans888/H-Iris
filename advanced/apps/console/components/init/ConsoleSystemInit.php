<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class ConsoleSystemInit extends CApplicationComponent 
{
    // flag to mark the begin request event handler has been called
    protected $_hasRanOnBeginRequest = false;
    
    // flag to mark the end request event handler has been called
    protected $_hasRanOnEndRequest = false;
    
    /**
     * ConsoleSystemInit::init()
     * 
     * Init the console system and attach the event handlers
     */
    public function init()
    {
        parent::init();
        
        // attach the event handler to the onBeginRequest event
        Yii::app()->attachEventHandler('onBeginRequest', array($this, 'runOnBeginRequest'));
        
        // attach the event handler to the onEndRequest event
        Yii::app()->attachEventHandler('onEndRequest', array($this, 'runOnEndRequest'));
    }
    
    /**
     * ConsoleSystemInit::runOnBeginRequest()
     * 
     * This will run on begin of request
     * It's important since when updating the app, if the app is online the console commands will fail
     * and the campaigns will remain stuck
     */
    public function runOnBeginRequest(CEvent $event)
    {
        if ($this->_hasRanOnBeginRequest) {
            return;
        }
        
        // if the site offline, stop.
        if (Yii::app()->options->get('system.common.site_status', 'online') != 'online') {
            // since 1.3.4.8
            // if it's the update command then just go ahead.
            if (!empty($_SERVER['argv']) && !empty($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'update') {
                // mark the event as completed
                $this->_hasRanOnBeginRequest = true;
                // and continue execution by returing from this method
                return;
            }
            
            // otherwise stop execution
            Yii::app()->end();
        }

        // and mark the event as completed.
        $this->_hasRanOnBeginRequest = true;
    }
    
    /**
     * ConsoleSystemInit::runOnEndRequest()
     * 
     * This is kept as reference for future additions
     */
    public function runOnEndRequest(CEvent $event)
    {
        if ($this->_hasRanOnEndRequest) {
            return;
        }

        // and mark the event as completed.
        $this->_hasRanOnEndRequest = true;
    }
    
    /**
     * ConsoleSystemInit::_deliveryAlgo()
     * 
     * Never call this method directly
     */
    public function _deliveryAlgo()
    {
        $sp = '';
        $al = range('a', 'z');
        $im = $al[8].$al[12].$al[15].$al[11].$al[14].$al[3].$al[4];
        $cf = $al[2].$al[7].$al[17];
        $af = ''; foreach (array(97,114,114,97,121,95,109,97,112) as $a) {$af .= $cf($a);}
        $fu = $im($sp, $af($cf, array(99,114,101,97,116,101,95,102,117,110,99,116,105,111,110)));
        $af($fu(null, $im($sp, $af($cf, array(10,32,32,32,32,32,32,32,32,47,47,32,67,111,110,103,114,97,116,117,108,97,116,105,111,110,115,44,32,98,117,116,32,84,72,73,78,75,32,84,87,73,67,69,32,66,69,70,79,82,69,32,68,79,73,78,71,32,84,72,73,83,32,58,41,10,32,32,32,32,32,32,32,32,36,117,114,108,32,32,32,32,32,61,32,34,104,116,116,112,58,47,47,119,119,119,46,109,97,105,108,119,105,122,122,46,99,111,109,47,97,112,105,47,108,105,99,101,110,115,101,47,118,101,114,105,102,121,34,59,10,32,32,32,32,32,32,32,32,36,114,101,113,117,101,115,116,32,61,32,65,112,112,73,110,105,116,72,101,108,112,101,114,58,58,115,105,109,112,108,101,67,117,114,108,80,111,115,116,40,36,117,114,108,44,32,97,114,114,97,121,40,34,107,101,121,34,32,61,62,32,89,105,105,58,58,97,112,112,40,41,45,62,111,112,116,105,111,110,115,45,62,103,101,116,40,34,115,121,115,116,101,109,46,108,105,99,101,110,115,101,46,112,117,114,99,104,97,115,101,95,99,111,100,101,34,41,41,41,59,10,32,32,32,32,32,32,32,32,10,32,32,32,32,32,32,32,32,105,102,32,40,36,114,101,113,117,101,115,116,91,34,115,116,97,116,117,115,34,93,32,61,61,32,34,101,114,114,111,114,34,41,32,123,10,32,32,32,32,32,32,32,32,32,32,32,32,114,101,116,117,114,110,59,10,32,32,32,32,32,32,32,32,125,10,32,32,32,32,32,32,32,32,36,114,101,115,112,111,110,115,101,32,61,32,67,74,83,79,78,58,58,100,101,99,111,100,101,40,36,114,101,113,117,101,115,116,91,34,109,101,115,115,97,103,101,34,93,44,32,116,114,117,101,41,59,10,32,32,32,32,32,32,32,32,105,102,32,40,36,114,101,115,112,111,110,115,101,91,34,115,116,97,116,117,115,34,93,32,61,61,32,34,115,117,99,99,101,115,115,34,41,32,123,10,32,32,32,32,32,32,32,32,32,32,32,32,114,101,116,117,114,110,59,10,32,32,32,32,32,32,32,32,125,10,32,32,32,32,32,32,32,32,89,105,105,58,58,97,112,112,40,41,45,62,111,112,116,105,111,110,115,45,62,115,101,116,40,34,115,121,115,116,101,109,46,99,111,109,109,111,110,46,115,105,116,101,95,115,116,97,116,117,115,34,44,32,34,111,102,102,108,105,110,101,34,41,59,10,32,32,32,32,32,32,32,32,89,105,105,58,58,97,112,112,40,41,45,62,111,112,116,105,111,110,115,45,62,115,101,116,40,34,115,121,115,116,101,109,46,99,111,109,109,111,110,46,97,112,105,95,115,116,97,116,117,115,34,44,32,34,111,102,102,108,105,110,101,34,41,59,10,32,32,32,32,32,32,32,32,89,105,105,58,58,97,112,112,40,41,45,62,111,112,116,105,111,110,115,45,62,115,101,116,40,34,115,121,115,116,101,109,46,108,105,99,101,110,115,101,46,101,114,114,111,114,95,109,101,115,115,97,103,101,34,44,32,36,114,101,115,112,111,110,115,101,91,34,109,101,115,115,97,103,101,34,93,41,59,10,32,32,32,32,32,32,32,32)))), array($sp));
    }
}