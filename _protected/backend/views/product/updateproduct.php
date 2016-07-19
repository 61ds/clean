<?php
   /* @var $this yii\web\View */
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use dosamigos\ckeditor\CKEditor;
    use kartik\slider\Slider;
    use kartik\file\FileInput;
    use common\models\DropdownValues;
	use common\models\Product;
	use common\models\ProductSearch;
	use common\models\ProductForm;
	use common\models\Category;
	use common\models\Attributes;
	use common\models\ProductDropdownValues;
	use common\models\ProductImages;
	use common\models\DropdownValuesSearch;
	use common\models\ProductTextValues;
	use common\models\ProductDescValues;
   $this->title = 'Update product';
  
   if($ProductImagesModel->main_image){
	   $main_image = Yii::$app->params['baseurl'] . '/uploads/product/main/'.$model->id.'/thumbs/'.$ProductImagesModel->main_image;
   }else{
	   $main_image = Yii::$app->params['baseurl'] . '/uploads/no-image.png';
   }
   if($ProductImagesModel->flip_image){
	   $main_image1 =Yii::$app->params['baseurl'] . '/uploads/product/flip/'.$model->id.'/thumbs/'.$ProductImagesModel->flip_image;
   }else{
	   $main_image1 = Yii::$app->params['baseurl'] . '/uploads/no-image.png';
   }
   if($ProductImagesModel->home_image){
	   $main_image2 = Yii::$app->params['baseurl'] . '/uploads/product/home/'.$model->id.'/thumbs/'.$ProductImagesModel->home_image;
   }else{
	   $main_image2 = Yii::$app->params['baseurl'] . '/uploads/no-image.png';
   }
   if($ProductImagesModel->video){
	   $main_image3e = Yii::$app->params['baseurl'] . '/uploads/product/video/'.$model->id.'/'.$ProductImagesModel->video;
	   $img_url = '<div class="vid"><video  autoplay="" loop="" controls style="max-width:300px;max-height:200px;"><source src="'.$main_image3e.'" type="video/mp4">Your browser does not support the video tag.</video></div>';
   }else{
	  $img_url = '<img src="'.Yii::$app->params['baseurl'].'/uploads/no-video.jpg" style="width:200px;height:150px;">';
   }
   
   ?>
<div class="pages-index">
   <div class="row">
      <div class="col-md-12">
         <div class="box">
            <div class="box-body table-responsive">
               <div class="basic-info">
                  <div class="admin-display-header">
                     <h4>Step 1: Add Product Info</h4>
                  </div>
                  <div class="admin-display-box">
                     <div class="admin-form sm-input">
                        <div class="nav-tabs-custom">
                           <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_1" data-toggle="tab">Basic Info</a></li>
                              <li><a href="#tab_3" data-toggle="tab">Images Info</a></li>
                              <li><a href="#tab_4" data-toggle="tab">Meta Info</a></li>
                              <li><a href="#tab_5" data-toggle="tab">Related Products</a></li>
                              <li><a href="#tab_6" data-toggle="tab">Special Product</a></li>
                           </ul>
                           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                 <input type="hidden" name="step" value="pbi">
                                 <div class="row" >
                                    <div class="col-md-6">
                                       <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                       <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                                       <?= $form->field($model, 'quantity')->textInput() ?>
                                    </div>
                                   
                                    
									<div class="col-md-6">
									 <?= $form->field($model, 'price')->textInput() ?>
									<?= $form->field($model, 'market_price')->textInput() ?>
									 <?= $form->field($model, 'article_id')->textInput(['maxlength' => true]) ?>
                                    </div>
                                   
                                       <?php
									   if(count($general_attrs) > 0){
                                          $count = round(count($general_attrs)/2);
                                          $i = 0;
										 
                                          foreach($general_attrs as $attr){
											  if($attr->entity_id == 2 || $attr->entity_id == 1 ){
												  
												   if($attr->id == 1 || $attr->id == 2 || $attr->id == 3 ){
															continue;
													}else{
														echo "<div class='col-md-6'>";
													}
												    
											  }else{
												   echo "<div class='col-md-12'>"; 
											  }
											
                                              if( $attr->isrequired == 1){
														
													$attr_name = 'general_attrs['.$attr->id.']';
													  if($attr->entity_id == 2){
														 if($attr->id == 1 || $attr->id == 2 || $attr->id == 3 ){
															continue;
														}
													  	$data = ProductDropdownValues::find()->where(['product_id'=> $model->id ])->all();
														foreach($data as $get){
															$val = DropdownValues::find()->where(['attribute_id' => $attr->id , 'id' => $get->value_id])->one();
															if($val){
																 $model->general_attrs[$attr->id] = $val->id;
															}
														}
													  echo $form->field($model, $attr_name)->dropDownList(
                                                      $dropdownmodel->getAttrValues($attr->id),
                                                      [
                                                          'prompt'=>'- Select option -',
                                                          'class'=>'form-control select2',
                                                      ]
													)->label($attr->name);
													}elseif($attr->entity_id == 4){
														$getdata = ProductDescValues::find()->where(['product_id' => $model->id, "attr_id" => $attr->id])->one();
														if($getdata){
															$model->general_attrs[$attr->id] = $getdata->value;
														}
														echo $form->field($model,  $attr_name)->widget(CKEditor::className(), [
														  'options' => ['rows' => 6],
														  'preset' => 'full',
														  'clientOptions' => [
															  'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
															  'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
														  ]
														  ]);
													}elseif($attr->entity_id == 1){
														$getdata = ProductTextValues::find()->where(['product_id' => $model->id, "attr_id" => $attr->id])->one();
														if($getdata){
															$model->general_attrs[$attr->id] = $getdata->value;
														}
														echo $form->field($model, $attr_name)->textInput()->label($attr->name);
													}
                                                  
                                                  $i++;
                                              }else{
                                                  $attr_name = 'optional_attrs['.$attr->id.']';

                                                if($attr->entity_id == 2){
													if($attr->id == 1 || $attr->id == 2 || $attr->id == 3 ){
															continue;
														}
														$data = ProductDropdownValues::find()->where(['product_id'=> $model->id ])->all();
														foreach($data as $get){
															$val = DropdownValues::find()->where(['attribute_id' => $attr->id , 'id' => $get->value_id])->one();
															if($val){
																 $model->optional_attrs[$attr->id] = $val->id;
															}
														}
														echo $form->field($model, $attr_name)->dropDownList(
                                                      $dropdownmodel->getAttrValues($attr->id),
                                                      [
                                                          'prompt'=>'- Select option -',
                                                          'class'=>'form-control select2',
                                                      ]
													)->label($attr->name);
													}elseif($attr->entity_id == 4){
														$getdata = ProductDescValues::find()->where(['product_id' => $model->id, "attr_id" => $attr->id])->one();
														if($getdata){
															$model->optional_attrs[$attr->id] = $getdata->value;
														}
														echo $form->field($model,  $attr_name)->widget(CKEditor::className(), [
														  'options' => ['rows' => 6],
														  'preset' => 'full',
														  'clientOptions' => [
															  'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
															  'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
														  ]
														  ]);
													}elseif($attr->entity_id == 1){
														$getdata = ProductTextValues::find()->where(['product_id' => $model->id, "attr_id" => $attr->id])->one();
														if($getdata){
															$model->optional_attrs[$attr->id] = $getdata->value;
														}
														echo $form->field($model, $attr_name)->textInput()->label($attr->name);
													}
                                                  $i++;

                                              }

                                              echo"</div>";
                                              }

									   }
                                          ?>
                                  
                                    <div class="col-md-12">
                                       <?= $form->field($model, 'short_descr')->textarea(['rows' => 4]) ?>
                                       <?= $form->field($model, 'descr')->widget(CKEditor::className(), [
                                          'options' => ['rows' => 6],
                                          'preset' => 'full',
                                          'clientOptions' => [
                                              'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
                                              'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
                                          ]
                                          ]) ?>
                                    </div>
                                 </div>
                              </div>
                           <div class="tab-pane" id="tab_3">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="img-box1">
                                       <h4 class="head4-borderd">Main image:</h4>
                                       <?= $form->field($ProductImagesModel, 'main_image')->widget(FileInput::classname(),
                                          [
                                              'options' => ['accept' => 'image/*'],
                                              'pluginOptions' => [
                                                  'showCaption' => false,
                                                  'showRemove' => true,
                                                  'showUpload' => false,
                                                  'initialPreview'=>[
                                                      Html::img($main_image, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                                                  ],
                                              ]
                                          ])->label(false);
                                          ?>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="img-box1">
                                       <h4 class="head4-borderd">Flip image:</h4>
                                       <?= $form->field($ProductImagesModel, 'flip_image')->widget(FileInput::classname(),
                                          [
                                              'options' => ['accept' => 'image/*'],
                                              'pluginOptions' => [
                                                  'showCaption' => false,
                                                  'showRemove' => true,
                                                  'showUpload' => false,
                                                  'initialPreview'=>[
                                                      Html::img($main_image1, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                                                  ],
                                              ]
                                          ])->label(false);
                                          ?>
                                    </div>
                                 </div>
                                  <div class="col-md-4">
                                      <div class="img-box1">
                                          <h4 class="head4-borderd">Home image:</h4>
                                          <?= $form->field($ProductImagesModel, 'home_image')->widget(FileInput::classname(),
                                              [
                                                  'options' => ['accept' => 'image/*'],
                                                  'pluginOptions' => [
                                                      'showCaption' => false,
                                                      'showRemove' => true,
                                                      'showUpload' => false,
                                                      'initialPreview'=>[
                                                          Html::img($main_image2, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                                                      ],
                                                  ]
                                              ])->label(false);
                                          ?>
                                      </div>
                                  </div>
                                  </div>
                                  <div class="row">
                                  <div class="col-md-12">
                                      <h4 class="head4-borderd">Featured video:</h4>
									  <div class="form-group field-course-name">
										<div class="image_div">
											<?= $img_url  ?>
										</div>

									<?php  // Usage with ActiveForm and model
                                    echo $form->field($ProductImagesModel, 'video')->widget(FileInput::classname(),
                                          [
                                              'options' => ['accept' => 'video/*'],
                                              'pluginOptions' => [
                                                  'showCaption' => false,
                                                  'showRemove' => true,
                                                  'showUpload' => false,
                                              ]
                                          ])->label(false);
                                      ?>
									</div>
                                      
                                  </div>
                                  </div>
                                <div class="row">
                                 <div class="col-md-12">
                                    <h4 class="head4-borderd">Please upload here all other images:</h4>
									<div class="image_div">
									<?php
									$images = unserialize($ProductImagesModel->other_image);
									if($images){
											 echo "<div class='file-updat'><ul>";
											foreach($images as $images)
											{
												echo "<li class='file-preview-frame' >";
												echo"<img src='". Yii::$app->params['baseurl']."/uploads/product/other/".$model->id."/thumbs/".$images ."' class='file-preview-image' style='width:auto;height:160px;' >";
												//$image[] = \Yii::$app->request->baseUrl."/".$images->image_path;
												echo "</li>";
											}
											echo "</ul></div><div class='clearfix'></div>";
										
										 echo $form->field($ProductImagesModel, 'other_image[]')->widget(FileInput::classname(),
                                           [
                                               'options' => ['accept' => 'image/*','multiple' => true],
                                               'pluginOptions' => [
                                                   'showCaption' => false,
                                                   'showRemove' => true,
                                                   'showUpload' => false,
                                               ]
                                           ])->label(false);
									  
								   }else{
										$main_imager = Yii::$app->params['baseurl'].'/uploads/no-image.png';
										 echo $form->field($ProductImagesModel, 'other_image[]')->widget(FileInput::classname(),
                                           [
                                               'options' => ['accept' => 'image/*','multiple' => true],
                                               'pluginOptions' => [
                                                   'showCaption' => false,
                                                   'showRemove' => true,
                                                   'showUpload' => false,
                                                   'initialPreview'=>[
                                                       Html::img($main_imager, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                                                   ],
                                               ]
                                           ])->label(false);
								   }
									?>
										</div>
                                    <?php
                                       // Usage with ActiveForm and model
                                      
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane" id="tab_4">
                              <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
                              <?= $form->field($model, 'meta_description')->textarea(['rows' => 3]) ?>
                              <?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>
                           </div>
                           <div class="tab-pane" id="tab_5"> 
								<?php
								if($product_model){ ?>
									<div class="form-group field-product-meta_title">
										<label class="control-label" for="product-meta_title">Related Products</label>
										<br>
										<?php
										$ids = unserialize($model->related);
										$model->related ="";
										$i=1;
										foreach($product_model as $product){
											if($ids){
												if(in_array($product->id,$ids)){
													$sd = "checked";
												}else{
													$sd="";
												}	
											}else{
												$sd="";
											} ?>
											<input type="checkbox" name="related[]" <?=  $sd ?> value="<?= $product->id ?>" id="related[]" >&nbsp; <?= $product->name ?>  <br>
									<?php	}
											?>
											
							<?php   ?>
									
								<?php   
								echo'</div>';
								}
								?>
                           </div>
						   
                           <div class="tab-pane" id="tab_6">
						    <?= $form->field($model, 'featured')->dropDownList(['1' => 'Yes','0' => 'No']); ?>
							<?php
								if($product_model){ ?>
									<div class="form-group field-product-meta_title">
										<label class="control-label" for="product-meta_title">Special Products</label>
										<br>
										<?php
										$ids = unserialize($model->special);
										$model->special ="";
										$i=1;
										foreach($product_model as $product){
											if($ids){
												if(in_array($product->id,$ids)){
													$sd = "checked";
												}else{
													$sd="";
												}	
											}else{
												$sd="";
											} ?>
											<input type="checkbox" name="special[]" <?=  $sd ?> value="<?= $product->id ?>" id="special[]" >&nbsp; <?= $product->name ?>  <br>
									<?php	}
											?>
											
							<?php   ?>
									
								<?php   
								echo'</div>';
								}
								?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                  </div>
                  <?php ActiveForm::end(); ?>
               </div>
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
   </div>
   <!-- /.row -->
</div>
</div>
