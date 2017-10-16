<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "existing".
 *
 * @property string $customer_ID
 */
class Existing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'existing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_ID'], 'required'],
            [['customer_ID'], 'string', 'max' => 13],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_ID' => 'Customer  ID',
        ];
    }
}
