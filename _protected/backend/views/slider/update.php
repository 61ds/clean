<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Gallery */

$this->title = 'Update Slider: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slider', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
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

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
$(document).ready(function(){
	$('.dele_img').click(function(){
		var img_id = $(this).attr('id');
		var sd =  confirm('Are you sure you want to delete this item?');
		if(sd == true){
			$.ajax({
			   url: '',
			   type: 'POST',
			   data: {imgid: img_id},
			   success: function (data) {
				   location.href ="";
				 }
		    });
		}
	});

});
</script>