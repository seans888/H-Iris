<?php

namespace backend\models;

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
    public $fullName;
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['customer_history_checkin', 'customer_history_checkout', 'customer_history_numberdays'
            , 'customer_id'], 'safe'],
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
       /*$query = CustomerHistory::find()->select('b.*,'
                . 'concat(c.customer_fname," ",c.customer_lname) as fullName')->from('CustomerHistory b')
                leftJoin('Customer c', 'c.customer_id=b.id');
                //echo $query;
                //die();*/
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
           // 'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like', 'customer_history_checkin', $this->customer_history_checkin])
            ->andFilterWhere(['like', 'customer_history_checkout', $this->customer_history_checkout])
            ->andFilterWhere(['like', 'customer_history_numberdays', $this->customer_history_numberdays])
            ->andFilterWhere(['like', 'customer_fname', $this->customer_id])
            ->orFilterWhere(['like', 'customer_lname', $this->customer_id]);
;

        return $dataProvider;
    }
}
