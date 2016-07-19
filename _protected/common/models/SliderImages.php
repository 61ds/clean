<?php

namespace common\models;
use common\models\Slider;
use Yii;
use yii\imagine\Image;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Slider_images".
 *
 * @property integer $id
 * @property integer $slider_id
 * @property string $content
 * @property string $image_path
 *
 * @property Slider $Slider
 */
class SliderImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
            [['slider_id'], 'integer'],
			[['image_path'], 'file', 'extensions' => 'png, jpg, gif, mp4, mkv, avi',],
            [['content','name','alt_title'], 'string', 'max' => 1000],
            [['type','button_link','button_text'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slider_id' => 'Slider Name',
            'content' => 'Image Content',
            'image_path' => 'Image',
            'alt_title' => 'Image Alt Title',
            'name' => 'Image Name',
            'button_text' => 'Button Text',
            'button_link' => 'Button Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlider()
    {
        return $this->hasOne(Slider::className(), ['id' => 'slider_id']);
    }
	
	public function updateVideo($video,$path)
    {
		$imagine = new Image();
		Yii::$app->params['uploadPath'] = '../themes/elmhurst/uploads/video';
		$type = array('video/mp4','video/mkv','video/avi');
		$videos = $video->name;
		$himage = $video->name;
		$uploadPath = Yii::$app->params['uploadPath'] .$path.'/'. $videos;
		
		if (!file_exists(Yii::$app->params['uploadPath'] .$path)) {
			mkdir(Yii::$app->params['uploadPath'] .$path, 0777, true);
		}	
		
		if($video->saveAs($uploadPath)){
			if(in_array($video->type , $type)){
				return $videos;
			}else{
				$imagineObj =  yii\imagine\Image::getImagine();	
				$imageObj = $imagineObj->open($uploadPath);
				$imageObj1 = $imagineObj->open($uploadPath);
				$imageObj2 = $imagineObj->open($uploadPath);
				$imageObj3 = $imagineObj->open($uploadPath);
				$imageObj3->effects()->grayscale();
				//$imageObj3->save($huploadPath);
				$imageObj2->save($uploadPath);
				return $videos;
			}
			
			
			//$imageObj->resize($imageObj->getSize()->widen(1000))->save($uploadLarge);				
			//$imageObj1->resize($imageObj1->getSize()->widen(100))->save($uploadThumbs);	
		}else{
			return false;
		}
    }
	public function getSlidepath($ids)
    {
        $vide  = $this->find()->where(['id'=>$ids])->all();
        return $vide;
    }
    public function getSlidername()
    {
        $slider = Slider::find()->where(['status' => 1])->orderBy('gallery_name')->all();
        return ArrayHelper::map($slider,'id','gallery_name');
    }
}
