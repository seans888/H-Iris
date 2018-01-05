<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * IpLocationIpinfodbExtModel
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 */
 
class IpLocationIpinfodbExtModel extends FormModel
{
    
    const STATUS_ENABLED = 'enabled';
    
    const STATUS_DISABLED = 'disabled';
    
    public $api_key;
    
    public $status = 'disabled';
    
    public $sort_order = 0;
    
    public $status_on_email_open = 'disabled';
    
    public $status_on_track_url = 'disabled';
    
    public $status_on_unsubscribe = 'disabled';

    public $status_on_customer_login = 'disabled';
    
    public function rules()
    {
        $rules = array(
            array('api_key, status, status_on_email_open, status_on_track_url, status_on_unsubscribe, status_on_customer_login, sort_order', 'required'),
            array('status, status_on_email_open, status_on_track_url, status_on_unsubscribe, status_on_customer_login', 'in', 'range' => array(self::STATUS_ENABLED, self::STATUS_DISABLED)),
            array('sort_order', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 999),
            array('sort_order', 'length', 'min' => 1, 'max' => 3),
            array('api_key', 'length', 'min' => 50, 'max' => 80),
            array('api_key', 'match', 'pattern' => '/[A-Za-z0-9]+/'),
        );
        
        return CMap::mergeArray($rules, parent::rules());    
    }
    
    public function save($extensionInstance)
    {
        $extensionInstance->setOption('api_key', $this->api_key);
        $extensionInstance->setOption('status', $this->status);
        $extensionInstance->setOption('status_on_email_open', $this->status_on_email_open);
        $extensionInstance->setOption('status_on_track_url', $this->status_on_track_url);
        $extensionInstance->setOption('status_on_unsubscribe', $this->status_on_unsubscribe);
        $extensionInstance->setOption('status_on_customer_login', $this->status_on_customer_login);
        $extensionInstance->setOption('sort_order', (int)$this->sort_order);
        
        return $this;
    }
    
    public function populate($extensionInstance) 
    {
        $this->api_key                  = $extensionInstance->getOption('api_key', $this->api_key);
        $this->status                   = $extensionInstance->getOption('status', $this->status);
        $this->status_on_email_open     = $extensionInstance->getOption('status_on_email_open', $this->status_on_email_open);
        $this->status_on_track_url      = $extensionInstance->getOption('status_on_track_url', $this->status_on_track_url);
        $this->status_on_unsubscribe    = $extensionInstance->getOption('status_on_unsubscribe', $this->status_on_unsubscribe);
        $this->status_on_customer_login = $extensionInstance->getOption('status_on_customer_login', $this->status_on_customer_login);
        $this->sort_order               = $extensionInstance->getOption('sort_order', (int)$this->sort_order);
        
        return $this;
    }
    
    public function attributeLabels()
    {
        $labels = array(
            'api_key'                   => Yii::t('ext_ip_location_ipinfodb', 'Api key'),
            'status_on_email_open'      => Yii::t('ext_ip_location_ipinfodb', 'Status on email open'),
            'status_on_track_url'       => Yii::t('ext_ip_location_ipinfodb', 'Status on track url'),
            'status_on_unsubscribe'     => Yii::t('ext_ip_location_ipinfodb', 'Status on unsubscribe'),
            'status_on_customer_login'  => Yii::t('ext_ip_location_ipinfodb', 'Status on customer login'),
            'sort_order'                => Yii::t('ext_ip_location_ipinfodb', 'Sort order'),
        );
        
        return CMap::mergeArray($labels, parent::attributeLabels());    
    }
    
    public function attributePlaceholders()
    {
        $placeholders = array();
        return CMap::mergeArray($placeholders, parent::attributePlaceholders());
    }
    
    public function attributeHelpTexts()
    {
        $texts = array(
            'api_key'                   => Yii::t('ext_ip_location_ipinfodb', 'The api key for your access at ipinfodb.com website'),
            'status'                    => Yii::t('ext_ip_location_ipinfodb', 'Whether this service is enabled and can be used'),
            'status_on_email_open'      => Yii::t('ext_ip_location_ipinfodb', 'Whether to collect ip location information when a campaign email is opened'),
            'status_on_track_url'       => Yii::t('ext_ip_location_ipinfodb', 'Whether to collect ip location information when a campaign link is clicked and tracked'),
            'status_on_unsubscribe'     => Yii::t('ext_ip_location_ipinfodb', 'Whether to collect ip location information when a subscriber unsubscribes via a campaign'),
            'status_on_customer_login'  => Yii::t('ext_ip_location_ipinfodb', 'Whether to collect ip location information when a customer logs in'),
            'sort_order'                => Yii::t('ext_ip_location_ipinfodb', 'If multiple location services active, sort order decides which one queries first'),
        );
        
        return CMap::mergeArray($texts, parent::attributeHelpTexts());
    }

    public function getStatusesDropDown()
    {
        return array(
            self::STATUS_DISABLED   => Yii::t('app', 'Disabled'),
            self::STATUS_ENABLED    => Yii::t('app', 'Enabled'),
        );
    }
    
    public function getSortOrderDropDown()
    {
        $options = array();
        for ($i = 0; $i < 100; ++$i) {
            $options[$i] = $i;
        }
        return $options;
    }
}
