<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">
	<div class="row">
        <div class="col-md-12">
			<div class="box">
                <div class="box-body table-responsive">

					<p class="pull-right">
						<?= Html::a('Create Page', ['create'], ['class' => 'btn btn-success']) ?>
					</p>
						<?php Pjax::begin() ?>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'filterModel' => $searchModel,
							'columns' => [
								['class' => 'yii\grid\SerialColumn', 'header' => 'S.No.'],

								'name',
								'slug',
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
								// 'meta_keywords',
								// 'meta_desc',

								[	
								'class' => 'yii\grid\ActionColumn','header'=>'Actions',
								'template' => '{update} {delete}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
							],
							],
						]); ?>
					<?php Pjax::end() ?>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row --> 
</div>
