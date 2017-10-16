<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property string $status
 * @property string $time_start
 * @property string $time_end
 * @property string $time_alloted
 * @property integer $escalation_level
 * @property string $desc
 * @property integer $check_in_id
 * @property integer $emp_repond_id
 * @property integer $category_id
 * @property integer $emp_create_id
 *
 * @property Category $category
 * @property CheckIn $checkIn
 * @property Employee1 $empRepond
 * @property Employee1 $empCreate
 * @property Transcript[] $transcripts
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'time_alloted', 'escalation_level', 'desc', 'check_in_id', 'emp_repond_id', 'category_id', 'emp_create_id'], 'required'],
            [['time_start', 'time_end', 'time_alloted'], 'safe'],
            [['escalation_level', 'check_in_id', 'emp_repond_id', 'category_id', 'emp_create_id'], 'integer'],
            [['desc'], 'string'],
            [['status'], 'string', 'max' => 45],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['check_in_id'], 'exist', 'skipOnError' => true, 'targetClass' => CheckIn::className(), 'targetAttribute' => ['check_in_id' => 'id']],
            [['emp_repond_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee1::className(), 'targetAttribute' => ['emp_repond_id' => 'id']],
            [['emp_create_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee1::className(), 'targetAttribute' => ['emp_create_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
            'time_alloted' => 'Time Alloted',
            'escalation_level' => 'Escalation Level',
            'desc' => 'Desc',
            'check_in_id' => 'Check In ID',
            'emp_repond_id' => 'Emp Repond ID',
            'category_id' => 'Category ID',
            'emp_create_id' => 'Emp Create ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCheckIn()
    {
        return $this->hasOne(CheckIn::className(), ['id' => 'check_in_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpRepond()
    {
        return $this->hasOne(Employee1::className(), ['id' => 'emp_repond_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpCreate()
    {
        return $this->hasOne(Employee1::className(), ['id' => 'emp_create_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranscripts()
    {
        return $this->hasMany(Transcript::className(), ['ticket_id' => 'id']);
    }
}
