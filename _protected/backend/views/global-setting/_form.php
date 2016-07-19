<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\GlobalSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

if($model->fevicon_icon != ''){
		$image = \Yii::$app->request->baseUrl . $model->fevicon_icon;
}else{
		$image = '/atmantan/web/images/user.jpg';
}
if($model->innerlogo != ''){
		$image2 = \Yii::$app->request->baseUrl . $model->innerlogo;
}else{
		$image2 = '/atmantan/web/images/user.jpg';
}
if($model->logo != '')
 {			$image1 = \Yii::$app->request->baseUrl . $model->logo; }
else{
	$image1 = '/atmantan/web/images/user.jpg';
}



if( isset($_GET['save']) && $_GET['save']=='yes'){
	echo"<h2>Your Settings has been saved successfully.</h2>";
}
 ?>
<div class="global-setting-form">

       <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'
]]); ?>

    <?= $form->field($model, 'site_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_tag')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'meta_desc')->textarea(['rows' => 6]) ?>

	<?php
		// Usage with ActiveForm and model
		echo $form->field($model, 'fevicon_icon')->widget(FileInput::classname(), 
		[
			'options' => ['accept' => 'image/*', 'value' => $model->fevicon_icon],    
			'pluginOptions' => [
				'showCaption' => false,
				'showRemove' => true,
				'showUpload' => false,
				 'initialPreview'=>[
					Html::img($image, ['class'=>'file-preview-images', 'alt'=>'', 'title'=>'' ,  'height' => 16]),				
				], 
			]
		]);
	?>
	<?php
		// Usage with ActiveForm and model
		echo $form->field($model, 'logo')->widget(FileInput::classname(), 
		[
			'options' => ['accept' => 'image/*', 'value' => $model->logo],    
			'pluginOptions' => [
				'showCaption' => false,
				'showRemove' => true,
				'showUpload' => false,
				 'initialPreview'=>[
					Html::img($image1, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),				
				], 
			]
		]);
	?>
	<?php
		// Usage with ActiveForm and model
		echo $form->field($model, 'innerlogo')->widget(FileInput::classname(), 
		[
			'options' => ['accept' => 'image/*', 'value' => $model->innerlogo],    
			'pluginOptions' => [
				'showCaption' => false,
				'showRemove' => true,
				'showUpload' => false,
				 'initialPreview'=>[
					Html::img($image2, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),				
				], 
			]
		]);
	?>
   <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
body .file-preview-frame.file-preview-initial {
    height: 60px;
}
body .file-preview-frame.file-preview-initial img.file-preview-images {
    width: 50px;
    height: 50px;
}
</style>