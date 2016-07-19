<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\slider\Slider;

/* @var $this yii\web\View */
/* @var $model common\models\Attributes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attributes-form">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'display_name')->textInput(['maxlength' => true]) ?>
                    <?php
                    echo $form->field($model, 'isvariant')->dropDownList(
                        [0 => 'No',1 => 'Yes'],
                        [ 'class'=>'form-control select2' ]
                    );
                    ?>

                <?php
                    echo $form->field($model, 'entity_id')->dropDownList(
                    $model->entities,
                    [ 'prompt'=>'Select Input Type','class'=>'form-control select2', 'disabled'=>!$model->isNewRecord ]
                );
                ?>
				<?php
                echo $form->field($model, 'parent_id',['options' => ['class' => (!$model->isNewRecord && $model->entity_id==3)?'form-group' : 'hidden','id' => 'pid']])->dropDownList(
                    $model->allAttributes,
                    ['class'=>'form-control select2',]
                );
                ?>
				<?php
                echo $form->field($model, 'mtype', ['options' => ['class' => (!$model->isNewRecord && $model->entity_id==3)?'form-group' : 'hidden','id' => 'mtype']])->dropDownList(
                    [0 => 'General',1 => 'Upper', 2 => 'Lower'],
                    ['class'=>'form-control select2',]
                );
                ?>
                    <span style="margin-right:50px">&nbsp;</span>
                <?php
                    echo $form->field($model, 'lower_limit',['options' => ['class' => (!$model->isNewRecord && $model->entity_id==3)?'form-group' : 'hidden','id' => 'lower_slider']])->widget(Slider::classname(), [
                        'sliderColor'=>Slider::TYPE_GREY,
                        'handleColor'=>Slider::TYPE_DANGER,
                        'pluginOptions'=>[
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                            'handle' => 'triangle',
                            'tooltip' => 'always'
                        ]
                    ]);
                ?>
                <span style="margin-right:50px">&nbsp;</span>
                <?php
                    echo $form->field($model, 'upper_limit',['options' => ['class' => (!$model->isNewRecord && $model->entity_id==3)?'form-group' : 'hidden','id' => 'upper_slider']])->widget(Slider::classname(), [
                        'sliderColor'=>Slider::TYPE_GREY,
                        'handleColor'=>Slider::TYPE_DANGER,
                        'pluginOptions'=>[
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                            'handle' => 'triangle',
                            'tooltip' => 'always'
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
