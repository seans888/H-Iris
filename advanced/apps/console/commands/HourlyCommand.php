<?php defined('MW_PATH') || exit('No direct script access allowed');

 
class HourlyCommand extends ConsoleCommand 
{
    // lock name
    protected $_lockName;

    // flag
    protected $_restoreStates = true;

    // flag
    protected $_improperShutDown = false;
    
    public function init()
    {
        parent::init();

        // set the lock name
        $this->_lockName = md5(__FILE__);

        // this will catch exit signals and restore states
        if (CommonHelper::functionExists('pcntl_signal')) {
            declare(ticks = 1);
            pcntl_signal(SIGINT,  array($this, '_handleExternalSignal'));
            pcntl_signal(SIGTERM, array($this, '_handleExternalSignal'));
            pcntl_signal(SIGHUP,  array($this, '_handleExternalSignal'));
        }

        register_shutdown_function(array($this, '_restoreStates'));
        Yii::app()->attachEventHandler('onError', array($this, '_restoreStates'));
        Yii::app()->attachEventHandler('onException', array($this, '_restoreStates'));
    }

    public function _handleExternalSignal($signalNumber)
    {
        // this will trigger all the handlers attached via register_shutdown_function
        $this->_improperShutDown = true;
        exit;
    }

    public function _restoreStates($event = null)
    {
        if (!$this->_restoreStates) {
            return;
        }
        $this->_restoreStates = false;

        // remove the lock
        Yii::app()->mutex->release($this->_lockName);
    }

    
    public function actionIndex()
    {
        if (!Yii::app()->mutex->acquire($this->_lockName, 5)) {
            return 0;
        }
        
        Yii::app()->hooks->doAction('console_command_hourly_before_process', $this);

        $result = $this->process();

        Yii::app()->hooks->doAction('console_command_hourly_after_process', $this);

        Yii::app()->mutex->release($this->_lockName);
        
        return $result;
    }
    
    public function process()
    {
        $this
            ->resetProcessingCampaigns()
            ->resetBounceServers();
        
        return 0;
    }

    protected function resetProcessingCampaigns()
    {
        try {
            $connection = Yii::app()->getDb();
            $connection->createCommand('UPDATE `{{campaign}}` SET `status` = "sending", last_updated = NOW() WHERE status = "processing" AND last_updated < DATE_SUB(NOW(), INTERVAL 7 HOUR)')->execute();
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $this;
    }

    protected function resetBounceServers()
    {
        try {
            $connection = Yii::app()->getDb();
            $connection->createCommand('UPDATE `{{bounce_server}}` SET `status` = "active", last_updated = NOW() WHERE status = "cron-running" AND last_updated < DATE_SUB(NOW(), INTERVAL 7 HOUR)')->execute();
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $this;
    }
}
