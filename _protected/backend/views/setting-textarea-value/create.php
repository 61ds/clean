<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SettingTextareaValue */

$this->title = 'Create Setting Textarea Value';
$this->params['breadcrumbs'][] = ['label' => 'Setting Textarea Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-textarea-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
