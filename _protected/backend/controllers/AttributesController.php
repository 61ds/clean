<?php

namespace backend\controllers;

use Yii;
use common\models\Attributes;
use common\models\DropdownValues;
use common\models\AttributesSearch;
use common\models\DropdownValuesSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
/**
 * AttributesController implements the CRUD actions for Attributes model.
 */
class AttributesController extends BackendController
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
     * Lists all Attributes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttributesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new DropdownValuesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('view', [
            'attribute' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSortAttrValues($id)
    {
        $model = $this->findModel($id);
        $values = DropdownValues::find()->where(['attribute_id' => $id, 'status' => 1])->orderBy(['sort_order' => SORT_ASC])->all();
        return $this->render('sort-attr-values', [
            'model' => $model,
            'values' => $values,
        ]);
    }
    public function actionSortAlphabetically($id,$order){
        $model = $this->findModel($id);
        if($order==1)
        $model->dropdownValuesAsc;
        else
        $model->dropdownValuesDesc;

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCreateValues($id)
    {
        $model = new DropdownValues();
        $model->attribute_id = $id;

        if (Yii::$app->request->isPost) {
            $postdata = Yii::$app->request->post();
            foreach($postdata['DropdownValues']['name'] as $value)
            {
                if($value!=''){
                    if ((DropdownValues::findOne(['name' => $value, 'attribute_id' => $id])) !== null) {
                        continue;
                    }
                    $attr_value = new DropdownValues();
                    $attr_value->name = $value;
                    $attr_value->attribute_id = $id;
                    $attr_value->save();
                } else {
                    continue;
                }
            }
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('create-values', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreate()
    {
        $model = new Attributes();
        $model->lower_limit = 0;
        $model->upper_limit = 0;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Attributes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateAttrValue($id)
    {
        if (($model = DropdownValues::findOne($id)) !== null) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['update-attr-value', 'id' => $model->id]);
            } else {
                return $this->render('update-attr-value', [
                    'model' => $model,
                ]);
            }
        } else {
            return Yii::$app->request->referrer;
        }
    }

    /**
     * Deletes an existing Attributes model.
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
     * Finds the Attributes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attributes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attributes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
