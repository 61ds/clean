<?php

namespace backend\controllers;

use Yii;
use common\models\Sizewidth;
use common\models\SizewidthSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SizewidthController implements the CRUD actions for Sizewidth model.
 */
class SizewidthController extends BackendController
{
    /**
     * @inheritdoc
     */


    /**
     * Lists all Sizewidth models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SizewidthSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sizewidth model.
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
     * Creates a new Sizewidth model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sizewidth();

        if ($model->load(Yii::$app->request->post())) {
            $model->size = serialize($model->size);
            $model->width = serialize($model->width);

            if($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', $model->name . ' has been created successfully!'));
                return $this->redirect(['index']);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sizewidth model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->size)
            $model->size = unserialize($model->size);

        if($model->width)
            $model->width = unserialize($model->width);


        if ($model->load(Yii::$app->request->post())) {
            $model->size = serialize($model->size);
            $model->width = serialize($model->width);
            if($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', $model->name . ' has been updated successfully!'));
                return $this->redirect(['index']);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sizewidth model.
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
     * Finds the Sizewidth model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sizewidth the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sizewidth::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
