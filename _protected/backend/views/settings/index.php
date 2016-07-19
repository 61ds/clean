<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Settings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn','header'=>'Actions',
			'buttons' => [
			'viewattribute' =>function ($url, $model, $key) {
			$options = array_merge([
			'title' => Yii::t('yii', 'View Attributea'),
			'aria-label' => Yii::t('yii', 'View Attributea'),
			'data-pjax' => '0',
			], []);
			return Html::a('<span class="glyphicon glyphicon-folder-open"></span>', ['setting-attributes/viewattribute','setting_id'=>$model->id], $options);
			},
			],
			'template' => '{viewattribute} {delete}{update}', 'contentOptions' => ['style' => 'width:160px;letter-spacing:10px;text-align:center'],
			],
        ],
    ]); ?>

</div>
