<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transcript".
 *
 * @property integer $id
 * @property integer $ticket_id
 * @property string $description
 * @property string $time
 * @property integer $by_employee
 * @property integer $current_emp_resp
 *
 * @property Employee1 $byEmployee
 * @property Employee1 $currentEmpResp
 * @property Ticket $ticket
 */
class Transcript extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transcript';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ticket_id', 'description', 'by_employee', 'current_emp_resp'], 'required'],
            [['ticket_id', 'by_employee', 'current_emp_resp'], 'integer'],
            [['description'], 'string'],
            [['time'], 'safe'],
            [['by_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee1::className(), 'targetAttribute' => ['by_employee' => 'id']],
            [['current_emp_resp'], 'exist', 'skipOnError' => true, 'targetClass' => Employee1::className(), 'targetAttribute' => ['current_emp_resp' => 'id']],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_id' => 'Ticket ID',
            'description' => 'Description',
            'time' => 'Time',
            'by_employee' => 'By Employee',
            'current_emp_resp' => 'Current Emp Resp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getByEmployee()
    {
        return $this->hasOne(Employee1::className(), ['id' => 'by_employee']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrentEmpResp()
    {
        return $this->hasOne(Employee1::className(), ['id' => 'current_emp_resp']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket_id']);
    }
}
