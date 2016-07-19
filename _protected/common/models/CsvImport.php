<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CsvImport extends Model{
	
    public $file;
    
    public function rules(){
        return [
            [['file'],'required'],
            [['file'],'file','extensions'=>'csv','maxSize'=>1024 * 1024 * 24],
        ];
    }
    
    public function attributeLabels(){
        return [
            'file'=>'Select File',
        ];
    }
		
}