<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class FeedbackLoopHandlerCommand extends ConsoleCommand 
{
    // lock name
    protected $_lockName;
    
    // flag 
    protected $_restoreStates = true;
    
    // flag
    protected $_improperShutDown = false;
    
    // current server
    protected $_server;
    
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
                
        // called as a callback from register_shutdown_function
        // must pass only if improper shutdown in this case
        if ($event === null && !$this->_improperShutDown) {
            return;
        }

        if (!empty($this->_server)) {
            $this->_server->saveStatus(FeedbackLoopServer::STATUS_ACTIVE);
        }
    }
    
    public function actionIndex() 
    {
        // because some cli are not compiled same way with the web module.
        if (!CommonHelper::functionExists('imap_open')) {
            Yii::log(Yii::t('servers', 'The PHP CLI binary is missing the IMAP extension!'), CLogger::LEVEL_ERROR);
            return 1;
        }
        
        if (!Yii::app()->mutex->acquire($this->_lockName, 5)) {
            return 0;
        }
        
        Yii::import('common.vendors.BounceHandler.*');
        $options = Yii::app()->options;
        
        if ($memoryLimit = $options->get('system.cron.process_feedback_loop_servers.memory_limit')) {
            ini_set('memory_limit', $memoryLimit);    
        }
        
        // added in 1.3.4.7
        Yii::app()->hooks->doAction('console_command_feedback_loop_handler_before_process', $this);

        if (CommonHelper::functionExists('pcntl_fork')) {
            $this->processWithPcntl();
        } else {
            $this->processWithoutPcntl();
        }
        
        // added in 1.3.4.7
        Yii::app()->hooks->doAction('console_command_feedback_loop_handler_after_process', $this);
        
        Yii::app()->mutex->release($this->_lockName);
        
        return 0;
    }

    protected function processWithPcntl()
    {
        // get all servers
        $servers = FeedbackLoopServer::model()->findAll(array(
            'condition' => 't.status = :status',
            'params'    => array(':status' => FeedbackLoopServer::STATUS_ACTIVE),
        ));

        // close the database connection
        Yii::app()->getDb()->setActive(false);

        // split into 10 server chuncks
        $serverChunks = array_chunk($servers, 10);
        unset($servers);

        foreach ($serverChunks as $servers) {

            $childs = array();

            foreach ($servers as $server) {
                $pid = pcntl_fork();
                if($pid == -1) {
                    continue;
                }

                // Parent
                if ($pid) {
                    $childs[] = $pid;
                }

                // child 
                if (!$pid) {
                    $this->_server = $server;
                    try {
                        $server->processRemoteContents(array(
                            'logger' => $this->verbose ? array($this, 'stdout') : null,
                        ));
                    } catch (Exception $e) {
                        Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
                    }
                    exit;
                }
            }

            while (count($childs) > 0) {
                foreach ($childs as $key => $pid) {
                    $res = pcntl_waitpid($pid, $status, WNOHANG);
                    if($res == -1 || $res > 0) {
                        unset($childs[$key]);
                    }
                }
                sleep(1);
            }
        }

        return $this;
    }

    protected function processWithoutPcntl()
    {
        // get all servers
        $servers = FeedbackLoopServer::model()->findAll(array(
            'condition' => 't.status = :status',
            'params'    => array(':status' => FeedbackLoopServer::STATUS_ACTIVE),
        ));

        foreach ($servers as $server) {
            $this->_server = $server;
            try {
                $server->processRemoteContents(array(
                    'logger' => $this->verbose ? array($this, 'stdout') : null,
                ));
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            }
        }

        return $this;
    }
}