<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer1".
 *
 * @property integer $id
 * @property string $fname
 * @property string $surname
 *
 * @property CheckIn[] $checkIns
 */
class Customer1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fname', 'surname'], 'required'],
            [['fname', 'surname'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'Fname',
            'surname' => 'Surname',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCheckIns()
    {
        return $this->hasMany(CheckIn::className(), ['customer_id' => 'id']);
    }
}
