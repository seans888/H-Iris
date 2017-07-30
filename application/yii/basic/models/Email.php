<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property integer $id
 * @property string $email_date
 * @property string $email_recipient
 * @property string $email_content
 * @property string $email_template
 * @property integer $marketeer_id
 *
 * @property Marketeer $marketeer
 * @property EmailActivity[] $emailActivities
 * @property EmailCustomer[] $emailCustomers
 * @property Customer[] $customers
 * @property ProspectEmail[] $prospectEmails
 * @property Prospect[] $prospects
 */
class Email extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_date'], 'safe'],
            [['marketeer_id'], 'required'],
            [['marketeer_id'], 'integer'],
            [['email_recipient', 'email_template'], 'string', 'max' => 45],
            [['email_content'], 'string', 'max' => 1000],
            [['marketeer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marketeer::className(), 'targetAttribute' => ['marketeer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email_date' => 'Email Date',
            'email_recipient' => 'Email Recipient',
            'email_content' => 'Email Content',
            'email_template' => 'Email Template',
            'marketeer_id' => 'Marketeer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    /**function getFullName()
    {
    return $this->marketeer_fname.' '.$this->marketeer_lname;
    }**/

    public function getMarketeer()
    {
         
        return $this->hasOne(Marketeer::className(), ['id' => 'marketeer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailActivities()
    {
        return $this->hasMany(EmailActivity::className(), ['email_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailCustomers()
    {
        return $this->hasMany(EmailCustomer::className(), ['email_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['id' => 'customer_id'])->viaTable('email_customer', ['email_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspectEmails()
    {
        return $this->hasMany(ProspectEmail::className(), ['email_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspects()
    {
        return $this->hasMany(Prospect::className(), ['id' => 'prospect_id'])->viaTable('prospect_email', ['email_id' => 'id']);
    }
}
