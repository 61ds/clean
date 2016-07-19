<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DropdownValues */

$this->title = 'Create Dropdown Values';
$this->params['breadcrumbs'][] = ['label' => 'Dropdown Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dropdown-values-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
