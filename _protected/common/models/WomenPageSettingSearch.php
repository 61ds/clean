<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WomenPageSetting;

/**
 * WomenPageSettingSearch represents the model behind the search form about `common\models\WomenPageSetting`.
 */
class WomenPageSettingSearch extends WomenPageSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['banner1', 'banner2', 'banner3', 'banner4', 'banner5', 'banner6'], 'safe'],
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
        $query = WomenPageSetting::find();

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
        ]);

        $query->andFilterWhere(['like', 'banner1', $this->banner1])
            ->andFilterWhere(['like', 'banner2', $this->banner2])
            ->andFilterWhere(['like', 'banner3', $this->banner3])
            ->andFilterWhere(['like', 'banner4', $this->banner4])
            ->andFilterWhere(['like', 'banner5', $this->banner5])
            ->andFilterWhere(['like', 'banner6', $this->banner6]);

        return $dataProvider;
    }
}
