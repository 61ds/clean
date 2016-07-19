<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="pages-index">
	<div class="row">
        <div class="col-md-12">
			<div class="box">
                <div class="box-body table-responsive">
					<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
						
						<?= $form->field($model,'file')->fileInput() ?>
						
						<div class="form-group">
							<?= Html::submitButton('Save',['class'=>'btn btn-primary']) ?>
						</div>
						
					<?php ActiveForm::end(); ?>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row --> 
</div>