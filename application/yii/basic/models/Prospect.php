<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prospect".
 *
 * @property integer $id
 * @property string $prospect_email
 * @property string $prospect_fname
 * @property string $prospect_mname
 * @property string $prospect_lname
 * @property string $prospect_contact_number
 *
 * @property ProspectEmail $prospectEmail
 * @property Email[] $ids
 * @property ProspectPreference $prospectPreference
 * @property Preference[] $ids0
 * @property WebvisitHistory $webvisitHistory
 * @property Customer[] $ids1
 */
class Prospect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prospect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prospect_email', 'prospect_fname', 'prospect_lname', 'prospect_contact_number'], 'required'],
            [['prospect_email', 'prospect_fname', 'prospect_lname', 'prospect_contact_number'], 'string', 'max' => 45],
            [['prospect_mname'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prospect_email' => 'Prospect Email',
            'prospect_fname' => 'Prospect Fname',
            'prospect_mname' => 'Prospect Mname',
            'prospect_lname' => 'Prospect Lname',
            'prospect_contact_number' => 'Prospect Contact Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspectEmail()
    {
        return $this->hasOne(ProspectEmail::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds()
    {
        return $this->hasMany(Email::className(), ['id' => 'id'])->viaTable('prospect_email', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspectPreference()
    {
        return $this->hasOne(ProspectPreference::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds0()
    {
        return $this->hasMany(Preference::className(), ['id' => 'id'])->viaTable('prospect_preference', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebvisitHistory()
    {
        return $this->hasOne(WebvisitHistory::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds1()
    {
        return $this->hasMany(Customer::className(), ['id' => 'id'])->viaTable('webvisit_history', ['id' => 'id']);
    }
}
