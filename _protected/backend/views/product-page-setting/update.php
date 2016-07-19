<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductPageSetting */

$this->title = 'Update Product Page Setting: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Page Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="gallery-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>


