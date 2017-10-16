<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "template".
 *
 * @property integer $id
 * @property string $template_type
 * @property string $template_description
 *
 * @property Email[] $emails
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getInformation()
    {
        return 'Type: '.$this->template_type.', Description: '.$this->template_description;
    }
    public static function tableName()
    {
        return 'template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_type', 'template_description'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_type' => 'Template Type',
            'template_description' => 'Template Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmails()
    {
        return $this->hasMany(Email::className(), ['template_id' => 'id']);
    }
}
