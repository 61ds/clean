<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VarientProduct;

/**
 * VarientProductSearch represents the model behind the search form about `common\models\VarientProduct`.
 */
class VarientProductSearch extends VarientProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'color', 'size', 'width', 'price', 'quantity','status', 'created_at', 'updated_at'], 'integer'],
            [['sku'], 'safe'],
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
        $query = VarientProduct::find();
        if($id) {
            $query->where(['product_id' => $id]);
        }


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
            'product_id' => $this->product_id,
            'color' => $this->color,
            'size' => $this->size,
            'quantity' => $this->quantity,
            'width' => $this->width,
            'price' => $this->price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'sku', $this->sku]);

        return $dataProvider;
    }
}
