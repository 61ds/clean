<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\StatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $state->name.' - Cities';
$this->params['breadcrumbs'][] = ['label' => 'Active Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $state->country->name, 'url' => ['viewstates', 'country_id' => $state->country->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="states-index">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body table-responsive">
					<div class="btn-group">
						<?= Html::a('Active Cities', ['viewcities',  'state_id' => $state->id], ['class' => 'btn btn-default'.(($this->context->route == 'admin/countries/viewcities')?' active':'')]) ?>
						<?= Html::a('Inactive Cities', ['inactive-cities',  'state_id' => $state->id], ['class' => 'btn btn-default'.(($this->context->route == 'admin/countries/inactive-cities')?' active':'')]) ?>
					</div>
					<?= Html::a('Add New City', ['add-city',  'id' => $state->id], ['class' => 'btn btn-success pull-right']) ?>
					<p></p>

					<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'filterModel' => $searchModel,
						'columns' => [
							['class' => 'yii\grid\SerialColumn', 'header' => 'S.No.'],

							'name',

							[
								'attribute' => 'status',
								'value' => function ($model) {
									if ($model->status) {
										return Html::a(Yii::t('app', 'Active'), null, [
											'class' => 'btn btn-success status',
											'data-id' =>  $model->id,
											'model' =>  'Cities',
											'href' => 'javascript:void(0);',
										]);
									} else {
										return Html::a(Yii::t('app', 'Inactive'), null, [
											'class' => 'btn btn-danger status',
											'data-id' =>  $model->id,
											'model' =>  'Cities',
											'href' => 'javascript:void(0);',
										]);
									}
								},
								'contentOptions' => ['style' => 'width:160px;text-align:center'],
								'format' => 'raw',
								'filter'=>array("1"=>"Active","0"=>"Inactive"),
							],
							[	
								'class' => 'yii\grid\ActionColumn','header'=>'Actions',
								'buttons' => [
									'view-details' =>function ($url, $model, $key) {
										$options = array_merge([
											'title' => Yii::t('yii', 'View Details'),
											'aria-label' => Yii::t('yii', 'View Details'),
											'data-pjax' => '0',
										], []);
										return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['city/view','id'=>$model->id], $options);
									},
									'city-update' =>function ($url, $model, $key) {
										$options = array_merge([
											'title' => Yii::t('yii', 'Edit City'),
											'aria-label' => Yii::t('yii', 'Edit City'),
											'data-pjax' => '0',
											'data-confirm' => \Yii::t('yii', 'Are you sure to update this city?'),
										], []);
										return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['city-update','city_id'=>$model->id], $options);
									},
									'city-delete' =>function ($url, $model, $key) {
										$options = array_merge([
											'title' => Yii::t('yii', 'Delete City'),
											'aria-label' => Yii::t('yii', 'Delete City'),
											'data-pjax' => '0',
											'data-confirm' => \Yii::t('yii', 'Are you sure to delete this city?'),
										], []);
										return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['city-delete','city_id'=>$model->id], $options);
									},
								],
								'template' => '{view-details}{city-update}{city-delete}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
							],
						],
					]); ?>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
    </div><!-- /.row -->
</div>
