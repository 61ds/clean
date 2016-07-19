<?php

namespace backend\controllers;

use Yii;
use common\models\Testimonial;
use common\models\TestimonialSearch;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\traits\ImageUploadTrait;
use common\traits\StatusChangeTrait;
use yii\web\UploadedFile;
use common\traits\AjaxStatusTrait;
/**
 * TestimonialController implements the CRUD actions for Testimonial model.
 */
class TestimonialController extends BackendController
{
	use ImageUploadTrait;
	use StatusChangeTrait;
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
     * Lists all Testimonial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestimonialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Testimonial model.
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
     * Creates a new Testimonial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Testimonial();

		$image = UploadedFile::getInstance($model, 'feat_image');
        if ($model->load(Yii::$app->request->post())) {
           if($image)
			{
					$name = time();
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "testimonial";
					$image_name= $this->uploadImage($image,$name,$main_folder,$size);
					$model->feat_image = $image_name;
			}
            Yii::$app->getSession()->setFlash('success', Yii::t('app', "Congratulations! Testimonial has been Updated."));
            $model->save();
			return $this->redirect(['index']);

        } else {
			return $this->render('create', [
                'model' => $model,
            ]);
        }			
		
    }

    /**
     * Updates an existing Testimonial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$image = UploadedFile::getInstance($model, 'feat_image');
        if ($model->load(Yii::$app->request->post()) ) {		
			if($image)
			{
					$name = time();
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "testimonial";
					$image_name= $this->uploadImage($image,$name,$main_folder,$size);
					$model->feat_image = $image_name;
			}else{
				$models = $this->findModel($id);
                $model->feat_image = $models->feat_image;
            }
			$model->save();	
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Testmonial has been updated successfully!'));			
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Testimonial model.
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
     * Finds the Testimonial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testimonial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testimonial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
