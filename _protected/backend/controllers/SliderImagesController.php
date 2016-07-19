<?php

namespace backend\controllers;

use Yii;
use common\models\SliderImages;
use common\models\Slider;
use common\models\SliderSearch;
use common\models\SliderImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\imagine\Image;
use kartik\file\FileInput;
use yii\web\UploadedFile;
use common\traits\ImageUploadTrait;
/**
 * SliderImagesController implements the CRUD actions for SliderImages model.
 */
class SliderImagesController extends BackendController
{
	use ImageUploadTrait;
	public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SliderImages models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('/Slider/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionUpdateslides($idd=0,$slider_id=0)
    {
        $searchModel = new SliderImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$idd);
		$model = new SliderImages();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'model' => $model,
			'slider_id' => $slider_id,
        ]);
        }
      
    }
	public function actionViewslides($slider_id=0)
    {
		
        $searchModel = new SliderImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$slider_id);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'video' => Slider::findOne($slider_id),
        ]);
    }
    /**
     * Displays a single SliderImages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SliderImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  
	public function actionCreate($slider_id=0)
    {
		
        $model = new SliderImages();
		$searchModel = new SliderImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$slider_id);
		$image = UploadedFile::getInstance($model, 'image_path');
        if ($model->load(Yii::$app->request->post())) {
				$path = '/'.$model->slider_id;
				$model->slider_id = $slider_id;
				if($image != '')
				{
						$newname =$image->name;
						$name = str_replace(' ','-',strtolower($newname));
						$size = Yii::$app->params['folders']['size'];
						$main_folder = "slides";
						$image_name= $this->uploadImage($image,$name,$main_folder,$size);
						$type1 = array('video/mp4','video/mkv','video/avi');
						$type2 = array('image/png','image/jpg','image/jpeg','image/gif');
						if(in_array($image->type , $type1)){
								$model->image_path = $image_name;
								$model->type = "video";
						}
						if(in_array($image->type , $type2)){
								$model->image_path = $image_name;
								$model->type = 'image';
						}
												
				}
				$model->save();	
				Yii::$app->getSession()->setFlash('success', Yii::t('app', 'slider has been updated successfully!'));
            return $this->redirect(['viewslides', 'slider_id' => $slider_id]);
        } else {
			
            return $this->render('create', [
                'model' => $model,
				'video' =>$slider_id,
            ]);
        }
    }
	 public function actionUpdate($id , $slider_id=0)
    {
        $model = $this->findModel($id,$slider_id);
		$image = UploadedFile::getInstance($model, 'image_path');
        if ($model->load(Yii::$app->request->post())) {
			
			$asdlogo = $model->getSlidepath($id);
			foreach($asdlogo as $asdlogo1 ){
				$image_path = $asdlogo1->image_path;
			}
					
					//die;
					if($image != '')
					{
						$newname =$image->name;
						$name = str_replace(' ','-',strtolower($newname));
						$size = Yii::$app->params['folders']['size'];
						$main_folder = "slides";
						$image_name= $this->uploadImage($image,$name,$main_folder,$size);
						$type1 = array('video/mp4','video/mkv','video/avi');
						$type2 = array('image/png','image/jpg','image/jpeg','image/gif');
						if(in_array($image->type , $type1)){
								$model->image_path = $image_name;
								$model->type = "video";
						}
						if(in_array($image->type , $type2)){
								$model->image_path = $image_name;
								$model->type = 'image';
						}
												
					}
					else
					{
						$model->image_path = $image_path;
					}
				
				$model->save();
				Yii::$app->getSession()->setFlash('success', Yii::t('app', 'slider has been updated successfully!'));
				//$imagine->thumbnail($uploadLarge, 1000, 400)->save($filename, ['quality' => 80]);				
						
            return $this->redirect(['viewslides', 'slider_id' => $slider_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'slider_id' => $slider_id,
            ]);
        }
    }
    /**
     * Updates an existing SliderImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    /**
     * Deletes an existing SliderImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	
        
		$mod = $this->findModel($id);
		$slide_id = $mod->slider_id;
		$this->findModel($id)->delete();
		return $this->redirect(['viewslides', 'slider_id' =>$slide_id]);
        //return $this->redirect(['index']);
    }

    /**
     * Finds the SliderImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SliderImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SliderImages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
