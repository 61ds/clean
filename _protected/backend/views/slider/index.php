<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\GallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sliders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-index">
		<div class="row">
        <div class="col-md-12">
			<div class="box">
                <div class="box-body table-responsive">

			<p class="pull-right">
				<?= Html::a('Create New Slider', ['create'], ['class' => 'btn btn-primary']) ?>
			</p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'Sr.No.'],


            'galley_name',
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
             ['class' => 'yii\grid\ActionColumn','header'=>'Actions',
			'buttons' => [
			'viewslides' =>function ($url, $model, $key) {
			$options = array_merge([
			'title' => Yii::t('yii', 'View Slides'),
			'aria-label' => Yii::t('yii', 'View Slides'),
			'data-pjax' => '0',
			], []);
			return Html::a('<span class="glyphicon glyphicon-folder-open"></span>', ['slider-images/viewslides','slider_id'=>$model->id], $options);
			},
			],
			'template' => '{viewslides} {delete}{update}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
			],
        ],
    ]); ?>
	</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->

</div>
