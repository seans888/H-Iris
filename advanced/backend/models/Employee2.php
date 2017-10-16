<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee2".
 *
 * @property integer $id
 * @property string $employee_lastname
 * @property string $employee_firstname
 * @property integer $employee_number
 * @property string $employee_email
 * @property string $employee_occupation
 * @property string $employee_user_type
 *
 * @property EmployeeHasFacility[] $employeeHasFacilities
 * @property EmployeeHasSchedule[] $employeeHasSchedules
 */
class Employee2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_number'], 'integer'],
            [['employee_lastname', 'employee_firstname', 'employee_email', 'employee_occupation', 'employee_user_type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_lastname' => 'Employee Lastname',
            'employee_firstname' => 'Employee Firstname',
            'employee_number' => 'Employee Number',
            'employee_email' => 'Employee Email',
            'employee_occupation' => 'Employee Occupation',
            'employee_user_type' => 'Employee User Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeHasFacilities()
    {
        return $this->hasMany(EmployeeHasFacility::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeHasSchedules()
    {
        return $this->hasMany(EmployeeHasSchedule::className(), ['employee_id' => 'id']);
    }
}
