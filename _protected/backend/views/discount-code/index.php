<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\DiscountCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Coupon Codes';
$this->params['breadcrumbs'][] = ['label' => 'Coupons', 'url' => ['discount/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-code-index">

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <?php /** if($discountModel->coupon_type == 1) {?>
                        <p class="pull-right">
                            <?= Html::a('Create Coupon Codes', ['create'], ['class' => 'btn btn-success']) ?>
                        </p>
                    <?php } */ ?>
                    <?php Pjax::begin(); ?>    <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn',"header"=>"Sr.No."],
                                'code',
                                [
                                    'attribute' => 'status',
                                    'value' => function ($model) {
                                        if ($model->status) {
                                            return "Used";
                                        } else {
                                            return "Available";
                                        }
                                    },
                                    'contentOptions' => ['style' => 'width:160px;text-align:center'],
                                    'format' => 'raw',
                                    'filter'=>array("1"=>"Used","0"=>"Available"),
                                ],
                                [
                                    'attribute' => 'locked',
                                    'value' => function ($model) {
                                        if ($model->locked) {
                                            return "Yes";
                                        } else {
                                            return "No";
                                        }
                                    },
                                    'contentOptions' => ['style' => 'width:160px;text-align:center'],
                                    'format' => 'raw',
                                    'filter'=>array("1"=>"Yes","0"=>"No"),
                                ],
                                //'created_at',
                                // 'updated_at',

                                ['class' => 'yii\grid\ActionColumn','header'=>'Actions',
                                    'template' => '{update}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
                                ],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>


