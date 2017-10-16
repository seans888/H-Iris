<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Event;

/**
 * EventSearch represents the model behind the search form about `app\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['event_date_created', 'event_description', 'event_start_date', 'event_end_date', 'employee_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Event::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('employee');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'event_date_created' => $this->event_date_created,
            'event_start_date' => $this->event_start_date,
            'event_end_date' => $this->event_end_date,
           // 'employee_id' => $this->employee_id,
        ]);

        $query->andFilterWhere(['like', 'event_description', $this->event_description])
        ->andFilterWhere(['like', 'employee_fname', $this->employee_id])
        ->orFilterWhere(['like', 'employee_lname', $this->employee_id])
        ->orFilterWhere(['like', 'employee_type', $this->employee_id]);

        return $dataProvider;
    }
}
