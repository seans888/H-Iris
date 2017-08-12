<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prospect_preference".
 *
 * @property integer $id
 * @property integer $prospect_id
 * @property integer $preference_id
 *
 * @property Prospect $prospect
 * @property Preference $preference
 */
class ProspectPreference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prospect_preference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prospect_id', 'preference_id'], 'required'],
            [['prospect_id', 'preference_id'], 'integer'],
            [['prospect_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prospect::className(), 'targetAttribute' => ['prospect_id' => 'id']],
            [['preference_id'], 'exist', 'skipOnError' => true, 'targetClass' => Preference::className(), 'targetAttribute' => ['preference_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prospect_id' => 'Prospect',
            'preference_id' => 'Preference',
        ];
    }

     public function getfullName()
    {
        return $this->hasOne(Prospect::className(), ['id' => 'prospect.fullName']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspect()
    {
        return $this->hasOne(Prospect::className(), ['id' => 'prospect_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreference()
    {
        return $this->hasOne(Preference::className(), ['id' => 'preference_id']);
    }
}
