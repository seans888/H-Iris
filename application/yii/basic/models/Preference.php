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
 * @property CustomerPreference $customerPreference
 * @property Customer[] $ids
 * @property ProspectPreference $prospectPreference
 * @property Prospect[] $ids0
 */
class Preference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
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
            [['preference_category', 'preference_description'], 'required'],
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
    public function getCustomerPreference()
    {
        return $this->hasOne(CustomerPreference::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds()
    {
        return $this->hasMany(Customer::className(), ['id' => 'id'])->viaTable('customer_preference', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProspectPreference()
    {
        return $this->hasOne(ProspectPreference::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds0()
    {
        return $this->hasMany(Prospect::className(), ['id' => 'id'])->viaTable('prospect_preference', ['id' => 'id']);
    }
}
