<?php

namespace backend\controllers;

use Yii;
use common\models\Slider;
use common\models\SliderSearch;
use common\models\SliderImages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\imagine\Image;
use kartik\file\FileInput;
use yii\web\UploadedFile;

/**
 * SliderController implements the CRUD actions for Slider model.
 */
class SliderController extends BackendController
{
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
     * Lists all Slider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slider model.
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
     * Creates a new Slider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$model = new Slider();
						
       if ($model->load(Yii::$app->request->post()) ) {
		$rf = Yii::$app->request->post('pageid');
		$pgeid = '0,';
		for($i=0;$i< count($rf);$i++){
			$pgeid .=	$rf[$i].",";
		}
		$model->pageid = $pgeid;
		$model->save();
				//$imagine->thumbnail($uploadLarge, 1000, 400)->save($filename, ['quality' => 80]);				
						
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
		
    }

    /**
     * Updates an existing Slider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		
		$request = Yii::$app->request;
		if ($request->isAjax){
			$id = $_POST['imgid'];
			$user = SliderImages::findOne($id);
			$user->delete();
			return "Deleted";
		}
        $model = $this->findModel($id);
		$image = UploadedFile::getInstances($model, 'file_path');
								
       if ($model->load(Yii::$app->request->post())) {
		  if(isset($_POST['pageid']) && !empty($_POST['pageid'])){
			$rf = $_POST['pageid'];
			$image = UploadedFile::getInstances($model, 'file_path');
			$pgeid = '0,';
			for($i=0;$i< count($rf);$i++){
				$pgeid .=	$rf[$i].",";
			}
			$model->pageid = $pgeid; 
		  }
		  else{
			  $model->pageid ='0,';
		  }
			
			$model->save();
			
				if($image != '')
				{
					
							$model3 = new SliderImages();
							foreach($image as $image1){	
							$path = '';
							$mimage= $model->updateImageFile($image1, $model->id,$path);
							$img_path = "/uploads/Slider/medium/".$mimage;
							$save = $model3->saveImage($model->id , $mimage , $img_path);
							if($model3->save()){
								echo 'hello';die;
							}							
					}
						 
				}	
			
				//$imagine->thumbnail($uploadLarge, 1000, 400)->save($filename, ['quality' => 80]);				
						
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Slider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
	
        return $this->redirect(['index']);
    }

    /**
     * Finds the Slider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
