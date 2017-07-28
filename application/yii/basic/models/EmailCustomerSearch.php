<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmailCustomer;

/**
 * EmailCustomerSearch represents the model behind the search form about `app\models\EmailCustomer`.
 */
class EmailCustomerSearch extends EmailCustomer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_id', 'customer_id'], 'integer'],
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
        $query = EmailCustomer::find();

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
            'email_id' => $this->email_id,
            'customer_id' => $this->customer_id,
        ]);

        return $dataProvider;
    }
}
