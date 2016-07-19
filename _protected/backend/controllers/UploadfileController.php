<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use common\traits\ImageUploadTrait;

class UploadfileController extends BackendController
{
	use ImageUploadTrait;
    public function behaviors()
    {
	    $behaviors = parent::behaviors();
		return $behaviors;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return "hello";
    }
	public function actionUrl()
    {         
        $uploadedFile = UploadedFile::getInstanceByName('upload'); 
		
        $mime = \yii\helpers\FileHelper::getMimeType($uploadedFile->tempName);
		$name = explode('.', $uploadedFile->name);
        $file = time()."_".$name[0];

		$size = Yii::$app->params['folders']['size'];
		$main_folder = "ckeditor";
		$image_name = $this->uploadImage($uploadedFile,$file,$main_folder,$size);

        $url = Yii::$app->params['baseurl'].'/uploads/main/ckeditor/'.$image_name;

        $uploadPath = Yii::$app->params['uploadurl'].'/uploads/ckeditor/'.$file;
        //extensive suitability check before doing anything with the file…
        if ($uploadedFile==null)
        {
           $message = "No file uploaded.";
        }
        else if ($uploadedFile->size == 0)
        {
           $message = "The file is of zero length.";
        }
        else if ($mime!="image/jpeg" && $mime!="image/png")
        {
           $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
        }
        else if ($uploadedFile->tempName==null)
        {
           $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
        }
        else {
          $message = "";
          $move = $uploadedFile->saveAs($uploadPath);
          if(!$move)
          {
             $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
          } 
        }
        $funcNum = $_GET['CKEditorFuncNum'] ;
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";        
    }
	public function actionBrowse()
    {

        $this->layout = 'main-browse';

        $dir = Yii::$app->params['uploadurl'].'/uploads/main/ckeditor/';

        $files = glob("$dir*.{jpg,jpe,jpeg,png,gif,ico}", GLOB_BRACE);


        return $this->render('browse', [
            'files' => $files
        ]);
	}

}
