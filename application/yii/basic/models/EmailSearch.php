<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Email;

/**
 * EmailSearch represents the model behind the search form about `app\models\Email`.
 */
class EmailSearch extends Email
{
    /**
     * @inheritdoc
     */

    public $marketeer_id;

    public function rules()
    {
        return [
            [['id', 'marketeer_id','marketeer.fullName'], 'safe'],
            [['email_date', 'email_recipient', 'email_content', 'email_template'], 'safe'],
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
        $query->joinWith('marketeer','marketeer.fullName');
        $query->andFilterWhere(['like', 'marketeer.fullName', $this->marketeer_id]);

        
        
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
            'email_date' => $this->email_date,
            'marketeer_id' => $this->marketeer_id,
        ]);

        $query->andFilterWhere(['like', 'email_recipient', $this->email_recipient])
            ->andFilterWhere(['like', 'email_content', $this->email_content])
            ->andFilterWhere(['like', 'email_template', $this->email_template]);

        return $dataProvider;
    }
}
