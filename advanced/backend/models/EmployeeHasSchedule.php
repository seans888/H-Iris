<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_has_schedule".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property integer $schedule_id
 *
 * @property Employee2 $employee
 * @property Schedule1 $schedule
 */
class EmployeeHasSchedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_has_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'schedule_id'], 'integer'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee2::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['schedule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Schedule1::className(), 'targetAttribute' => ['schedule_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'schedule_id' => 'Schedule ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee2::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule1::className(), ['id' => 'schedule_id']);
    }
}
