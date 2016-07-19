<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DiscountCode */

$this->title = 'Create Discount Code';
$this->params['breadcrumbs'][] = ['label' => 'Discount Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
