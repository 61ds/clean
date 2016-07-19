<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\VarientProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="varient-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->dropDownList(
        $model->allcolor,
        [
            'prompt'=>'- Select Product -',
            'class'=>'form-control select2'

        ]
    ); ?>

    <?= $form->field($model, 'width')->dropDownList(
        $model->allwidth,
        [
            'prompt'=>'- Select Product -',
            'class'=>'form-control select2'

        ]
    ); ?>

    <?= $form->field($model, 'size')->dropDownList(
        $model->allsize,
        [
            'prompt'=>'- Select Product -',
            'class'=>'form-control select2'

        ]
    ); ?>

    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
