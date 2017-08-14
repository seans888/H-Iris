<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recipient_preference".
 *
 * @property integer $id
 * @property integer $recipient_id
 * @property integer $preference_id
 *
 * @property Preference $preference
 * @property Recipient $recipient
 */
class RecipientPreference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipient_preference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipient_id', 'preference_id'], 'required'],
            [['recipient_id', 'preference_id'], 'integer'],
            [['preference_id'], 'exist', 'skipOnError' => true, 'targetClass' => Preference::className(), 'targetAttribute' => ['preference_id' => 'id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipient::className(), 'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipient_id' => 'Recipient ID',
            'preference_id' => 'Preference ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreference()
    {
        return $this->hasOne(Preference::className(), ['id' => 'preference_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(Recipient::className(), ['id' => 'recipient_id']);
    }
}
