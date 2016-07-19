<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Discount;

/**
 * DiscountSearch represents the model behind the search form about `common\models\Discount`.
 */
class DiscountSearch extends Discount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'coupon_type', 'uses_per_coupon', 'uses_per_customer', 'start_date', 'end_date', 'discount_type', 'discount_amount', 'quantity', 'quantity_used', 'quantity_left', 'status', 'locked', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'coupon_code'], 'safe'],
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
        $query = Discount::find();

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
            'coupon_type' => $this->coupon_type,
            'uses_per_coupon' => $this->uses_per_coupon,
            'uses_per_customer' => $this->uses_per_customer,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'discount_type' => $this->discount_type,
            'discount_amount' => $this->discount_amount,
            'quantity' => $this->quantity,
            'quantity_used' => $this->quantity_used,
            'quantity_left' => $this->quantity_left,
            'status' => $this->status,
            'locked' => $this->locked,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'coupon_code', $this->coupon_code]);

        return $dataProvider;
    }
}
