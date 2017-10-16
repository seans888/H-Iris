<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property integer $id
 * @property string $email_date
 * @property string $email_template
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
            [['email_status'], 'string'],
            [['template_id', 'customer_id'], 'required'],
            [['template_id', 'customer_id'], 'integer'],
            [['email_template'], 'string', 'max' => 45],
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
            'email_date' => 'Email Date',
            'email_template' => 'Email Template',
            'email_status' => 'Email Status',
            'template_id' => 'Template ID',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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
