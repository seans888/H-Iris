<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "webvisit_history".
 *
 * @property integer $id
 * @property string $wvh_date
 * @property string $wvh_time
 * @property string $wvh_ip_address
 * @property string $wvh_url
 * @property string $wvh_cookie_information
 * @property integer $recipient_id
 *
 * @property Recipient $recipient
 */
class WebvisitHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webvisit_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wvh_date', 'wvh_time'], 'safe'],
            [['recipient_id'], 'required'],
            [['recipient_id'], 'integer'],
            [['wvh_ip_address'], 'string', 'max' => 20],
            [['wvh_url'], 'string', 'max' => 100],
            [['wvh_cookie_information'], 'string', 'max' => 45],
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
            'wvh_date' => 'Wvh Date',
            'wvh_time' => 'Wvh Time',
            'wvh_ip_address' => 'Wvh Ip Address',
            'wvh_url' => 'Wvh Url',
            'wvh_cookie_information' => 'Wvh Cookie Information',
            'recipient_id' => 'Recipient ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(Recipient::className(), ['id' => 'recipient_id']);
    }
}
