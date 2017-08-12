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
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['email_date', 'email_recipient', 'email_template', 'email_status', 'template_id', 'recipient_id'], 'safe'],
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

        $query->joinWith('template')
            ->joinWith('recipient');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'email_date' => $this->email_date,
           // 'template_id' => $this->template_id,
          //  'recipient_id' => $this->recipient_id,
        ]);

        $query->andFilterWhere(['like', 'email_status', $this->email_status])
            ->andFilterWhere(['like', 'template_type', $this->template_id])
            ->andFilterWhere(['like', 'recipient_fname', $this->recipient_id]);
        return $dataProvider;
    }
}
