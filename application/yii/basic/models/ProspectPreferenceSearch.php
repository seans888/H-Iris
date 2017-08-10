<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProspectPreference;

/**
 * ProspectPreferenceSearch represents the model behind the search form about `app\models\ProspectPreference`.
 */
class ProspectPreferenceSearch extends ProspectPreference
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prospect_id', 'preference_id'], 'integer'], ['prospect.fullName', 'email.informaion'], 'safe'],
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
        $query = ProspectPreference::find();

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
            'prospect_id' => $this->prospect_id,
            'preference_id' => $this->preference_id,
            'prospect.fullName' => $this->prospect_id,
            'email.informaion' => $this->email_id,
        ]);

        return $dataProvider;
    }
}
