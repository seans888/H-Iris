<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "housekeeping_log_details".
 *
 * @property integer $id
 * @property string $housekeeping_log_details_checklist
 * @property string $housekeeping_log_details_status
 * @property string $housekeeping_log_details_timecompleted
 *
 * @property HousekeepingLog[] $housekeepingLogs
 */
class HousekeepingLogDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'housekeeping_log_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['housekeeping_log_details_timecompleted'], 'safe'],
            [['housekeeping_log_details_checklist', 'housekeeping_log_details_status'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'housekeeping_log_details_checklist' => 'Housekeeping Log Details Checklist',
            'housekeeping_log_details_status' => 'Housekeeping Log Details Status',
            'housekeeping_log_details_timecompleted' => 'Housekeeping Log Details Timecompleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHousekeepingLogs()
    {
        return $this->hasMany(HousekeepingLog::className(), ['housekeeping_log_details_id' => 'id']);
    }
}
