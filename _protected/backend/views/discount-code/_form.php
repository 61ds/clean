<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DiscountCode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-code-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'locked')->dropDownList(
        array('0'=>'No','1'=>'Yes'),
        [
            'prompt'=>'- Select discount type -',
            'class'=>'form-control select2'

        ]
    )
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
