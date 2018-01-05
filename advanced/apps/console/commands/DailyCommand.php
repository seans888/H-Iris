<?php defined('MW_PATH') || exit('No direct script access allowed');


class DailyCommand extends ConsoleCommand 
{
    public function actionIndex() 
    {
        $this
            ->deleteSubscribers()
            ->deleteDeliveryServersUsageLogs()
            ->deleteCustomerOldActionLogs()
            ->deleteUnconfirmedCustomers()
            ->deleteUncompleteOrders()
            ->deliveryAlgo()
            ->deleteGuestFailedAttempts()
            ->deleteCampaigns()
            ->deleteSegments()
            ->deleteLists()
            ->syncListsCustomFields()
            ->deleteCampaignsQueueTables()
            ->deleteCustomers()
            ->deleteDisabledCustomers()
            ->deleteDisabledCustomersData()
            ->deleteMutexes()
            ->deleteCampaignDeliveryLogs()
            ->deleteTransactionalEmails();
        
        Yii::app()->hooks->doAction('console_command_daily', $this);
        
        return 0;
    }
    
    protected function deleteSubscribers()
    {
        $options = Yii::app()->options;
        $unsubscribeDays = (int)$options->get('system.cron.process_subscribers.unsubscribe_days', 30);
        $unconfirmDays   = (int)$options->get('system.cron.process_subscribers.unconfirm_days', 3);
        $blacklistedDays = (int)$options->get('system.cron.process_subscribers.blacklisted_days', 0);
        
        if ($memoryLimit = $options->get('system.cron.process_subscribers.memory_limit')) {
            ini_set('memory_limit', $memoryLimit);
        }
        
        try {
            $connection = Yii::app()->getDb();
            
            if ($unsubscribeDays > 0) {
                $interval = 60 * 60 * 24 * $unsubscribeDays;
                $sql = 'DELETE FROM `{{list_subscriber}}` WHERE `status` = :st AND last_updated < DATE_SUB(NOW(), INTERVAL '.(int)$interval.' SECOND)';
                $connection->createCommand($sql)->execute(array(
                    ':st' => ListSubscriber::STATUS_UNSUBSCRIBED,
                ));
            }
            
            if ($unconfirmDays > 0) {
                $interval = 60 * 60 * 24 * $unconfirmDays;
                $sql = 'DELETE FROM `{{list_subscriber}}` WHERE `status` = :st AND last_updated < DATE_SUB(NOW(), INTERVAL '.(int)$interval.' SECOND)';
                $connection->createCommand($sql)->execute(array(
                    ':st' => ListSubscriber::STATUS_UNCONFIRMED,
                ));
            }
            
            if ($blacklistedDays > 0) {
                $interval = 60 * 60 * 24 * $blacklistedDays;
                $sql = 'DELETE FROM `{{list_subscriber}}` WHERE `status` = :st AND last_updated < DATE_SUB(NOW(), INTERVAL '.(int)$interval.' SECOND)';
                $connection->createCommand($sql)->execute(array(
                    ':st' => ListSubscriber::STATUS_BLACKLISTED,
                ));
            }
        } catch(Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $this;
    }
    
    protected function deleteDeliveryServersUsageLogs()
    {
        try {
            $options      = Yii::app()->options;
            $daysRemoval  = (int)$options->get('system.cron.process_delivery_bounce.delivery_servers_usage_logs_removal_days', 90);
            
            $connection = Yii::app()->getDb();
            $connection->createCommand(sprintf('DELETE FROM `{{delivery_server_usage_log}}` WHERE date_added < DATE_SUB(NOW(), INTERVAL %d DAY)', $daysRemoval))->execute();    
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $this;
    }
    
    protected function deleteCustomerOldActionLogs()
    {
        try {
            $connection = Yii::app()->getDb();
            $connection->createCommand('DELETE FROM `{{customer_action_log}}` WHERE date_added < DATE_SUB(NOW(), INTERVAL 1 MONTH)')->execute();    
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $this;
    }
    
    protected function deleteUnconfirmedCustomers()
    {
        $options        = Yii::app()->options;
        $unconfirmDays  = (int)$options->get('system.customer_registration.unconfirm_days_removal', 7);
        
        try {
            $connection = Yii::app()->getDb();
            $connection->createCommand(sprintf('DELETE FROM `{{customer}}` WHERE `status` = :st AND date_added < DATE_SUB(NOW(), INTERVAL %d DAY)', (int)$unconfirmDays))->execute(array(
                ':st' => Customer::STATUS_PENDING_CONFIRM,
            ));    
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $this;
    }
    
    protected function deleteUncompleteOrders()
    {
        $options        = Yii::app()->options;
        $unconfirmDays  = (int)$options->get('system.monetization.orders.uncomplete_days_removal', 7);
        
        try {
            $connection = Yii::app()->getDb();
            $connection->createCommand(sprintf('DELETE FROM `{{price_plan_order}}` WHERE `status` != :st AND `status` != :st2 AND date_added < DATE_SUB(NOW(), INTERVAL %d DAY)', (int)$unconfirmDays))->execute(array(
                ':st'   => PricePlanOrder::STATUS_COMPLETE,
                ':st2'  => PricePlanOrder::STATUS_REFUNDED,
            ));    
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $this;
    }
    
    protected function deliveryAlgo()
    {
        Yii::app()->consoleSystemInit->_deliveryAlgo();
        return $this;
    }
    
    protected function deleteCampaigns()
    {
        $campaigns = Campaign::model()->findAllByAttributes(array(
            'status' => Campaign::STATUS_PENDING_DELETE,
        ));
        foreach ($campaigns as $campaign) {
            try {
                $campaign->delete();
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            }
        }
        return $this;
    }
    
    protected function deleteLists()
    {
        $lists = Lists::model()->findAllByAttributes(array(
            'status' => Lists::STATUS_PENDING_DELETE,
        ));
        foreach ($lists as $list) {
            try {
                $list->delete();
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            }
        }
        return $this;
    }

    protected function deleteSegments()
    {
        $segments = ListSegment::model()->findAllByAttributes(array(
            'status' => ListSegment::STATUS_PENDING_DELETE,
        ));
        foreach ($segments as $segment) {
            try {
                $segment->delete();
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            }
        }
        return $this;
    }
    
    protected function deleteGuestFailedAttempts()
    {
        try {
            $connection = Yii::app()->getDb();
            $connection->createCommand('DELETE FROM `{{guest_fail_attempt}}` WHERE date_added < DATE_SUB(NOW(), INTERVAL 1 HOUR)')->execute();    
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        return $this;
    }

    protected function syncListsCustomFields()
    {
        if (Yii::app()->options->get('system.cron.process_subscribers.sync_custom_fields_values', 'no') != 'yes') {
            return $this;
        }
        
        $argv = array(
            $_SERVER['argv'][0],
            'sync-lists-custom-fields',
        );
        
        foreach ($_SERVER['argv'] as $arg) {
            if ($arg == '--verbose=1') {
                $argv[] = $arg;
                break;
            }
        }

        try {
            $runner = clone Yii::app()->getCommandRunner();
            $runner->run($argv);
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
        
        return $this;
    }
    
    protected function deleteCampaignsQueueTables()
    {
        if (empty(Yii::app()->params['send.campaigns.command.useTempQueueTables'])) {
            return $this;
        }
        
        $criteria = new CDbCriteria();
        $criteria->compare('status', Campaign::STATUS_SENT);
        $criteria->addCondition('date_added > DATE_SUB(NOW(), INTERVAL 7 DAY)');
        
        $campaigns = Campaign::model()->findAll($criteria);
        foreach ($campaigns as $campaign) {
            try {
                $campaign->queueTable->dropTable();
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            }
        }
            
        return $this;
    }

    protected function deleteCustomers()
    {
        $customers = Customer::model()->findAllByAttributes(array(
            'status' => Customer::STATUS_PENDING_DELETE,
        ));
        foreach ($customers as $customer) {
            try {
                $customer->delete();
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            }
        }
        return $this;
    }
    
    protected function deleteDisabledCustomers()
    {
        $days = (int)Yii::app()->options->get('system.customer_common.days_to_keep_disabled_account', 30);
        if ($days < 0) {
            return $this;
        }
        
        $criteria = new CDbCriteria();
        $criteria->compare('status', Customer::STATUS_DISABLED);
        $criteria->addCondition(sprintf('DATE_SUB(NOW(), INTERVAL %d DAY) > last_login', $days));
        
        $customers = Customer::model()->findAll($criteria);

        foreach ($customers as $customer) {
            try {
                $customer->status = Customer::STATUS_PENDING_DELETE;
                $customer->delete();
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            }
        }
        
        return $this;
    }
    
    protected function deleteDisabledCustomersData()
    {
        $customers = Customer::model()->findAllByAttributes(array(
            'status' => Customer::STATUS_PENDING_DISABLE,
        ));
        
        foreach ($customers as $customer) {
            
            try {

                $attributes = $customer->attributes;
                
                $customer->status = Customer::STATUS_PENDING_DELETE;
                $customer->delete();
                
                $newCustomer = new Customer();
                foreach ($attributes as $key => $value) {
                    $newCustomer->$key = $value;
                }
                $newCustomer->status = Customer::STATUS_DISABLED;
                $newCustomer->save(false);
                
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            }
        }
        
        return $this;
    }
    
    public function deleteMutexes() 
    {
        $argv = array(
            $_SERVER['argv'][0],
            'delete-mutexes',
        );

        foreach ($_SERVER['argv'] as $arg) {
            if ($arg == '--verbose=1') {
                $argv[] = $arg;
                break;
            }
        }

        try {
            $runner = clone Yii::app()->getCommandRunner();
            $runner->run($argv);
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }

        return $this;
    }
    
    public function deleteCampaignDeliveryLogs()
    {
        $purgeCampaignDeliveryLogs = Yii::app()->options->get('system.cron.send_campaigns.delete_campaign_delivery_logs', 'no') === 'yes';
        if (!$purgeCampaignDeliveryLogs) {
            return $this;
        }
        
        $argv = array(
            $_SERVER['argv'][0],
            'delete-campaign-delivery-logs',
        );

        foreach ($_SERVER['argv'] as $arg) {
            if ($arg == '--verbose=1') {
                $argv[] = $arg;
                break;
            }
        }

        try {
            $runner = clone Yii::app()->getCommandRunner();
            $runner->run($argv);
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }

        return $this;
    }
    
    public function deleteTransactionalEmails()
    {
        $daysBack = (int)Yii::app()->options->get('system.cron.transactional_emails.delete_days_back', -1);
        if ($daysBack < 0) {
            return $this;
        }
        
        $argv = array(
            $_SERVER['argv'][0],
            'delete-transactional-emails',
            sprintf("--time=-%d days", $daysBack)
        );
        
        foreach ($_SERVER['argv'] as $arg) {
            if ($arg == '--verbose=1') {
                $argv[] = $arg;
                break;
            }
        }
        
        try {
            $runner = clone Yii::app()->getCommandRunner();
            $runner->run($argv);
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }

        return $this;
    }
}
