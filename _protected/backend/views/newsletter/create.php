<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Newsletter */

$this->title = 'Create Newsletter';
$this->params['breadcrumbs'][] = ['label' => 'Newsletters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


