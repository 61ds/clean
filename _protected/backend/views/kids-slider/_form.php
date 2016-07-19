<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\KidsSlider */
/* @var $form yii\widgets\ActiveForm */
if($model->img != ''){
		$image = Yii::$app->params['baseurl'].'/uploads/slides/thumbs/'. $model->img;
		$title = $model->img_title;
		$initialPreview[] = '<img class="file-preview-image" src="'.$image. ' " alt="'.$title.'" title="'.$title.'">';	
}else{
		$title = 'None';
		$image = Yii::$app->params['baseurl'] . '/uploads/gal.png';
		$initialPreview[] = '<img class="file-preview-image" src="'.$image.'" alt="'.$title.'" title="'.$title.'">';
}
?>

<div class="kids-slider-form">

  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'img_title')->textInput(['maxlength' => true]) ?>
	<?php
		// Usage with ActiveForm and model
		echo $form->field($model, 'img')->widget(FileInput::classname(), 
		[
			'options' => ['accept' => 'image/*'],    
			'pluginOptions' => [
				'showCaption' => false,
				'showRemove' => true,
				'showUpload' => false,
				 'initialPreview'=> $initialPreview,
			]
		]);
	?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
