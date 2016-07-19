<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'guest_id') ?>

    <?= $form->field($model, 'items_count') ?>

    <?= $form->field($model, 'price_total') ?>

    <?php // echo $form->field($model, 'delivery_charges') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'discount_id') ?>

    <?php // echo $form->field($model, 'grand_total') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'locked') ?>

    <?php // echo $form->field($model, 'payment_method') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
