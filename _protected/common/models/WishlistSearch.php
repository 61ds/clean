<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Wishlist;

/**
 * WishlistSearch represents the model behind the search form about `app\models\Wishlist`.
 */
class WishlistSearch extends Wishlist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'integer'],
            [['programs'], 'string'],
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
        $query = Wishlist::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'client_id' => $this->client_id,
        ]);

        

        return $dataProvider;
    }
}
