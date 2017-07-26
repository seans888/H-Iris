<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_preference".
 *
 * @property integer $id
 *
 * @property Customer $id0
 * @property Preference $id1
 */
class CustomerPreference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_preference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['id' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Preference::className(), 'targetAttribute' => ['id' => 'id']],
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
        return $this->hasOne(Customer::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId1()
    {
        return $this->hasOne(Preference::className(), ['id' => 'id']);
    }
}
