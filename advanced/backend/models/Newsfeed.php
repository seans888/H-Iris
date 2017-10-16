<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "newsfeed".
 *
 * @property integer $id
 * @property string $newsfeed_post
 * @property string $newsfeed_comment
 * @property integer $attendee_id
 * @property integer $event_id
 *
 * @property Attendee $attendee
 * @property Event1 $event
 */
class Newsfeed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'newsfeed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attendee_id', 'event_id'], 'required'],
            [['attendee_id', 'event_id'], 'integer'],
            [['newsfeed_post'], 'string', 'max' => 140],
            [['newsfeed_comment'], 'string', 'max' => 45],
            [['attendee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attendee::className(), 'targetAttribute' => ['attendee_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event1::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'newsfeed_post' => 'Newsfeed Post',
            'newsfeed_comment' => 'Newsfeed Comment',
            'attendee_id' => 'Attendee ID',
            'event_id' => 'Event ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttendee()
    {
        return $this->hasOne(Attendee::className(), ['id' => 'attendee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event1::className(), ['id' => 'event_id']);
    }
}
