<?php

namespace backend\controllers;

use Yii;
use common\models\WomenPageSetting;
use common\models\WomenPageSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use kartik\file\FileInput;
use yii\web\UploadedFile;
use common\traits\ImageUploadTrait;
/**
 * WomenPageSettingController implements the CRUD actions for WomenPageSetting model.
 */
class WomenPageSettingController extends Controller
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
     * Lists all WomenPageSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
		 return $this->redirect(['update', 'id' => 1]);
        $searchModel = new WomenPageSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WomenPageSetting model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		 return $this->redirect(['update', 'id' => 1]);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WomenPageSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		return $this->redirect(['update', 'id' => 1]);
        $model = new WomenPageSetting();
		$banner1 = UploadedFile::getInstance($model, 'banner11[3]');
		$banner2 = UploadedFile::getInstance($model, 'banner21[3]');
		$banner3 = UploadedFile::getInstance($model, 'banner31[3]');
		$banner4 = UploadedFile::getInstance($model, 'banner41[3]');
		$banner5 = UploadedFile::getInstance($model, 'banner51[3]');
		$banner6 = UploadedFile::getInstance($model, 'banner61[3]');
        if ($model->load(Yii::$app->request->post())) {
			
			if($banner1 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name= $this->uploadImage($banner1,$name,$main_folder,$size);
					$model->banner11[3] = $image_name;
			}
			if($banner2 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name= $this->uploadImage($banner2,$name,$main_folder,$size);
					$model->banner21[3] = $image_name;
			}
			if($banner3 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name= $this->uploadImage($banner3,$name,$main_folder,$size);
					$model->banner31[3] = $image_name;
			}
			if($banner4 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name= $this->uploadImage($banner4,$name,$main_folder,$size);
					$model->banner41[3] = $image_name;
			}
			if($banner5 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name= $this->uploadImage($banner5,$name,$main_folder,$size);
					$model->banner51[3] = $image_name;
			}
			if($banner6 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name= $this->uploadImage($banner6,$name,$main_folder,$size);
					$model->banner61[3] = $image_name;
			}
			$model->banner1 = serialize($model->banner11);
			$model->banner2 = serialize($model->banner21);
			$model->banner3 = serialize($model->banner31);
			$model->banner4 = serialize($model->banner41);
			$model->banner5 = serialize($model->banner51);
			$model->banner6 = serialize($model->banner61);
			//echo'<pre>';print_r($model);die;
			$model->save();
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Settings has been Updated successfully!'));
			return $this->redirect(['update', 'id' => 1]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WomenPageSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$model = $this->findModel($id);
		$model3 = $this->findModel($id);
		$model3->banner11 = unserialize($model3->banner1);	
		$model3->banner21 = unserialize($model3->banner2);
		$model3->banner31 = unserialize($model3->banner3);
		$model3->banner41 = unserialize($model3->banner4);
		$model3->banner51 = unserialize($model3->banner5);
		$model3->banner61 = unserialize($model3->banner6);
		$banner1 = UploadedFile::getInstance($model, 'banner11[3]');
		$banner2 = UploadedFile::getInstance($model, 'banner21[3]');
		$banner3 = UploadedFile::getInstance($model, 'banner31[3]');
		$banner4 = UploadedFile::getInstance($model, 'banner41[3]');
		$banner5 = UploadedFile::getInstance($model, 'banner51[3]');
		$banner6 = UploadedFile::getInstance($model, 'banner61[3]');
        if ($model->load(Yii::$app->request->post())) {
			
			if($banner1 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name= $this->uploadImage($banner1,$name,$main_folder,$size);
					$model->banner11[3] = $image_name;
			}else{
				$model->banner11[3] =$model3->banner11[3];
			}
			if($banner2 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name1= $this->uploadImage($banner2,$name,$main_folder,$size);
					$model->banner21[3] = $image_name1;
			}else{
				$model->banner21[3] =$model3->banner21[3];
			}
			if($banner3 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name2= $this->uploadImage($banner3,$name,$main_folder,$size);
					$model->banner31[3] = $image_name2;
			}else{
				$model->banner31[3] =$model3->banner31[3];
			}
			if($banner4 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name3= $this->uploadImage($banner4,$name,$main_folder,$size);
					$model->banner41[3] = $image_name3;
			}else{
				$model->banner41[3] =$model3->banner41[3];
			}
			if($banner5 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name4= $this->uploadImage($banner5,$name,$main_folder,$size);
					$model->banner51[3] = $image_name4;
			}else{
				$model->banner51[3] =$model3->banner51[3];
			}
			if($banner6 != '')
			{
					$name = time().'_banner';
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "banner";
					$image_name5= $this->uploadImage($banner6,$name,$main_folder,$size);
					$model->banner61[3] = $image_name5;
			}else{
				$model->banner61[3] =$model3->banner61[3];
			}
			$model->banner1 = serialize($model->banner11);
			$model->banner2 = serialize($model->banner21);
			$model->banner3 = serialize($model->banner31);
			$model->banner4 = serialize($model->banner41);
			$model->banner5 = serialize($model->banner51);
			$model->banner6 = serialize($model->banner61);
			$model->save();
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Settings has been Updated successfully!'));
			return $this->redirect(['update', 'id' => 1]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WomenPageSetting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		 return $this->redirect(['update', 'id' => 1]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the WomenPageSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WomenPageSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WomenPageSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
