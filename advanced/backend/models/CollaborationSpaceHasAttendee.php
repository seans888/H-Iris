<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collaboration_space_has_attendee".
 *
 * @property integer $id
 * @property integer $attendee_id
 * @property integer $collaboration_space_attendee_id
 * @property string $message
 *
 * @property Attendee $attendee
 */
class CollaborationSpaceHasAttendee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collaboration_space_has_attendee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'attendee_id', 'collaboration_space_attendee_id'], 'required'],
            [['id', 'attendee_id', 'collaboration_space_attendee_id'], 'integer'],
            [['message'], 'string', 'max' => 140],
            [['attendee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attendee::className(), 'targetAttribute' => ['attendee_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attendee_id' => 'Attendee ID',
            'collaboration_space_attendee_id' => 'Collaboration Space Attendee ID',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttendee()
    {
        return $this->hasOne(Attendee::className(), ['id' => 'attendee_id']);
    }
}
