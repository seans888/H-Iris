<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_activity".
 *
 * @property integer $id
 * @property string $email_activity_status
 * @property string $email_activity_date
 * @property string $email_activity_time
 *
 * @property Email $id0
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
            [['email_activity_status', 'email_activity_date'], 'required'],
            [['email_activity_date', 'email_activity_time'], 'safe'],
            [['email_activity_status'], 'string', 'max' => 45],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Email::className(), 'targetAttribute' => ['id' => 'id']],
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
            'email_activity_time' => 'Email Activity Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Email::className(), ['id' => 'id']);
    }
}
