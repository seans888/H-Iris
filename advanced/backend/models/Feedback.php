<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $feedback_rating
 * @property string $feedback_comment
 * @property integer $attendee_id
 * @property integer $employee_id
 * @property integer $event_id
 * @property integer $employee_id1
 *
 * @property Employee3 $employeeId1
 * @property Event1 $event
 * @property Attendee $attendee
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'attendee_id', 'employee_id', 'event_id', 'employee_id1'], 'required'],
            [['id', 'attendee_id', 'employee_id', 'event_id', 'employee_id1'], 'integer'],
            [['feedback_rating', 'feedback_comment'], 'string', 'max' => 45],
            [['employee_id1'], 'exist', 'skipOnError' => true, 'targetClass' => Employee3::className(), 'targetAttribute' => ['employee_id1' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event1::className(), 'targetAttribute' => ['event_id' => 'id']],
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
            'feedback_rating' => 'Feedback Rating',
            'feedback_comment' => 'Feedback Comment',
            'attendee_id' => 'Attendee ID',
            'employee_id' => 'Employee ID',
            'event_id' => 'Event ID',
            'employee_id1' => 'Employee Id1',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeId1()
    {
        return $this->hasOne(Employee3::className(), ['id' => 'employee_id1']);
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
    public function getAttendee()
    {
        return $this->hasOne(Attendee::className(), ['id' => 'attendee_id']);
    }
}
