<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

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
            'g_id',
            'root',
            'lft',
            'rgt',
            'lvl',
            'name',
            'banner',
            'image',
            'meta_title',
            'meta_descr',
            'descr:ntext',
            'icon',
            'icon_type',
            'active',
            'selected',
            'disabled',
            'readonly',
            'visible',
            'collapsed',
            'movable_u',
            'movable_d',
            'movable_l',
            'movable_r',
            'removable',
            'removable_all',
        ],
    ]) ?>

</div>
