<?php

namespace backend\controllers;

use common\models\SettingAttributes;
use common\models\SettingAttributesSearch;
use common\models\SettingIntegerValues;
use common\models\Settings;
use common\models\SettingTextareaValue;
use common\models\SettingTextValues;
use common\traits\ImageUploadTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * SettingAttributesController implements the CRUD actions for SettingAttributes model.
 */
class SettingAttributesController extends Controller
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
     * Lists all SettingAttributes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingAttributesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->redirect(['settings/index']);
        /* return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); */
    }
	public function actionViewattribute($setting_id=0)
    {
        $searchModel = new SettingAttributesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$setting_id);
		if($setting_id != 0){
			 return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'setting_id' => $setting_id,
			'attribute' => SettingAttributes::findOne(['setting_id' => $setting_id]),
			]);
		}else{
			 return $this->redirect(['settings/index']);
		}
       
    }
	public function actionGlobalsetting()
    {
		$model = new Settings();
		$text_model = new SettingTextValues;		
		//echo"<pre>";print_r($_POST);print_r($_FILES);die;
		$settingsa = $model->find()->all();
        if (!empty(Yii::$app->request->post())){
			$postarray = Yii::$app->request->post();
			$set_id = Yii::$app->request->post("form_name");
			$image = UploadedFile::getInstance($text_model, 'img[]');
			$image = UploadedFile::getInstance($text_model, 'video[]');

			if(!empty($_FILES) && isset($_FILES)){
				foreach($_FILES['SettingTextValues']['name']['img'] as $keys => $values){

						$text_model = new SettingTextValues;
						$get_value = $text_model->find()->where(['setting_id'=> $set_id , 'setting_attribute_id' =>$keys])->one();
						if($get_value != ""){
							$image = UploadedFile::getInstance($text_model, 'img['.$keys.']');
							if($image)
							{
								$type = explode("/",$image->type);
								if($type[0]  == "image" ){
									$name = time();
									$size = Yii::$app->params['folders']['size'];
									$size['uploadThumbs'] = '170';
									$main_folder = "settings";
									$image_name= $this->uploadImage($image,$name,$main_folder,$size);
									$get_value->value = $image_name;
									$get_value->save();
								}else{
									$name = time();
									$main_folder = "settings";
									$image_name= $this->uploadFile($image,$name,$main_folder);
									$get_value->value = $image_name;
									$get_value->save();
								}
								
								
							}
							
						}else{
							$text_model->setting_attribute_id = $keys;
							$text_model->setting_id = $set_id;
							$image = UploadedFile::getInstance($text_model, 'img['.$keys.']');
							if($image)
							{
								$type = explode("/",$image->type);
								if($type[0]  == "image" ){
									$name = time();
									$size = Yii::$app->params['folders']['size'];
									$size['uploadThumbs'] = '170';
									$main_folder = "settings";
									$image_name= $this->uploadImage($image,$name,$main_folder,$size);
									$text_model->value = $image_name;
									$text_model->save();
								}else{
									$name = time();
									$main_folder = "settings";
									$image_name= $this->uploadFile($image,$name,$main_folder);
									$text_model->value = $image_name;
									$text_model->save();
								}
								
							}
							
						}
				}
				if(isset($_FILES['SettingTextValues']['name']['video'])){
					foreach($_FILES['SettingTextValues']['name']['video'] as $keys => $values){

						$text_model = new SettingTextValues;
						$get_value = $text_model->find()->where(['setting_id'=> $set_id , 'setting_attribute_id' =>$keys])->one();
						if($get_value != ""){
							$image = UploadedFile::getInstance($text_model, 'video['.$keys.']');
							if($image)
							{
								$type = explode("/",$image->type);
								if($type[0]  == "image" ){
									$name = time();
									$size = Yii::$app->params['folders']['size'];
									$size['uploadThumbs'] = '170';
									$main_folder = "settings";
									$image_name= $this->uploadImage($image,$name,$main_folder,$size);
									$get_value->value = $image_name;
									$get_value->save();
								}else{
									$name = time();
									$main_folder = "settings";
									$image_name= $this->uploadFile($image,$name,$main_folder);
									$get_value->value = $image_name;
									$get_value->save();
								}
								
								
							}
							
						}else{
							$text_model->setting_attribute_id = $keys;
							$text_model->setting_id = $set_id;
							$image = UploadedFile::getInstance($text_model, 'video['.$keys.']');
							if($image)
							{
								$type = explode("/",$image->type);
								if($type[0]  == "image" ){
									$name = time();
									$size = Yii::$app->params['folders']['size'];
									$size['uploadThumbs'] = '170';
									$main_folder = "settings";
									$image_name= $this->uploadImage($image,$name,$main_folder,$size);
									$text_model->value = $image_name;
									$text_model->save();
								}else{
									$name = time();
									$main_folder = "settings";
									$image_name= $this->uploadFile($image,$name,$main_folder);
									$text_model->value = $image_name;
									$text_model->save();
								}
								
							}
							
						}
					}
				}
			}
			
			if(!empty($postarray) && isset($postarray)){									
				if(isset($postarray['SettingTextareaValue']['content']) && $postarray['SettingTextareaValue']['content'] != ""){
					foreach($postarray['SettingTextareaValue']['content'] as $keys => $values){
						$text_modelr = new SettingTextareaValue;
							$asdr = $text_modelr->find()->where(['setting_id'=> $set_id , 'setting_attribute_id' =>$keys])->one();
							
							if($asdr!=""){
								$asdr->value = $values;
								$asdr->save();
							}else{
								$text_modelr->setting_attribute_id = $keys;
								$text_modelr->setting_id = $set_id;
								$text_modelr->value = $values;
								$text_modelr->save();
							}
					}
				}
				if(isset($postarray['SettingTextValues']['attributes']) && $postarray['SettingTextValues']['attributes'] !=  ""){
					foreach($postarray['SettingTextValues']['attributes'] as $keys => $values){
						$text_model = new SettingTextValues;
						$get_value = $text_model->find()->where(['setting_id'=> $set_id , 'setting_attribute_id' =>$keys])->one();
						if($get_value!=""){
							$get_value->value = $values;
							$get_value->save();
						}else{
								$text_model->setting_attribute_id = $keys;
								$text_model->setting_id = $set_id;
								$text_model->value = $values;
								$text_model->save();
							}
					}
				}
				
				
			}
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Settings has been updated successfully!'));
            return $this->redirect(['globalsetting', 'id' => $model->id]);
        } else {
			$text_model = new SettingTextValues;
			$int_model = new SettingIntegerValues;
			$textarea_model = new SettingTextareaValue;
			
            return $this->render('globalsetting', [
                'model' => $model,
                'settingsa' => $settingsa,
                'text_model' => $text_model,
                'int_model' => $int_model,
                'textarea_model' => $textarea_model,
            ]);
        }
    }
    /**
     * Displays a single SettingAttributes model.
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
     * Creates a new SettingAttributes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($setting_id=0)
    {
        $model = new SettingAttributes();
		$model->setting_id = $setting_id;
        if ($model->load(Yii::$app->request->post())) {
			$model->save();
			 return $this->redirect(['viewattribute', 'setting_id' => $setting_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'setting_id' => $setting_id,
            ]);
        }
    }

    /**
     * Updates an existing SettingAttributes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SettingAttributes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$mod = $this->findModel($id);
		 if($mod->input_type==1 || $mod->input_type == 2){
			SettingTextValues::findOne(['setting_attribute_id'=>$id,'setting_id'=>$mod->setting_id])->delete();
		}elseif($mod->input_type==3){
			SettingTextareaValue::findOne(['setting_attribute_id'=>$id,'setting_id'=>$mod->setting_id])->delete();
		}else{
			SettingIntegerValues::findOne(['setting_attribute_id'=>$id,'setting_id'=>$mod->setting_id])->delete();
		} 
		$setting_id = $mod->setting_id;
        $this->findModel($id)->delete();
		return $this->redirect(['viewattribute', 'setting_id' => $setting_id]);
    }

    /**
     * Finds the SettingAttributes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SettingAttributes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SettingAttributes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
