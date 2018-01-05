<?php defined('MW_PATH') || exit('No direct script access allowed');



class ConsoleCommand extends CConsoleCommand
{
    /**
     * Whether this should be verbose and output to console
     * 
     * @var int
     */
    public $verbose = 0;

    /**
     * @var int
     */
    protected $__startTime = 0;

    /**
     * @var int
     */
    protected $__startMemory = 0;
    
    /**
     * @inheritdoc
     */
    protected function beforeAction($action, $params) 
    {
        $this->__startTime   = microtime(true);
        $this->__startMemory = memory_get_peak_usage(true);
        
        return parent::beforeAction($action, $params);
    }

    /**
     * @inheritdoc
     */
    protected function afterAction($action, $params, $exitCode = 0)
    {
        parent::afterAction($action, $params, $exitCode);
        $this->saveCommandHistory($action, $params, $exitCode);
    }
    
    /**
     * @param $message
     * @param bool $timer
     * @param string $separator
     * @return int
     */
    public function stdout($message, $timer = true, $separator = "\n")
    {
        if (!$this->verbose) {
            return 0;
        }
        
        if (!is_array($message)) {
            $message = array($message);
        }

        $out = '';
        
        foreach ($message as $msg) {
            
            if ($timer) {
                $out .= '[' . date('Y-m-d H:i:s') . '] - ';
            }
            
            $out .= $msg;
            
            if ($separator) {
                $out .= $separator;
            }
        }

        echo $out;
        return 0;
    }

    /**
     * @param array $params
     * @return string
     */
    protected function stringifyParams(array $params = array())
    {
        if (empty($params)) {
            return '';
        }
        
        $out = array();
        foreach ($params as $key => $value) {
            $out[] = '--' . $key . '=' . $value;
        }
        
        return implode(' ', $out);
    }

    /**
     * @param $action
     * @param array $params
     * @param int $exitCode
     */
    protected function saveCommandHistory($action, $params = array(), $exitCode = 0)
    {
        try {

            $command = ConsoleCommandList::model()->findByAttributes(array(
                'command' => $this->getName(),
            ));

            if (empty($command)) {
                $command = new ConsoleCommandList();
                $command->command = $this->getName();
                $command->save();
            }

            $commandHistory = new ConsoleCommandListHistory();
            $commandHistory->command_id   = $command->command_id;
            $commandHistory->action       = $action;
            $commandHistory->params       = $this->stringifyParams($params);
            $commandHistory->start_time   = $this->__startTime;
            $commandHistory->end_time     = microtime(true);
            $commandHistory->start_memory = $this->__startMemory;
            $commandHistory->end_memory   = memory_get_peak_usage(true);
            $commandHistory->status       = $exitCode !== 0 ? ConsoleCommandListHistory::STATUS_ERROR : ConsoleCommandListHistory::STATUS_SUCCESS;
            $commandHistory->save();

        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
    }
}
