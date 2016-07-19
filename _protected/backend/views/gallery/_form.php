<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;



/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
$pagearray = $model->getPageId();
$pieces = explode(",", $model->pageid);
?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'galley_name')->textInput(['maxlength' => true]) ?>
	<?php
	if(!$model->isNewRecord){
		echo "<div class='file-updat'><ul>";
		foreach($model->images as $images)
		{
			echo "<li class='file-preview-frame' >";
			echo "<div class='dele_img' id='" . $images->id . "' >X</div>";
			echo"<img src='". Yii::$app->params['baseurl']."/uploads/thumbs/gallery/".$model->id."/".$images->image_path ."' class='file-preview-image' style='width:auto;height:160px;' >";
			//$image[] = \Yii::$app->request->baseUrl."/".$images->image_path;
			echo "</li>";
		}
		echo "</ul></div><div class='clearfix'></div>";
	}
	?>
	<?php
		// Usage with ActiveForm and model
		echo $form->field($model, 'file_path[]')->widget(FileInput::classname(), 
		[
			'options' => ['accept' => 'image/*','multiple' => true],    
			'pluginOptions' => [
				'showCaption' => false,
				'showRemove' => true,
				'showUpload' => false,
				/* 'initialPreview'=>[
					Html::img($image, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),				
				], */
			]
		]);
	?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
.dele_img {
    width: 100%;
    border: 1px solid #000;
    font-weight: bold;
    cursor: pointer;
}
.file-updat {
    width: 100%;
    height: auto;
    overflow: hidden;
    border: 1px solid #8C8C8C;
    border-radius: 5px;
}
</style>
