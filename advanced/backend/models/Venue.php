<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venue".
 *
 * @property integer $id
 * @property string $venue_name
 * @property string $venue_address
 * @property string $venue_desc
 * @property integer $venue_contact_num
 *
 * @property Room1[] $room1s
 */
class Venue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_contact_num'], 'integer'],
            [['venue_name', 'venue_address'], 'string', 'max' => 120],
            [['venue_desc'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'venue_name' => 'Venue Name',
            'venue_address' => 'Venue Address',
            'venue_desc' => 'Venue Desc',
            'venue_contact_num' => 'Venue Contact Num',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom1s()
    {
        return $this->hasMany(Room1::className(), ['venue_id' => 'id']);
    }
}
