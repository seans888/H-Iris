<?php defined('MW_PATH') || exit('No direct script access allowed');



/**
 * This is the model class for table "{{price_plan}}".
 *
 * The followings are the available columns in table '{{price_plan}}':
 * @property integer $plan_id
 * @property string $plan_uid
 * @property integer $group_id
 * @property string $name
 * @property string $price
 * @property string $description
 * @property string $recommended
 * @property string $visible
 * @property integer $sort_order
 * @property string $status
 * @property string $date_added
 * @property string $last_updated
 *
 * The followings are the available model relations:
 * @property CustomerGroup $customerGroup
 * @property PricePlanOrder[] $pricePlanOrders
 */
class PricePlan extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{price_plan}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		$rules = array(
			array('group_id, name, price, recommended, status', 'required'),
            
			array('group_id', 'numerical', 'integerOnly' => true),
            array('group_id', 'exist', 'className' => 'CustomerGroup'),
			array('name', 'length', 'max' => 50),
			array('price', 'numerical'),
            array('price', 'type', 'type' => 'float'),
			array('recommended, visible', 'in', 'range' => array_keys($this->getYesNoOptions())),
			array('status', 'in', 'range' => array_keys($this->getStatusesList())),
			array('sort_order', 'numerical', 'integerOnly' => true),
            
			// The following rule is used by search().
			array('name, group_id, price, status', 'safe', 'on'=>'search'),
            array('description', 'safe'),
		);
        return CMap::mergeArray($rules, parent::rules());
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array(
			'customerGroup'   => array(self::BELONGS_TO, 'CustomerGroup', 'group_id'),
            'pricePlanOrders' => array(self::HAS_MANY, 'PricePlanOrder', 'plan_id'),
		);
        return CMap::mergeArray($relations, parent::relations());
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'plan_id'     => Yii::t('price_plans', 'Plan'),
			'plan_uid'    => Yii::t('price_plans', 'Plan uid'),
			'group_id'    => Yii::t('price_plans', 'Customer group'),
			'name'        => Yii::t('price_plans', 'Name'),
			'price'       => Yii::t('price_plans', 'Price'),
			'description' => Yii::t('price_plans', 'Description'),
			'recommended' => Yii::t('price_plans', 'Recommended'),
            'visible'     => Yii::t('price_plans', 'Visible'),
		);
        return CMap::mergeArray($labels, parent::attributeLabels());
	}
    
    /**
     * @return array help text for attributes
     */
    public function attributeHelpTexts()
    {
        $texts = array(
			'group_id'    => Yii::t('price_plans', 'The group where the customer will be moved after purchasing this plan. Make sure the group has proper permissions and limits'),
			'name'        => Yii::t('price_plans', 'The price plan name, used in customer display area, orders, etc'),
			'price'       => Yii::t('price_plans', 'The amount the customers will be charged when buying this plan'),
			'description' => Yii::t('price_plans', 'A detailed description about the price plan features'),
			'recommended' => Yii::t('price_plans', 'Whether this plan has the recommended badge on it'),
            'visible'     => Yii::t('price_plans', 'Whether this plan is visible in customers area'),
		);
        
        return CMap::mergeArray($texts, parent::attributeHelpTexts());
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

		$criteria->compare('name', $this->name, true);
        $criteria->compare('group_id', $this->group_id);
		$criteria->compare('price', $this->price, true);
		$criteria->compare('status', $this->status);

		return new CActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => $this->paginationOptions->getPageSize(),
                'pageVar'  => 'page',
            ),
            'sort'=>array(
                'defaultOrder' => array(
                    'sort_order'  => CSort::SORT_ASC,
                    'plan_id'     => CSort::SORT_DESC,
                ),
            ),
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PricePlan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    protected function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }
        
        if (empty($this->plan_uid)) {
            $this->plan_uid = $this->generateUid();
        }

        return true;
    }
    
    public function findByUid($plan_uid)
    {
        return $this->findByAttributes(array(
            'plan_uid' => $plan_uid,
        ));    
    }
    
    public function generateUid()
    {
        $unique = StringHelper::uniqid();
        $exists = $this->findByUid($unique);
        
        if (!empty($exists)) {
            return $this->generateUid();
        }
        
        return $unique;
    }

    public function getUid()
    {
        return $this->plan_uid;
    }
    
    public function getFormattedPrice()
    {
        return Yii::app()->numberFormatter->formatCurrency($this->price, $this->getCurrency()->code);
    }
    
    public function getCurrency()
    {
        return Currency::model()->findDefault();
    }
    
    public function getIsRecommended()
    {
        return $this->recommended == self::TEXT_YES;
    }
}
