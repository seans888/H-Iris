<?php defined('MW_PATH') || exit('No direct script access allowed');



/**
 * This is the model class for table "campaign_delivery_log".
 *
 * The followings are the available columns in table 'campaign_delivery_log':
 * @property string $log_id
 * @property integer $campaign_id
 * @property integer $subscriber_id
 * @property string $message
 * @property string $processed
 * @property integer $retries
 * @property integer $max_retries
 * @property string $email_message_id
 * @property string $delivery_confirmed
 * @property string $status
 * @property string $date_added
 *
 * The followings are the available model relations:
 * @property ListSubscriber $subscriber
 * @property Campaign $campaign
 * @property DeliveryServer $server
 */
class CampaignDeliveryLog extends ActiveRecord
{
    const STATUS_SUCCESS = 'success';

    const STATUS_ERROR = 'error';

    const STATUS_FATAL_ERROR = 'fatal-error';

    const STATUS_TEMPORARY_ERROR = 'temporary-error';

    const STATUS_BLACKLISTED = 'blacklisted';

    const STATUS_GIVEUP = 'giveup';

    public $customer_id;

    public $list_id;

    public $segment_id;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{campaign_delivery_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array(
            array('delivery_confirmed, status', 'safe', 'on' => 'customer-search'),
            array('customer_id, campaign_id, list_id, segment_id, subscriber_id, message, processed, delivery_confirmed, status', 'safe', 'on' => 'search'),
        );

        return CMap::mergeArray($rules, parent::rules());
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = array(
            'subscriber' => array(self::BELONGS_TO, 'ListSubscriber', 'subscriber_id'),
            'campaign'   => array(self::BELONGS_TO, 'Campaign', 'campaign_id'),
            'server'     => array(self::BELONGS_TO, 'DeliveryServer', 'server_id'),
        );

        return CMap::mergeArray($relations, parent::relations());
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $labels = array(
            'log_id'             => Yii::t('campaigns', 'Log'),
            'campaign_id'        => Yii::t('campaigns', 'Campaign'),
            'subscriber_id'      => Yii::t('campaigns', 'Subscriber'),
            'message'            => Yii::t('campaigns', 'Message'),
            'processed'          => Yii::t('campaigns', 'Processed'),
            'email_message_id'   => Yii::t('campaigns', 'Message ID'),
            'delivery_confirmed' => Yii::t('campaigns', 'Sent'),
            'server_id'          => Yii::t('campaigns', 'Delivery server'),
            
            // search
            'customer_id'   => Yii::t('campaigns', 'Customer'),
            'list_id'       => Yii::t('campaigns', 'List'),
            'segment_id'    => Yii::t('campaigns', 'Segment'),
        );

        $labels = CMap::mergeArray($labels, parent::attributeLabels());
        
        return CMap::mergeArray($labels, array(
            'status' => Yii::t('campaigns', 'Processed status'),
        ));
    }

    protected function beforeSave()
    {
        if ($this->status == self::STATUS_TEMPORARY_ERROR) {
            $this->retries++;
            if ($this->retries >= $this->max_retries) {
                $this->status = self::STATUS_GIVEUP;
            }
        }
        return parent::beforeSave();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function customerSearch()
    {
        $criteria=new CDbCriteria;

        // for BC
        $campaignId = (int)$this->campaign_id;
        if ($campaignId >= 0) {
            $criteria->compare('campaign_id', $campaignId);
        }

        if (!empty($this->subscriber_id)) {
            $criteria->compare('subscriber_id', (int)$this->subscriber_id);
        }

        $criteria->compare('delivery_confirmed', $this->delivery_confirmed);
        $criteria->compare('status', $this->status);
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria'      => $criteria,
            'pagination'    => array(
                'pageSize'  => $this->paginationOptions->getPageSize(),
                'pageVar'   => 'page',
            ),
            'sort'  => array(
                'defaultOrder'  => array(
                    'log_id'    => CSort::SORT_DESC,
                ),
            ),
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->select = 't.message, t.processed, t.status, t.date_added';
        $criteria->with = array(
            'campaign' => array(
                'select'   => 'campaign.name, campaign.list_id, campaign.segment_id',
                'joinType' => 'INNER JOIN',
                'together' => true,
                'with'     => array(
                    'list' => array(
                        'select'    => 'list.name',
                        'joinType'  => 'INNER JOIN',
                        'together'  => true,
                    ),
                    'customer' => array(
                        'select'    => 'customer.customer_id, customer.first_name, customer.last_name',
                        'joinType'  => 'INNER JOIN',
                        'together'  => true,
                    ),
                ),
            ),
            'subscriber' => array(
                'select'    => 'subscriber.email',
                'joinType'  => 'INNER JOIN',
                'together'  => true,
            ),
        );

        if ($this->customer_id && is_numeric($this->customer_id)) {
            $criteria->with['campaign']['with']['customer'] = array_merge($criteria->with['campaign']['with']['customer'], array(
                'condition' => 'customer.customer_id = :customerId',
                'params'    => array(':customerId' => $this->customer_id),
            ));
        } elseif ($this->customer_id && is_string($this->customer_id)) {
            $criteria->with['campaign']['with']['customer'] = array_merge($criteria->with['campaign']['with']['customer'], array(
                'condition' => 'CONCAT(customer.first_name, " ", customer.last_name) LIKE :customerName',
                'params'    => array(':customerName' => '%'. $this->customer_id .'%'),
            ));
        }

        if ($this->campaign_id && is_numeric($this->campaign_id)) {
            $criteria->with['campaign'] = array_merge($criteria->with['campaign'], array(
                'condition' => 'campaign.campaign_id = :campaignId',
                'params'    => array(':campaignId' => $this->campaign_id),
            ));
        } elseif ($this->campaign_id && is_string($this->campaign_id)) {
            $criteria->with['campaign'] = array_merge($criteria->with['campaign'], array(
                'condition' => 'campaign.name LIKE :campaignName',
                'params'    => array(':campaignName' => '%'. $this->campaign_id .'%'),
            ));
        }

        if ($this->list_id && is_numeric($this->list_id)) {
            $criteria->with['campaign']['with']['list'] = array_merge($criteria->with['campaign']['with']['list'], array(
                'condition' => 'list.list_id = :listId',
                'params'    => array(':listId' => $this->list_id),
            ));
        } elseif ($this->list_id && is_string($this->list_id)) {
            $criteria->with['campaign']['with']['list'] = array_merge($criteria->with['campaign']['with']['list'], array(
                'condition' => 'list.name LIKE :listName',
                'params'    => array(':listName' => '%'. $this->list_id .'%'),
            ));
        }

        if ($this->segment_id && is_numeric($this->segment_id)) {
            $criteria->with['campaign']['with']['segment'] = array(
                'condition' => 'segment.segment_id = :segmentId',
                'params'    => array(':segmentId' => $this->segment_id),
            );
        } elseif ($this->segment_id && is_string($this->segment_id)) {
            $criteria->with['campaign']['with']['segment'] = array(
                'condition' => 'segment.name LIKE :segmentId',
                'params'    => array(':segmentId' => '%'. $this->segment_id .'%'),
            );
        }

        if ($this->subscriber_id && is_numeric($this->subscriber_id)) {
            $criteria->with['subscriber'] = array_merge($criteria->with['subscriber'], array(
                'condition' => 'subscriber.subscriber_id = :subscriberId',
                'params'    => array(':subscriberId' => $this->subscriber_id),
            ));
        } elseif ($this->subscriber_id && is_string($this->subscriber_id)) {
            $criteria->with['subscriber'] = array_merge($criteria->with['subscriber'], array(
                'condition' => 'subscriber.email LIKE :subscriberId',
                'params'    => array(':subscriberId' => '%'. $this->subscriber_id .'%'),
            ));
        }

        $criteria->compare('t.message', $this->message, true);
        $criteria->compare('t.processed', $this->processed);
        $criteria->compare('t.delivery_confirmed', $this->delivery_confirmed);
        $criteria->compare('t.status', $this->status);

        $criteria->order = 't.log_id DESC';

        return new CActiveDataProvider(get_class($this), array(
            'criteria'      => $criteria,
            'pagination'    => array(
                'pageSize'  => $this->paginationOptions->getPageSize(),
                'pageVar'   => 'page',
            ),
            'sort'  => array(
                'defaultOrder'  => array(
                    't.log_id'    => CSort::SORT_DESC,
                ),
            ),
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function searchLight()
    {
        $criteria=new CDbCriteria;
        $criteria->order  = 't.log_id DESC';

        return new CActiveDataProvider(get_class($this), array(
            'criteria'      => $criteria,
            'pagination'    => array(
                'pageSize'  => $this->paginationOptions->getPageSize(),
                'pageVar'   => 'page',
            ),
            'sort'  => array(
                'defaultOrder'  => array(
                    't.log_id'    => CSort::SORT_DESC,
                ),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CampaignDeliveryLog the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getStatusesArray()
    {
        return array(
            self::STATUS_SUCCESS        => Yii::t('campaigns', ucfirst(self::STATUS_SUCCESS)),
            self::STATUS_ERROR          => Yii::t('campaigns', ucfirst(self::STATUS_ERROR)),
            self::STATUS_TEMPORARY_ERROR=> Yii::t('campaigns', ucfirst(self::STATUS_TEMPORARY_ERROR)),
            self::STATUS_FATAL_ERROR    => Yii::t('campaigns', ucfirst(self::STATUS_FATAL_ERROR)),
            self::STATUS_GIVEUP         => Yii::t('campaigns', ucfirst(self::STATUS_GIVEUP)),
            self::STATUS_BLACKLISTED    => Yii::t('campaigns', ucfirst(self::STATUS_BLACKLISTED)),
        );
    }

    public static function getArchiveEnabled()
    {
        if (($log_id = Yii::app()->cache->get(md5(__FILE__ . __METHOD__))) === false) {
            $sql = 'SELECT log_id FROM {{campaign_delivery_log_archive}} WHERE `status` = :st AND processed = :pr LIMIT 1';
            $row = Yii::app()->getDb()->createCommand($sql)->queryRow(true, array(':st' => self::STATUS_SUCCESS, ':pr' => self::TEXT_NO));
            $log_id = !empty($row['log_id']) ? $row['log_id'] : 0;
            Yii::app()->cache->set(md5(__FILE__ . __METHOD__), $log_id, 3600);
        }
        return !empty($log_id);
    }

}
