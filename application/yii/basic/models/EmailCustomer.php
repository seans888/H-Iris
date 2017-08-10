<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_customer".
 *
 * @property integer $email_id
 * @property integer $customer_id
 *
 * @property Customer $customer
 * @property Email $email
 */
class EmailCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_id', 'customer_id'], 'required'],
            [['email_id', 'customer_id'], 'integer'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['email_id'], 'exist', 'skipOnError' => true, 'targetClass' => Email::className(), 'targetAttribute' => ['email_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email_id' => 'Email',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmail()
    {
        return $this->hasOne(Email::className(), ['id' => 'email_id']);
    }
}
