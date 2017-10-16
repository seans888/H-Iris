<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "checklist_category".
 *
 * @property integer $id
 * @property string $checklist_category_name
 *
 * @property ChecklistRef[] $checklistRefs
 */
class ChecklistCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'checklist_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['checklist_category_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'checklist_category_name' => 'Checklist Category Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklistRefs()
    {
        return $this->hasMany(ChecklistRef::className(), ['checklist_category_id' => 'id']);
    }
}
