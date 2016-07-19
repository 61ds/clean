<?php

namespace backend\controllers;

use common\models\OrderComments;
use Yii;
use common\models\Orders;
use common\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Orders model.
 */
class OrderController extends BackendController
{


    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $order = new Orders();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order' => $order,
        ]);
    }
	public function actionRefund()
    {
        $searchModel = new OrderSearch();
        $order = new Orders();
		$refund = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$refund);

        return $this->render('refundindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order' => $order,
        ]);
    }

    /**
     * Displays a single Orders model.
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
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
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
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSummary($id)
    {
        $models = $this->findModel($id);
        $model = new OrderComments();
        $model->order_id = $id;
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            if($model->save()){
                $models->status = $model->status;
                $models->save();
                Yii::$app->getSession()->setFlash('success', Yii::t('app', "Order status updated successfully."));

            }else{

                Yii::$app->getSession()->setFlash('danger', Yii::t('app', "This status already updated."));

            }
            return $this->redirect(['summary', 'id' => $id]);
        }
        $model->status = $models->status;
        $comments = OrderComments::find()->where(['order_id' => $id])->orderBy([
	           'created_at' => SORT_DESC,
	        ])->all();

        $orderdetail = Orders::getOrderDetail($id);

        return $this->render('summary', [
            'orderdetail' => $orderdetail,
            'model' => $model,
            'comments' => $comments,
        ]);
    }
	public function actionRefundUpdate($id)
    {
        $models = $this->findModel($id);
        $model = new OrderComments();
        $model->order_id = $id;
        if ($model->load(Yii::$app->request->post()) && $models->load(Yii::$app->request->post())) {
            if($model->save() || $models->save()){
                $models->status = $model->status;
                $models->save();
                Yii::$app->getSession()->setFlash('success', Yii::t('app', "Order status updated successfully."));

            }else{

                Yii::$app->getSession()->setFlash('danger', Yii::t('app', "This status already updated."));

            }
            return $this->redirect(['refund-update', 'id' => $id]);
        }
        $model->status = $models->status;
        $comments = OrderComments::find()->where(['order_id' => $id])->orderBy([
	           'created_at' => SORT_DESC,
	        ])->all();

        $orderdetail = Orders::getOrderDetail($id);

        return $this->render('refundupdate', [
            'orderdetail' => $orderdetail,
            'model' => $model,
            'models' => $models,
            'comments' => $comments,
        ]);
    }

}
