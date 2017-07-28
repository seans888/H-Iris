<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $event_date_created
 * @property string $event_description
 * @property string $event_start_date
 * @property string $event_end_date
 * @property integer $marketeer_id
 *
 * @property Marketeer $marketeer
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'marketeer_id'], 'required'],
            [['id', 'marketeer_id'], 'integer'],
            [['event_date_created', 'event_start_date', 'event_end_date'], 'safe'],
            [['event_description'], 'string', 'max' => 400],
            [['marketeer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marketeer::className(), 'targetAttribute' => ['marketeer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_date_created' => 'Event Date Created',
            'event_description' => 'Event Description',
            'event_start_date' => 'Event Start Date',
            'event_end_date' => 'Event End Date',
            'marketeer_id' => 'Marketeer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarketeer()
    {
        return $this->hasOne(Marketeer::className(), ['id' => 'marketeer_id']);
    }
}
