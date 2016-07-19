<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sizewidth */

$this->title = 'Update Sizewidth: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sizewidths', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sizewidth-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
