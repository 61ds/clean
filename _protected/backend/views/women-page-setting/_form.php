<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\WomenPageSetting */
/* @var $form yii\widgets\ActiveForm */
$label = array('','Banner 1','Banner 2','Banner 3','Banner 4','Banner 5','Banner 6');
use yii\helpers\Url;
use kartik\file\FileInput;


	$model->banner11 = unserialize($model->banner1);	
	$model->banner21 = unserialize($model->banner2);
	$model->banner31 = unserialize($model->banner3);
	$model->banner41 = unserialize($model->banner4);
	$model->banner51 = unserialize($model->banner5);
	$model->banner61 = unserialize($model->banner6);
	if($model->banner11[3]){
		$image1 = Yii::$app->params['baseurl'] . '/uploads/banner/thumbs/'.$model->banner11[3];
	}else{
		$image1 = Yii::$app->params['baseurl'] . '/uploads/gal.png';
	}if($model->banner21[3]){
		$image2 = Yii::$app->params['baseurl'] . '/uploads/banner/thumbs/'.$model->banner21[3];
	}else{
		$image2 = Yii::$app->params['baseurl'] . '/uploads/gal.png';
	}
	if($model->banner31[3]){
		$image3 = Yii::$app->params['baseurl'] . '/uploads/banner/thumbs/'.$model->banner31[3];
	}else{
		$image3 = Yii::$app->params['baseurl'] . '/uploads/gal.png';
	}
	if($model->banner41[3]){
		$image4 = Yii::$app->params['baseurl'] . '/uploads/banner/thumbs/'.$model->banner41[3];
	}else{
		$image4 = Yii::$app->params['baseurl'] . '/uploads/gal.png';
	}
	if($model->banner51[3]){
		$image5 = Yii::$app->params['baseurl'] . '/uploads/banner/thumbs/'.$model->banner51[3];
	}else{
		$image5 = Yii::$app->params['baseurl'] . '/uploads/gal.png';
	}
	if($model->banner61[3]){
		$image6 = Yii::$app->params['baseurl'] . '/uploads/banner/thumbs/'.$model->banner61[3];
	}else{
		$image6 = Yii::$app->params['baseurl'] . '/uploads/gal.png';
	}


?>

<div class="nav-tabs-custom">

	<ul class="nav nav-tabs">
		<?php $count = 1;
		for($count=1;$count <= 6; $count++){ ?>
			<li <?php if($count==1){ ?>class="active"<?php } ?>><a href="#tab_<?= $count ?>" data-toggle="tab"><?= $label[$count] ?></a></li>
			<?php
		}
		?>
	</ul>
	<div class="tab-content">
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		
		<div class="tab-pane active" id="tab_1">
			<?= $form->field($model, 'banner11[0]')->textInput(['maxlength' => true])->label('Title') ?>
			<?= $form->field($model, 'banner11[1]')->textInput(['maxlength' => true])->label('SubTitle') ?>
			<?= $form->field($model, 'banner11[2]')->textInput(['maxlength' => true])->label('Link') ?>
			<?= $form->field($model, 'banner11[3]')->widget(FileInput::classname(),
				[
					'options' => ['accept' => 'image/*', 'value' => ''],    
						'pluginOptions' => [
							'showCaption' => false,
							'showRemove' => false,
							'showUpload' => false,
							 'initialPreview'=>[
								Html::img($image1, ['class'=>'file-preview-images', 'alt'=>'', 'title'=>'' , 'style' => 'max-width:300px;max-height:200px;']),				
							], 
						]
			])->label('Banner 1'); ?>
		</div>
		<div class="tab-pane " id="tab_2">
			<?= $form->field($model, 'banner21[0]')->textInput(['maxlength' => true])->label('Title') ?>
			<?= $form->field($model, 'banner21[1]')->textInput(['maxlength' => true])->label('SubTitle') ?>
			<?= $form->field($model, 'banner21[2]')->textInput(['maxlength' => true])->label('Link') ?>
			<?= $form->field($model, 'banner21[3]')->widget(FileInput::classname(),
				[
					'options' => ['accept' => 'image/*', 'value' => ''],    
						'pluginOptions' => [
							'showCaption' => false,
							'showRemove' => false,
							'showUpload' => false,
							 'initialPreview'=>[
								Html::img($image2, ['class'=>'file-preview-images', 'alt'=>'', 'title'=>'' , 'style' => 'max-width:300px;max-height:200px;']),				
							], 
						]
			])->label('Banner 2'); ?>
		</div>
		<div class="tab-pane " id="tab_3">
			<?= $form->field($model, 'banner31[0]')->textInput(['maxlength' => true])->label('Title') ?>
			<?= $form->field($model, 'banner31[1]')->textInput(['maxlength' => true])->label('SubTitle') ?>
			<?= $form->field($model, 'banner31[2]')->textInput(['maxlength' => true])->label('Link') ?>
			<?= $form->field($model, 'banner31[3]')->widget(FileInput::classname(),
				[
					'options' => ['accept' => 'image/*', 'value' => ''],    
						'pluginOptions' => [
							'showCaption' => false,
							'showRemove' => false,
							'showUpload' => false,
							 'initialPreview'=>[
								Html::img($image3, ['class'=>'file-preview-images', 'alt'=>'', 'title'=>'' , 'style' => 'max-width:300px;max-height:200px;']),				
							], 
						]
			])->label('Banner 3'); ?>
		</div>
		<div class="tab-pane " id="tab_4">
				
			<?= $form->field($model, 'banner41[0]')->textInput(['maxlength' => true])->label('Title') ?>
			<?= $form->field($model, 'banner41[1]')->textInput(['maxlength' => true])->label('SubTitle') ?>
			<?= $form->field($model, 'banner41[2]')->textInput(['maxlength' => true])->label('Link') ?>
			<?= $form->field($model, 'banner41[3]')->widget(FileInput::classname(),
				[
					'options' => ['accept' => 'image/*', 'value' => ''],    
						'pluginOptions' => [
							'showCaption' => false,
							'showRemove' => false,
							'showUpload' => false,
							 'initialPreview'=>[
								Html::img($image4, ['class'=>'file-preview-images', 'alt'=>'', 'title'=>'' , 'style' => 'max-width:300px;max-height:200px;']),				
							], 
						]
			])->label('Banner 4'); ?>
		</div>
		<div class="tab-pane " id="tab_5">
			<?= $form->field($model, 'banner51[0]')->textInput(['maxlength' => true])->label('Title') ?>
			<?= $form->field($model, 'banner51[1]')->textInput(['maxlength' => true])->label('SubTitle') ?>
			<?= $form->field($model, 'banner51[2]')->textInput(['maxlength' => true])->label('Link') ?>
			<?= $form->field($model, 'banner51[3]')->widget(FileInput::classname(),
				[
					'options' => ['accept' => 'image/*', 'value' => ''],    
						'pluginOptions' => [
							'showCaption' => false,
							'showRemove' => false,
							'showUpload' => false,
							 'initialPreview'=>[
								Html::img($image5, ['class'=>'file-preview-images', 'alt'=>'', 'title'=>'' , 'style' => 'max-width:300px;max-height:200px;']),				
							], 
						]
			])->label('Banner 5'); ?>
		</div>
		<div class="tab-pane " id="tab_6">
			<?= $form->field($model, 'banner61[0]')->textInput(['maxlength' => true])->label('Title') ?>
			<?= $form->field($model, 'banner61[1]')->textInput(['maxlength' => true])->label('SubTitle') ?>
			<?= $form->field($model, 'banner61[2]')->textInput(['maxlength' => true])->label('Link') ?>
			<?= $form->field($model, 'banner61[3]')->widget(FileInput::classname(),
				[
					'options' => ['accept' => 'image/*', 'value' => ''],    
						'pluginOptions' => [
							'showCaption' => false,
							'showRemove' => false,
							'showUpload' => false,
							 'initialPreview'=>[
								Html::img($image6, ['class'=>'file-preview-images', 'alt'=>'', 'title'=>'' , 'style' => 'max-width:300px;max-height:200px;']),				
							], 
						]
			])->label('Banner 6'); ?>
		</div>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	
		<?php ActiveForm::end(); ?>
	</div>
</div>

<style>
	body .file-preview-frame.file-preview-initial {
		height: 60px;
	}
	body .file-preview-frame.file-preview-initial img.file-preview-images {
		width: 50px;
		height: 50px;
	}
	.tab-pane{
		display:none;
	}
	.active{
		display:block;
	}
	.image_div img {
		padding: 10px;
		border: 1px solid #ddd;
		box-shadow: 1px 1px 5px 0 #a2958a;
		margin: 10px auto;
	}
</style>