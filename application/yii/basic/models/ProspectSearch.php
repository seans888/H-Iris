<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prospect;

/**
 * ProspectSearch represents the model behind the search form about `app\models\Prospect`.
 */
class ProspectSearch extends Prospect
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prospect_contact_number'], 'integer'],
            [['prospect_email', 'prospect_fname', 'prospect_mname', 'prospect_lname'], 'safe'],
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
        $query = Prospect::find();

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
            'prospect_contact_number' => $this->prospect_contact_number,
        ]);

        $query->andFilterWhere(['like', 'prospect_email', $this->prospect_email])
            ->andFilterWhere(['like', 'prospect_fname', $this->prospect_fname])
            ->andFilterWhere(['like', 'prospect_mname', $this->prospect_mname])
            ->andFilterWhere(['like', 'prospect_lname', $this->prospect_lname]);

        return $dataProvider;
    }
}
