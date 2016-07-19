<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sizewidth */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="sizewidth-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'size')->dropDownList(
        $model->allsize,
        [
            'class'=>'form-control select2 required',
            'multiple' => 'multiple'
        ]
    );
    ?>
    <?= $form->field($model, 'width')->dropDownList(
        $model->allwidth,
        [
            'class'=>'form-control select2 required',
            'multiple' => 'multiple'
        ]
    );
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
