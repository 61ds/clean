<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Discount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'coupon_type')->dropDownList(
         array('0'=>'specific','1'=>'generate'),
        [
            'prompt'=>'- Select coupon type -',
            'class'=>'form-control select2'

        ]
    )
    ?>
    <?php if($model->isNewRecord){
        echo $form->field($model, 'coupon_code')->textInput(['maxlength' => true]);
    }else{
        echo $form->field($model, 'coupon_code')->textInput(['maxlength' => true,'readonly' => true]);
    }
    ?>

    <?= $form->field($model, 'discount_choice')->dropDownList(
        array('0'=>'Normal','1'=>'Buy one get discount on minimum second product','2'=>'Buy one get discount on all other product','3'=>'minimum amount','4'=>'buy 1 get special product discount'),
        [
            'prompt'=>'- Select discount type -',
            'class'=>'form-control select2'

        ]
    )
    ?>

    <?= $form->field($model, 'discount_type')->dropDownList(
        array('0'=>'fixed','1'=>'percent'),
        [
            'prompt'=>'- Select discount type -',
            'class'=>'form-control select2'

        ]
    )
    ?>

    <?= $form->field($model, 'discount_amount')->textInput() ?>

    <?= $form->field($model, 'minimum_amount')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>


    <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
     //'language' => 'ru', //'dateFormat' => 'yyyy-MM-dd',
      ]) ?>
    <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
         //'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'discount_products')->checkboxList($model->allProducts) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
