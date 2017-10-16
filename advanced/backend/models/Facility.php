<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facility".
 *
 * @property integer $id
 * @property string $facility_type
 * @property string $facility_status
 * @property string $facility_qrcode
 * @property integer $checklist_id
 *
 * @property EmployeeHasFacility[] $employeeHasFacilities
 * @property Checklist $checklist
 * @property ScheduleHasFacility[] $scheduleHasFacilities
 */
class Facility extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facility';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['checklist_id'], 'required'],
            [['checklist_id'], 'integer'],
            [['facility_type', 'facility_status', 'facility_qrcode'], 'string', 'max' => 45],
            [['checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Checklist::className(), 'targetAttribute' => ['checklist_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'facility_type' => 'Facility Type',
            'facility_status' => 'Facility Status',
            'facility_qrcode' => 'Facility Qrcode',
            'checklist_id' => 'Checklist ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeHasFacilities()
    {
        return $this->hasMany(EmployeeHasFacility::className(), ['facility_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklist()
    {
        return $this->hasOne(Checklist::className(), ['id' => 'checklist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleHasFacilities()
    {
        return $this->hasMany(ScheduleHasFacility::className(), ['facility_id' => 'id', 'facility_checklist_id' => 'checklist_id']);
    }
}
