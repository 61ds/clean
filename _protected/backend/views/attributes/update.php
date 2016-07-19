<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Attributes */

$this->title = 'Update Attribute: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="attributes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
