<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;

use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Pages */
/* @var $form yii\widgets\ActiveForm */
if($model->featured_image != ''){
		$image = Yii::$app->params['baseurl'] ."/uploads/pages/thumbs/". $model->featured_image;
}else{
		$image = Yii::$app->params['baseurl'] . '/uploads/gal.png';
}
?>

<div class="pages-form">

  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'description')->widget(CKEditor::className(), [
		'options' => ['rows' => 6],
		'preset' => 'full',
		'clientOptions' => [
		'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
		'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
		]
	]) ?>
	<?php
		// Usage with ActiveForm and model
		echo $form->field($model, 'featured_image')->widget(FileInput::classname(), 
		[
			'options' => ['accept' => 'image/*', 'value' => $model->featured_image],    
			'pluginOptions' => [
				'showCaption' => false,
				'showRemove' => true,
				'showUpload' => false,
				 'initialPreview'=>[
					Html::img($image, ['class'=>'file-preview-images', 'alt'=>'', 'title'=>'' , 'style' => 'max-width:300px;max-height:200px;']),				
				], 
			]
		]);
	?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_desc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
