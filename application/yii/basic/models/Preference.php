<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preference".
 *
 * @property integer $id
 * @property string $preference_category
 * @property string $preference_description
 *
 * @property CustomerPreference[] $customerPreferences
 * @property Customer[] $customers
 * @property ProspectPreference[] $prospectPreferences
 * @property Prospect[] $prospects
 */
class Preference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
<<<<<<< HEAD
public function getInformation()
=======

      public function getInformation()
>>>>>>> 141ebc8666a9f8e04304c85e35d048ed5cbca640
    {
    return $this->preference_category.' '.$this->preference_description;
    }

    public static function tableName()
    {
        return 'preference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preference_category', 'preference_description'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preference_category' => 'Preference Category',
            'preference_description' => 'Preference Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerPreferences()
    {
        return $this->hasMany(CustomerPreference::className(), ['preference_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['id' => 'customer_id'])->viaTable('customer_preference', ['preference_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspectPreferences()
    {
        return $this->hasMany(ProspectPreference::className(), ['preference_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspects()
    {
        return $this->hasMany(Prospect::className(), ['id' => 'prospect_id'])->viaTable('prospect_preference', ['preference_id' => 'id']);
    }
}
