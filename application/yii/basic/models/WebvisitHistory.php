<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "webvisit_history".
 *
 * @property integer $id
 * @property string $wvh_date
 * @property string $wvh_time
 * @property string $wvh_ip_address
 * @property string $wvh_url
 * @property string $wvh_cookie_information
 * @property integer $customer_id
 * @property integer $prospect_id
 *
 * @property Prospect $prospect
 * @property Customer $customer
 */
class WebvisitHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webvisit_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wvh_date', 'wvh_time'], 'safe'],
            [['customer_id', 'prospect_id'], 'required'],
            [['customer_id', 'prospect_id'], 'integer'],
            [['wvh_ip_address'], 'string', 'max' => 20],
            [['wvh_url'], 'string', 'max' => 100],
            [['wvh_cookie_information'], 'string', 'max' => 45],
            [['prospect_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prospect::className(), 'targetAttribute' => ['prospect_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wvh_date' => 'Web Visit History Date',
            'wvh_time' => 'Web Visit History Time',
            'wvh_ip_address' => 'Web Visit History Ip Address',
            'wvh_url' => 'Web Visit History Url',
            'wvh_cookie_information' => 'Web Visit History Cookie Information',
            'customer_id' => 'Customer Name',
            'prospect_id' => 'Prospect Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspect()
    {
        return $this->hasOne(Prospect::className(), ['id' => 'prospect_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
