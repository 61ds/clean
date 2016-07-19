<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\StatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $country->name.' - States';
$this->params['breadcrumbs'][] = ['label' => 'Active Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="states-index">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body table-responsive">
                    <div class="btn-group">
                        <?= Html::a('Active States', ['viewstates',  'country_id' => $country->id], ['class' => 'btn btn-default'.(($this->context->route == 'admin/countries/viewstates')?' active':'')]) ?>
                        <?= Html::a('Inactive States', ['inactive-states',  'country_id' => $country->id], ['class' => 'btn btn-default'.(($this->context->route == 'admin/countries/inactive-states')?' active':'')]) ?>
                    </div>
                    <?= Html::a('Add New State', ['add-state',  'id' => $country->id], ['class' => 'btn btn-primary pull-right']) ?>
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
								'class' => 'yii\grid\ActionColumn','header'=>'Actions',
								'buttons' => [
									'viewcities' =>function ($url, $model, $key) {
										$options = array_merge([
											'title' => Yii::t('yii', 'View Cities'),
											'aria-label' => Yii::t('yii', 'View Cities'),
											'data-pjax' => '0',
										], []);
										return Html::a('<span class="glyphicon glyphicon-folder-open"></span>', ['viewcities','state_id'=>$model->id], $options);
									},
									'state-update' =>function ($url, $model, $key) {
										$options = array_merge([
											'title' => Yii::t('yii', 'Edit State Name'),
											'aria-label' => Yii::t('yii', 'Edit State Name'),
											'data-pjax' => '0',
											'data-confirm' => \Yii::t('yii', 'Are you sure to update this state?'),
										], []);
										return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['state-update','state_id'=>$model->id], $options);
									},
								],
								'template' => '{viewcities} {state-update}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
							],
						],
					]); ?>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
    </div><!-- /.row -->
</div>
