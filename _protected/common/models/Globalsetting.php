<?php

namespace common\models;
use Yii;

use yii\imagine\Image;
use kartik\file\FileInput;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "globalsetting".
 *
 * @property integer $id
 * @property string $site_title
 * @property string $meta_tag
 * @property string $meta_desc
 * @property string $fevicon_icon
 * @property string $logo
 */
class Globalsetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'globalsetting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_title', 'meta_tag', 'meta_desc'], 'required'],
            [['meta_tag', 'meta_desc'], 'string'],
			[['logo'], 'image'],
			[['fevicon_icon'], 'file', 'extensions' => 'gif, png, jpg, ico'],
			[['logo'], 'file', 'extensions' => 'gif, jpg, png'],
			[['innerlogo'], 'file', 'extensions' => 'gif, jpg, png'],
            [['contact_details'], 'string', 'max' => 10000],
            [['site_title'], 'string', 'max' => 100],
            [['admin_mail'], 'string', 'max' => 100],
            [['facebook'], 'string', 'max' => 100],
            [['twitter'], 'string', 'max' => 100],
            [['linkedin'], 'string', 'max' => 100],
            [['googleplus'], 'string', 'max' => 100],
            [['youtube'], 'string', 'max' => 100],
            [['pinterest'], 'string', 'max' => 255],
        ];
    }
	

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'site_title' => 'Site Title',
            'meta_tag' => 'Meta Tag',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'linkedin' => 'Linked In',
            'googleplus' => 'Google Plus',
            'youtube' => 'You Tube',
            'admin_mail' => 'Admin Mail',
            'contact_details' => 'Contact Details',
            'meta_desc' => 'Meta Desc',
            'fevicon_icon' => 'Fevicon Icon',
            'logo' => 'Logo',
            'innerlogo' => 'Footer logo',
            'pinterest' => 'Pinterest',
        ];
    }
	public function updateImage($image,$id,$path,$typ)
    {
		$imagine = new Image();		
		Yii::$app->params['uploadPath'] = 'uploads/';
		Yii::$app->params['uploadThumbs'] = 'uploads/site/thumbs/';
		Yii::$app->params['uploadLarge'] = 'uploads/site/large/';
		Yii::$app->params['uploadMedium'] = 'uploads/site/medium/';
	
		$mimage = $typ.'.'. $image->extension;
		$himage = $typ.'.'. $image->extension;
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
			if($typ=="fevicon"){
				$imageObj2->resize($imageObj2->getSize()->widen(32))->save($uploadMedium);
			}elseif($typ=="logo"){
				$imageObj2->resize($imageObj2->getSize()->widen(170))->save($uploadMedium);
			}elseif($typ=="innerlogo"){
				$imageObj2->resize($imageObj2->getSize()->widen(112))->save($uploadMedium);
			}
			else{
				$imageObj2->resize($imageObj2->getSize()->widen(500))->save($uploadMedium);
			}
				
			
			return $mimage;
		}else{
			return false;
		}
    }
	public function updateVideo($video,$id,$path,$typ)
    {
		Yii::$app->params['uploadPath'] = 'uploads/video';
		$videos = 'landing_'.$video->name;
		$himage = 'landing_'.$video->name;
		$uploadPath = Yii::$app->params['uploadPath'] .$path.'/'. $videos;
		$huploadPath = Yii::$app->params['uploadPath'] .$path.'/'. $himage;
		if (!file_exists(Yii::$app->params['uploadPath'] .$path)) {
			mkdir(Yii::$app->params['uploadPath'] .$path, 0777, true);
		}
						
		if($video->saveAs($uploadPath)){
			return $videos;
		}else{
			return false;
		}
    }
	public function getLogoFevicon()
    {
        $logo  = $this->find()->where(['id'=>1])->all();
        return $logo;
    }
	public function getHomeslider()
	{
		//$programs = Gallery::find()->orderBy('id')->all();
		//return ArrayHelper::map($programs,'id','galley_name');
		return array();
	}
}
