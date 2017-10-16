<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee1".
 *
 * @property integer $id
 * @property integer $department_id
 * @property string $fname
 * @property string $surname
 * @property string $position
 * @property integer $supervisor
 * @property string $sched_start
 * @property string $sched_end
 *
 * @property Department $department
 * @property Employee1 $supervisor0
 * @property Employee1[] $employee1s
 * @property Ticket[] $tickets
 * @property Ticket[] $tickets0
 * @property Transcript[] $transcripts
 * @property Transcript[] $transcripts0
 */
class Employee1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id', 'fname', 'surname', 'position', 'supervisor', 'sched_start'], 'required'],
            [['department_id', 'supervisor'], 'integer'],
            [['sched_start', 'sched_end'], 'safe'],
            [['fname', 'surname', 'position'], 'string', 'max' => 45],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['supervisor'], 'exist', 'skipOnError' => true, 'targetClass' => Employee1::className(), 'targetAttribute' => ['supervisor' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department_id' => 'Department ID',
            'fname' => 'Fname',
            'surname' => 'Surname',
            'position' => 'Position',
            'supervisor' => 'Supervisor',
            'sched_start' => 'Sched Start',
            'sched_end' => 'Sched End',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisor0()
    {
        return $this->hasOne(Employee1::className(), ['id' => 'supervisor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee1s()
    {
        return $this->hasMany(Employee1::className(), ['supervisor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['emp_repond_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets0()
    {
        return $this->hasMany(Ticket::className(), ['emp_create_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranscripts()
    {
        return $this->hasMany(Transcript::className(), ['by_employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranscripts0()
    {
        return $this->hasMany(Transcript::className(), ['current_emp_resp' => 'id']);
    }
}
