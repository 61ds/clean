<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VarientProduct */

$this->title = 'Update Varient Product: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Varient Products', 'url' => ['index','id'=>$id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="varient-product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
