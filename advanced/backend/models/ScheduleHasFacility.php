<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule_has_facility".
 *
 * @property integer $id
 * @property integer $schedule_id
 * @property integer $facility_id
 * @property integer $facility_checklist_id
 *
 * @property Facility $facility
 * @property Schedule1 $schedule
 */
class ScheduleHasFacility extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule_has_facility';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'facility_id', 'facility_checklist_id'], 'integer'],
            [['facility_id', 'facility_checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Facility::className(), 'targetAttribute' => ['facility_id' => 'id', 'facility_checklist_id' => 'checklist_id']],
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
            'schedule_id' => 'Schedule ID',
            'facility_id' => 'Facility ID',
            'facility_checklist_id' => 'Facility Checklist ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacility()
    {
        return $this->hasOne(Facility::className(), ['id' => 'facility_id', 'checklist_id' => 'facility_checklist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule1::className(), ['id' => 'schedule_id']);
    }
}
