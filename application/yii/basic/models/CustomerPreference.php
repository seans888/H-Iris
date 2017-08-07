<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_preference".
 *
 * @property integer $customer_id
 * @property integer $preference_id
 *
 * @property Customer $customer
 * @property Preference $preference
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
            [['customer_id', 'preference_id'], 'required'],
            [['customer_id', 'preference_id'], 'integer'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['preference_id'], 'exist', 'skipOnError' => true, 'targetClass' => Preference::className(), 'targetAttribute' => ['preference_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'preference_id' => 'Preference ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreference()
    {
        return $this->hasOne(Preference::className(), ['id' => 'preference_id']);
    }
}
