<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Activity;

/**
 * ActivitySearch represents the model behind the search form about `app\models\Activity`.
 */
class ActivitySearch extends Activity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['activity_status', 'activity_description', 'email_id'], 'safe'],
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
        $query = Activity::find();

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
        $query->joinWith('email');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'email_id' => $this->email_id,
        ]);

        $query->andFilterWhere(['like', 'activity_status', $this->activity_status])
            ->andFilterWhere(['like', 'activity_description', $this->activity_description])
            ->andFilterWhere(['like', 'email_status', $this->email_id])
            ->orFilterWhere(['like', 'email_date', $this->email_id]);

        return $dataProvider;
    }
}
