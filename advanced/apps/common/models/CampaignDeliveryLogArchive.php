<?php defined('MW_PATH') || exit('No direct script access allowed');


 
/**
 * This is the model class for table "campaign_delivery_log_archive".
 *
 * The followings are the available columns in table 'campaign_delivery_log_archive':
 * @property string $log_id
 * @property integer $campaign_id
 * @property integer $subscriber_id
 * @property string $message
 * @property string $processed
 * @property integer $retries
 * @property integer $max_retries
 * @property string $email_message_id
 * @property string $status
 * @property string $date_added
 *
 * The followings are the available model relations:
 * @property ListSubscriber $subscriber
 * @property Campaign $campaign
 */
class CampaignDeliveryLogArchive extends CampaignDeliveryLog
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{campaign_delivery_log_archive}}';
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CampaignDeliveryLogArchive the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}