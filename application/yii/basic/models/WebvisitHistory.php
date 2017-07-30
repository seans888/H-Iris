<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "webvisit_history".
 *
 * @property integer $id
 * @property string $wvh_date
 * @property string $wvh_time
 * @property integer $wvh_ip_address
 * @property string $wvh_url
 * @property string $wvh_cookie_information
 * @property integer $customer_id
 * @property integer $Prospect_id
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
            [['wvh_ip_address', 'customer_id', 'Prospect_id'], 'integer'],
            [['customer_id', 'Prospect_id'], 'required'],
            [['wvh_url'], 'string', 'max' => 100],
            [['wvh_cookie_information'], 'string', 'max' => 45],
            [['Prospect_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prospect::className(), 'targetAttribute' => ['Prospect_id' => 'id']],
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
            'wvh_date' => 'Wvh Date',
            'wvh_time' => 'Wvh Time',
            'wvh_ip_address' => 'Wvh Ip Address',
            'wvh_url' => 'Wvh Url',
            'wvh_cookie_information' => 'Wvh Cookie Information',
            'customer_id' => 'Customer ID',
            'Prospect_id' => 'Prospect ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspect()
    {
        return $this->hasOne(Prospect::className(), ['id' => 'Prospect_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
