<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public $fullName;

    public function rules()
    {
        return [
            [['id', 'customer_contact_number'], 'integer'],
            [['customer_type', 'customer_email', 'customer_fname', 'customer_mname', 'customer_lname',
            'fullName'], 'safe'],
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
        $query = Customer::find();

        // add conditions that should always apply here
        //$query = Blog::find()->select('b.*,'
               // . 'concat(c.customer_fname," ",c.customer_lname) as fullName')->from('CustomerHistory b')
                //leftJoin('Customer c', 'c.Id=b.id');


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
            'customer_contact_number' => $this->customer_contact_number,
        ]);

        $query->andFilterWhere(['like', 'customer_type', $this->customer_type])
            ->andFilterWhere(['like', 'customer_email', $this->customer_email])
            ->andFilterWhere(['like', 'customer_fname', $this->customer_fname])
            ->andFilterWhere(['like', 'customer_mname', $this->customer_mname])
            ->andFilterWhere(['like', 'customer_lname', $this->customer_lname]);

        return $dataProvider;
    }
}
