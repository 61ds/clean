<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
$this->registerJs(
    " 
		$(function(){
			$('form').submit(function () {
				var attrsArray=[];
				var val = $('.bulk_action').val();
				
				$('input:checkbox[name=\'selection[]\']:checked').each(function(){
				attrsArray.push($(this).val());
				});
				var val1 = attrsArray.join(); 
				$('#selected1').val(val1);
				if (val  === '') {
				alert('Select an action.');
				return false;
				}
			});
        });
	"
);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\WeightSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$id = $category->id;
if($id){
	$this->params['breadcrumbs'][] = ['label' => 'Main Categories', 'url' => ['index']];
	$parents = $category->parents();
	if($parents->count()){
		foreach($parents->all() as $parent){
			$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['index', 'id' => $parent->id]];
			$parent_id = $parent->id;
		}
		$this->title = $category->name." - Edit Attributes";
		$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['manage-attributes', 'id' => $category->id]];
	} else {
		$this->title = $category->name." - Edit Attributes";
		$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['manage-attributes', 'id' => $category->id]];
	}	
} else {
	$this->title = $title;
	$this->params['breadcrumbs'][] = $this->title;
}
$this->params['breadcrumbs'][] = 'Edit Attributes';
if(unserialize($category_attrs->general_attributes)==null){
	$general_attr_ids = array();	
}else{
	$general_attr_ids = unserialize($category_attrs->general_attributes);	
}
if(unserialize($category_attrs->slider_attributes)==null){
	$slider_attr_ids = array();	
}else{
	$slider_attr_ids = unserialize($category_attrs->slider_attributes);	
}
?>
<div class="weight-index">
    <div class="row">
        <div class="col-md-12">
			<div class="box box-solid">
                <div class="box-body">
                    <p style="margin-bottom:0px;">
                        <?= Html::a('<i class="fa fa-angle-left"></i>Back to '.$category->name, ['manage-attributes', 'id'=> $id], ['class' => 'btn btn-primary']) ?>
					</p>
                </div>
            </div>
				
            <div class="box">
			<div class="box-body table-responsive">	
			<div class="col-md-12">
				<div class="box-header">
					<h3 class="box-title">General Attributes</h3>
				</div>
						<?= GridView::widget([
							'dataProvider' => $dataProvider1,
							'columns' => [
								['class' => 'yii\grid\SerialColumn','header'=>'S.No.'],
								[
								'attribute' => 'name',
								'value' =>  function ($model) {return $model->name;},
								'filter' => false,
								],
								[
									'attribute' => 'status',
									'value' => function ($model) use ($general_attr_ids,$category) {
										if (in_array($model->id,$general_attr_ids )) {
											return Html::a(Yii::t('app', 'Active'), null, [
												'class' => 'btn btn-success attr-status',
												'data-id' => $model->id,
												'data-status' => 1,
												'data-type' => 1,
												'data-category' => $category->id,
												'href' => 'javascript:void(0);',
											]);
										} else {
											return Html::a(Yii::t('app', 'Inactive'), null, [
												'class' => 'btn btn-danger attr-status',
												'data-id' => $model->id,
												'data-status' => 2,
												'data-type' => 1,
												'data-category' => $category->id,
												'href' => 'javascript:void(0);',
											]);
										}
									},
									'contentOptions' => ['style' => 'width:160px;text-align:center'],
									'format' => 'raw',
									'filter'=>array("1"=>"Active","0"=>"Inactive"),
								],
						],		
						]); ?>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
