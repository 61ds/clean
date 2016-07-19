<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SliderImages;

/**
 * SliderImagesSearch represents the model behind the search form about `app\modules\admin\models\SliderImages`.
 */
class SliderImagesSearch extends SliderImages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'slider_id'], 'integer'],
            [['content', 'image_path'], 'safe'],
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
    public function search($params,$slider_id=0, $video_id=0)
    {
        $query = SliderImages::find();
		if($slider_id){
		$query->where(['slider_id' => $slider_id]);	
		}
		if($video_id){
		$query->where(['id' => $video_id]);	
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
            'slider_id' => $this->slider_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'image_path', $this->image_path]);

        return $dataProvider;
    }
}
