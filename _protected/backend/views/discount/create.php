<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Discount */

$this->title = 'Create Discount';
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-create">

    <?= $this->render('_form', [
        'model' => $model,
        'product_model' => $product_model,
    ]) ?>

</div>
