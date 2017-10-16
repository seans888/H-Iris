<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event1".
 *
 * @property integer $id
 * @property string $event_name
 * @property string $event_venue
 * @property string $event_start_date
 * @property string $event_end_date
 * @property string $event_type
 * @property integer $employee_id
 *
 * @property Employee3 $employee
 * @property EventCollaboration[] $eventCollaborations
 * @property EventHasRoom[] $eventHasRooms
 * @property EventSchedule[] $eventSchedules
 * @property Feedback[] $feedbacks
 * @property Landmark[] $landmarks
 * @property Newsfeed[] $newsfeeds
 */
class Event1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_start_date', 'event_end_date'], 'safe'],
            [['employee_id'], 'required'],
            [['employee_id'], 'integer'],
            [['event_name', 'event_venue'], 'string', 'max' => 120],
            [['event_type'], 'string', 'max' => 45],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee3::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_name' => 'Event Name',
            'event_venue' => 'Event Venue',
            'event_start_date' => 'Event Start Date',
            'event_end_date' => 'Event End Date',
            'event_type' => 'Event Type',
            'employee_id' => 'Employee ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee3::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventCollaborations()
    {
        return $this->hasMany(EventCollaboration::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventHasRooms()
    {
        return $this->hasMany(EventHasRoom::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventSchedules()
    {
        return $this->hasMany(EventSchedule::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLandmarks()
    {
        return $this->hasMany(Landmark::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsfeeds()
    {
        return $this->hasMany(Newsfeed::className(), ['event_id' => 'id']);
    }
}
