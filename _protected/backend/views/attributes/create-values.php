<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\DropdownValues */

$this->title = 'Add Values to Attribute - '.$model->attr->name;
$this->params['breadcrumbs'][] = ['label' => 'Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->attr->name, 'url' => ['view', 'id' => $model->attr->id]];
$this->params['breadcrumbs'][] = 'Add Values';
?>
<div class="dropdown-values-create">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>
                    <span id="w1">
                <?php
                for($i=1;$i<=5;$i++){
                ?>
                    <div class="form-group">
                        <span><?=$i?></span>
                        <input id="dropdownvalues-name" class="form-control" type="text" maxlength="50" name="DropdownValues[name][]">
                    </div>
                <?php
                }
                ?>

</span>
                <div class="form-group">
                    <?= Html::button( 'Add More', ['class' => 'btn btn-primary add-more']) ?>
                    &nbsp;&nbsp;OR &nbsp;&nbsp;
                    <?= Html::submitButton( 'Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
