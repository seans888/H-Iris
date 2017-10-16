<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee3".
 *
 * @property integer $id
 * @property string $emp_name
 * @property string $emp_surname
 * @property string $emp_dept
 * @property string $emp_position
 *
 * @property Attendee[] $attendees
 * @property Event1[] $event1s
 * @property Feedback[] $feedbacks
 */
class Employee3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_name', 'emp_surname', 'emp_dept', 'emp_position'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emp_name' => 'Emp Name',
            'emp_surname' => 'Emp Surname',
            'emp_dept' => 'Emp Dept',
            'emp_position' => 'Emp Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttendees()
    {
        return $this->hasMany(Attendee::className(), ['employee_id1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent1s()
    {
        return $this->hasMany(Event1::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['employee_id1' => 'id']);
    }
}
