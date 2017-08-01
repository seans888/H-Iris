<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmailActivity;

/**
 * EmailActivitySearch represents the model behind the search form about `app\models\EmailActivity`.
 */
class EmailActivitySearch extends EmailActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'email_id'], 'integer'],
            [['email_activity_status', 'email_activity_date'], 'safe'],
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
        $query = EmailActivity::find();

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
            'email_activity_date' => $this->email_activity_date,
            'email_id' => $this->email_id,
        ]);

        $query->andFilterWhere(['like', 'email_activity_status', $this->email_activity_status]);

        return $dataProvider;
    }
}
