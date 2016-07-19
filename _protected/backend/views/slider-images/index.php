<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\GalleryImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Slider Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-index">
	<div class="row">
        <div class="col-md-12">
			<div class="box">
                <div class="box-body table-responsive">

				   <p class="pull-right">
					<?php if(isset($video) && !empty($video)){ ?>
							   <?= Html::a('Add Slider Image', ['create', 'slider_id' => $video->id], ['class' => 'btn btn-success']) ?>
						<?php

						$video_id = $video->id;
						}
						else{ ?>
							   <?= Html::a('Add Slider Image', ['create'], ['class' => 'btn btn-success']) ?>
					<?php $video_id = 0;	} ?>
					</p>

					<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'filterModel' => $searchModel,
						'columns' => [
							['class' => 'yii\grid\SerialColumn','header'=>"Sr.No.",
							'contentOptions' => ['style' => 'width:20px;text-align:left;vertical-align: middle;']
							],
							[
								'attribute' => 'slider_id',
								'enableSorting' => true,
								'value' => function ($model) {
									return $model->slider->galley_name;
								},
								'contentOptions' => ['style' => 'width:200px;text-align:left;vertical-align: middle;'],
								'format' => 'raw',

							],
							[
								'attribute' => 'name',
								'format' => 'raw',
								'filter' => '',
								'contentOptions' => ['style' => 'text-align:left;vertical-align: middle;']

							],
							[
								'attribute' => 'image_path',
								'format' => 'html',
								'value' => function ($model) {
									return Html::img( Yii::$app->params['baseurl'] . '/uploads/slides/thumbs/' . $model->image_path,
										['width' => '80px']);
								},
								'contentOptions' => ['style' => 'width:200px;height:100px;text-align:left;vertical-align: middle;'],
							],

							 ['class' => 'yii\grid\ActionColumn','header'=>'Actions',
							'buttons' => [
							'update' =>function ($url, $model, $key) {
							$options = array_merge([
							'title' => Yii::t('yii', 'Update Slide'),
							'aria-label' => Yii::t('yii', 'Update Slide'),
							'data-pjax' => '0',
							], []);
							return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['slider-images/update','id'=> $model->id , 'slider_id'=> $model->slider_id], $options);
							},
							],
							'template' => '{update} {delete}', 'contentOptions' => ['style' => 'width:160px;text-align:center'],
							 'contentOptions' => ['style' => 'text-align:center;vertical-align: middle;letter-spacing:10px;'],
							 ],
						],
					]); ?>

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>
