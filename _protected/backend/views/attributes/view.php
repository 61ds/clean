<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DropdownValuesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attribute '. $attribute->name.' - values';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dropdown-values-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('<i class="fa fa-angle-left"></i>Back to Attributes', ['index'], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Add Values', ['create-values', 'id' => $attribute->id], ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Sort Order', ['sort-attr-values',  'id' => $attribute->id], ['class' => 'btn btn-primary pull-right margin-right']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'S.No.',
                                'contentOptions' => ['style' => 'width:50px;text-align:center'],
                            ],

                            'id',
                            'name',
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
                                'class' => 'yii\grid\ActionColumn',
                                'header'=>'Action',
                                'buttons' => [
                                    'update-attr-val' =>function ($url, $model, $key) {
                                        $options = array_merge([
                                            'title' => Yii::t('yii', 'Update Value'),
                                            'aria-label' => Yii::t('yii', 'Update Value'),
                                            'data-pjax' => '0',
                                        ], []);
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['attributes/update-attr-value','id'=>$model->id], $options);
                                    },
                                ],
                                'template' => '{update-attr-val}',
                                'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
