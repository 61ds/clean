<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;

/**
 * OrderSearch represents the model behind the search form about `common\models\Orders`.
 */
class OrderSearch extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'guest_id', 'items_count', 'discount_id', 'status', 'is_refunded','locked', 'payment_method', 'payment_status', 'created_at', 'updated_at'], 'integer'],
            [['price_total', 'delivery_charges', 'discount', 'grand_total'], 'number'],
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
    public function search($params,$refund=0)
    {
        $query = Orders::find();
		if($refund){
		$query->where(['refund_request' => $refund]);	
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
            'user_id' => $this->user_id,
            'guest_id' => $this->guest_id,
            'items_count' => $this->items_count,
            'price_total' => $this->price_total,
            'delivery_charges' => $this->delivery_charges,
            'discount' => $this->discount,
            'discount_id' => $this->discount_id,
            'grand_total' => $this->grand_total,
            'status' => $this->status,
            'locked' => $this->locked,
            'payment_method' => $this->payment_method,
            'is_refunded' => $this->is_refunded,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
