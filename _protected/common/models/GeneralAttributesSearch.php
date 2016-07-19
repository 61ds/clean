<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Attributes;

/**
 * AttributesSearch represents the model behind the search form about `common\models\Attributes`.
 */
class GeneralAttributesSearch extends Attributes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'entity_id', 'status'], 'integer'],
            [['name', 'display_name'], 'safe'],
            [['lower_limit', 'upper_limit'], 'number'],
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
    public function search($general_attributes = null)
    {
        $query = Attributes::find()->where(['entity_id'=>[1,2,4]]);
		if($general_attributes){
			$attrs = unserialize($general_attributes);
			$query->andWhere(['id'=>$attrs]);
		}
		$query->orderBy('name');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' =>false,
        ]);



        return $dataProvider;
    }
}
