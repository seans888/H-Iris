<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $customer_fname
 * @property string $customer_mname
 * @property string $customer_lname
 * @property string $customer_email
 * @property integer $customer_contact_number
 *
 * @property CustomerHistory[] $customerHistories
 * @property CustomerPreference[] $customerPreferences
 * @property Preference[] $preferences
 * @property EmailCustomer[] $emailCustomers
 * @property Email[] $emails
 * @property WebvisitHistory[] $webvisitHistories
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

        public function getName()
    {
    return $this->customer_fname.' '.$this->customer_lname;
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
            [['customer_contact_number'], 'integer'],
            [['customer_fname', 'customer_mname', 'customer_lname', 'customer_email'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_fname' => 'Customer First Name',
            'customer_mname' => 'Customer Middle Name',
            'customer_lname' => 'Customer Last Name',
            'customer_email' => 'Customer Email',
            'customer_contact_number' => 'Customer Contact Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerHistories()
    {
        return $this->hasMany(CustomerHistory::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerPreferences()
    {
        return $this->hasMany(CustomerPreference::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreferences()
    {
        return $this->hasMany(Preference::className(), ['id' => 'preference_id'])->viaTable('customer_preference', ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailCustomers()
    {
        return $this->hasMany(EmailCustomer::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmails()
    {
        return $this->hasMany(Email::className(), ['id' => 'email_id'])->viaTable('email_customer', ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebvisitHistories()
    {
        return $this->hasMany(WebvisitHistory::className(), ['customer_id' => 'id']);
    }
}
