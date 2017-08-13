<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $event_date_created
 * @property string $event_description
 * @property string $event_start_date
 * @property string $event_end_date
 * @property integer $employee_id
 *
 * @property EmailEvent[] $emailEvents
 * @property Employee $employee
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_date_created', 'event_start_date', 'event_end_date'], 'safe'],
            [['employee_id'], 'required'],
            [['employee_id'], 'integer'],
            [['event_description'], 'string', 'max' => 400],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_date_created' => 'Event Date Created',
            'event_description' => 'Event Description',
            'event_start_date' => 'Event Start Date',
            'event_end_date' => 'Event End Date',
            'employee_id' => 'Employee',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailEvents()
    {
        return $this->hasMany(EmailEvent::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }
}
