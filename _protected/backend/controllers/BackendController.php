<?php
namespace backend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 *
 *
 *
 *
 *
 * BackendController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC) for 
 * your controllers and their actions.
 */
class BackendController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     * Here we use RBAC in combination with AccessControl filter.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
						'controllers' => ['site'],
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
						'controllers' => ['site'],
                        'actions' => ['logout','index'],
                        'allow' => true,
						'roles' => ['admin','theCreator'],
                    ],				
				
                    [
                        'controllers' => ['user'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin','theCreator'],
                    ],
                    [
                        'controllers' => ['setting-attributes'],
                        'actions' => ['index', 'globalsetting'],
                        'allow' => true,
                        'roles' => ['admin','theCreator'],						
                    ],					
                    [
                        'controllers' => ['pages','category','type','discount','discount-code'],
                        'actions' => ['index', 'create','update','update-any-status','manage','save','remove','move','delete'],
                        'allow' => true,
                        'roles' => ['admin','theCreator'],
                    ],		
                    [
                        'controllers' => ['uploadfile'],
                        'actions' => ['browse', 'create','update','url'],
                        'allow' => true,
                        'roles' => ['admin','theCreator'],					
                    ],
                    [
                        'controllers' => ['attributes','entity','category','type','menu','slider-images'],
                        'actions' => ['home-slider','index', 'term-value','view', 'create', 'update','viewmenus','c-menu','values','status','url','browse','inactive','active','manage-attributes','add-attributes','sort-general-attrs','sort-slider-attrs'],
                        'allow' => true,
                        'roles' => ['admin','theCreator'],
                    ],
                    [
                        'controllers' => ['sizewidth'],
                        'actions' => ['index', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['admin','theCreator'],
                    ],
                    [
                        'controllers' => ['product','varient-product','sizewidth','order'],
                        'actions' => ['index','update-any-status', 'create','upload','refund','refund-update', 'summary','update','subcategories','viewitems','generate'],
                        'allow' => true,
                        'roles' => ['admin','theCreator'],
                    ],
                ], // rules
				
				'denyCallback' => function ($rule, $action) {
					if(Yii::$app->user->isGuest){	
						return $this->redirect(['site/login']); 
					}else{						
						return $this->redirect(Yii::$app->params['baseurl']);
					}
				},
      				

            ], // access

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ], // verbs

        ]; // return

    } // behaviors
	
	//update any status
    public function actionUpdateAnyStatus(){


		if(Yii::$app->request->isAjax && Yii::$app->request->post('status_token')){
			$add = 'Inactive';
			$remove = 'Active';
			
            $id = Yii::$app->request->post('id');
            $field = Yii::$app->request->post('field');
			if($field == 'status'){
				$add = 'Inactive';
				$remove = 'Active';
			}
			
            $model = Yii::$app->request->post('model');
			
			if($model){
				$model = 'common\models\\'.$model;
				$model = $model::findOne($id);
			}else{
				$model = $this->findModel($id);
			}
			
			if($model->$field == 1){

				$result = (bool)$model->updateAttributes([$field => 0]);
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				return [
					'result' => $result,
					'action' => $add,
				];
			} else {

				$result = (bool)$model->updateAttributes([$field => 1]);
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				return [
					'result' => $result,
					'action' => $remove,
				];
			}
        }
    }
} // BackendController