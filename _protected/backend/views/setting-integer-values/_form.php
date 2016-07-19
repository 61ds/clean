<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SettingIntegerValues */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-integer-values-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'setting_id')->textInput() ?>

    <?= $form->field($model, 'setting_attribute_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
