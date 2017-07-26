<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property integer $id
 * @property string $email
 * @property string $email_recipient
 * @property string $email_content
 * @property string $email_template
 *
 * @property Marketeer $id0
 * @property EmailActivity $emailActivity
 * @property EmailCustomer $emailCustomer
 * @property Customer[] $ids
 * @property ProspectEmail $prospectEmail
 * @property Prospect[] $ids0
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
            [['email'], 'safe'],
            [['email_recipient', 'email_content', 'email_template'], 'required'],
            [['email_recipient', 'email_template'], 'string', 'max' => 45],
            [['email_content'], 'string', 'max' => 1000],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Marketeer::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'email_recipient' => 'Email Recipient',
            'email_content' => 'Email Content',
            'email_template' => 'Email Template',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Marketeer::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailActivity()
    {
        return $this->hasOne(EmailActivity::className(), ['id' => 'id']);
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
    public function getIds()
    {
        return $this->hasMany(Customer::className(), ['id' => 'id'])->viaTable('email_customer', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspectEmail()
    {
        return $this->hasOne(ProspectEmail::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds0()
    {
        return $this->hasMany(Prospect::className(), ['id' => 'id'])->viaTable('prospect_email', ['id' => 'id']);
    }
}
