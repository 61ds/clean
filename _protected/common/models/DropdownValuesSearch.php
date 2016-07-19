<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DropdownValues;

/**
 * DropdownValuesSearch represents the model behind the search form about `common\models\DropdownValues`.
 */
class DropdownValuesSearch extends DropdownValues
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'attribute_id', 'sort_order', 'status'], 'integer'],
            [['name','displayname'], 'safe'],
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
    public function search($params,$id=0)
    {
        $query = DropdownValues::find();
        if($id) {
            $query->where(['attribute_id' => $id])->orderBy('sort_order');
        }
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
            'attribute_id' => $this->attribute_id,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'displayname', $this->displayname]);

        return $dataProvider;
    }
}
