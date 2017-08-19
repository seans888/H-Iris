<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $customer_type
 * @property string $customer_email
 * @property string $customer_fname
 * @property string $customer_mname
 * @property string $customer_lname
 * @property string $customer_contact_number
 *
 * @property CustomerHistory[] $customerHistories
 * @property CustomerPreference[] $customerPreferences
 * @property Email[] $emails
 * @property WebvisitHistory[] $webvisitHistories
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
            [['customer_contact_number'], 'integer'],
            [['customer_type', 'customer_email', 'customer_fname', 'customer_mname', 'customer_lname'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_type' => 'Type',
            'customer_email' => 'Email',
            'customer_fname' => 'First Name',
            'customer_mname' => 'Middle Name',
            'customer_lname' => 'Last Name',
            'customer_contact_number' => 'Contact Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
     public function getName() 
    { 
    return $this->customer_fname.' '.$this->customer_lname.', '.$this->customer_type; 
    }    
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
    public function getEmails()
    {
        return $this->hasMany(Email::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebvisitHistories()
    {
        return $this->hasMany(WebvisitHistory::className(), ['customer_id' => 'id']);
    }
}
