<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\GalleryImages */

$this->title = 'Create Slide';

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

