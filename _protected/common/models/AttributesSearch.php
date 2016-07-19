<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Attributes;

/**
 * AttributesSearch represents the model behind the search form about `common\models\Attributes`.
 */
class AttributesSearch extends Attributes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'entity_id', 'status'], 'integer'],
            [['name', 'display_name'], 'safe'],
            [['lower_limit', 'upper_limit'], 'number'],
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
    public function search($params, $general_attributes = null, $slider_attributes = null)
    {
        $query = Attributes::find();
		if($general_attributes){
			$attrs = unserialize($general_attributes);
			$query->where(['id'=>$attrs]);
		}
		$query->orderBy('name');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' =>false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'entity_id' => $this->entity_id,
            'lower_limit' => $this->lower_limit,
            'upper_limit' => $this->upper_limit,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'display_name', $this->display_name]);

        return $dataProvider;
    }
}
