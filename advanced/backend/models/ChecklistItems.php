<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "checklist_items".
 *
 * @property integer $id
 * @property integer $checklist_ref_id
 * @property integer $room_type_id
 *
 * @property ChecklistRef $checklistRef
 * @property RoomType $roomType
 */
class ChecklistItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'checklist_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['checklist_ref_id', 'room_type_id'], 'required'],
            [['checklist_ref_id', 'room_type_id'], 'integer'],
            [['checklist_ref_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChecklistRef::className(), 'targetAttribute' => ['checklist_ref_id' => 'id']],
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
            'checklist_ref_id' => 'Checklist Ref ID',
            'room_type_id' => 'Room Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklistRef()
    {
        return $this->hasOne(ChecklistRef::className(), ['id' => 'checklist_ref_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasOne(RoomType::className(), ['id' => 'room_type_id']);
    }
}
