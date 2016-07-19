<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

	<?= $form->field($model, 'feed_type')->dropDownList(
		$model->feed_types,
		[
			'prompt'=>'- Select Feed Type -',
			'class'=>'form-control select2',
		]
	) ?>
	<?= $form->field($model, 'language')->dropDownList(
		$languages,
		[
			'prompt'=>'- Select language -',
			'class'=>'form-control select2',
		]
	) ?>	
    <?= $form->field($model,'file')->fileInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save',['class'=>'btn btn-primary']) ?>
    </div>
	
<?php ActiveForm::end(); ?>