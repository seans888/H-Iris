<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form about `app\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'employee_contact_number'], 'integer'],
            [['employee_type', 'employee_fname', 'employee_mname', 'employee_lname'], 'safe'],
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
        $query = Employee::find();

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
            'employee_contact_number' => $this->employee_contact_number,
        ]);

        $query->andFilterWhere(['like', 'employee_type', $this->employee_type])
            ->andFilterWhere(['like', 'employee_fname', $this->employee_fname])
            ->andFilterWhere(['like', 'employee_mname', $this->employee_mname])
            ->andFilterWhere(['like', 'employee_lname', $this->employee_lname]);

        return $dataProvider;
    }
}
