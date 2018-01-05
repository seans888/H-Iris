<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class ProcessDeliveryAndBounceLogCommand extends ConsoleCommand 
{
    // will process the logs and decide what subscribers to be blacklisted.
    public function actionIndex()
    {
        // added in 1.3.4.7
        Yii::app()->hooks->doAction('console_command_process_delivery_and_bounce_log_before_process', $this);
        
        $result = $this->process();
        
        // added in 1.3.4.7
        Yii::app()->hooks->doAction('console_command_process_delivery_and_bounce_log_after_process', $this);
        
        return $result;
    }
    
    // will process the logs and decide what subscribers to be blacklisted.
    protected function process() 
    {
        // 1.3.9.5
        $lockName = sha1(__FILE__ . __METHOD__);
        if (!Yii::app()->mutex->acquire($lockName)) {
            return 1;
        }
        
        $options = Yii::app()->options;
        
        $processLimit = (int)$options->get('system.cron.process_delivery_bounce.process_at_once', 100);
        $blacklistAtDeliveryFatalErrors = (int)$options->get('system.cron.process_delivery_bounce.max_fatal_errors', 1);
        $blacklistAtDeliverySoftErrors = (int)$options->get('system.cron.process_delivery_bounce.max_soft_errors', 5);
        $blacklistAtHardBounce = (int)$options->get('system.cron.process_delivery_bounce.max_hard_bounce', 1);
        $blacklistAtSoftBounce = (int)$options->get('system.cron.process_delivery_bounce.max_soft_bounce', 5);
        
        if ($memoryLimit = $options->get('system.cron.process_delivery_bounce.memory_limit')) {
            ini_set('memory_limit', $memoryLimit);
        }
        
        $db = Yii::app()->getDb();
        $cdlModel = !CampaignDeliveryLog::getArchiveEnabled() ? CampaignDeliveryLog::model() : CampaignDeliveryLogArchive::model();
        
        // subscribers with fatal delivery errors.
        $sql = sprintf('
            SELECT subscriber_id, message, COUNT(*) as counter FROM `' . $cdlModel->tableName() . '` 
                WHERE `processed` = :processed AND `status` = :status GROUP BY subscriber_id HAVING(counter) >= %d 
            LIMIT %d', $blacklistAtDeliveryFatalErrors, $processLimit
        );
        $rows = (array)$db->createCommand($sql)->queryAll(true, array(
            ':processed' => CampaignDeliveryLog::TEXT_NO, 
            ':status'    => CampaignDeliveryLog::STATUS_FATAL_ERROR
        ));
        $subscriberIds = array();
        foreach ($rows as $row) {
            $subscriber = ListSubscriber::model()->findByPk((int)$row['subscriber_id']);
            if (empty($subscriber)) {
                continue;
            }
            $subscriber->addToBlacklist($row['message']);
            $subscriberIds[] = (int)$row['subscriber_id'];
        }
        if (!empty($subscriberIds)) {
            $db->createCommand()->update($cdlModel->tableName(), array('processed' => CampaignDeliveryLog::TEXT_YES), 'subscriber_id IN('. implode(',', $subscriberIds) .')');
        }
        
        // subscribers with soft delivery errors.
        $sql = sprintf('
            SELECT subscriber_id, message, COUNT(*) as counter FROM `' . $cdlModel->tableName() . '` 
                WHERE `processed` = :processed AND `status` = :status GROUP BY subscriber_id HAVING(counter) >= %d 
            LIMIT %d', $blacklistAtDeliverySoftErrors, $processLimit
        );
        $rows = (array)$db->createCommand($sql)->queryAll(true, array(
            ':processed' => CampaignDeliveryLog::TEXT_NO, 
            ':status'    => CampaignDeliveryLog::STATUS_ERROR
        ));
        $subscriberIds = array();
        foreach ($rows as $row) {
            $subscriber = ListSubscriber::model()->findByPk((int)$row['subscriber_id']);
            if (empty($subscriber)) {
                continue;
            }
            $subscriber->addToBlacklist($row['message']);
            $subscriberIds[] = (int)$row['subscriber_id'];
        }
        if (!empty($subscriberIds)) {
            $db->createCommand()->update($cdlModel->tableName(), array('processed' => CampaignDeliveryLog::TEXT_YES), 'subscriber_id IN('. implode(',', $subscriberIds) .')');
        }
        
        // subscribers with hard bounces.
        $sql = sprintf('
            SELECT subscriber_id, message, COUNT(*) as counter FROM `{{campaign_bounce_log}}` 
                WHERE `processed` = :processed AND `bounce_type` = :bounce_type GROUP BY subscriber_id HAVING(counter) >= %d 
            LIMIT %d', $blacklistAtHardBounce, $processLimit
        );
        $rows = (array)$db->createCommand($sql)->queryAll(true, array(
            ':processed'    => CampaignBounceLog::TEXT_NO, 
            ':bounce_type'  => CampaignBounceLog::BOUNCE_HARD
        ));
        $subscriberIds = array();
        foreach ($rows as $row) {
            $subscriber = ListSubscriber::model()->findByPk((int)$row['subscriber_id']);
            if (empty($subscriber)) {
                continue;
            }
            $subscriber->addToBlacklist($row['message']);
            $subscriberIds[] = (int)$row['subscriber_id'];
        }
        if (!empty($subscriberIds)) {
            $db->createCommand()->update('{{campaign_bounce_log}}', array('processed' => CampaignBounceLog::TEXT_YES), 'subscriber_id IN('. implode(',', $subscriberIds) .')');
        }
        
        // subscribers with soft bounces.
        $sql = sprintf('
            SELECT subscriber_id, message, COUNT(*) as counter FROM `{{campaign_bounce_log}}` 
                WHERE `processed` = :processed AND `bounce_type` = :bounce_type GROUP BY subscriber_id HAVING(counter) >= %d 
            LIMIT %d', $blacklistAtSoftBounce, $processLimit
        );
        $rows = (array)$db->createCommand($sql)->queryAll(true, array(
            ':processed'    => CampaignBounceLog::TEXT_NO, 
            ':bounce_type'  => CampaignBounceLog::BOUNCE_SOFT
        ));
        $subscriberIds = array();
        foreach ($rows as $row) {
            $subscriber = ListSubscriber::model()->findByPk((int)$row['subscriber_id']);
            if (empty($subscriber)) {
                continue;
            }
            $subscriber->addToBlacklist($row['message']);
            $subscriberIds[] = (int)$row['subscriber_id'];
        }
        if (!empty($subscriberIds)) {
            $db->createCommand()->update('{{campaign_bounce_log}}', array('processed' => CampaignBounceLog::TEXT_YES), 'subscriber_id IN('. implode(',', $subscriberIds) .')');
        }
        
        // 1.3.9.5
        Yii::app()->mutex->release($lockName);
        
        return 0;
    }

}
