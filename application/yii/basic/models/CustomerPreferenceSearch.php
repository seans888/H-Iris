<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CustomerPreference;
//use app\models\CustomerPreferenceSearch;

/**
 * CustomerPreferenceSearch represents the model behind the search form about `app\models\CustomerPreference`.
 */
class CustomerPreferenceSearch extends CustomerPreference
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'],'integer'], 
            [['customer.name', 'preference.information', 'customer_id', 'preference_id'], 'safe'],
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
        $query = CustomerPreference::find();

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
        $query->joinWith('customer')
        	->joinWith('preference');

        // grid filtering conditions
        $query->andFilterWhere(['id' => $this->id,]);

       $query->andFilterWhere(['like','customer_fname', $this->customer_id]) 
         ->orFilterWhere(['like','customer_lname', $this->customer_id])
         ->andFilterWhere(['like','preference_description', $this->preference_id])
        ->orFilterWhere(['like','preference_category', $this->preference_id]);
       

        return $dataProvider;
    }
}
