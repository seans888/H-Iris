<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recipient".
 *
 * @property integer $id
 * @property string $recipient_type
 * @property string $recipient_email
 * @property string $recipient_fname
 * @property string $recipient_mname
 * @property string $recipient_lname
 * @property string $recipient_contact_number
 * @property integer $customer_id
 *
 * @property Email[] $emails
 * @property Customer $customer
 * @property RecipientPreference[] $recipientPreferences
 * @property WebvisitHistory[] $webvisitHistories
 */
class Recipient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipient_contact_number', 'customer_id'], 'integer'],
            [['customer_id'], 'required'],
            [['recipient_type', 'recipient_email', 'recipient_fname', 'recipient_mname', 'recipient_lname'], 'string', 'max' => 45],
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
            'recipient_type' => 'Recipient Type',
            'recipient_email' => 'Recipient Email',
            'recipient_fname' => 'Recipient Fname',
            'recipient_mname' => 'Recipient Mname',
            'recipient_lname' => 'Recipient Lname',
            'recipient_contact_number' => 'Recipient Contact Number',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmails()
    {
        return $this->hasMany(Email::className(), ['recipient_id' => 'id']);
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
    public function getRecipientPreferences()
    {
        return $this->hasMany(RecipientPreference::className(), ['recipient_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebvisitHistories()
    {
        return $this->hasMany(WebvisitHistory::className(), ['recipient_id' => 'id']);
    }
}
