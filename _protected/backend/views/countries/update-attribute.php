<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Attributes */

$this->title = 'Update '.$entity->name.' Attribute';
$this->params['breadcrumbs'][] = ['label' => 'Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attributes-create">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body table-responsive">
					<div class="attributes-form">

						<?php $form = ActiveForm::begin(); ?>

						<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

						<div class="form-group">
							<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
						</div>

						<?php ActiveForm::end(); ?>

					</div>
				</div>
			</div>
		</div>
    </div>
</div>
