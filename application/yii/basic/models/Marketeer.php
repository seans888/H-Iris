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
 * @property Email $email
 * @property Event $event
 */
class Marketeer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
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
            [['marketeer_fname', 'marketeer_mname', 'marketeer_lname', 'marketeer_contact_number'], 'required'],
            [['marketeer_birthdate'], 'safe'],
            [['marketeer_fname', 'marketeer_lname', 'marketeer_contact_number'], 'string', 'max' => 45],
            [['marketeer_mname'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'marketeer_fname' => 'Marketeer Fname',
            'marketeer_mname' => 'Marketeer Mname',
            'marketeer_lname' => 'Marketeer Lname',
            'marketeer_birthdate' => 'Marketeer Birthdate',
            'marketeer_contact_number' => 'Marketeer Contact Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmail()
    {
        return $this->hasOne(Email::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'id']);
    }
}
