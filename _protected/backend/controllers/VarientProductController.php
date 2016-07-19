<?php

namespace backend\controllers;

use Yii;
use common\models\VarientProduct;
use common\models\Product;
use common\models\VarientProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VarientProductController implements the CRUD actions for VarientProduct model.
 */
class VarientProductController extends BackendController
{


    /**
     * Lists all VarientProduct models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new VarientProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $model = new VarientProduct();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'id' => $id,
        ]);
    }
    /**
     * Displays a single VarientProduct model.
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
     * Creates a new VarientProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new VarientProduct();
        $model->product_id = $id;
        $model->colors = 'red';
        $product = Product::findOne($id);
        $model->sku = $product->article_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', "Item successfully created."));
            return $this->redirect(['index', 'id' => $id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'id' => $id,
            ]);
        }
    }

    /**
     * Updates an existing VarientProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->colors = 'red';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', "Item successfully updated."));
            return $this->redirect(['index', 'id' => $model->product_id]);
        } else {

            return $this->render('update', [
                'model' => $model,
                'id' => $model->product_id,
            ]);
        }
    }

    /**
     * Deletes an existing VarientProduct model.
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
     * Finds the VarientProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VarientProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VarientProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
