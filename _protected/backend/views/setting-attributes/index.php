<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SettingAttributesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Setting Attributes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body table-responsive">

					<p class="pull-right">
					<?php if(isset($setting_id) && !empty($setting_id)){ ?>
							   <?= Html::a('Add Setting Attribute', ['create', 'setting_id' => $setting_id], ['class' => 'btn btn-success']) ?>
						<?php

						$attribute_id = $setting_id;
						}
						else{ ?>
							   <?= Html::a('Add Setting Attribute', ['create'], ['class' => 'btn btn-success']) ?>
					<?php $attribute_id = 0;	} ?>
					</p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'setting_id',
				'enableSorting' => true,
				'value' => function ($model) {
					return $model->setting->name;
				},
				'contentOptions' => ['style' => 'width:200px;text-align:left;vertical-align: middle;'],
				'format' => 'raw',

			],
            'name',
			[
				'attribute' => 'input_type',
				'enableSorting' => true,
				'value' => function ($model) {
					return $model->inputType->name;
				},
				'contentOptions' => ['style' => 'width:200px;text-align:left;vertical-align: middle;'],
				'format' => 'raw',

			],

           ['class' => 'yii\grid\ActionColumn','header'=>'Actions',
							'buttons' => [
							'update' =>function ($url, $model, $key) {
							$options = array_merge([
							'title' => Yii::t('yii', 'Update Attribute'),
							'aria-label' => Yii::t('yii', 'Update Attribute'),
							'data-pjax' => '0',
							], []);
							return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['setting-attributes/update','id'=> $model->id , 'setting_id'=> $model->setting_id], $options);
							},
							],
							'template' => '{update}{delete}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
							],
        ],
    ]); ?>

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>
