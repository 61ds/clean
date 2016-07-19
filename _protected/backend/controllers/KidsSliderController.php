<?php

namespace backend\controllers;

use Yii;
use common\models\KidsSlider;
use common\models\KidsSliderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use kartik\file\FileInput;
use yii\web\UploadedFile;
use common\traits\ImageUploadTrait;
/**
 * KidsSliderController implements the CRUD actions for KidsSlider model.
 */
class KidsSliderController extends Controller
{
    /**
     * @inheritdoc
     */
	use ImageUploadTrait;
	public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all KidsSlider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KidsSliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KidsSlider model.
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
     * Creates a new KidsSlider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KidsSlider();
        $image = UploadedFile::getInstance($model, 'img');
        if ($model->load(Yii::$app->request->post())) {
			if($image != '')
			{
					$name = time();
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "slides";
					$image_name= $this->uploadImage($image,$name,$main_folder,$size);
					$model->img = $image_name;
			}
            $model->save();
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Slide has been created successfully!'));
			 return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing KidsSlider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$imgname = $model->img;
		$image = UploadedFile::getInstance($model, 'img');
        if ($model->load(Yii::$app->request->post())) {
			if($image)
			{
					$name = time();
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "slides";
					$image_name= $this->uploadImage($image,$name,$main_folder,$size);
					$model->img = $image_name;
			}else{
				$models = $this->findModel($id);
                $model->img = $models->img;
            }
			$model->save();
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Slide has been updated successfully!'));
             return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing KidsSlider model.
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
     * Finds the KidsSlider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KidsSlider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KidsSlider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
