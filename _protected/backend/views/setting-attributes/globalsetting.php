<?php


use common\models\SettingAttributes;
use common\models\SettingTextareaValue;
use common\models\SettingTextValues;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$model = new SettingAttributes();

?>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<?php $count = 1;
		foreach($settingsa as $setting){ ?>
			<li <?php if($count==1){ ?>class="active"<?php } ?>><a href="#tab_<?= $count ?>" data-toggle="tab"><?= $setting->name ?></a></li>
			<?php
			$count++;
		}
		?>
	</ul>
	<div class="tab-content">
		<?php $i = 1;
		foreach($settingsa as $setting){
			$modelattr = new SettingAttributes();
			$settingsattr = $modelattr->find()->where(['setting_id'=>$setting->id])->all();
			?>

			<?php
			$lowname = strtolower(preg_replace('/-+/', '_', preg_replace('/[^\wáéíóú]/', '_', $setting->attributes['name'])));?>
			<div class="tab-pane <?php if($i == 1){ echo'active';} ?>" id="tab_<?= $i ?>">
				<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','name'=>$setting->id]]); ?>
				<input type="hidden" name="form_name" value="<?= $i ?>">
				<?php	foreach($settingsattr as $attribute){

					if($attribute->input_type == 1){
						$asdvalue = SettingTextValues::find()->where(['setting_attribute_id'=>$attribute->id])->one();
						$attr_name = 'attributes['.$attribute->id.']';
						echo $form->field($text_model, $attr_name)->textInput(['value'=>$asdvalue['value']])->label($attribute->name);
						?>
						<?php
					} else if($attribute->input_type == 2){
						$asdvalue = SettingTextValues::find()->where(['setting_attribute_id'=>$attribute->id])->one();
						if(isset($asdvalue['value']) && $asdvalue['value']!=""){
							$img_url = Yii::$app->params['baseurl'] . '/uploads/settings/thumbs/'.$asdvalue['value'];
						}else{
							$img_url = Yii::$app->params['baseurl']."/uploads/no-image.png";
						}
						?>



						<div class="form-group field-course-name">
							<div class="image_div">
								<img class="file-preview-image" src="<?= $img_url  ?>" alt="" title="" style="max-width:300px;max-height:200px;">
							</div>

							<?php

							$attr_name = 'img['.$attribute->id.']';
							// Usage with ActiveForm and model
							echo $form->field($text_model, $attr_name )->widget(FileInput::classname(),
								[
									'options' => ['accept' => 'image/*', 'value' => ''],
									'pluginOptions' => [
										'showCaption' => false,
										'showRemove' => true,
										'showUpload' => false,
									]
								])->label($attribute->name);
							?>

						</div>
						<?php
					} else if($attribute->input_type == 6){
						$asdvalue = SettingTextValues::find()->where(['setting_attribute_id'=>$attribute->id])->one();
						if(isset($asdvalue['value']) && $asdvalue['value']!=""){
							$image3 = Yii::$app->params['baseurl'] . '/uploads/settings/'.$asdvalue['value'];
							$img_url = '<div class="vid"><video  autoplay="" loop="" controls style="max-width:300px;max-height:200px;"><source src="'.$image3.'" type="video/mp4">Your browser does not support the video tag.</video></div>';
						}else{
							$img_url = '<img src="'.Yii::$app->params['baseurl'].'/uploads/no-video.jpg" style="width:200px;height:150px;">';
						}
						?>



						<div class="form-group field-course-name">
							<div class="image_div">
								<?= $img_url  ?>
							</div>

							<?php

							$attr_name = 'video['.$attribute->id.']';
							// Usage with ActiveForm and model
							echo $form->field($text_model, $attr_name )->widget(FileInput::classname(),
								[
									'options' => ['accept' => 'video/*', 'value' => ''],
									'pluginOptions' => [
										'showCaption' => false,
										'showRemove' => true,
										'showUpload' => false,
									]
								])->label($attribute->name);
							?>

						</div>
						<?php
					} else if($attribute->input_type == 3){
						$attr_name = 'content['.$attribute->id.']';
						$teatareavalue = SettingTextareaValue::find()->where(['setting_attribute_id'=>$attribute->id])->one();
						$teatareavalue->content[$attribute->id] = $teatareavalue->value;
						echo $form->field($teatareavalue, $attr_name)->textArea(['rows' => 3]) ->label($attribute->name);

					} else if($attribute->input_type == 4){
						?>
						<div class="form-group field-course-name">
							<label class="control-label" for="attr-<?= $attribute->name ?>"><?= $attribute->name ?></label>
							<input type="text" id="attr-<?= $attribute->id ?>" class="form-control" name="attribute[<?= $attribute->input_type ?>][<?= $attribute->id ?>]" >
						</div>
						<?php
					} else{
						?>
						<div class="form-group field-course-name">
							<label class="control-label" for="attr-<?= $attribute->name ?>"><?= $attribute->name ?></label>
							<input type="text" id="attr-<?= $attribute->id ?>" class="form-control" name="attribute[<?= $attribute->input_type ?>][<?= $attribute->id ?>]" >
						</div>
						<?php
					}

				}
				?>
				<div class="form-group">
					<?= Html::submitButton($model->isNewRecord ? 'Update' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
			<?php $i++;	}
		?>
	</div>

</div>



<style>
	body .file-preview-frame.file-preview-initial {
		height: 60px;
	}
	body .file-preview-frame.file-preview-initial img.file-preview-images {
		width: 50px;
		height: 50px;
	}
	.tab-pane{
		display:none;
	}
	.active{
		display:block;
	}
	.image_div img {
		padding: 10px;
		border: 1px solid #ddd;
		box-shadow: 1px 1px 5px 0 #a2958a;
		margin: 10px auto;
	}
</style>
