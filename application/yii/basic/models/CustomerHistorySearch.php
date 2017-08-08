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
            [['id', 'ch_numberdays'], 'integer'],
            [['ch_checkin', 'ch_checkout', 'customer_id'], 'safe'],
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
        $query->joinWith('customer');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ch_checkin' => $this->ch_checkin,
            'ch_checkout' => $this->ch_checkout,
            'ch_numberdays' => $this->ch_numberdays,
            
        ]);
        $query->andFilterWhere(['like', 'customer_fname', $this->customer_id]);
        return $dataProvider;
    }
}
