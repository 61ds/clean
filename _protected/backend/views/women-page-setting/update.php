<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WomenPageSetting */

$this->title = 'Women Page Setting: ';
$this->params['breadcrumbs'][] = ['label' => 'Women Page Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pages-index">
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


