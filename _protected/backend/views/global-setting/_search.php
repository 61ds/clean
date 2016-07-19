<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\GlobalSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="global-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'site_title') ?>

    <?= $form->field($model, 'meta_tag') ?>

    <?= $form->field($model, 'meta_desc') ?>

    <?= $form->field($model, 'fevicon_icon') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
