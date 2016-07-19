<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SettingTextareaValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-textarea-value-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'setting_id')->textInput() ?>

    <?= $form->field($model, 'setting_attribute_id')->textInput() ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
