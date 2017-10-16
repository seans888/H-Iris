<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "check_in".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $room_id
 * @property string $check_in
 * @property string $check_out
 *
 * @property Customer1 $customer
 * @property Room $room
 * @property Ticket[] $tickets
 */
class CheckIn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'check_in';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'room_id', 'check_in'], 'required'],
            [['customer_id', 'room_id'], 'integer'],
            [['check_in', 'check_out'], 'safe'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer1::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::className(), 'targetAttribute' => ['room_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'room_id' => 'Room ID',
            'check_in' => 'Check In',
            'check_out' => 'Check Out',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer1::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['check_in_id' => 'id']);
    }
}
