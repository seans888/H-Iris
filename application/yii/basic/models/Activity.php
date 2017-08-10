<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property integer $id
 * @property string $activity_status
 * @property string $activity_description
 *
 * @property Email[] $emails
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->activity_status; 
    }
    public function rules()
    {
        return [
            [['activity_status'], 'string', 'max' => 45],
            [['activity_description'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_status' => 'Status',
            'activity_description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmails()
    {
        return $this->hasMany(Email::className(), ['email_activity_id' => 'id']);
    }
}
