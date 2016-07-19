<?php

namespace backend\controllers;

use Yii;
use common\models\Gallery;
use common\models\GallerySearch;
use common\models\GalleryImages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\imagine\Image;
use kartik\file\FileInput;
use yii\web\UploadedFile;
use common\traits\ImageUploadTrait;
/**
 * GalleryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends Controller
{
	use ImageUploadTrait;	
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
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GallerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Gallery model.
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
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$model = new Gallery();
						
       if ($model->load(Yii::$app->request->post()) ) {
		$image = UploadedFile::getInstances($model, 'file_path');
		$pgeid = '0,';
		$model->pageid = $pgeid;
		$model->save();
				if($image != '')
				{
					
							$model3 = new GalleryImages();
							foreach($image as $image1){	
							
								$name = time().$model->id;
								$size = Yii::$app->params['folders']['size'];
								$main_folder = "gallery/".$model->id;
								$image_name= $this->uploadImage($image1,$name,$main_folder,$size);
								$img_path = $image_name;
								$save = $model3->saveImage($model->id , $image1->name , $img_path);
								if($model3->save()){
								echo 'hello';die;
								}							
							}
						 
				}	
			
				//$imagine->thumbnail($uploadLarge, 1000, 400)->save($filename, ['quality' => 80]);				
			 Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Gallery <b>'.$model->galley_name	.'</b> has been created successfully'));			
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
		
    }

    /**
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		
		$request = Yii::$app->request;
		if ($request->isAjax){
			$id = $_POST['imgid'];
			$user = GalleryImages::findOne($id);
			$user->delete();
			return "Deleted";
		}
        $model = $this->findModel($id);
		$image = UploadedFile::getInstances($model, 'file_path');
								
       if ($model->load(Yii::$app->request->post())) {
			$image = UploadedFile::getInstances($model, 'file_path');			
			$model->save();
			if($image != '')
			{
				$model3 = new GalleryImages();
				foreach($image as $image1){	
					$name = time().$model->id;
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "gallery/".$model->id;
					$image_name= $this->uploadImage($image1,$name,$main_folder,$size);
					$img_path = $image_name;
					$save = $model3->saveImage($model->id , $image1->name , $img_path);
					if($model3->save()){
						echo 'hello';die;
					}							
				}							
			}
						 
					
			
				//$imagine->thumbnail($uploadLarge, 1000, 400)->save($filename, ['quality' => 80]);				
						
           Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Gallery <b>'.$model->galley_name	.'</b> has been Updated successfully'));			
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Gallery model.
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
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
