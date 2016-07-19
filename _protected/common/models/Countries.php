<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\imagine\Image;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $sortname
 * @property string $name
 * @property integer $status
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sortname', 'name'], 'required'],
            [['status','is_slider_item'], 'integer'],
            [['flag'], 'image'],
            [['flag'], 'file', 'extensions' => 'gif, jpg, png'],
            [['sortname'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sortname' => 'Country Code',
            'name' => 'Country Name',
            'is_slider_item' => 'Action',
            'flag' => 'Country Flag',
            'status' => 'Status',
        ];
    }
    public function getStates()
    {
        return $this->hasMany(States::className(), ['country_id' => 'id']);
    }
    public function getSliderCountries(){
        $query = $this->find()->where(['is_slider_item' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        return $dataProvider;
    }
    public function getActiveSliderCountries(){
        $query = $this->find()->where(['is_slider_item' => 1])->all();

        return $query;
    }
    public function getActiveCountries(){
        $query = $this->find()->where(['status' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        return $dataProvider;
    }
    public static function find()
    {
        return new CountriesQuery(get_called_class());
    }
    public function updateImage($image,$name)
    {
        $imagine = new Image();
        Yii::$app->params['upload'] = 'uploads/';
        Yii::$app->params['uploadPath'] = 'uploads/country/';
        Yii::$app->params['original'] = 'uploads/country/original/';
        Yii::$app->params['32x32'] = 'uploads/country/32x32/';
        Yii::$app->params['64x64'] = 'uploads/country/64x64/';
        Yii::$app->params['128x128'] = 'uploads/country/128x128/';
        Yii::$app->params['256x256'] = 'uploads/country/256x256/';

        $mimage = $name.'.'. $image->extension;
        $uploadPath = Yii::$app->params['uploadPath'] .'/'. $mimage;

        $uploadoriginal = Yii::$app->params['original'] .'/'. $mimage;
        $upload256x256 = Yii::$app->params['256x256'] .'/'. $mimage;
        $upload128x128 = Yii::$app->params['128x128'] .'/'. $mimage;
        $upload64x64 = Yii::$app->params['64x64'] .'/'. $mimage;
        $upload32x32 = Yii::$app->params['32x32'] .'/'. $mimage;

        if (!file_exists(Yii::$app->params['upload'])) {
            mkdir(Yii::$app->params['upload'], 0777, true);
        }
        if (!file_exists(Yii::$app->params['uploadPath'])) {
            mkdir(Yii::$app->params['uploadPath'], 0777, true);
        }
        if (!file_exists(Yii::$app->params['256x256'])) {
            mkdir(Yii::$app->params['256x256'], 0777, true);
        }
        if (!file_exists(Yii::$app->params['128x128'])) {
            mkdir(Yii::$app->params['128x128'], 0777, true);
        }
        if (!file_exists(Yii::$app->params['32x32'])) {
            mkdir(Yii::$app->params['32x32'], 0777, true);
        }
        if (!file_exists(Yii::$app->params['64x64'])) {
            mkdir(Yii::$app->params['64x64'], 0777, true);
        }
        if($image->saveAs($upload256x256)){

            $imagineObj =  \yii\imagine\Image::getImagine();
            $imageObj2 = $imagineObj->open($upload256x256);
            $imageObj2->resize($imageObj2->getSize()->widen(128))->save($upload128x128);
            $imageObj2->resize($imageObj2->getSize()->widen(64))->save($upload64x64);
            $imageObj2->resize($imageObj2->getSize()->widen(32))->save($upload32x32);
            return $mimage;
        }else{
            return false;
        }
    }
}
