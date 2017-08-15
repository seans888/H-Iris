<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmailEvent;

/**
 * EmailEventSearch represents the model behind the search form about `app\models\EmailEvent`.
 */
class EmailEventSearch extends EmailEvent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['event_id', 'email_id'], 'safe'],
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
        $query = EmailEvent::find();

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
        $query->joinWith('event')
        ->joinWith('email');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'event_id' => $this->event_id,
            //'email_id' => $this->email_id,
        ]);

        $query->andFilterWhere(['like', 'email_status', $this->email_id])
        ->andFilterWhere(['like', 'event_description', $this->event_id]);

        return $dataProvider;
    }
}
