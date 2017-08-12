<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recipient;

/**
 * RecipientSearch represents the model behind the search form about `app\models\Recipient`.
 */
class RecipientSearch extends Recipient
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'recipient_contact_number', 'customer_id'], 'integer'],
            [['recipient_type', 'recipient_email', 'recipient_fname', 'recipient_mname', 'recipient_lname'], 'safe'],
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
        $query = Recipient::find();

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
            'recipient_contact_number' => $this->recipient_contact_number,
            'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like', 'recipient_type', $this->recipient_type])
            ->andFilterWhere(['like', 'recipient_email', $this->recipient_email])
            ->andFilterWhere(['like', 'recipient_fname', $this->recipient_fname])
            ->andFilterWhere(['like', 'recipient_mname', $this->recipient_mname])
            ->andFilterWhere(['like', 'recipient_lname', $this->recipient_lname]);

        return $dataProvider;
    }
}
