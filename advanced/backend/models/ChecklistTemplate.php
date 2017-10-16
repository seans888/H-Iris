<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "checklist_template".
 *
 * @property integer $id
 * @property string $checklist_template_type
 * @property string $checklist_template_equipment
 * @property string $checklist_template_temperature
 * @property integer $checklist_template_equipment_number
 * @property string $checklist_template_equipment_description
 * @property integer $checklist_id
 *
 * @property Checklist $checklist
 */
class ChecklistTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'checklist_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['checklist_template_equipment_number', 'checklist_id'], 'integer'],
            [['checklist_id'], 'required'],
            [['checklist_template_type'], 'string', 'max' => 10],
            [['checklist_template_equipment', 'checklist_template_temperature'], 'string', 'max' => 45],
            [['checklist_template_equipment_description'], 'string', 'max' => 60],
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
            'checklist_template_type' => 'Checklist Template Type',
            'checklist_template_equipment' => 'Checklist Template Equipment',
            'checklist_template_temperature' => 'Checklist Template Temperature',
            'checklist_template_equipment_number' => 'Checklist Template Equipment Number',
            'checklist_template_equipment_description' => 'Checklist Template Equipment Description',
            'checklist_id' => 'Checklist ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklist()
    {
        return $this->hasOne(Checklist::className(), ['id' => 'checklist_id']);
    }
}
