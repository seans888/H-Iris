<?php defined('MW_PATH') || exit('No direct script access allowed');



/**
 * This is the model class for table "{{customer_suppression_list_email}}".
 *
 * The followings are the available columns in table '{{customer_suppression_list_email}}':
 * @property integer $email_id
 * @property string $email_uid
 * @property integer $list_id
 * @property string $email
 * @property string $date_added
 * @property string $last_updated
 *
 * The followings are the available model relations:
 * @property CustomerSuppressionList $list
 */
class CustomerSuppressionListEmail extends ActiveRecord
{
    /**
     * @var $file uploaded file containing the suppressed emails
     */
    public $file;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customer_suppression_list_email}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        $mimes   = null;
        $options = Yii::app()->options;
        if ($options->get('system.importer.check_mime_type', 'yes') == 'yes' && CommonHelper::functionExists('finfo_open')) {
            $mimes = Yii::app()->extensionMimes->get('csv')->toArray();
        }

        $rules = array(
            array('email', 'required', 'on' => 'insert, update'),
            array('email', 'length', 'max' => 150),
            array('email', '_validateEmail'),
            array('email', '_validateEmailUnique'),
            
            array('email', 'unsafe', 'on' => 'import'),
            array('file', 'required', 'on' => 'import'),
            array('file', 'file', 'types' => array('csv'), 'mimeTypes' => $mimes, 'maxSize' => 512000000, 'allowEmpty' => true),

            array('email', 'safe', 'on' => 'search'),
        );

        return CMap::mergeArray($rules, parent::rules());
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array(
			'list' => array(self::BELONGS_TO, 'CustomerSuppressionList', 'list_id'),
		);

        return CMap::mergeArray($relations, parent::relations());
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
        $labels = array(
			'email_id'  => Yii::t('suppression_lists', 'Email'),
			'email_uid' => Yii::t('suppression_lists', 'Email'),
			'list_id'   => Yii::t('suppression_lists', 'List'),
			'email'     => Yii::t('suppression_lists', 'Email'),
		);

        return CMap::mergeArray($labels, parent::attributeLabels());
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
		$criteria = new CDbCriteria;
        
		$criteria->compare('list_id', (int)$this->list_id);
		$criteria->compare('email', $this->email, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => $this->paginationOptions->getPageSize(),
                'pageVar'  => 'page',
            ),
            'sort' => array(
                'defaultOrder' => array(
                    't.email_id' => CSort::SORT_DESC,
                ),
            ),
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerSuppressionListEmail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return bool
     */
    protected function beforeSave()
    {
        if (empty($this->email_uid)) {
            $this->email_uid = $this->generateUid();
        }

        return parent::beforeSave();
    }

    /**
     * @inheritdoc
     */
    protected function afterSave()
    {
        if (!empty($this->email)) {
            try {
                $criteria = new CDbCriteria();
                $criteria->addInCondition('`list_id`', $this->list->customer->getAllListsIdsNotMerged());
                $criteria->addCondition('(`email` = :e OR MD5(`email`) = :e) AND `status` = :s');
                
                $criteria->params[':e'] = $this->email;
                $criteria->params[':s'] = ListSubscriber::STATUS_CONFIRMED;

                ListSubscriber::model()->updateAll(array(
                    'status' => ListSubscriber::STATUS_BLACKLISTED
                ), $criteria);
            } catch (Exception $e) {

            }
        }
        parent::afterSave();
    }

    /**
     * @return bool
     * @throws CDbException
     */
    public function delete()
    {
        try {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('`list_id`', $this->list->customer->getAllListsIdsNotMerged());
            $criteria->addCondition('(`email` = :e OR MD5(`email`) = :e) AND `status` = :s');

            $criteria->params[':e'] = $this->email;
            $criteria->params[':s'] = ListSubscriber::STATUS_BLACKLISTED;

            ListSubscriber::model()->updateAll(array(
                'status' => ListSubscriber::STATUS_CONFIRMED
            ), $criteria);
        } catch (Exception $e) {

        }
        
        return parent::delete();
    }

    /**
     * @param $email_uid
     * @return static
     */
    public function findByUid($email_uid)
    {
        return $this->findByAttributes(array(
            'email_uid' => $email_uid,
        ));
    }

    /**
     * @return string
     */
    public function generateUid()
    {
        $unique = StringHelper::uniqid();
        $exists = $this->findByUid($unique);

        if (!empty($exists)) {
            return $this->generateUid();
        }

        return $unique;
    }

    /**
     * @param $email
     * @return static
     */
    public function findByEmail($email)
    {
        return $this->findByAttributes(array('email' => $email));
    }

    /**
     * @param $email
     * @return bool
     * @throws CDbException
     */
    public static function removeByEmail($email)
    {
        if (!($model = self::model()->findByEmail($email))) {
            return false;
        }
        return $model->delete();
    }

    /**
     * @param ListSubscriber $subscriber
     * @param Campaign $campaign
     * @return bool
     */
    public static function isSubscriberListedByCampaign(ListSubscriber $subscriber, Campaign $campaign)
    {
        if ($campaign->isNewRecord || $subscriber->isNewRecord) {
            return false;
        }
        
        static $emailsStore = array();
        if (!isset($emailsStore[$campaign->campaign_id])) {
            $emailsStore[$campaign->campaign_id] = array();
        }
        if (isset($emailsStore[$campaign->campaign_id][$subscriber->email])) {
            return $emailsStore[$campaign->campaign_id][$subscriber->email];
        }
        $emailsStore[$campaign->campaign_id][$subscriber->email] = false;
        
        static $suppressionLists = array();
        if (!array_key_exists($campaign->campaign_id, $suppressionLists)) {
            $lists = CustomerSuppressionListToCampaign::model()->findAllByAttributes(array(
                'campaign_id' => $campaign->campaign_id,
            ));
            foreach ($lists as $list) {
                $suppressionLists[$campaign->campaign_id][] = (int)$list->list_id;
            }
        }
        if (empty($suppressionLists[$campaign->campaign_id])) {
            return $emailsStore[$campaign->campaign_id][$subscriber->email] = false;
        }
        
        $lists   = $suppressionLists[$campaign->campaign_id];
        $command = Yii::app()->getDb()->createCommand();
        $command->select('email_id')
            ->from('{{customer_suppression_list_email}}')
            ->where('list_id IN(' . implode(',', $lists) . ') AND (`email` = :email OR MD5(`email`) = :email)', array(
                ':email' => $subscriber->email,
            ));

        $blacklisted = $command->queryRow();
        
        if (empty($blacklisted)) {
            return $emailsStore[$campaign->campaign_id][$subscriber->email] = false;
        }
        
        if ($subscriber->getIsConfirmed()) {
            $subscriber->saveStatus(ListSubscriber::STATUS_BLACKLISTED);
        }
        
        return $emailsStore[$campaign->campaign_id][$subscriber->email] = true;
    }

    /**
     * @param $attribute
     * @param $params
     * @return bool|void
     */
    public function _validateEmailUnique($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        $duplicate = self::model()->findByAttributes(array(
            'list_id' => (int)$this->list->list_id,
            'email'   => $this->$attribute
        ));

        if (!empty($duplicate)) {
            $this->addError('email', Yii::t('suppression_lists', 'The email address {email} is already in your blacklist!', array(
                '{email}' => $this->$attribute
            )));
            return;
        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function _validateEmail($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }
        
        if (empty($this->$attribute)) {
            return;
        }
        
        if (FilterVarHelper::email($this->$attribute)) {
            return;
        }

        if (StringHelper::isMd5($this->$attribute)) {
            return;
        }

        $this->addError($attribute, Yii::t('suppression_lists', 'Please enter a valid email address, or a md5 of the email address!'));
    }
}
