<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\KidsSliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kids Sliders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-index">
	<div class="row">
        <div class="col-md-12">
			<div class="box">
                <div class="box-body table-responsive">

				   <p class="pull-right">
						<?= Html::a('Create Kids Slider', ['create'], ['class' => 'btn btn-success']) ?>
					</p>
					<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'filterModel' => $searchModel,
						'columns' => [
							['class' => 'yii\grid\SerialColumn'],

							'img_title',
							[
								'attribute' => 'img',
								'format' => 'html',
								'value' => function ($model) {
									return Html::img( Yii::$app->params['baseurl'] . '/uploads/slides/thumbs/' . $model->img,
										['width' => '80px']);
								},
								'contentOptions' => ['style' => 'width:200px;height:100px;text-align:left;vertical-align: middle;'],
							],
							'url:url',
							

							['class' => 'yii\grid\ActionColumn'],
						],
					]); ?>

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>
