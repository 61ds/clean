<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\VarientProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Varient Products';
$this->params['breadcrumbs'][] = ['label' => 'All Articles', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="varient-product-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">

                    <p class="pull-right">
                        <?= Html::a('Add New items', ['varient-product/create','id'=>$id ], ['class' => 'btn btn-primary']) ?>
                    </p>
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'header' => 'S.No.'],
                            'sku',
                            [
                                'attribute' => 'color',
                                'value' => 'color0.name',
                                'format' => 'raw',
                                'label' => 'Color',
                                'filter' =>  $model->allcolor,
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'size',
                                'value' => 'size0.name',
                                'format' => 'raw',
                                'label' => 'Size',
                                'filter' =>  $model->allsize,
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'width',
                                'value' => 'width0.name',
                                'format' => 'raw',
                                'label' => 'Width',
                                'filter' =>  $model->allwidth,
                                'enableSorting' => false,
                            ],
                            'price',
                            'quantity',
                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    if ($model->status) {
                                        return Html::a(Yii::t('app', 'Active'), null, [
                                            'class' => 'btn btn-success status',
                                            'data-id' => $model->id,
                                            'model' => 'VarientProduct',
                                            'href' => 'javascript:void(0);',
                                        ]);
                                    } else {
                                        return Html::a(Yii::t('app', 'Inactive'), null, [
                                            'class' => 'btn btn-danger status',
                                            'data-id' => $model->id,
                                            'model' => 'VarientProduct',
                                            'href' => 'javascript:void(0);',
                                        ]);
                                    }
                                },
                                'contentOptions' => ['style' => 'width:80px;text-align:center'],
                                'format' => 'raw',
                                'filter'=>array("1"=>"Active","0"=>"Inactive"),
                            ],
                            // 'created_at',
                            'updated_at:Date',

                            [
                                'class' => 'yii\grid\ActionColumn','header'=>'Actions',
                                'template' => '{update}', 'contentOptions' => ['style' => 'width:40px;letter-spacing:10px;text-align:center'],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
