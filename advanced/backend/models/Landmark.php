<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "landmark".
 *
 * @property integer $id
 * @property string $landmark_name
 * @property string $landmark_address
 * @property string $landmark_distance_from_attendee
 * @property integer $event_id
 *
 * @property Event1 $event
 */
class Landmark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'landmark';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['landmark_distance_from_attendee', 'event_id'], 'required'],
            [['event_id'], 'integer'],
            [['landmark_name', 'landmark_address', 'landmark_distance_from_attendee'], 'string', 'max' => 45],
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
            'landmark_name' => 'Landmark Name',
            'landmark_address' => 'Landmark Address',
            'landmark_distance_from_attendee' => 'Landmark Distance From Attendee',
            'event_id' => 'Event ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event1::className(), ['id' => 'event_id']);
    }
}
