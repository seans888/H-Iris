<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property integer $id
 * @property string $email_date
 * @property string $email_recipient
 * @property string $email_template
 * @property string $email_status
 * @property integer $template_id
 * @property integer $recipient_id
 *
 * @property Activity[] $activities
 * @property Recipient $recipient
 * @property Template $template
 * @property EmailEvent[] $emailEvents
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
            [['template_id', 'recipient_id'], 'required'],
            [['template_id', 'recipient_id'], 'integer'],
            [['email_status'], 'string', 'max' => 45],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipient::className(), 'targetAttribute' => ['recipient_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email_date' => 'Date',
            'email_recipient' => 'Recipient',
            'email_template' => 'Template',
            'email_status' => 'Status',
            'template_id' => 'Template',
            'recipient_id' => 'Recipient',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
     public function getInformation()
    {
        return 'Date: '.$this->email_date.' Recipient: '.$this->email_recipient.' Content: '.$this->email_content;
    }
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['email_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(Recipient::className(), ['id' => 'recipient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailEvents()
    {
        return $this->hasMany(EmailEvent::className(), ['email_id' => 'id']);
    }
}
