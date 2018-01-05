<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * OptionCronDelivery
 *
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com>
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */

class OptionCronDelivery extends OptionBase
{
    // settings category
    protected $_categoryName = 'system.cron.send_campaigns';

    // memory limit
    public $memory_limit;

    // how many campaigns to process at once
    public $campaigns_at_once = 10;

    // how many subscribers should we load at once for each sending campaign
    public $subscribers_at_once = 300;

    // after how many emails we should send at once
    public $send_at_once = 0;

    // how many seconds should we pause bettwen the batches
    public $pause = 0;

    // how many emails should we deliver within a minute
    public $emails_per_minute = 0;

    // after what number of emails we should change the delivery server.
    public $change_server_at = 0;

    // since 1.3.5.9
    public $use_pcntl = 'no';

    // since 1.3.5.9
    public $campaigns_in_parallel = 5;

    // since 1.3.5.9
    public $subscriber_batches_in_parallel = 5;

    // since 1.3.5.9 max allowed bounce rate per campaign
    public $max_bounce_rate = -1;
    
    // since 1.4.4 - whether to retry failed sendings
    public $retry_failed_sending = 'no';
    
    // since 1.4.4
    public $delete_campaign_delivery_logs = 'no';

    public function rules()
    {
        $rules = array(
            array('campaigns_at_once, subscribers_at_once, send_at_once, pause, emails_per_minute, change_server_at', 'required'),
            array('memory_limit', 'in', 'range' => array_keys($this->getMemoryLimitOptions())),
            array('campaigns_at_once, subscribers_at_once, send_at_once, pause, emails_per_minute, change_server_at', 'numerical', 'integerOnly' => true),
            array('campaigns_at_once', 'numerical', 'min' => 1, 'max' => 10000),
            array('subscribers_at_once', 'numerical', 'min' => 1, 'max' => 10000),
            array('send_at_once', 'numerical', 'min' => 0, 'max' => 10000),
            array('pause', 'numerical', 'min' => 0, 'max' => 30),
            array('emails_per_minute', 'numerical', 'min' => 0, 'max' => 10000),
            array('change_server_at', 'numerical', 'min' => 0, 'max' => 10000),
            
            // since 1.3.5.9
            array('use_pcntl', 'in', 'range' => array_keys($this->getYesNoOptions())),
            array('campaigns_in_parallel, subscriber_batches_in_parallel', 'numerical', 'min' => 1, 'max' => 50),
            array('max_bounce_rate', 'numerical', 'integerOnly' => true, 'min' => -1, 'max' => 100),
            
            // since 1.4.4
            array('retry_failed_sending, delete_campaign_delivery_logs', 'in', 'range' => array_keys($this->getYesNoOptions())),
        );

        return CMap::mergeArray($rules, parent::rules());
    }

    public function attributeLabels()
    {
        $labels = array(
            'memory_limit'          => Yii::t('settings', 'Memory limit'),
            'campaigns_at_once'     => Yii::t('settings', 'Campaigns at once'),
            'subscribers_at_once'   => Yii::t('settings', 'Subscribers at once'),
            'send_at_once'          => Yii::t('settings', 'Send at once'),
            'pause'                 => Yii::t('settings', 'Pause'),
            'emails_per_minute'     => Yii::t('settings', 'Emails per minute'),
            'change_server_at'      => Yii::t('settings', 'Change server at'),

            // since 1.3.5.9
            'use_pcntl'                     => Yii::t('settings', 'Parallel sending via PCNTL'),
            'campaigns_in_parallel'         => Yii::t('settings', 'Campaigns in parallel'),
            'subscriber_batches_in_parallel'=> Yii::t('settings', 'Subscriber batches in parallel'),
            'max_bounce_rate'               => Yii::t('settings', 'Max. bounce rate'),
            
            // since 1.4.4
            'retry_failed_sending'          => Yii::t('settings', 'Retry failed sendings'),
            'delete_campaign_delivery_logs' => Yii::t('settings', 'Delete delivery logs'),
        );

        return CMap::mergeArray($labels, parent::attributeLabels());
    }

    public function attributePlaceholders()
    {
        $placeholders = array(
            'memory_limit'          => null,
            'campaigns_at_once'     => null,
            'subscribers_at_once'   => null,
            'send_at_once'          => null,
            'pause'                 => null,
            'emails_per_minute'     => null,
            'change_server_at'      => null,

            // since 1.3.5.9
            'campaigns_in_parallel'         => 5,
            'subscriber_batches_in_parallel'=> 5,
            'max_bounce_rate'               => -1,
        );

        return CMap::mergeArray($placeholders, parent::attributePlaceholders());
    }

    public function attributeHelpTexts()
    {
        $texts = array(
            'memory_limit'          => Yii::t('settings', 'The maximum memory amount the delivery process is allowed to use while processing one batch of campaigns.'),
            'campaigns_at_once'     => Yii::t('settings', 'How many campaigns to process at once.'),
            'subscribers_at_once'   => Yii::t('settings', 'How many subscribers to process at once for each loaded campaign.'),
            'send_at_once'          => Yii::t('settings', 'How many emails should we send before pausing(this avoids server flooding and getting blacklisted). Set this to 0 to disable it.'),
            'pause'                 => Yii::t('settings', 'How many seconds to sleep after sending a batch of emails.'),
            'emails_per_minute'     => Yii::t('settings', 'Limit the number of emails sent in one minute. This avoids getting blacklisted by various providers. Set this to 0 to disable it.'),
            'change_server_at'      => Yii::t('settings', 'After how many sent emails we should change the delivery server. This only applies if there are multiple delivery servers. Set this to 0 to disable it.'),

            // since 1.3.5.9
            'use_pcntl'                     => Yii::t('settings', 'The PHP PCNTL extension allows processing campaigns in parallel. You can enable it if you need your campaigns to be sent faster.'),
            'campaigns_in_parallel'         => Yii::t('settings', 'How many campaigns to send in parallel. Please note that this depends on the number of campaigns at once.'),
            'subscriber_batches_in_parallel'=> Yii::t('settings', 'How many batches of subscribers to send at once. Please note that this depends on the number of subscribers at once.'),
            'max_bounce_rate'               => Yii::t('settings', 'When a campaign reaches this bounce rate, it will be blocked. Set to -1 to disable this check or between 1 and 100 to set the percent of allowed bounce rate.'),

            // since 1.4.4
            'retry_failed_sending'          => Yii::t('settings', 'By default, when sending a campaign, if sending to a certain email address fails, we giveup on that email address and move forward. This option allows you to enable retry sending for failed emails up to 3 times.'),
            'delete_campaign_delivery_logs' => Yii::t('settings', 'Whether to delete the campaign delivery logs after the campaign has been sent. If this is enabled, you will not be able to see the logs related to delivery but it will improve overall system performance. Keep in mind that we purge the logs after {n} days since the campaign finishes sending.', array(
                '{n}' => Yii::app()->params['campaign.delivery.logs.delete.days_back']
            ))
        );

        return CMap::mergeArray($texts, parent::attributeHelpTexts());
    }
}
