<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prospect_email".
 *
 * @property integer $prospect_id
 * @property integer $email_id
 *
 * @property Prospect $prospect
 * @property Email $email
 */
class ProspectEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prospect_email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prospect_id', 'email_id'], 'required'],
            [['prospect_id', 'email_id'], 'integer'],
            [['prospect_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prospect::className(), 'targetAttribute' => ['prospect_id' => 'id']],
            [['email_id'], 'exist', 'skipOnError' => true, 'targetClass' => Email::className(), 'targetAttribute' => ['email_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prospect_id' => 'Prospect ID',
            'email_id' => 'Email ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspect()
    {
        return $this->hasOne(Prospect::className(), ['id' => 'prospect_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmail()
    {
        return $this->hasOne(Email::className(), ['id' => 'email_id']);
    }
}
