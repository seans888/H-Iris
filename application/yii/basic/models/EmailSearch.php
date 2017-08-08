<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Email;
use yii\models\Marketeer;

/**
 * EmailSearch represents the model behind the search form about `app\models\Email`.
 */
class EmailSearch extends Email
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['email_date', 'email_activity_id', 'email_recipient', 'email_content', 'email_template'], 'safe'],
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
        $query = Email::find();

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
        $query->joinWith('activity'); 

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'email_date' => $this->email_date,
        ]);

        $query->andFilterWhere(['like', 'email_recipient', $this->email_recipient])
            ->andFilterWhere(['like', 'email_content', $this->email_content])
            ->andFilterWhere(['like', 'email_template', $this->email_template])
            ->andFilterWhere(['like', 'activity_status', $this->email_activity_id]);
        return $dataProvider;
    }
}
