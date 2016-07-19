<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <p class="pull-right">
                        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-primary']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn',"header"=>"Sr.No."],

                            'id',
                            'name',
                            'category_id',
                           // 'quantity',
                            'price',
                            // 'market_price',
                            // 'descr:ntext',
                            // 'short_descr:ntext',
                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    if ($model->status) {
                                        return Html::a(Yii::t('app', 'Active'), null, [
                                            'class' => 'btn btn-success status',
                                            'data-id' => $model->id,
                                            'href' => 'javascript:void(0);',
                                        ]);
                                    } else {
                                        return Html::a(Yii::t('app', 'Inactive'), null, [
                                            'class' => 'btn btn-danger status',
                                            'data-id' => $model->id,
                                            'href' => 'javascript:void(0);',
                                        ]);
                                    }
                                },
                                'contentOptions' => ['style' => 'width:160px;text-align:center'],
                                'format' => 'raw',
                                'filter'=>array("1"=>"Active","0"=>"Inactive"),
                            ],
                            // 'soldout',
                            // 'created_at',
                             'updated_at:date',
                            // 'meta_title',
                            // 'meta_description:ntext',
                            // 'meta_keyword',
                            ['class' => 'yii\grid\ActionColumn','header'=>'Actions',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        $purl = $model->createProductUrl($model->id);
                                        return Html::a('',  $purl, ['title'=>'View Product',
                                            'class'=>'glyphicon glyphicon-eye-open']);
                                    },
                                    'viewitems' =>function ($url, $model, $key) {
                                        $options = array_merge([
                                            'title' => Yii::t('yii', 'View Items'),
                                            'aria-label' => Yii::t('yii', 'View Items'),
                                            'data-pjax' => '0',
                                        ], []);
                                        return Html::a('<span class="glyphicon glyphicon-folder-open"></span>', ['varient-product/index','id'=>$model->id], $options);
                                    },
                                    'generate' =>function ($url, $model, $key) {
                                        $options = array_merge([
                                            'title' => Yii::t('yii', 'Generate Items'),
                                            'aria-label' => Yii::t('yii', 'Generate Items'),
                                            'data-pjax' => '0',
                                        ], []);
                                        return Html::a('<span class="glyphicon glyphicon-cog"></span>', ['product/generate','id'=>$model->id], $options);
                                    },
                                ],
                                'template' => '{view}{generate}{viewitems}{update}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
                            ],
                        ],
                    ]); ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>

