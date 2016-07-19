<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\GlobalSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Global Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="global-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Global Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'site_title',
            'meta_tag:ntext',
            'meta_desc:ntext',
            'fevicon_icon',
            // 'logo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
