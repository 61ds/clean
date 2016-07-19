<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Testimonial */
/* @var $form yii\widgets\ActiveForm */

if($model->feat_image != ''){
    $image = Yii::$app->params['baseurl'] . '/uploads/testimonial/thumbs/'. $model->feat_image;
	
}else{
    $image = Yii::$app->params['baseurl'] . '/uploads/no-image.png';
}

?>

<div class="testimonial-form">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'
                    ]]); ?>

					<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

					<?php //echo $form->field($model, 'short_descr')->textarea(['rows' => 6]) ?>

					<?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'feat_image')->widget(FileInput::classname(),
                        [
                            'options' => ['accept' => 'image/*', 'value' => $model->feat_image],
                            'pluginOptions' => [
                                'showCaption' => false,
                                'showRemove' => false,
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
