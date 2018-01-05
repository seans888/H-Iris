<?php defined('MW_PATH') || exit('No direct script access allowed');


/**
 * This is the model class for table "campaign_template".
 *
 * The followings are the available columns in table 'campaign_template':
 * @property integer $template_id
 * @property integer $campaign_id
 * @property integer $customer_template_id
 * @property string $content
 * @property string $inline_css
 * @property string $minify
 * @property string $meta_data
 * @property string $plain_text
 * @property string $only_plain_text
 * @property string $auto_plain_text
 *
 * The followings are the available model relations:
 * @property Campaign $campaign
 * @property CustomerEmailTemplate $customerTemplate
 * @property CampaignTemplateUrlActionListField[] $urlActionListFields
 * @property CampaignTemplateUrlActionSubscriber[] $urlActionSubscribers
 */
class CampaignTemplate extends ActiveRecord
{
    // enable importing from url
    public $from_url;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{campaign_template}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array(
            array('content, auto_plain_text, only_plain_text', 'required'),
            array('content', 'customer.components.validators.CampaignTemplateValidator'),
            array('only_plain_text, auto_plain_text', 'in', 'range' => array_keys($this->getYesNoOptions())),
            array('plain_text, from_url', 'safe'),
        );

        return CMap::mergeArray($rules, parent::rules());
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = array(
            'campaign'              => array(self::BELONGS_TO, 'Campaign', 'campaign_id'),
            'customerTemplate'      => array(self::BELONGS_TO, 'CustomerEmailTemplate', 'customer_template_id'),
            'urlActionListFields'   => array(self::HAS_MANY, 'CampaignTemplateUrlActionListField', 'template_id'),
            'urlActionSubscribers'  => array(self::HAS_MANY, 'CampaignTemplateUrlActionSubscriber', 'template_id'),
        );

        return CMap::mergeArray($relations, parent::relations());
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $labels = array(
            'campaign_id'       => Yii::t('campaigns', 'Campaign'),
            'content'           => Yii::t('campaigns', 'Content'),
            'plain_text'        => Yii::t('campaigns', 'Plain text'),
            'only_plain_text'   => Yii::t('campaigns', 'Only plain text'),
            'auto_plain_text'   => Yii::t('campaigns', 'Auto plain text'),
            'from_url'          => Yii::t('campaigns', 'From url'),
        );

        return CMap::mergeArray($labels, parent::attributeLabels());
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CampaignTemplate the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeSave()
    {
        $this->content = EmojiHelper::encodeEmoji($this->content);
        return parent::beforeSave();
    }

    public function getInlineCssArray()
    {
        return $this->getYesNoOptions();
    }

    public function getAutoPlainTextArray()
    {
        return $this->getYesNoOptions();
    }

    public function attributePlaceholders()
    {
        $placeholders = array(
            'content'           => '',
            'plain_text'        => '',
            'only_plain_text'   => '',
            'auto_plain_text'   => '',
            'from_url'          => '',
        );

        return CMap::mergeArray($placeholders, parent::attributePlaceholders());
    }

    public function attributeHelpTexts()
    {
        $texts = array(
            'content'           => '',
            'plain_text'        => Yii::t('campaigns', 'This is the plain text version of the html template. If left empty and autogenerate option is set to "yes" then this will be created based on your html template.'),
            'only_plain_text'   => Yii::t('campaigns', 'Whether the template contains only plain text and should be treated like so by all parsers.'),
            'auto_plain_text'   => Yii::t('campaigns', 'Whether the plain text version of the html template should be auto generated.'),
            'from_url'          => Yii::t('campaigns', 'Enter url to fetch as a template'),
        );

        return CMap::mergeArray($texts, parent::attributeHelpTexts());
    }

    // see also CampaignHelper class
    public function getAvailableTags()
    {
        $tags = array(
            array('tag' => '[UNSUBSCRIBE_URL]', 'required' => true, 'alt_tags_if_tag_required_and_missing' => array('[UNSUBSCRIBE_LINK]', '[DIRECT_UNSUBSCRIBE_URL]', '[DIRECT_UNSUBSCRIBE_LINK]')),
            array('tag' => '[COMPANY_FULL_ADDRESS]', 'required' => true),
            array('tag' => '[UNSUBSCRIBE_LINK]', 'required' => false, 'alt_tags_if_tag_required_and_missing' => array('[UNSUBSCRIBE_URL]', '[UNSUBSCRIBE_LINK]', '[DIRECT_UNSUBSCRIBE_LINK]')),
            array('tag' => '[UPDATE_PROFILE_URL]', 'required' => false),
            array('tag' => '[WEB_VERSION_URL]', 'required' => false),
            array('tag' => '[CAMPAIGN_URL]', 'required' => false),
            array('tag' => '[FORWARD_FRIEND_URL]', 'required' => false),
            array('tag' => '[DIRECT_UNSUBSCRIBE_URL]', 'required' => false, 'alt_tags_if_tag_required_and_missing' => array('[UNSUBSCRIBE_URL]', '[UNSUBSCRIBE_LINK]', '[DIRECT_UNSUBSCRIBE_LINK]')),
            array('tag' => '[DIRECT_UNSUBSCRIBE_LINK]', 'required' => false, 'alt_tags_if_tag_required_and_missing' => array('[UNSUBSCRIBE_URL]', '[UNSUBSCRIBE_LINK]', '[DIRECT_UNSUBSCRIBE_URL]')),
            array('tag' => '[LIST_UID]', 'required' => false),
            array('tag' => '[LIST_NAME]', 'required' => false),
            array('tag' => '[LIST_SUBJECT]', 'required' => false),
            array('tag' => '[LIST_DESCRIPTION]', 'required' => false),
            array('tag' => '[LIST_FROM_NAME]', 'required' => false),
            array('tag' => '[LIST_FROM_EMAIL]', 'required' => false),

            array('tag' => '[CURRENT_YEAR]', 'required' => false),
            array('tag' => '[CURRENT_MONTH]', 'required' => false),
            array('tag' => '[CURRENT_DAY]', 'required' => false),
            array('tag' => '[CURRENT_DATE]', 'required' => false),
            array('tag' => '[CURRENT_MONTH_FULL_NAME]', 'required' => false),

            array('tag' => '[COMPANY_NAME]', 'required' => false),
            array('tag' => '[COMPANY_WEBSITE]', 'required' => false),
            array('tag' => '[COMPANY_ADDRESS_1]', 'required' => false),
            array('tag' => '[COMPANY_ADDRESS_2]', 'required' => false),
            array('tag' => '[COMPANY_CITY]', 'required' => false),
            array('tag' => '[COMPANY_ZONE]', 'required' => false),
            array('tag' => '[COMPANY_ZIP]', 'required' => false),
            array('tag' => '[COMPANY_COUNTRY]', 'required' => false),
            array('tag' => '[COMPANY_PHONE]', 'required' => false),

            array('tag' => '[CAMPAIGN_NAME]', 'required' => false),
            array('tag' => '[CAMPAIGN_SUBJECT]', 'required' => false),
            array('tag' => '[CAMPAIGN_TO_NAME]', 'required' => false),
            array('tag' => '[CAMPAIGN_FROM_NAME]', 'required' => false),
            array('tag' => '[CAMPAIGN_FROM_EMAIL]', 'required' => false),
            array('tag' => '[CAMPAIGN_REPLY_TO]', 'required' => false),
            array('tag' => '[CAMPAIGN_UID]', 'required' => false),
            array('tag' => '[CAMPAIGN_SEND_AT]', 'required' => false),
            array('tag' => '[CAMPAIGN_STARTED_AT]', 'required' => false),
            array('tag' => '[CAMPAIGN_DATE_ADDED]', 'required' => false),
            array('tag' => '[CAMPAIGN_SEGMENT_NAME]', 'required' => false),
           
            array('tag' => '[SUBSCRIBER_UID]', 'required' => false),
            array('tag' => '[SUBSCRIBER_IP]', 'required' => false),
            array('tag' => '[SUBSCRIBER_DATE_ADDED]', 'required' => false),
            array('tag' => '[SUBSCRIBER_DATE_ADDED_LOCALIZED]', 'required' => false),
            array('tag' => '[SUBSCRIBER_OPTIN_IP]', 'required' => false),
            array('tag' => '[SUBSCRIBER_OPTIN_DATE]', 'required' => false),
            array('tag' => '[SUBSCRIBER_CONFIRM_IP]', 'required' => false),
            array('tag' => '[SUBSCRIBER_CONFIRM_DATE]', 'required' => false),
            array('tag' => '[SUBSCRIBER_LAST_SENT_DATE]', 'required' => false),
            array('tag' => '[SUBSCRIBER_LAST_SENT_DATE_LOCALIZED]', 'required' => false),
            
            array('tag' => '[DATE]', 'required' => false),
            array('tag' => '[DATETIME]', 'required' => false),
            array('tag' => '[RANDOM_CONTENT:a|b|c]', 'required' => false),
            array('tag' => '[CAMPAIGN_REPORT_ABUSE_URL]', 'required' => false),
            array('tag' => '[CURRENT_DOMAIN_URL]', 'required' => false),
            array('tag' => '[CURRENT_DOMAIN]', 'required' => false),

            array('tag' => '[DS_NAME]', 'required' => false),
            array('tag' => '[DS_HOST]', 'required' => false),
            array('tag' => '[DS_TYPE]', 'required' => false),
            array('tag' => '[DS_ID]', 'required' => false),
            array('tag' => '[DS_FROM_NAME]', 'required' => false),
            array('tag' => '[DS_FROM_EMAIL]', 'required' => false),
            array('tag' => '[DS_REPLYTO_EMAIL]', 'required' => false),
        );

        if (!empty($this->campaign) && !empty($this->campaign->list)) {
            $fields = $this->campaign->list->fields;
            foreach ($fields as $field) {
                $tags[] = array('tag' => '['.$field->tag.']', 'required' => false);
            }
        } else {
            $tags[] = array('tag' => '[EMAIL]', 'required' => false);
            $tags[] = array('tag' => '[FNAME]', 'required' => false);
            $tags[] = array('tag' => '[LNAME]', 'required' => false);
        }

        // since 1.3.5.9
        if (!empty($this->campaign)) {
            $customerCampaignTags = CustomerCampaignTag::model()->findAll(array(
                'select'    => 'tag',
                'condition' => 'customer_id = :cid',
                'params'    => array(':cid' => $this->campaign->customer_id),
                'limit'     => 100,
            ));
            foreach ($customerCampaignTags as $cct) {
                $tags[] = array('tag' => '[' . CustomerCampaignTag::getTagPrefix() . $cct->tag . ']', 'required' => false);
            }
        }

        $tags = (array)Yii::app()->hooks->applyFilters('campaign_template_available_tags_list', $tags, $this);

        $optionTags = (array)Yii::app()->options->get('system.campaign.template_tags.template_tags', array());
        
        // since 1.3.6.3
        $optionTags = (array)Yii::app()->hooks->applyFilters('campaign_template_available_option_tags_list', $optionTags, $this);
        
        foreach ($optionTags as $optionTagInfo) {
            if (!isset($optionTagInfo['tag'], $optionTagInfo['required'])) {
                continue;
            }
            foreach ($tags as $index => $tag) {
                if ($tag['tag'] == $optionTagInfo['tag']) {
                    $tags[$index]['required'] = (bool)$optionTagInfo['required'];
                    break;
                }
            }
        }

        return $tags;
    }

    public function getContentUrls()
    {
        return CampaignHelper::extractTemplateUrls($this->content);
    }

    public function getIsOnlyPlainText()
    {
        return $this->only_plain_text == self::TEXT_YES;
    }

    public function getExtraUtmTags()
    {
        return array(
            '[TITLE_ATTR]' => Yii::t('campaigns', 'Will use the title attribute of the element'),
        );
    }
}
