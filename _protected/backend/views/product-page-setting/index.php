<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductPageSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Page Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn','header'=>"Sr.No."],
                        'name',
                        'video',
                        [
                            'attribute' => 'category_id',
                            'enableSorting' => true,
                            'value' => function ($model) {
                                return $model->category->name;
                            },

                        ],

                        ['class' => 'yii\grid\ActionColumn','template' => '{update}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center']],
                    ],
                ]); ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>

