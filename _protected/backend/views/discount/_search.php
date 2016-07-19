<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DiscountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'coupon_type') ?>

    <?= $form->field($model, 'coupon_code') ?>

    <?php // echo $form->field($model, 'uses_per_coupon') ?>

    <?php // echo $form->field($model, 'uses_per_customer') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'discount_type') ?>

    <?php // echo $form->field($model, 'discount_amount') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'quantity_used') ?>

    <?php // echo $form->field($model, 'quantity_left') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'locked') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
