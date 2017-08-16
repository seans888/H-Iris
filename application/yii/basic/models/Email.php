<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property integer $id
 * @property string $email_date
 * @property string $email_status
 * @property integer $template_id
 * @property integer $customer_id
 *
 * @property Activity[] $activities
 * @property Customer $customer
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
            [['template_id', 'customer_id'], 'required'],
            [['template_id', 'customer_id'], 'integer'],
            [['email_status'], 'string', 'max' => 45],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
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
            'email_date' => 'Date Sent',
            'email_status' => 'Email Status',
            'template_id' => 'Template',
            'customer_id' => 'Customer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformation()
    {
     return $this->email_date.' '.$this->email_status;
    }
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['email_id' => 'id']);
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
