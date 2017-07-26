<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $customer_email
 * @property string $customer_fname
 * @property string $customer_mname
 * @property string $customer_lname
 * @property string $customer_contact_number
 *
 * @property CustomerHistory $customerHistory
 * @property CustomerPreference $customerPreference
 * @property Preference[] $ids
 * @property EmailCustomer $emailCustomer
 * @property Email[] $ids0
 * @property WebvisitHistory $webvisitHistory
 * @property Prospect[] $ids1
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
            [['customer_email', 'customer_fname', 'customer_lname', 'customer_contact_number'], 'required'],
            [['customer_email', 'customer_fname', 'customer_lname', 'customer_contact_number'], 'string', 'max' => 45],
            [['customer_mname'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_email' => 'Customer Email',
            'customer_fname' => 'Customer Fname',
            'customer_mname' => 'Customer Mname',
            'customer_lname' => 'Customer Lname',
            'customer_contact_number' => 'Customer Contact Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerHistory()
    {
        return $this->hasOne(CustomerHistory::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerPreference()
    {
        return $this->hasOne(CustomerPreference::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds()
    {
        return $this->hasMany(Preference::className(), ['id' => 'id'])->viaTable('customer_preference', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailCustomer()
    {
        return $this->hasOne(EmailCustomer::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds0()
    {
        return $this->hasMany(Email::className(), ['id' => 'id'])->viaTable('email_customer', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebvisitHistory()
    {
        return $this->hasOne(WebvisitHistory::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds1()
    {
        return $this->hasMany(Prospect::className(), ['id' => 'id'])->viaTable('webvisit_history', ['id' => 'id']);
    }
}
