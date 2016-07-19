<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AttributesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attributes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attributes-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Create Attributes', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
				
                             'id',
                            'name',
                            'display_name',
                            [
                                'attribute' => 'entity_id',
                                'label' => 'Input Type',
                                'value' => 'entity.name',
                                'format' => 'raw',
                                'filter' =>  $searchModel->entityfilter,
                                'enableSorting' => false,
                            ],
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
                            [
                                'attribute'=>'editvalues',
                                'label' => 'Values',
                                'value' => function ($model) {
                                    if($model->entity_id==2){
                                        return Html::a(Yii::t('app', 'Details'), ['view', 'id' => $model->id], [
                                            'class' => 'btn btn-primary',
                                            'data-method' => 'post',
                                            //'data-confirm' => Yii::t('app', 'Are you sure you want to edit Values for '.$model->name.' attribute?'),
                                        ]);
                                    }else if($model->entity_id==3){
                                        return $model->lower_limit.', '.$model->upper_limit;
                                    } else {
                                        return "---";
                                    }
                                },
                                'format'=>'raw',
                                'contentOptions' => ['style' => 'width:60px;text-align:center'],
                            ],

                            ['class' => 'yii\grid\ActionColumn',
                                'header'=>'Actions',
                                'template' => '{update}',

                                'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
                            ],
                        ],
                    ]); ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
