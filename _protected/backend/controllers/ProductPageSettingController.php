<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use common\models\ProductPageSetting;
use common\models\ProductPageSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use common\traits\ImageUploadTrait;
use yii\web\UploadedFile;
/**
 * ProductPageSettingController implements the CRUD actions for ProductPageSetting model.
 */
class ProductPageSettingController extends BackendController
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
     * Lists all ProductPageSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPageSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductPageSetting model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		 return $this->redirect(['index']);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductPageSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductPageSetting();
        $video = UploadedFile::getInstance($model, 'video');
		$image = UploadedFile::getInstance($model, 'banner');
        if ($model->load(Yii::$app->request->post())) {
            if($video)
            {
                $name = time().$model->id;
                $main_folder = "product/setting/";
                $image_name= $this->uploadFile($video,$name,$main_folder);
                $model->video = $image_name;
            }
			if($image)
			{
					$name = time();
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "product/setting/";
					$image_name= $this->uploadImage($image,$name,$main_folder,$size);
					$model->banner = $image_name;
			}
            $model->product_slides = serialize(Yii::$app->request->post("product_slides"));
            Yii::$app->getSession()->setFlash('success', Yii::t('app', "Congratulations! Setting has been Updated."));
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductPageSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $cat_model = new Category();
        $video = UploadedFile::getInstance($model, 'video');
		$image = UploadedFile::getInstance($model, 'banner');
		$image1 = UploadedFile::getInstance($model, 'testimonial_banner');
        if ($model->load(Yii::$app->request->post())) {
            if($video)
            {
                $name = time().$model->id;
                $main_folder = "product/setting/";
                $image_name= $this->uploadFile($video,$name,$main_folder);
                $model->video = $image_name;
            }else{
				$models = $this->findModel($id);
                $model->video = $models->video;
            }
			if($image)
			{
					$name = time();
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "product/setting/";
					$image_name= $this->uploadImage($image,$name,$main_folder,$size);
					$model->banner = $image_name;
			}else{
				$models = $this->findModel($id);
                $model->banner = $models->banner;
            }
			if($image1)
			{
					$name = time();
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "product/setting/";
					$image_name= $this->uploadImage($image1,$name,$main_folder,$size);
					$model->testimonial_banner = $image_name;
			}else{
				$models = $this->findModel($id);
                $model->testimonial_banner = $models->testimonial_banner;
            }

            $model->product_slides = serialize(Yii::$app->request->post("product_slides"));
            Yii::$app->getSession()->setFlash('success', Yii::t('app', "Congratulations!Products Setting has been Updated."));
            $model->save();
            return $this->redirect(['index']);
        }else {
            return $this->render('update', [
                'model' => $model,
                'cat_model' =>  $cat_model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductPageSetting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		 return $this->redirect(['index']);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductPageSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductPageSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductPageSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
