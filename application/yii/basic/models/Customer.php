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
   public function getInformation()
    {
        return 'Check-In Date: '.$this->customer_checkin.' Check-out Date: '.$this->customer_checkout;
    }
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
            'customer_checkin' => 'Check-In Date',
            'customer_checkout' => 'Check-Out Date',
            'customer_numberdays' => 'Number of Days',
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
