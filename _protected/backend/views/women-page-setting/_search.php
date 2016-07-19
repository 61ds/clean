<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WomenPageSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="women-page-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'banner1') ?>

    <?= $form->field($model, 'banner2') ?>

    <?= $form->field($model, 'banner3') ?>

    <?= $form->field($model, 'banner4') ?>

    <?php // echo $form->field($model, 'banner5') ?>

    <?php // echo $form->field($model, 'banner6') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
