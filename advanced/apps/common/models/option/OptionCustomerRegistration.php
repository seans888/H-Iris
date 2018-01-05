<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * OptionCustomerRegistration
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.4.3
 */
 
class OptionCustomerRegistration extends OptionBase
{
    // send email method
    const SEND_EMAIL_TRANSACTIONAL = 'transactional';
    
    // send email method
    const SEND_EMAIL_DIRECT = 'direct';
    
    // settings category
    protected $_categoryName = 'system.customer_registration';
    
    // is customer registration allowed?
    public $enabled = 'no';
    
    // default group after registration
    public $default_group;
    
    // remove unconfirmed after x days
    public $unconfirm_days_removal = 7;
    
    // if customers must be approved after registration confirmation
    public $require_approval = 'no';

    // if customers must confirm their email addresses
    public $require_email_confirmation = 'yes';
    
    // whether company info is required
    public $company_required = 'no';
    
    // terms and conditions url
    public $tc_url;
    
    // notification emails when a new customer registers
    public $new_customer_registration_notification_to;
    
    // send email method
    public $send_email_method = 'transactional';
    
    // forbidden domains
    public $forbidden_domains = '';
    
    // facebook login/register
    public $facebook_app_id;
    public $facebook_app_secret;
    public $facebook_enabled = 'no';
    
    // twitter login register
    public $twitter_app_consumer_key;
    public $twitter_app_consumer_secret;
    public $twitter_enabled = 'no';
    
    // welcome email
    public $welcome_email = 'no';
    public $welcome_email_subject;
    public $welcome_email_content;
    
    // default country/timezone
    public $default_country;
    public $default_timezone;
    
    // send to email list
    public $api_url;
    public $api_private_key;
    public $api_public_key;
    public $api_list_uid;
    
    public function init()
    {
        parent::init();
        $this->api_url = rtrim(Yii::app()->apps->getAppBaseUrl('api', true), '/');
    }
    
    public function rules()
    {
        $rules = array(
            array('enabled, unconfirm_days_removal, require_approval, require_email_confirmation, company_required, send_email_method, welcome_email', 'required'),
            array('enabled, require_approval, require_email_confirmation, company_required, facebook_enabled, twitter_enabled, welcome_email', 'in', 'range' => array_keys($this->getYesNoOptions())),
            array('unconfirm_days_removal', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => 365),
            array('default_group', 'exist', 'className' => 'CustomerGroup', 'attributeName' => 'group_id'),
            array('tc_url', 'url'),
            array('send_email_method', 'in', 'range' => array_keys($this->getSendEmailMethods())),
            array('forbidden_domains', '_validateForbiddenDomains'),
            array('new_customer_registration_notification_to, facebook_app_id, facebook_app_secret, twitter_app_consumer_key, twitter_app_consumer_secret', 'safe'),
            array('welcome_email_subject, welcome_email_content', 'safe'),
            array('default_country', 'in', 'range' => array_keys(Country::getAsDropdownOptions())),
            array('default_timezone', 'in', 'range' => array_keys(DateTimeHelper::getTimeZones())),
            array('api_url', 'url'),
            array('api_private_key, api_public_key', 'length', 'is' => 40),
            array('api_list_uid', 'safe'),
        );
        
        return CMap::mergeArray($rules, parent::rules());    
    }

    protected function beforeValidate()
    {
        if ($this->enabled == self::TEXT_NO) {
            $this->default_group = '';
        }
        
        return parent::beforeValidate();
    }
    
    public function attributeLabels()
    {
        $labels = array(
            'enabled'                   => Yii::t('settings', 'Enabled'),
            'unconfirm_days_removal'    => Yii::t('settings', 'Unconfirmed removal days'),
            'default_group'             => Yii::t('settings', 'Default group'),
            'require_approval'          => Yii::t('settings', 'Require approval'),
            'require_email_confirmation'=> Yii::t('settings', 'Require email confirmation'),
            'company_required'          => Yii::t('settings', 'Require company info'),
            'tc_url'                    => Yii::t('settings', 'Terms and conditions url'),
            'send_email_method'         => Yii::t('settings', 'Send email method'),
            'forbidden_domains'         => Yii::t('settings', 'Forbidden domains'),
            
            'api_url'           => Yii::t('settings', 'Api url'),
            'api_private_key'   => Yii::t('settings', 'Api private key'),
            'api_public_key'    => Yii::t('settings', 'Api public key'),
            'api_list_uid'      => Yii::t('settings', 'Api list unique id'),
             
            'facebook_app_id'             => Yii::t('settings', 'Facebook application id'),
            'facebook_app_secret'         => Yii::t('settings', 'Facebook application secret'),
            'facebook_enabled'            => Yii::t('settings', 'Enabled'),
            'twitter_app_consumer_key'    => Yii::t('settings', 'Twitter application consumer key'),
            'twitter_app_consumer_secret' => Yii::t('settings', 'Twitter application consumer secret'),
            'twitter_enabled'             => Yii::t('settings', 'Enabled'),
            
            'new_customer_registration_notification_to' => Yii::t('settings', 'New customer notification'),
            
            'welcome_email'         => Yii::t('settings', 'Send welcome email'),
            'welcome_email_subject' => Yii::t('settings', 'Subject'),
            'welcome_email_content' => Yii::t('settings', 'Content'),
            
            'default_country'  => Yii::t('settings', 'Default country'),
            'default_timezone' => Yii::t('settings', 'Default timezone'),
        );
        
        return CMap::mergeArray($labels, parent::attributeLabels());    
    }
    
    public function attributePlaceholders()
    {
        $placeholders = array(
            'enabled'                => '',
            'unconfirm_days_removal' => '',
            'default_group'          => '',
            'require_approval'       => '',
            'company_required'       => '',
            'tc_url'                 => '',
            'send_email_method'      => '',
            'forbidden_domains'      => 'yahoo.com, hotmail.com, gmail.com',
        
            'facebook_app_id'             => '365206940300000',
            'facebook_app_secret'         => 'e48f5d4b30fcea90cb47a7b8cb50ft2y',
            'twitter_app_consumer_key'    => 'E1BBQZGOLU6IXAVRVZN371237',
            'twitter_app_consumer_secret' => 'f2SVAvDEwcpqEmoDxoXN42p19Xem6zsXHYF7l0eUaI6Ed9alt2',
            
            'new_customer_registration_notification_to' => '',
        );
        
        return CMap::mergeArray($placeholders, parent::attributePlaceholders());
    }
    
    public function attributeHelpTexts()
    {
        $texts = array(
            'enabled'                    => Yii::t('settings', 'Whether the customer registration is enabled'),
            'unconfirm_days_removal'     => Yii::t('settings', 'How many days to keep the unconfirmed customers in the system before permanent removal'),
            'default_group'              => Yii::t('settings', 'Default group for customer after registration'),
            'require_approval'           => Yii::t('settings', 'Whether customers must be approved after they have confirmed the registration'),
            'require_email_confirmation' => Yii::t('settings', 'Whether the customers must confirm their email address before being able to login'),
            'company_required'           => Yii::t('settings', 'Whether the company basic info is required'),
            'tc_url'                     => Yii::t('settings', 'The url for terms and conditions for the customer to read before signup'),
            'send_email_method'          => Yii::t('settings', 'Whether to send the email directly or to queue it to be later sent via transactional emails'),
            'forbidden_domains'          => Yii::t('settings', 'Do not allow registration if an email address belongs to any of these domains. You can type: "yahoo.com" to block only yahoo.com emails, or "yahoo" to block all domain names that start with "yahoo" wording, i.e: yahoo.co.uk'),
            
            'new_customer_registration_notification_to' => Yii::t('settings', 'One or multiple email addresses separated by a comma to where notifications about new customer registration will be sent'),
            
            'welcome_email'         => Yii::t('settings', 'Whether this welcome email should be sent to new customers'),
            'welcome_email_subject' => Yii::t('settings', 'The subject for the welcome email, following customer tags are recognized and parsed: {tags}', array('{tags}' => '[FIRST_NAME], [LAST_NAME], [FULL_NAME], [EMAIL]')),
            'welcome_email_content' => Yii::t('settings', 'The content for the welcome email, following customer tags are recognized and parsed: {tags}. Please note that the common template will be used as the layout.', array('{tags}' => '[FIRST_NAME], [LAST_NAME], [FULL_NAME], [EMAIL]')),

            'api_url'           => Yii::t('settings', 'The url where the api resides and where we will send the customer as a subscriber'),
            'api_private_key'   => Yii::t('settings', 'The private key for api access'),
            'api_public_key'    => Yii::t('settings', 'The public key for api access'),
            'api_list_uid'      => Yii::t('settings', 'The list unique id where the subscriber will go. You can use multiple lists as well, separate them using a comma, i.e: ju12gt28s412m, h12uod3nsyr2b'),
        );
        
        return CMap::mergeArray($texts, parent::attributeHelpTexts());
    }

    public function getGroupsList()
    {
        static $options;
        if ($options !== null) {
            return $options;
        }
        
        $options = array();
        $groups  = CustomerGroup::model()->findAll();
        
        foreach ($groups as $group) {
            $options[$group->group_id] = $group->name;
        }
        
        return $options;
    }
    
    public function getSendEmailMethods()
    {
        return array(
            self::SEND_EMAIL_TRANSACTIONAL => Yii::t('settings', ucfirst(self::SEND_EMAIL_TRANSACTIONAL)),
            self::SEND_EMAIL_DIRECT        => Yii::t('settings', ucfirst(self::SEND_EMAIL_DIRECT)),
        );
    }
    
    public function _validateForbiddenDomains($attribute, $params)
    {
        if ($this->hasErrors($attribute) || empty($this->$attribute)) {
            return;
        }
        $pieces = explode(',', $this->$attribute);
        $pieces = array_map('strtolower', array_map('trim', $pieces));
        $pieces = array_unique($pieces);
        
        $valid = array();
        foreach ($pieces as $piece) {
            $valid[] = $piece;
        }
        $this->$attribute = implode(', ', $valid);
    }
}
