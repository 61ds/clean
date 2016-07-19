<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CategoryAttributes;

/**
 * CategoryAttributesSearch represents the model behind the search form about `common\models\CategoryAttributes`.
 */
class CategoryAttributesSearch extends CategoryAttributes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'status'], 'integer'],
            [['attributes'], 'safe'],
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
        $query = CategoryAttributes::find();

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
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'attributes', $this->attributes]);

        return $dataProvider;
    }
}
