<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "checklist_ref".
 *
 * @property integer $id
 * @property string $checklist_description
 * @property integer $checklist_category_id
 *
 * @property ChecklistItems[] $checklistItems
 * @property ChecklistCategory $checklistCategory
 */
class ChecklistRef extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'checklist_ref';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['checklist_category_id'], 'required'],
            [['checklist_category_id'], 'integer'],
            [['checklist_description'], 'string', 'max' => 60],
            [['checklist_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChecklistCategory::className(), 'targetAttribute' => ['checklist_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'checklist_description' => 'Checklist Description',
            'checklist_category_id' => 'Checklist Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklistItems()
    {
        return $this->hasMany(ChecklistItems::className(), ['checklist_ref_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklistCategory()
    {
        return $this->hasOne(ChecklistCategory::className(), ['id' => 'checklist_category_id']);
    }
}
