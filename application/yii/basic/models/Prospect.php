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
 * @property integer $prospect_contact_number
 *
 * @property ProspectEmail[] $prospectEmails
 * @property Email[] $emails
 * @property ProspectPreference[] $prospectPreferences
 * @property Preference[] $preferences
 * @property WebvisitHistory[] $webvisitHistories
 */
class Prospect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public function getName()
    {
    return $this->prospect_fname.' '.$this->prospect_lname;
    }
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
            [['prospect_contact_number'], 'integer'],
            [['prospect_email', 'prospect_fname', 'prospect_mname', 'prospect_lname'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prospect_email' => 'Email Address',
            'prospect_fname' => 'First Name',
            'prospect_mname' => 'Middle Name',
            'prospect_lname' => 'Last Name',
            'prospect_contact_number' => 'Contact Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspectEmails()
    {
        return $this->hasMany(ProspectEmail::className(), ['prospect_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmails()
    {
        return $this->hasMany(Email::className(), ['id' => 'email_id'])->viaTable('prospect_email', ['prospect_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspectPreferences()
    {
        return $this->hasMany(ProspectPreference::className(), ['prospect_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreferences()
    {
        return $this->hasMany(Preference::className(), ['id' => 'preference_id'])->viaTable('prospect_preference', ['prospect_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebvisitHistories()
    {
        return $this->hasMany(WebvisitHistory::className(), ['Prospect_id' => 'id']);
    }
}
