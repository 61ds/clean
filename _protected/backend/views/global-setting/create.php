<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\GlobalSetting */

$this->title = 'Create Global Setting';
$this->params['breadcrumbs'][] = ['label' => 'Global Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="global-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
