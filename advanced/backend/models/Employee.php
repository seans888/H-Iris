<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property string $employee_type
 * @property string $employee_fname
 * @property string $employee_mname
 * @property string $employee_lname
 * @property string $employee_contact_number
 *
 * @property Event[] $events
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
     public function getNameAndPosition()
    {
     return $this->employee_fname.' '.$this->employee_lname.', '.$this->employee_type;
    }
    public function rules()
    {
        return [
            [['employee_contact_number'], 'integer'],
            [['employee_type', 'employee_fname', 'employee_mname', 'employee_lname'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_type' => 'Type',
            'employee_fname' => 'First Name',
            'employee_mname' => 'Middle Name',
            'employee_lname' => 'Last Name',
            'employee_contact_number' => 'Contact Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['employee_id' => 'id']);
    }
}
