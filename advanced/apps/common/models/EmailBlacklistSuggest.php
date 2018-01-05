<?php defined('MW_PATH') || exit('No direct script access allowed');



/**
 * This is the model class for table "email_blacklist".
 *
 * The followings are the available columns in table 'email_blacklist_suggest':
 * @property integer $email_id
 * @property string $email
 * @property string $ip_address
 * @property string $user_agent
 * @property string $date_added
 * @property string $last_updated
 */
class EmailBlacklistSuggest extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{email_blacklist_suggest}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array(
            array('email', 'required'),
            array('email', 'length', 'max' => 150),
            array('email', 'email', 'validateIDN' => true),
            array('email', 'unique', 'message' => Yii::t('email_blacklist', '{attribute} "{value}" has already been blocked.')),
            
            array('email, ip_address, user_agent', 'safe', 'on' => 'search'),
        );

        return CMap::mergeArray($rules, parent::rules());
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $labels = array(
            'email_id'      => Yii::t('email_blacklist', 'Email'),
            'email'         => Yii::t('email_blacklist', 'Email'),
            'ip_address'    => Yii::t('email_blacklist', 'Ip address'),
            'user_agent'    => Yii::t('email_blacklist', 'User agent'),
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
        $criteria->compare('email', $this->email, true);
        $criteria->compare('ip_address', $this->ip_address, true);
        $criteria->compare('user_agent', $this->user_agent, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'      => $criteria,
            'pagination'    => array(
                'pageSize'  => $this->paginationOptions->getPageSize(),
                'pageVar'   => 'page',
            ),
            'sort'=>array(
                'defaultOrder' => array(
                    'email_id'  => CSort::SORT_DESC,
                ),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EmailBlacklist the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
