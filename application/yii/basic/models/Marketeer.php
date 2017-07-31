<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "marketeer".
 *
 * @property integer $id
 * @property string $marketeer_fname
 * @property string $marketeer_mname
 * @property string $marketeer_lname
 * @property string $marketeer_birthdate
 * @property string $marketeer_contact_number
 *
 * @property Email[] $emails
 * @property Event[] $events
 */
class Marketeer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getFull()
    {
    return $this->marketeer_fname.' '.$this->marketeer_lname;
    }
    public static function tableName()
    {
        return 'marketeer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marketeer_birthdate'], 'safe'],
            [['marketeer_contact_number'], 'integer'],
            [['marketeer_fname', 'marketeer_mname', 'marketeer_lname'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'marketeer_fname' => 'Marketeer First Name',
            'marketeer_mname' => 'Marketeer Middle Name',
            'marketeer_lname' => 'Marketeer Last Name',
            'marketeer_birthdate' => 'Marketeer Birthdate',
            'marketeer_contact_number' => 'Marketeer Contact Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmails()
    {
        return $this->hasMany(Email::className(), ['marketeer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['marketeer_id' => 'id']);
    }
}
