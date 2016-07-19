<?php

namespace backend\controllers;

use Yii;
use common\models\DropdownValues;
use common\models\DropdownValuesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
/**
 * DropdownValuesController implements the CRUD actions for DropdownValues model.
 */
class DropdownValuesController extends Controller
{
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
     * Lists all DropdownValues models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DropdownValuesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DropdownValues model.
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
     * Creates a new DropdownValues model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DropdownValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DropdownValues model.
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
     * Deletes an existing DropdownValues model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSortValues(){
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $idsarray = Yii::$app->request->post('sort_ids');

            $index = 1;
            foreach($idsarray as $id){
                $model = $this->findModel($id);
                $model->sort_order = $index;
                $model->save();
                $index++;
            }
            $result = "success";
        } else {
            $result = "fail";
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'result' => $result,
        ];
    }

    protected function findModel($id)
    {
        if (($model = DropdownValues::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
