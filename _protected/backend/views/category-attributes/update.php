<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryAttributes */

$this->title = 'Update Category Attributes: ' . ' ' . $model->category_id;
$this->params['breadcrumbs'][] = ['label' => 'Category Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category_id, 'url' => ['view', 'id' => $model->category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-attributes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
