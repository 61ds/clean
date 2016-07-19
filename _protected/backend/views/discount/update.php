<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Discount */

$this->title = 'Update Discount: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="discount-update">

    <?= $this->render('_form', [
        'model' => $model,
        'product_model' => $product_model,
    ]) ?>

</div>
