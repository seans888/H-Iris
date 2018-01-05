<?php defined('MW_PATH') || exit('No direct script access allowed');



class ClearCacheCommand extends ConsoleCommand
{
    // enable verbose mode
    public $verbose = 1;
    
    /**
     * @return int
     */
    public function actionIndex()
    {
        Yii::app()->hooks->doAction('console_command_clear_cache_before_process', $this);

        $result = $this->process();

        Yii::app()->hooks->doAction('console_command_clear_cache_after_process', $this);

        return $result;
    }

    /**
     * @return int
     */
    protected function process()
    {
        $this->stdout(FileSystemHelper::clearCache());
        
        $this->stdout('Calling Cache::flush()...');
        Yii::app()->cache->flush();
        
        $this->stdout('Clearing the database schema cache...');
        Yii::app()->db->schema->getTables();
        Yii::app()->db->schema->refresh();
        
        $this->stdout('DONE.');
        
        return 0;
    }
}
