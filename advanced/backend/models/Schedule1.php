<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule1".
 *
 * @property integer $id
 * @property string $schudule_date
 *
 * @property EmployeeHasSchedule[] $employeeHasSchedules
 * @property ScheduleHasFacility[] $scheduleHasFacilities
 */
class Schedule1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schudule_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'schudule_date' => 'Schudule Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeHasSchedules()
    {
        return $this->hasMany(EmployeeHasSchedule::className(), ['schedule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleHasFacilities()
    {
        return $this->hasMany(ScheduleHasFacility::className(), ['schedule_id' => 'id']);
    }
}
