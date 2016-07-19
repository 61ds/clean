<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use common\models\Attributes;
use common\models\TypeSearch;
use common\models\AttributesSearch;
use common\models\GeneralAttributesSearch;
use common\models\SliderAttributesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

use common\traits\ImageUploadTrait;



/**
 * CategoryController implements the CRUD actions for Category model.
 */
class TypeController extends BackendController
{

	use ImageUploadTrait;
	
    public function behaviors()
    {
	    $behaviors = parent::behaviors();
		return $behaviors;
    }
    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex($id=0)
    {
        $searchModel = new TypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('index', [
			'category' => Category::findOne(['id'=>$id]),
			'title' => 'Main Categories',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		echo "hello";
		die;
        $model = new Category();
        $image = UploadedFile::getInstance($model, 'image');
        $banner = UploadedFile::getInstance($model, 'banner');
		
        if ($model->load(Yii::$app->request->post())) {
			$model->image = $model->title;
			
            if($model->save()) {				
				if($image)
				{
					$name = str_replace(' ','-',strtolower($model->title.$model->id));
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "category";
					$image_name= $this->uploadImage($image,$name,$main_folder,$size);
					$model->updateAttributes(['image' => $image_name]);
				}
				if($banner)
				{
					$name = str_replace(' ','-',strtolower($model->title.'_banner_'.$model->id));
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "category";
					$image_name= $this->uploadImage($banner,$name,$main_folder,$size);
					$model->updateAttributes(['image' => $image_name]);
				}	
				
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'slider has been created successfully!'));
				return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'sliders' => $sliders,
                ]);
            }			
			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	public function actionManageAttributes($id)
	{
		$model = $this->findModel($id);
		if (($attrsModel = $model->categoryAttributes) === null) {
            $attrsModel = $model->createAttrsModel;
        }
		$general_added = unserialize($attrsModel->general_attributes);
		$general_attrs = array();
		foreach($general_added as $attr){
			$general_attrs[] = Attributes::findOne(['id'=>$attr]);
		}
		$slider_added = unserialize($attrsModel->slider_attributes);
		$slider_attrs = array();
		foreach($slider_added as $attr){
			$slider_attrs[] = Attributes::findOne(['id'=>$attr]);
		} 
		 return $this->render('manage-attributes', [
			'category' => Category::findOne(['id'=>$id]),
			'general_attrs' => $general_attrs,
			'slider_attrs' => $slider_attrs,
        ]);	
		/*$model = $this->findModel($id);
		if (($attrsModel = $model->categoryAttributes) === null) {
            $attrsModel = $model->createAttrsModel;
        }
		$searchModel = new AttributesSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $attrsModel->general_attributes, $attrsModel->slider_attributes);
		 return $this->render('manage-attributes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'category' => Category::findOne(['id'=>$id]),			
        ]);	*/
		
	}
	public function actionSortGeneralAttrs()
	{
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $id = Yii::$app->request->post('cat_id');
            $idsarray = Yii::$app->request->post('sort_ids');
			$model = $this->findModel($id);
			$attrsModel = $model->categoryAttributes;
			$attrsModel->general_attributes = serialize($idsarray);            
            $attrsModel->save();           
            $result = "success";
        } else {
            $result = "fail";
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'result' => $result,
        ];
    }
	public function actionSortSliderAttrs()
	{
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $id = Yii::$app->request->post('cat_id');
            $idsarray = Yii::$app->request->post('sort_ids');
			$model = $this->findModel($id);
			$attrsModel = $model->categoryAttributes;
			$attrsModel->slider_attributes = serialize($idsarray);            
            $attrsModel->save();           
            $result = "success";
        } else {
            $result = "fail";
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'result' => $result,
        ];
    }
	public function actionSortAttributes($id)
	{
		$model = $this->findModel($id);
		if (($attrsModel = $model->categoryAttributes) === null) {
            $attrsModel = $model->createAttrsModel;
        }
		$attrs = unserialize($attrsModel->general_attributes);
		$values = array();
		foreach($attrs as $attr){
			$values[] = Attributes::findOne(['id'=>$attr]);
		}
		 
		 return $this->render('sort-attributes', [
			'category' => Category::findOne(['id'=>$id]),
			'values' => $values,
			'attrs' =>$attrs,
        ]);	
		
	}
	public function actionAddAttributes($id)
	{
		$model = $this->findModel($id);
		if (($attrsModel = $model->categoryAttributes) === null) {
            $attrsModel = $model->createAttrsModel;
        }
		$searchModel1 = new GeneralAttributesSearch();
		$dataProvider1 = $searchModel1->search();
		$searchModel2 = new SliderAttributesSearch();
		$dataProvider2 = $searchModel2->search();
		if (Yii::$app->request->isAjax && Yii::$app->request->post('status_token')) {
			$id = Yii::$app->request->post('id');			
			$category_id = Yii::$app->request->post('category_id');			
			$status_token = Yii::$app->request->post('status_token');			
			$attr_type = Yii::$app->request->post('attr_type');			
						
			
			if($attr_type==1){
				$attr_ids = unserialize($attrsModel->general_attributes);
				if($status_token==2){
					if(!in_array($id,$attr_ids)){
					$attr_ids[]=$id;
				$serialized_attrs = serialize($attr_ids);
				$attrsModel->general_attributes = $serialized_attrs;
				$attrsModel->save();
					 Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return [
						'result' => 1,
						'action' => 'Active',
					];
					}else{
						Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return [
						'result' => 0,
						'action' => 'Active',
					];
					}
				}else{
					if(($key = array_search($id, $attr_ids)) !== false) {
						unset($attr_ids[$key]);
				$serialized_attrs = serialize($attr_ids);
				$attrsModel->general_attributes = $serialized_attrs;
				$attrsModel->save();
						Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return [
							'result' => 1,
							'action' => 'Inactive',
						];
					}else{
						Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return [
							'result' => 0,
							'action' => 'Inactive',
						];
					}				
				}			
			} else {
				$attr_ids = unserialize($attrsModel->slider_attributes);
				if($status_token==2){
					if(!in_array($id,$attr_ids)){
					$attr_ids[]=$id;
				$serialized_attrs = serialize($attr_ids);
				$attrsModel->slider_attributes = $serialized_attrs;
				$attrsModel->save();
					 Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return [
						'result' => 1,
						'action' => 'Active',
					];
					}else{
						Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return [
						'result' => 0,
						'action' => 'Active',
					];
					}
				}else{
					if(($key = array_search($id, $attr_ids)) !== false) {
						unset($attr_ids[$key]);
				$serialized_attrs = serialize($attr_ids);
				$attrsModel->slider_attributes = $serialized_attrs;
				$attrsModel->save();
						Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return [
							'result' => 1,
							'action' => 'Inactive',
						];
					}else{
						Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return [
							'result' => 0,
							'action' => 'Inactive',
						];
					}				
				}
			}
		}
		 return $this->render('add-attributes', [
            'dataProvider1' => $dataProvider1,
            'dataProvider2' => $dataProvider2,
			'category' => Category::findOne(['id'=>$id]),
			'category_attrs' => $attrsModel,
        ]);	
		
	}
	
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
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
