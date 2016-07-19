<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DiscountCode;

/**
 * DiscountCodeSearch represents the model behind the search form about `common\models\DiscountCode`.
 */
class DiscountCodeSearch extends DiscountCode
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'discount_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['code'], 'safe'],
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
    public function search($params,$id)
    {
        $query = DiscountCode::find();

        // add conditions that should always apply here
        if($id) {
            $query->where(['discount_id' => $id]);
        }
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
            'discount_id' => $this->discount_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
