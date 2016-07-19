<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if($model->flag != ''){
    $image = \Yii::$app->request->baseUrl . '/uploads/country/256x256/'. $model->flag;
}else{
    $image = \Yii::$app->request->baseUrl . '/uploads/country/256x256/no-image.png';
}
?>

<div class="countries-form">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'
    ]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sortname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'flag')->widget(FileInput::classname(),
        [
            'options' => ['accept' => 'image/*', 'value' => $model->flag],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                'initialPreview'=>[
                    Html::img($image, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                ],
            ]
        ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
