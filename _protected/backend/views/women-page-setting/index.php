<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WomenPageSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Women Page Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="women-page-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Women Page Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'banner1',
            'banner2',
            'banner3',
            'banner4',
            // 'banner5',
            // 'banner6',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
