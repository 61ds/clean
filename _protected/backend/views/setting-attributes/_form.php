<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SettingAttributes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-attributes-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'attribute_key')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'input_type')->dropDownList($model->inputTypes,['prompt'=>'Select Input Type','class'=>'form-control select2','disabled'=>!$model->isNewRecord ]); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
