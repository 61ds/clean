<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SettingIntegerValuesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Setting Integer Values';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-integer-values-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Setting Integer Values', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'setting_id',
            'setting_attribute_id',
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
