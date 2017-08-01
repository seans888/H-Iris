<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_history".
 *
 * @property integer $id
 * @property string $ch_checkin
 * @property string $ch_checkout
 * @property integer $ch_numberdays
 * @property integer $customer_id
 *
 * @property Customer $customer
 */
class CustomerHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ch_checkin', 'ch_checkout'], 'safe'],
            [['ch_numberdays', 'customer_id'], 'integer'],
            [['customer_id'], 'required'],
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
            'ch_checkin' => 'Check-in Date',
            'ch_checkout' => 'Check-out Date',
            'ch_numberdays' => 'Number of Days',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
