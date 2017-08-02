<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_activity".
 *
 * @property integer $id
 * @property string $email_activity_status
 * @property string $email_activity_date
 * @property integer $email_id
 *
 * @property Email $email
 */
class EmailActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_activity_date'], 'safe'],
            [['email_id'], 'required'],
            [['email_id'], 'integer'],
            [['email_activity_status'], 'string', 'max' => 45],
            [['email_id'], 'exist', 'skipOnError' => true, 'targetClass' => Email::className(), 'targetAttribute' => ['email_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email_activity_status' => 'Email Activity Status',
            'email_activity_date' => 'Email Activity Date',
            'email_id' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmail()
    {
        return $this->hasOne(Email::className(), ['id' => 'email_id']);
    }
}
