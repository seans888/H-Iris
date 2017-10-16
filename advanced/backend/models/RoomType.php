<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "room_type".
 *
 * @property integer $id
 * @property string $room_type
 *
 * @property ChecklistItems[] $checklistItems
 * @property Room2[] $room2s
 */
class RoomType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_type' => 'Room Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklistItems()
    {
        return $this->hasMany(ChecklistItems::className(), ['room_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom2s()
    {
        return $this->hasMany(Room2::className(), ['room_type_id' => 'id']);
    }
}
