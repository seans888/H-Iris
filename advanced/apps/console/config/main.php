<?php defined('MW_PATH') || exit('No direct script access allowed');


return array(
    'basePath' => Yii::getPathOfAlias('console'),

    'preload' => array(
        'consoleSystemInit'
    ),

    'import' => array(
        'console.components.*',
        'console.components.db.*',
        'console.components.db.ar.*',
        'console.components.web.*',
        'console.components.console.*',
    ),

    'commandMap' => array(
        'hello' => array(
            'class' => 'console.commands.HelloCommand'
        ),
        'send-campaigns' => array(
            'class' => 'console.commands.SendCampaignsCommand'
        ),
        'bounce-handler' => array(
            'class' => 'console.commands.BounceHandlerCommand'
        ),
        'process-delivery-and-bounce-log' => array(
            'class' => 'console.commands.ProcessDeliveryAndBounceLogCommand'
        ),
        'option' => array(
            'class' => 'console.commands.OptionCommand'
        ),
        'feedback-loop-handler' => array(
            'class' => 'console.commands.FeedbackLoopHandlerCommand'
        ),
        'email-box-monitor-handler' => array(
            'class' => 'console.commands.EmailBoxMonitorHandlerCommand'
        ),
        'send-transactional-emails' => array(
            'class' => 'console.commands.SendTransactionalEmailsCommand'
        ),
        'daily' => array(
            'class' => 'console.commands.DailyCommand'
        ),
        'update' => array(
            'class' => 'console.commands.UpdateCommand'
        ),
        'archive-campaigns-delivery-logs' => array(
            'class' => 'console.commands.ArchiveCampaignsDeliveryLogsCommand'
        ),
        'list-import' => array(
            'class' => 'console.commands.ListImportCommand'
        ),
        'list-export' => array(
            'class' => 'console.commands.ListExportCommand'
        ),
        'mailerq-handler-daemon' => array(
            'class' => 'console.commands.MailerqHandlerDaemon'
        ),
        'table-cleaner' => array(
            'class' => 'console.commands.TableCleanerCommand'
        ),
        'clear-cache' => array(
            'class' => 'console.commands.ClearCacheCommand'
        ),
        'translate' => array(
            'class' => 'console.commands.TranslateCommand'
        ),
        'email-blacklist-monitor' => array(
            'class' => 'console.commands.EmailBlacklistMonitorCommand'
        ),
        'reset-customers-quota' => array(
            'class' => 'console.commands.ResetCustomersQuotaCommand'
        ),
        'move-inactive-subscribers' => array(
            'class' => 'console.commands.MoveInactiveSubscribersCommand'
        ),
        'delete-inactive-subscribers' => array(
            'class' => 'console.commands.DeleteInactiveSubscribersCommand'
        ),
        'delete-campaigns' => array(
            'class' => 'console.commands.DeleteCampaignsCommand'
        ),
        'hourly' => array(
            'class' => 'console.commands.HourlyCommand'
        ),
        'sync-lists-custom-fields' => array(
            'class' => 'console.commands.SyncListsCustomFieldsCommand'
        ),
        'delete-mutexes' => array(
            'class' => 'console.commands.DeleteMutexesCommand'
        ),
        'unsubscribe-inactive-subscribers' => array(
            'class' => 'console.commands.UnsubscribeInactiveSubscribersCommand'
        ),
        'delete-campaign-delivery-logs' => array(
            'class' => 'console.commands.DeleteCampaignDeliveryLogsCommand'
        ),
        'suppression-list-import' => array(
            'class' => 'console.commands.SuppressionListImportCommand'
        ),
        'validate-list-mx-records' => array(
            'class' => 'console.commands.ValidateListMxRecordsCommand'
        ),
        'update-ip-location-for-campaign-opens' => array(
            'class' => 'console.commands.UpdateIpLocationForCampaignOpensCommand'
        ),
        'update-ip-location-for-campaign-clicks' => array(
            'class' => 'console.commands.UpdateIpLocationForCampaignClicksCommand'
        ),
        'delete-transactional-emails' => array(
            'class' => 'console.commands.DeleteTransactionalEmailsCommand'
        ),
    ),

    'components' => array(
        'consoleSystemInit' => array(
            'class' => 'console.components.init.ConsoleSystemInit',
        ),
    ),
);
