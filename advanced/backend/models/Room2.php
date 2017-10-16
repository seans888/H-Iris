<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "room2".
 *
 * @property integer $id
 * @property integer $room_type_id
 * @property resource $room_qr
 *
 * @property HousekeepingLog[] $housekeepingLogs
 * @property RoomType $roomType
 */
class Room2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_type_id'], 'required'],
            [['room_type_id'], 'integer'],
            [['room_qr'], 'string'],
            [['room_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoomType::className(), 'targetAttribute' => ['room_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_type_id' => 'Room Type ID',
            'room_qr' => 'Room Qr',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHousekeepingLogs()
    {
        return $this->hasMany(HousekeepingLog::className(), ['room_id' => 'id', 'room_room_type_id' => 'room_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasOne(RoomType::className(), ['id' => 'room_type_id']);
    }
}
