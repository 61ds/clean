<?php

namespace common\traits;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Imagine as imagick;
use Imagine\Gd\Imagine as gd;
use Tinify;
trait ImageUploadTrait
{
	
 	public function uploadImage($image,$name,$main_folder,$size,$folder=0)
    {

		Tinify\setKey('o4wsFZIT3uOpeoHzkMt4VWG7HL6GAZ9b');
		$imagine = new Image();
		if($folder==0)
			$folders = Yii::$app->params['folders']['name'];
		else
			$folders = $folder;

		$image_name = $name.'.'. $image->extension;
		foreach($folders as $folder){

			$$folder = Yii::getAlias('@upload') .'/'. $main_folder .'/'. Yii::$app->params[$folder].'/'. $image_name;
			if (!file_exists(Yii::getAlias('@upload') .'/'. $main_folder .'/'. Yii::$app->params[$folder] )) {
				mkdir(Yii::getAlias('@upload') .'/'. $main_folder .'/'. Yii::$app->params[$folder] , 0777, true);
			}
		}

		if($image->saveAs($uploadMain)){
			
			$imagineObj =  new gd();	
		
			if($image->extension == 'jpg' || $image->extension == 'JPEG'){			
			
				$compress = array('quality' => 75);
				$imagineObj->open($uploadMain)
				->save($uploadMain, $compress); // from 0 to 9	
			}else{	
			
				$imagineObj =   new gd();
				$compress = array('quality' => 67);		
				$imagineObj->open($uploadMain)
					->save($uploadMain, $compress); // from 0 to 9	
			   
				$filesize = round((filesize($uploadMain)/1024));
				if($filesize > 200){
					try {
						Tinify\fromFile($uploadMain)->toFile($uploadMain);
					}catch(Exception $e) {
						Tinify\setKey('o4wsFZIT3uOpeoHzkMt4VWG7HL6GAZ9b');
						try {
							Tinify\fromFile($uploadMain)->toFile($uploadMain);
						}catch(Exception $e) {
							
						}
						
					}
				}	
			} 
			

			
			list($newWidth, $newHeight) = getimagesize($uploadMain);
			
			//$imageObj->thumbnail(new Box($newWidth, $newHeight))->save($uploadMain , $compress);


			   
			$i = 0;

			foreach($folders as $folder){

				$imaginename = 'imgobj'.$i;
				if($folder == 'uploadThumbs' && $size[$folder] != ''){		
					$$imaginename = $imagineObj->open($uploadMain);					
					$$imaginename->resize($$imaginename->getSize()->widen($size[$folder]))->save(Yii::getAlias('@upload') .'/'. $main_folder .'/'. Yii::$app->params[$folder] .'/'. $image_name);	 				
				
					//Image::thumbnail($uploadMain, $size[$folder], $size[$folder])
						//->save(Yii::$app->params[$folder] . $main_folder .'/'. $image_name, $compress);	   
				}
				else if($folder != 'uploadMain' && $size[$folder] != ''){
					$findme   = 'x';
					$pos = strpos($size[$folder], $findme);

					if ($pos === false) {
						$$imaginename = $imagineObj->open($uploadMain);

						$$imaginename->resize($$imaginename->getSize()->widen($size[$folder]))->save(Yii::getAlias('@upload') .'/'. $main_folder .'/'. Yii::$app->params[$folder] .'/'. $image_name);
					} else {

						list($newWidth, $newHeight) = explode('x',$size[$folder]);

						//$imageObj->thumbnail(new Box($newWidth, $newHeight))->save($uploadMain , $compress);
						$$imaginename = $imagineObj->open($uploadMain);

						$$imaginename->thumbnail(new Box($newWidth, $newHeight))->save(Yii::getAlias('@upload') .'/'. $main_folder .'/'. Yii::$app->params[$folder] .'/'. $image_name);
					}

				}
				
				$i++;
			}
			
			return $image_name;
		}else{
			return false;
		}
    }
	public function uploadFile($file,$name,$main_folder)
	{
		$filename =  $name.'.'. $file->extension;
		$uploadPath =  Yii::getAlias('@upload') .'/' . $main_folder .'/'. $filename;
		if (!file_exists( Yii::getAlias('@upload') .'/'. $main_folder )) {
			mkdir( Yii::getAlias('@upload') .'/'.$main_folder , 0777, true);
		}
		if($file->saveAs($uploadPath)){
			return $filename;
		}else{
			return false;
		}
	}


}


