<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SettingAttributesSearch represents the model behind the search form about `common\models\SettingAttributes`.
 */
class SettingAttributesSearch extends SettingAttributes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'setting_id', 'input_type'], 'integer'],
            [['name', 'attribute_key'], 'safe'],
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
    public function search($params,$setting_id=0)
    {
        $query = SettingAttributes::find();
		if($setting_id){
            $query->where(['setting_id' => $setting_id]);
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

        $query->andFilterWhere([
            'id' => $this->id,
            'setting_id' => $this->setting_id,
            'input_type' => $this->input_type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'attribute_key', $this->attribute_key]);

        return $dataProvider;
    }
}
