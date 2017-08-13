<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecipientPreference;

/**
 * RecipientPreferenceSearch represents the model behind the search form about `app\models\RecipientPreference`.
 */
class RecipientPreferenceSearch extends RecipientPreference
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'recipient_id', 'preference_id'], 'integer'],
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
        $query = RecipientPreference::find();

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
            'recipient_id' => $this->recipient_id,
            'preference_id' => $this->preference_id,
        ]);

        return $dataProvider;
    }
}
