<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preference".
 *
 * @property integer $id
 * @property string $preference_category
 * @property string $preference_description
 *
 * @property RecipientPreference[] $recipientPreferences
 */
class Preference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preference_category', 'preference_description'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preference_category' => 'Preference Category',
            'preference_description' => 'Preference Description',
        ];
    }
    public function getPreference() 
    { 
    return $this->preference_category.', '.$this->preference_description; 
    }  

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipientPreferences()
    {
        return $this->hasMany(RecipientPreference::className(), ['preference_id' => 'id']);
    }
}
