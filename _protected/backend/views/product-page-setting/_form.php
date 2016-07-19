<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use common\models\Product;
use common\models\Category;
/* @var $this yii\web\View */
/* @var $model common\models\ProductPageSetting */
/* @var $form yii\widgets\ActiveForm */

if($model->video){
		$image3 = Yii::$app->params['baseurl'] . '/uploads/product/setting/'.$model->video;
		$img_url = '<div class="vid"><video  autoplay="" loop="" controls style="max-width:300px;max-height:200px;"><source src="'.$image3.'" type="video/mp4">Your browser does not support the video tag.</video></div>';
}else{
		$img_url = '<img src="'.Yii::$app->params['baseurl'].'/uploads/no-video.jpg" style="width:200px;height:150px;">';
}
if($model->banner){
		$image3 = Yii::$app->params['baseurl'] . '/uploads/product/setting/thumbs/'.$model->banner;
		$img_urls = '<img src="'.$image3 .'" style="width:200px;height:150px;">'; 
}else{
		$img_urls = '<img src="'.Yii::$app->params['baseurl'].'/uploads/no-image.png" style="width:200px;height:150px;">';
}
if($model->testimonial_banner){
		$image3 = Yii::$app->params['baseurl'] . '/uploads/product/setting/thumbs/'.$model->testimonial_banner;
		$img_urls1 = '<img src="'.$image3 .'" style="width:200px;height:150px;">'; 
}else{
		$img_urls1 = '<img src="'.Yii::$app->params['baseurl'].'/uploads/no-image.png" style="width:200px;height:150px;">';
}
?>

<div class="product-page-setting-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(['prompt'=>"Select Category",'1' => 'Kids','2' => 'Men','3' => 'WoMen']); ?>
	
	
    <?php
	if($model->id == 1 ){ ?>
	
	<div class="form-group field-course-name">
		<div class="image_div">
			<?= $img_url  ?>
		</div>
    <?php
    // Usage with ActiveForm and model
    echo $form->field($model, 'video')->widget(FileInput::classname(),
        [
            'options' => ['accept' => 'video/*', 'value' => $model->video],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
            ]
        ])->label(false);
    ?>
	</div>
	<?php
		$countries = Category::findOne(['id' => $model->category_id ]);
		$category_id = $countries->children()->all();
		foreach($category_id as $cat_id){
			$catid[] = $cat_id->id;
		}
		$product_model = Product::find()->where( ["Status" => 1 , 'category_id'=> $catid ])->all();
		if($product_model){ ?>
        <div class="form-group field-product-meta_title">
            <label class="control-label" for="product-meta_title">Offer Products</label>
            <br>
            <?php
            $ids = unserialize($model->product_slides);
            $model->product_slides ="";
            $i=1;
            foreach($product_model as $product){
                if(in_array($product->id,$ids)){
                    $sd = "checked";
                }else{
                    $sd="";
                }
                ?>
                <input type="checkbox" name="product_slides[]" <?=  $sd ?> value="<?= $product->id ?>" id="product_slides[]" >&nbsp; <?= $product->name ?>  <br>
            <?php  } ?>
        </div>
		<?php  }
	}
	
	if($model->id == 3 ){ ?>
		 <?php
			// Usage with ActiveForm and model
			echo $form->field($model, 'banner')->widget(FileInput::classname(),
				[
					'options' => ['accept' => 'image/*'],
					'pluginOptions' => [
						'showCaption' => false,
						'showRemove' => true,
						'showUpload' => false,
						'initialPreview'=> $img_urls,
					]
				]);
				echo'<label class="control-label" for="product-meta_title">Or</label>';
				echo $form->field($model, 'testimonial_banner')->widget(FileInput::classname(),
				[
					'options' => ['accept' => 'image/*'],
					'pluginOptions' => [
						'showCaption' => false,
						'showRemove' => true,
						'showUpload' => false,
						'initialPreview'=> $img_urls1,
					]
				]);

				echo $form->field($model, 'testimonial')->dropDownList(
                    $model->getTestimonial(),
                        [
                            'prompt'=>'- Select Testimonial -',
                            'class'=>'form-control select2',
                        ]
					);
			?>
			
		<?php	}
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
