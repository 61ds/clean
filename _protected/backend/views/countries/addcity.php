<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\States */

$this->title = $state->name.'- Add New City';
$this->params['breadcrumbs'][] = ['label' => 'Active Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $state->country->name, 'url' => ['viewstates', 'country_id' => $state->country->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cities-create">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body table-responsive">	
					<div class="cities-form">
						<?php $form = ActiveForm::begin(); ?>

							<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

							<div class="form-group">
								<?= Html::submitButton('Create', ['class' =>'btn btn-success']) ?>
							</div>

						<?php ActiveForm::end(); ?>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
    </div><!-- /.row -->
</div>
