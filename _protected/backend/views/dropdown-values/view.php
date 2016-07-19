<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DropdownValues */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dropdown Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dropdown-values-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'attribute_id',
            'sort_order',
            'status',
        ],
    ]) ?>

</div>
