<?php


$this->title = 'Update Country Detail: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="countries-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
