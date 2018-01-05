<?php defined('MW_PATH') || exit('No direct script access allowed');



/**
 * This is the model class for table "campaign_url".
 *
 * The followings are the available columns in table 'campaign_url':
 * @property string $url_id
 * @property integer $campaign_id
 * @property string $hash
 * @property string $destination
 * @property string $date_added
 *
 * The followings are the available model relations:
 * @property CampaignTrackUrl[] $trackUrls
 * @property Campaign $campaign
 */
class CampaignUrl extends ActiveRecord
{
    public $counter;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{campaign_url}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array();
        return CMap::mergeArray($rules, parent::rules());
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = array(
            'trackUrls' => array(self::HAS_MANY, 'CampaignTrackUrl', 'url_id'),
            'trackUrlsCount' => array(self::STAT, 'CampaignTrackUrl', 'url_id'),
            'campaign' => array(self::BELONGS_TO, 'Campaign', 'campaign_id'),
        );

        return CMap::mergeArray($relations, parent::relations());
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $labels = array(
            'url_id'        => Yii::t('campaigns', 'Url'),
            'campaign_id'   => Yii::t('campaigns', 'Campaign'),
            'hash'          => Yii::t('campaigns', 'Hash'),
            'destination'   => Yii::t('campaigns', 'Destination'),
            'clicked_times' => Yii::t('campaigns', 'Clicked times'),
        );

        return CMap::mergeArray($labels, parent::attributeLabels());
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CampaignUrl the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getDisplayGridDestination($textLength = 0)
    {
        $destination = str_replace('&amp;', '&', $this->destination);
        $text = $destination;
        if ($textLength > 0) {
            $text = StringHelper::truncateLength($text, $textLength);
        }
        if (FilterVarHelper::url($destination)) {
            return CHtml::link($text, $destination, array('target' => '_blank', 'title' => $destination));
        }
        return $text;
    }
}
