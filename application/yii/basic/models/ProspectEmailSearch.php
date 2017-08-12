<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProspectEmail;
use app\models\ProspectEmailSearch;

/**
 * ProspectEmailSearch represents the model behind the search form about `app\models\ProspectEmail`.
 */
class ProspectEmailSearch extends ProspectEmail
{
    /**
     * @inheritdoc
     */
    //public $prospect_id;
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['email.information', 'prospect.fullName',  'prospect_id', 'email_id'], 'safe'],
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
        $query = ProspectEmail::find();
       

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
         $query->joinWith('prospect')
            ->joinWith('email');



         //->joinWith('email_id');


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
          
           // 'prospect_id' => $this->prospect_id,
           // 'email.information' => $this->email_id,

            
             
        ]);
        //$query->andFilterWhere(['like' , 'prospect_fname'.])
        $query->andFilterWhere(['like', 'prospect_fname',$this->prospect_id])
         ->orFilterWhere(['like', 'prospect_lname', $this->prospect_id])
            ->andFilterWhere(['like', 'email_date', $this->email_id])
            ->orFilterWhere(['like', 'email_recipient', $this->email_id])
            ->orFilterWhere(['like', 'email_content', $this->email_id]);
            
        return $dataProvider;
    }
}
