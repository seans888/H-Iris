<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_history".
 *
 * @property integer $id
 * @property string $customer_history_checkin
 * @property string $customer_history_checkout
 * @property string $customer_history_numberdays
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
            [['customer_id'], 'required'],
            [['customer_id'], 'integer'],
            [['customer_history_checkin', 'customer_history_checkout', 'customer_history_numberdays'], 'string', 'max' => 45],
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
            'customer_history_checkin' => 'Check-in Date',
            'customer_history_checkout' => 'Check-out Date',
            'customer_history_numberdays' => 'Number of days',
            'customer_id' => 'Customer',
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
