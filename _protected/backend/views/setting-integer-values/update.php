<?php

use yii\helpers\Html;

$this->title = 'Update Setting Integer Values: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Setting Integer Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="setting-integer-values-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
