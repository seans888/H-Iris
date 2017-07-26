<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "webvisit_history".
 *
 * @property integer $id
 * @property string $wvh_date
 * @property string $wvh_time
 * @property integer $wvh_ip_address
 * @property string $wvh_url
 * @property string $wvh_cookie_information
 *
 * @property Customer $id0
 * @property Prospect $id1
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
            [['wvh_ip_address'], 'integer'],
            [['wvh_url', 'wvh_cookie_information'], 'required'],
            [['wvh_url'], 'string', 'max' => 100],
            [['wvh_cookie_information'], 'string', 'max' => 45],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['id' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Prospect::className(), 'targetAttribute' => ['id' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Customer::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId1()
    {
        return $this->hasOne(Prospect::className(), ['id' => 'id']);
    }
}
