<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $customer_checkin
 * @property string $customer_checkout
 * @property string $customer_numberdays
 *
 * @property Recipient[] $recipients
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
  
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_checkin', 'customer_checkout', 'customer_numberdays'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_checkin' => 'Customer Checkin',
            'customer_checkout' => 'Customer Checkout',
            'customer_numberdays' => 'Customer Numberdays',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipients()
    {
        return $this->hasMany(Recipient::className(), ['customer_id' => 'id']);
    }
}
