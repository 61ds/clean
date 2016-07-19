<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SizewidthSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Size widths Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sizewidth-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">

             <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p class="pull-right">
                <?= Html::a('Create new Size width group', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn','header'=>'Sr.No.'],
                        'name',
                        [
                            'attribute' => 'size',
                            'format' => 'html',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                $allsize = $model->getallsize();
                                $size = unserialize($model->size);
                                $names = array();
                                foreach($size as $val){
                                    $names[] = $allsize[$val];
                                }

                                return implode(' | ',$names);
                            },
                            'contentOptions' => ['style' => 'width:260px;text-align:center;vertical-align: middle;'],
                        ],
                        [
                            'attribute' => 'width',
                            'format' => 'html',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                $allsize = $model->getallwidth();
                                $size = unserialize($model->width);
                                $names = array();
                                foreach($size as $val){
                                    $names[] = $allsize[$val];
                                }
                                return implode(' | ',$names);
                            },
                            'contentOptions' => ['style' => 'width:260px;text-align:center;vertical-align: middle;'],
                        ],
                        ['class' => 'yii\grid\ActionColumn','header'=>'Actions',
                            'template' => '{update}{delete}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>

