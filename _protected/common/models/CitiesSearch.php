<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CitiesSearch represents the model behind the search form about `app\modules\admin\models\Cities`.
 */
class CitiesSearch extends Cities
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'state_id', 'status'], 'integer'],
            [['name'], 'safe'],
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
    public function search($params,$state_id=null)
    {
        $query = Cities::find();
		
		if($state_id){
			$query->where(['state_id' => $state_id, 'status' => 1]);
		}

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'state_id' => $this->state_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
