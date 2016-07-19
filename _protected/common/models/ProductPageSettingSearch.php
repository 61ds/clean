<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductPageSetting;

/**
 * ProductPageSettingSearch represents the model behind the search form about `common\models\ProductPageSetting`.
 */
class ProductPageSettingSearch extends ProductPageSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['video', 'product_slides', 'name'], 'safe'],
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
        $query = ProductPageSetting::find();

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
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'product_slides', $this->product_slides])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
