<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sizewidth */

$this->title = 'Create Sizewidth';
$this->params['breadcrumbs'][] = ['label' => 'Sizewidths', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sizewidth-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
