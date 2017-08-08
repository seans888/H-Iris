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
 * @property integer $email_activity_id
 *
 * @property Activity $emailActivity
 * @property EmailCustomer[] $emailCustomers
 * @property EmailEvent[] $emailEvents
 * @property ProspectEmail[] $prospectEmails
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
    public function getInformation()
    {
        return $this->email_date.' '.$this->email_recipient.' '.$this->email_content;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_date'], 'safe'],
            [['email_activity_id'], 'required'],
            [['email_activity_id'], 'integer'],
            [['email_recipient', 'email_template'], 'string', 'max' => 45],
            [['email_content'], 'string', 'max' => 1000],
            [['email_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['email_activity_id' => 'id']],
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
            'email_activity_id' => 'Email Activity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'email_activity_id']);
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
    public function getEmailEvents()
    {
        return $this->hasMany(EmailEvent::className(), ['email_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspectEmails()
    {
        return $this->hasMany(ProspectEmail::className(), ['email_id' => 'id']);
    }
}
