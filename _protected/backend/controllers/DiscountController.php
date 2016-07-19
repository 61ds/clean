<?php

namespace backend\controllers;

use common\models\DiscountCode;
use Yii;
use common\models\Discount;
use common\models\Product;
use common\models\DiscountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DiscountController implements the CRUD actions for Discount model.
 */
class DiscountController extends BackendController
{


    /**
     * Lists all Discount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Discount model.
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
     * Creates a new Discount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Discount();
        $product_model = Product::find()->where(['status' => 1])->all();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->discount_products = serialize($model->discount_products);
            $model->start_date = strtotime($model->start_date);
            $model->end_date = strtotime($model->end_date);
            $model->quantity_left = $model->quantity;
            $model->locked = 0;
            if($model->start_date > time() ){
                $model->locked = 1;

            }
            if($model->end_date < time() ){
                $model->locked = 1;
            }
            if($model->save()) {
                if ($model->coupon_type == 0) {
                    $couponModel = new DiscountCode();
                    $couponModel->code = $model->coupon_code;
                    $couponModel->discount_id = $model->id;
                    $couponModel->save();
                } else {
                    for ($i = 0; $i < $model->quantity; $i++) {
                        $couponModel = new DiscountCode();
                        $couponModel->code = $model->coupon_code . '-' . $i . mt_rand(111111, 999999);
                        $couponModel->discount_id = $model->id;
                        $couponModel->save();
                    }
                }

                Yii::$app->getSession()->setFlash('success', Yii::t('app', "Congratulations! Coupons successfully created."));
                return $this->redirect(['discount-code/index', 'id' => $model->id]);
            }else {

                return $this->render('create', [
                    'model' => $model,
                    'product_model' => $product_model,
                ]);
            }
        } else {

            return $this->render('create', [
                'model' => $model,
                'product_model' => $product_model,
            ]);
        }
    }

    /**
     * Updates an existing Discount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $product_model = Product::find()->where(['status' => 1])->all();
        $model->discount_products = unserialize($model->discount_products);

        $quantity = $model->quantity;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->start_date = strtotime($model->start_date);
            $model->end_date = strtotime($model->end_date);
            $model->locked = 0;
            if($model->start_date > time() ){
                $model->locked = 1;

            }
            if($model->end_date < time() ){
                $model->locked = 1;
            }
            $model->discount_products = serialize($model->discount_products);
            if($model->save()) {
                if($model->quantity > $quantity) {
                    $model->quantity_left = $model->quantity_left + ($model->quantity-$quantity);
                    $model->save();
                    if ($model->coupon_type == 1) {

                        for ($i = $quantity+1; $i <= ($model->quantity-$quantity); $i++) {
                            $couponModel = new DiscountCode();
                            $couponModel->code = $model->coupon_code . '-' . $i . mt_rand(111111, 999999);
                            $couponModel->discount_id = $model->id;
                            $couponModel->save();
                        }
                    }
                }else if($model->quantity < $quantity) {
                    $discounoldModels = DiscountCode::find()->where(['discount_id' =>$model->id , 'status'=>0])->limit(0,$model->quantity-$quantity)->all();

                    foreach($discounoldModels as $data){
                        print_r($data->id);
                    }
                    die;

                }

                Yii::$app->getSession()->setFlash('success', Yii::t('app', "Congratulations! Coupons successfully created."));
                return $this->redirect(['discount-code/index', 'id' => $model->id]);
            }else {

                return $this->render('create', [
                    'model' => $model,
                    'product_model' => $product_model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'product_model' => $product_model,
            ]);
        }
    }

    /**
     * Deletes an existing Discount model.
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
     * Finds the Discount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Discount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Discount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
