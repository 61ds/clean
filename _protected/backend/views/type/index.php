<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\StatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if($category){
	$id = $category->id;
	$this->params['breadcrumbs'][] = ['label' => 'Main Categories', 'url' => ['index']];
	$parents = $category->parents();
	if($parents->count()){
		foreach($parents->all() as $parent){
			$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['index', 'id' => $parent->id]];
		}
		$this->title = 'Sub Category : '.$category->name;
		$this->params['breadcrumbs'][] = $category->name;
	} else {
		$this->title = 'Main Category : '.$category->name;
		$this->params['breadcrumbs'][] = $category->name;
	}	
} else {
	$this->title = $title;
	$this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="category-index">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body table-responsive">

					<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'columns' => [
							['class' => 'yii\grid\SerialColumn','header'=>"Sr. No."],
							//'id',
							'name',
							[
								'attribute' => 'active',
								'value' => function ($model) {
									if ($model->active) {
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
									'viewsubcats' =>function ($url, $model, $key) {
										if($model->children()->count()){											
											$options = array_merge([
												'title' => Yii::t('yii', 'View Subcategories'),
												'aria-label' => Yii::t('yii', 'View Subcategories'),
												'data-pjax' => '0',
											], []);
											return Html::a('<span class="glyphicon glyphicon-folder-open"></span>', ['index','id'=>$model->id], $options);
										} else {
											$options = array_merge([
												'title' => Yii::t('yii', 'Manage Attributes'),
												'aria-label' => Yii::t('yii', 'Manage Attributes'),
												'data-pjax' => '0',
											], []);
											return Html::a('<span class="glyphicon glyphicon-cog"></span>', ['manage-attributes','id'=>$model->id], $options);
										}
									},
								],
								'template' => '{viewsubcats} {update}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
							],
						],
					]); ?>
				</div>
			</div>
		</div>
    </div>
</div>
