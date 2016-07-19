<?php

namespace backend\controllers;

use Yii;
use common\models\Pages;
use common\models\PagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use kartik\file\FileInput;
use yii\web\UploadedFile;

use common\traits\ImageUploadTrait;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class PagesController extends BackendController
{

	use ImageUploadTrait;
	public $enableCsrfValidation = false;
    /**
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pages model.
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
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pages();
		$image = UploadedFile::getInstance($model, 'featured_image');
        if ($model->load(Yii::$app->request->post())) {
			if($image != '')
			{
					$name = time();
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "pages";
					$image_name= $this->uploadImage($image,$name,$main_folder,$size);
					$model->featured_image = $image_name;
			}
            $model->save();
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Page has been created successfully!'));
			 return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$imgname = $model->featured_image;
		$image = UploadedFile::getInstance($model, 'featured_image');
        if ($model->load(Yii::$app->request->post())) {

			if($image != '')
			{
				if($imgname){
					$name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgname);
				}else{
					$name = time();
				}
				$size = Yii::$app->params['folders']['size'];
				$main_folder = "pages";

				$image_name= $this->uploadImage($image,$name,$main_folder,$size);
				$model->featured_image = $image_name;
			}else{
				$model->featured_image = $imgname;
			}
			$model->save();
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Page has been updated successfully!'));
             return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Pages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Page has been Deleted successfully!'));
        return $this->redirect(['index']);
    }
    /**
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
