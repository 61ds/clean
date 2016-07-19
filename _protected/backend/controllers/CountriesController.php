<?php

namespace backend\controllers;

use common\models\AllcountriesSearch;
use common\models\Attributes;
use common\models\AttributesSearch;
use common\models\AttributeValues;
use common\models\Cities;
use common\models\CitiesSearch;
use common\models\Countries;
use common\models\CountriesSearch;
use common\models\Entity;
use common\models\InactiveCitiesSearch;
use common\models\InactiveStatesSearch;
use common\models\States;
use common\models\StatesSearch;
use common\traits\AjaxStatusTrait;
use common\traits\StatusChangeTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * CountryController implements the CRUD actions for Countries model.
 */
class CountriesController extends BackendController
{
	use StatusChangeTrait;
	use AjaxStatusTrait;
	public $entity_id = 1;
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
     * Lists all Countries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CountriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(Yii::$app->request->isAjax && Yii::$app->request->post('status_token'))
        {
            $id = Yii::$app->request->post('id');
            $model = Countries::findOne($id);
            return $this->changeStatus($model);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionAll()
    {
        $searchModel = new AllcountriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(Yii::$app->request->isAjax && Yii::$app->request->post('status_token'))
        {
            $id = Yii::$app->request->post('id');
            $model = Countries::findOne($id);
            return $this->changeStatus($model);
        }
        return $this->render('all', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        $attributes = Attributes::find()->where(['entity_id' => $this->entity_id, 'status' => 1])->orderBy('sort_order')->all();


        return $this->render('view', [
            'model' => $this->findModel($id),
            'attributes' => $attributes,
        ]);
    }
	public function actionViewstates($country_id)
    {
        $searchModel = new StatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$country_id);
        if(Yii::$app->request->isAjax && Yii::$app->request->post('status_token'))
        {
            $id = Yii::$app->request->post('id');
            $model = $this->findState($id);
            return $this->changeStatus($model);
        }
        return $this->render('viewstates', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'country' => Countries::findOne($country_id),
        ]);
    }
	public function actionInactiveStates($country_id)
    {
        $searchModel = new InactiveStatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$country_id);
        if(Yii::$app->request->isAjax && Yii::$app->request->post('status_token'))
        {
            $id = Yii::$app->request->post('id');
            $model = $this->findState($id);
            return $this->changeStatus($model);
        }
        return $this->render('viewstates', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'country' => Countries::findOne($country_id),
        ]);
    }

	public function actionAddState($id=0)
    {
        $model = new States();
		$model->country_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New State <b>'.$model->name.'</b> has been added to  '.$model->country->name.' successfully'));
            return $this->redirect(['viewstates', 'country_id'=>$model->country_id]);
        } else {
            return $this->render('addstate', [
                'model' => $model,
                'country' => Countries::findOne($id),
            ]);
        }
    }
		
	public function actionStateUpdate($state_id)
    {
        $model = $this->findState($state_id);
		$name = $model->name;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'State name <b>'.$name.'</b> has been updated to <b>'.$model->name.'</b>'));
            return $this->redirect(['viewstates', 'country_id'=>$model->country_id]);
        } else {
            return $this->render('state_update', [
                'model' => $model,
            ]);
        }
    }	
	public function actionCityUpdate($city_id)
    {
        $model = $this->findCity($city_id);
		$name = $model->name;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'City name <b>'.$name.'</b> has been updated to <b>'.$model->name.'</b>'));
            return $this->redirect(['viewcities', 'state_id'=>$model->state_id]);
        } else {
            return $this->render('city_update', [
                'model' => $model,
            ]);
        }
    }
	public function actionCityDetails($city_id)
    {
		echo $city_id;
    }
	public function actionViewcities($state_id)
    {
        $searchModel = new CitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$state_id);
        if(Yii::$app->request->isAjax && Yii::$app->request->post('status_token'))
        {
            $id = Yii::$app->request->post('id');
            $model = $this->findCity($id);
            return $this->changeStatus($model);
        }
        return $this->render('viewcities', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'state' => States::findOne($state_id),
        ]);
    }
    public function actionInactiveCities($state_id)
    {
        $searchModel = new InactiveCitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$state_id);
        if(Yii::$app->request->isAjax && Yii::$app->request->post('status_token'))
        {
            $id = Yii::$app->request->post('id');
            $model = $this->findCity($id);
            return $this->changeStatus($model);
        }
        return $this->render('viewcities', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'state' => States::findOne($state_id),
        ]);
    }

	public function actionAddCity($id=0)
    {
        $model = new Cities();
		$model->state_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New City <b>'.$model->name.'</b> has been added to  '.$model->state->name.' successfully'));
            return $this->redirect(['viewcities', 'state_id' => $model->state->id]);
        } else {
            return $this->render('addcity', [
                'model' => $model,
				'state' => States::findOne($id),
            ]);
        }
    }
	public function actionCityDelete($city_id)
    {
		$model = $this->findCity($city_id);
		$name = $model->name;
        if($model->delete()){
			Yii::$app->getSession()->setFlash('success', Yii::t('app', '<b>'.$name.'</b> has been removed from the list'));
		} else {
			Yii::$app->getSession()->setFlash('danger', Yii::t('app', '<b>'.$name.'</b> cannot be removed from the list'));
		}
		
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $flag = UploadedFile::getInstance($model, 'flag');
        if ($model->load(Yii::$app->request->post())) {
            if($flag)
            {
                $name = str_replace(' ','-',strtolower($model->name));
                $mimage= $model->updateImage($flag,$name);
                $model->flag = $mimage;
            }
            if($model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdateAttributeValue($id,$country)
    {
        if (($model = AttributeValues::findOne(['attr_id'=>$id,'entity_id'=>$this->entity_id,'item_id'=>$country])) === null) {
            $model = new AttributeValues();
            $model->attr_id = $id;
            $model->entity_id = $this->entity_id;
            $model->item_id = $country;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', $model->attr->name.' has been updated successfully.'));
            return $this->redirect(['view', 'id' => $country]);
        } else {
            return $this->render('update-attribute-value', [
                'model' => $model,
                'country' => Countries::findOne($country),
                'attribute' => Attributes::findOne($id),
            ]);
        }
    }

    /**
     * Deletes an existing Countries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
   
	public function actionStatus($id)
    { 
		$model = $this->findModel($id);
		if ($this->getIsActive($model)) {
			$this->inactive($model);
			Yii::$app->getSession()->setFlash('success', Yii::t('app', '<b>'.$model->name.'</b> has been de-activated'));
		} else {
			$this->active($model);
			Yii::$app->getSession()->setFlash('success', Yii::t('app', '<b>'.$model->name.'</b> has been activated'));
		}  

       return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionQuickStatus(){
        $request = Yii::$app->request;
        if($request->isAjax) {
            $id = Yii::$app->request->post('id');
            $model = Countries::findOne($id);
            $result = $this->changeStatus($model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->status == 0) {
                return [
                    'result' => $result,
                    'action' => 'Inactive',
                ];
            } else {
                return [
                    'result' => $result,
                    'action' => 'Active',
                ];
            }
        }
    }

	
	public function actionStateStatus($id)
    { 
		$model = $this->findState($id);
		if ($this->getIsActive($model)) {
			$this->inactive($model);
			Yii::$app->getSession()->setFlash('success', Yii::t('app', '<b>'.$model->name.'</b> has been de-activated'));
		} else {
			$this->active($model);
			Yii::$app->getSession()->setFlash('success', Yii::t('app', '<b>'.$model->name.'</b> has been activated'));
		}  

       return $this->redirect(Yii::$app->request->referrer);
    }
	public function actionCityStatus($id)
    { 
		$model = $this->findCity($id);
		if ($this->getIsActive($model)) {
			$this->inactive($model);
			Yii::$app->getSession()->setFlash('success', Yii::t('app', '<b>'.$model->name.'</b> has been de-activated'));
		} else {
			$this->active($model);
			Yii::$app->getSession()->setFlash('success', Yii::t('app', '<b>'.$model->name.'</b> has been activated'));
		}  

       return $this->redirect(Yii::$app->request->referrer);
    }

    // country, state, city attributes management

    public function actionCountryAttributes()
    {
        $searchModel = new AttributesSearch();
        $entity = Entity::findOne(1);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $entity->id);

        return $this->render('attributes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'entity' => $entity,
        ]);
    }
    public function actionStateAttributes()
    {
        $searchModel = new AttributesSearch();
        $entity = Entity::findOne(2);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $entity->id);

        return $this->render('attributes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'entity' => $entity,
        ]);
    }
    public function actionCityAttributes()
    {
        $searchModel = new AttributesSearch();
        $entity = Entity::findOne(3);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $entity->id);

        return $this->render('attributes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'entity' => $entity,
        ]);
    }
    public function actionCreateAttribute($entity_id)
    {
        $model = new Attributes();
        $model->entity_id = $entity_id;
        $entity = Entity::findOne($entity_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New attribute <b>'.$model->name.'</b> has been added successfully'));
            return $this->redirect([strtolower($entity->name).'-attributes']);
        } else {
            return $this->render('create-attribute', [
                'model' => $model,
                'entity' => $entity,
            ]);
        }
    }
    public function actionUpdateAttribute($id)
    {
        $model = Attributes::findOne($id);
        $entity = Entity::findOne($model->entity_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New attribute <b>'.$model->name.'</b> has been updated successfully'));
            return $this->redirect([strtolower($entity->name).'-attributes']);
        } else {
            return $this->render('update-attribute', [
                'model' => $model,
                'entity' => $entity,
            ]);
        }
    }
    public function actionAttributeStatus($id)
    {
        $model = Attributes::findOne($id);
        if ($this->getIsActive($model)) {
            $this->inactive($model);
            Yii::$app->getSession()->setFlash('success', Yii::t('app', '<b>'.$model->name.'</b> attribute has been de-activated'));
        } else {
            $this->active($model);
            Yii::$app->getSession()->setFlash('success', Yii::t('app', '<b>'.$model->name.'</b> attribute has been activated'));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionQuickAttributeStatus()
    {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $id = Yii::$app->request->post('id');
            $model = Attributes::findOne($id);
            return $this->changeStatus($model);

        }
    }
    protected function findModel($id)
    {
        if (($model = Countries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	// find the state model based on its primary key value	
	protected function findState($id)
    {
        if (($model = States::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	// find the city model based on its primary key value
	protected function findCity($id)
    {
        if (($model = Cities::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionActiveStates($id)
    {
        $model = new States();
        $model->country_id = $id;
        $states = $model->getStates();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'states' => $states,
            'cities' => '<option value="">- Select City -</option>',
        ];
    }
    public function actionActiveCities($id)
    {
        $model = new Cities();
        $model->state_id = $id;
        $cities = $model->getCities();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            $cities
        ];
    }
}
