<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
if($model->featured_image != ''){
    $image = Yii::$app->params['baseurl'] ."/uploads/pages/thumbs/". $model->featured_image;
}else{
    $image = Yii::$app->params['baseurl'] . '/uploads/gal.png';
}
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        $model->categories,
        [
            'prompt'=>'- Select Category -',
            'class'=>'form-control select2'

        ]
    )
    ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'market_price')->textInput() ?>
    <?= $form->field($model, 'short_descr')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'descr')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => [
            'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
            'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
        ]
    ]) ?>


    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'soldout')->textInput() ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
