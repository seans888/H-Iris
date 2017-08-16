<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CustomerHistory;

/**
 * CustomerHistorySearch represents the model behind the search form about `app\models\CustomerHistory`.
 */
class CustomerHistorySearch extends CustomerHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id'], 'integer'],
            [['customer_history_checkin', 'customer_history_checkout', 'customer_history_numberdays'], 'safe'],
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
        $query = CustomerHistory::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like', 'customer_history_checkin', $this->customer_history_checkin])
            ->andFilterWhere(['like', 'customer_history_checkout', $this->customer_history_checkout])
            ->andFilterWhere(['like', 'customer_history_numberdays', $this->customer_history_numberdays]);

        return $dataProvider;
    }
}
