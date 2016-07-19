<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\AttributesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJs("var status_change_url = ".json_encode(Yii::$app->urlManager->createAbsoluteUrl('admin/countries/quick-attribute-status')).";", View::POS_END);
$this->title = $entity->name.' Attributes';
$this->params['breadcrumbs'][] = ['label' => 'Active Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attributes-index">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body table-responsive">	
					<p>
						<?= Html::a('Create Attribute', ['create-attribute', 'entity_id' => $entity->id], ['class' => 'btn btn-success']) ?>
					</p>
					<?php Pjax::begin() ?>
					<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'filterModel' => $searchModel,
						'columns' => [
							['class' => 'yii\grid\SerialColumn'],

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
									'update-attribute' =>function ($url, $model, $key) {
										$options = array_merge([
											'title' => Yii::t('yii', 'Edit attribute'),
											'aria-label' => Yii::t('yii', 'Edit attribute'),
											'data-pjax' => '0',
											'data-confirm' => \Yii::t('yii', 'Are you sure to update this attribute?'),
										], []);
										return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-attribute','id'=>$model->id], $options);
									},
									],
								'template' => '{update-attribute} {delete}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
							],
						],
					]); ?>
					<?php Pjax::end() ?>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
    </div><!-- /.row -->	
</div>
