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



trait FileUploadTrait
{
	public function uploadFileDocs($file,$name,$main_folder,$size)
    {
		$files =  $name.'.'. $file->extension;
		$himage =  $name.'.'. $file->extension;
		$uploadPath = "uploads/" . $main_folder .'/'. $files;
		if (!file_exists("uploads/" . $main_folder )) {
				mkdir("uploads/". $main_folder , 0777, true);
		}				
		if($file->saveAs($uploadPath)){
			return $files;
		}else{
			return false;
		}
    }
}


