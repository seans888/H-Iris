<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event_has_room".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $room_id
 *
 * @property Event1 $event
 * @property Room1 $room
 * @property EventSchedule[] $eventSchedules
 */
class EventHasRoom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_has_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'room_id'], 'required'],
            [['event_id', 'room_id'], 'integer'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event1::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room1::className(), 'targetAttribute' => ['room_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'room_id' => 'Room ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event1::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room1::className(), ['id' => 'room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventSchedules()
    {
        return $this->hasMany(EventSchedule::className(), ['event_has_room_id' => 'id']);
    }
}
