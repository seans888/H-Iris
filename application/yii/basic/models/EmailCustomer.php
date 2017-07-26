<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_customer".
 *
 * @property integer $id
 *
 * @property Email $id0
 * @property Customer $id1
 */
class EmailCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Email::className(), 'targetAttribute' => ['id' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Email::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId1()
    {
        return $this->hasOne(Customer::className(), ['id' => 'id']);
    }
}
