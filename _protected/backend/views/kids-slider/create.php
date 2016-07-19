<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\KidsSlider */

$this->title = 'Create Kids Slider';
$this->params['breadcrumbs'][] = ['label' => 'Kids Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

