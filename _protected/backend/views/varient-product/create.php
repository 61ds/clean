<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VarientProduct */

$this->title = 'Create Varient Product';
$this->params['breadcrumbs'][] = ['label' => 'Varient Products', 'url' => ['index','id'=>$id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="varient-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
