<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "setting_attributes".
 *
 * @property integer $id
 * @property integer $setting_id
 * @property string $name
 * @property integer $input_type
 * @property string $attribute_key
 *
 * @property Settings $setting
 * @property InputType $inputType
 * @property SettingIntegerValues[] $settingIntegerValues
 * @property SettingTextValues[] $settingTextValues
 * @property SettingTextareaValue[] $settingTextareaValues
 */
class SettingAttributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $attributes;
	public $img;
	public $video;
    public static function tableName()
    {
        return 'setting_attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_id', 'name', 'input_type', 'attribute_key'], 'required'],
            [['setting_id', 'input_type'], 'integer'],
            [['name', 'attribute_key'], 'string', 'max' => 255],
            [['attribute_key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'setting_id' => 'Setting ID',
            'name' => 'Name',
            'input_type' => 'Input Type',
            'attribute_key' => 'Attribute Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasOne(Settings::className(), ['id' => 'setting_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputType()
    {
        return $this->hasOne(InputType::className(), ['id' => 'input_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingIntegerValues()
    {
        return $this->hasMany(SettingIntegerValues::className(), ['setting_attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingTextValues()
    {
        return $this->hasMany(SettingTextValues::className(), ['setting_attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingTextareaValues()
    {
        return $this->hasMany(SettingTextareaValue::className(), ['setting_attribute_id' => 'id']);
    }
	public function updateImage($image,$path)
    {
		$imagine = new Image();		
		Yii::$app->params['uploadPath'] = 'uploads/';
		Yii::$app->params['uploadThumbs'] = 'uploads/site/thumbs/';
		Yii::$app->params['uploadLarge'] = 'uploads/site/large/';
		Yii::$app->params['uploadMedium'] = 'uploads/site/medium/';
	
		$mimage = $image['name'];
		$himage = $image['name'];
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
			
			return $mimage;
		}else{
			return false;
		}
    }
    /**
     * @inheritdoc
     * @return SettingAttributesQuery the active query used by this AR class.
     */
/*     public static function find()
    {
        return new SettingAttributesQuery(get_called_class());
    } */
	public function getInputTypes()
	{
		$programs = InputType::find()->where('id != 0')->orderBy('name')->all();
		$arr = array();

		$merge =  ArrayHelper::map($programs,'id','name');

		return $merge;
	}
	public function getSiteInfo($setting_id = 0){
		$data = SettingAttributes::find()->where(['setting_id'=>$setting_id])->all();
			
		foreach($data as $data1){
				
			if($data1->input_type==1 || $data1->input_type==2 || $data1->input_type==6){
				$text_model = new SettingTextValues;
				$item_data = $text_model->find()->where(['setting_attribute_id'=>$data1->id])->one();
				if($item_data != ""){
					$itme_value[$data1->attribute_key] =  $item_data->value;
				}
			}elseif($data1->input_type==3){
				$textarea_model = new SettingTextareaValue;
				$item_data = $textarea_model->find()->where(['setting_attribute_id'=>$data1->id])->one();
				if($item_data != ""){
					$itme_value[$data1->attribute_key] =  $item_data->value;	
				}
			}
		}
		return $itme_value;
	} 
}
