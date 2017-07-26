<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_history".
 *
 * @property integer $id
 * @property string $ch_checkin
 * @property string $ch_chekout
 * @property integer $ch_numberdays
 * @property string $ch_goods
 *
 * @property Customer $id0
 */
class CustomerHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ch_checkin', 'ch_chekout'], 'safe'],
            [['ch_numberdays'], 'integer'],
            [['ch_goods'], 'required'],
            [['ch_goods'], 'string', 'max' => 45],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ch_checkin' => 'Ch Checkin',
            'ch_chekout' => 'Ch Chekout',
            'ch_numberdays' => 'Ch Numberdays',
            'ch_goods' => 'Ch Goods',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Customer::className(), ['id' => 'id']);
    }
}
