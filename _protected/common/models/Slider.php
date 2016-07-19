<?php

namespace common\models;

use Yii;
use yii\imagine\Image;
use kartik\file\FileInput;
use yii\web\UploadedFile;
use common\models\SliderImages;
use common\models\Pages;
/**
 * This is the model class for table "Slider".
 *
 * @property integer $id
 * @property string $galley_name
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
	public $file_path;
	
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['galley_name'], 'required'],
            [['status'], 'string', 'max' => 100],
            [['galley_name'], 'string', 'max' => 100],
            [['pageid'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'galley_name' => 'Slider Name',
            'pageid' => 'Pageid',
            'status' => 'Status',
        ];
    }
	public function updateImageFile($image,$id,$path)
    {
		$imagine = new Image();
		Yii::$app->params['uploadPath'] = 'uploads/slider';
		Yii::$app->params['uploadThumbs'] = 'uploads/slider/thumbs/';
		Yii::$app->params['uploadLarge'] = 'uploads/slider/large/';
		Yii::$app->params['uploadMedium'] = 'uploads/slider/medium/';
	
		$mimage = 'm_'. $id .'.'. $image->name;
		$himage = 'h_'. $id .'.'. $image->name;
		$uploadPath = Yii::$app->params['uploadPath'] .$path.'/'. $mimage;
		$huploadPath = Yii::$app->params['uploadPath'] .$path.'/'. $himage;
		
		$uploadLarge = Yii::$app->params['uploadLarge'] .$path.'/'. $mimage;
		$uploadThumbs = Yii::$app->params['uploadThumbs'] .$path.'/'. $mimage;
		$uploadMedium = Yii::$app->params['uploadMedium'] .$path.'/'. $mimage;
		
		if (!file_exists(Yii::$app->params['uploadPath'] .$path)) {
			mkdir(Yii::$app->params['uploadPath'] .$path, 0777, true);
		}
		if (!file_exists(Yii::$app->params['uploadLarge'] .$path)) {
			mkdir(Yii::$app->params['uploadLarge'] .$path, 0777, true);
		}
		if (!file_exists(Yii::$app->params['uploadThumbs'] .$path)) {
			mkdir(Yii::$app->params['uploadThumbs'] .$path, 0777, true);
		}
		if (!file_exists(Yii::$app->params['uploadMedium'] .$path)) {
			mkdir(Yii::$app->params['uploadMedium'] .$path, 0777, true);
		}				
		if($image->saveAs($uploadPath)){
		
			$imagineObj =  yii\imagine\Image::getImagine();
			$imageObj = $imagineObj->open($uploadPath);
			$imageObj1 = $imagineObj->open($uploadPath);
			$imageObj2 = $imagineObj->open($uploadPath);
			$imageObj3 = $imagineObj->open($uploadPath);
			
			$imageObj3->effects()->grayscale();
			$imageObj3->save($huploadPath);	
			
			//$imageObj->resize($imageObj->getSize()->widen(1000))->save($uploadLarge);				
			//$imageObj1->resize($imageObj1->getSize()->widen(100))->save($uploadThumbs);	
			
			$imageObj2->resize($imageObj2->getSize()->widen(500))->save($uploadMedium);	
			
			return $mimage;
		}else{
			return false;
		}
		
    }
	
	public function getImages()
   {
       return $this->hasMany(SliderImages::className(), ['slider_id' => 'id']);
   }
   public function getSlider($asd)
   {
	  $model = new SliderImages();
	  $page = $model->find()->where(['slider_id'=>$asd])->all();
      return $page;
   }
   
   public function getPageId()
   {
	  $model = new Pages();
	  $pagesd = $model->find('id','name')->all();
      return $pagesd;
   }
   public function getPageGal($asd)
   {
	  $model = new Slider();
	  $pagegal = $model->find('pageid')->where(['id'=>$asd])->one();
      return $pagegal;
   }
   public function getCurrentSlider()
   {
	  $model = new Slider();
	  $pagesgal = $model->find('id','pageid')->all();
      return $pagesgal;
   }
}
