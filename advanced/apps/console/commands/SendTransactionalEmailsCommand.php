<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class SendTransactionalEmailsCommand extends ConsoleCommand 
{
    public function actionIndex() 
    {
        $mutex    = Yii::app()->mutex;
        $lockName = md5(__FILE__ . __CLASS__);
        
        if (!$mutex->acquire($lockName)) {
            return 1;
        }
        
        // added in 1.3.4.7
        Yii::app()->hooks->doAction('console_command_transactional_emails_before_process', $this);
        
        $this->process();
        
        // added in 1.3.4.7
        Yii::app()->hooks->doAction('console_command_transactional_emails_after_process', $this);
        
        $mutex->release($lockName);
        return 0;
    }
    
    protected function process()
    {
        // 1.3.7.3
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.status = "unsent" AND t.send_at < NOW() AND t.retries < t.max_retries');
        $criteria->order = 't.email_id ASC';
        $criteria->limit = 100;

        // 1.3.7.3 - offer a chance to alter this criteria.
        $criteria = Yii::app()->hooks->applyFilters('console_send_transactional_emails_command_find_all_criteria', $criteria, $this);

        $emails = TransactionalEmail::model()->findAll($criteria);
        
        if (empty($emails)) {
            return $this;
        }
        
        foreach ($emails as $email) {
            $email->send();
        }

        Yii::app()->getDb()->createCommand('UPDATE {{transactional_email}} SET `status` = "sent" WHERE `status` = "unsent" AND send_at < NOW() AND retries >= max_retries')->execute();
        Yii::app()->getDb()->createCommand('DELETE FROM {{transactional_email}} WHERE `status` = "unsent" AND send_at < NOW() AND date_added < DATE_SUB(NOW(), INTERVAL 1 MONTH)')->execute();
        
        return $this;
    }
}