<?php
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Cities */

$this->title = $country->name.' - '.$attribute->name;
$this->params['breadcrumbs'][] = ['label' => 'Active Countries', 'url' => ['countries/index']];
$this->params['breadcrumbs'][] = ['label' => $country->name, 'url' => ['countries/viewstates', 'country_id' => $country->id]];
$this->params['breadcrumbs'][] = 'Update Attribute';
?>
<div class="cities-update">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body table-responsive">
					<div class="cities-form">
						<?php $form = ActiveForm::begin(); ?>

							<?= $form->field($model, 'value')->widget(CKEditor::className(), [
									'options' => ['rows' => 6],
									'preset' => 'full',
									'clientOptions' => [
									'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
									'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
								]
							]) ?>
							<div class="form-group">
								<?= Html::submitButton('Update', ['class' =>'btn btn-primary']) ?>
							</div>
						<?php ActiveForm::end(); ?>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
    </div><!-- /.row -->
</div>
