<?php
   /* @var $this yii\web\View */
   use yii\helpers\Html;
   use yii\widgets\ActiveForm;
   use yii\helpers\Url;
   use dosamigos\ckeditor\CKEditor;
   use kartik\slider\Slider;
   use kartik\file\FileInput;
   
   $this->title = 'Add new product';
   
   $main_image = \Yii::$app->request->baseUrl . '/uploads/no-image.png';
   ?>
<div class="pages-index">
   <div class="row">
      <div class="col-md-12">
         <div class="box">
		
            <div class="box-body table-responsive">
					 <p class="pull-right">
                        <?= Html::a('Change Category', ['create','start'=>1], ['class' => 'btn btn-primary']) ?>
                    </p>
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
                                 <div class="row">
									<div class="col-md-12">
										<?= $form->field($model, 'size_width_id')->dropDownList(
                                             $model->sizeWidthGroup,
                                             [
                                                 'prompt'=>'- Select Size width group -',
                                                 'class'=>'form-control select2'
                                             ]
                                         );
                                         ?>
									</div>
									<div class="col-md-6">
										<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
										<?= $form->field($model, 'price')->textInput() ?>
										<?= $form->field($model, 'article_id')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
									    <?= $form->field($model, 'market_price')->textInput() ?>
                                        <?= $form->field($model, 'quantity')->textInput() ?>
                                    </div>
                                   
                                       <?php
									   if(count($general_attrs) > 0){
                                          $count = round(count($general_attrs)/2);
                                          $i = 0;
                                          foreach($general_attrs as $attr){
											  if($attr->id != 1 && $attr->id != 2  && $attr->id != 3 ){
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
													if($attr->entity_id ){
														if($attr->id == 1 || $attr->id == 2 || $attr->id == 3 ){
															continue;
														}
														echo $form->field($model, $attr_name)->dropDownList(
                                                      $dropdownmodel->getAttrValues($attr->id),
                                                      [
                                                          'prompt'=>'- Select option -',
                                                          'class'=>'form-control select2',
                                                      ]
													)->label($attr->name);
													}elseif($attr->entity_id == 4){
														echo $form->field($model,  $attr_name)->widget(CKEditor::className(), [
														  'options' => ['rows' => 1],
														  'preset' => 'full',
														  'clientOptions' => [
															  'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
															  'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
														  ]
														  ])->label($attr->name);
													}elseif($attr->entity_id == 1){
														echo $form->field($model, $attr_name)->textInput()->label($attr->name);
													}
                                                  
                                                  $i++;
                                              }else{
                                                  $attr_name = 'optional_attrs['.$attr->id.']';

                                                if($attr->entity_id == 2){
														if($attr->id == 1 || $attr->id == 2 || $attr->id == 3 ){
															continue;
														}
														echo $form->field($model, $attr_name)->dropDownList(
                                                      $dropdownmodel->getAttrValues($attr->id),
                                                      [
                                                          'prompt'=>'- Select option -',
                                                          'class'=>'form-control select2',
                                                      ]
													)->label($attr->name);
													}elseif($attr->entity_id == 4){
														echo $form->field($model, $attr_name)->textarea(['rows' => 4])->label($attr->name);
													}elseif($attr->entity_id == 1){
														echo $form->field($model, $attr_name)->textInput()->label($attr->name);
													}
                                                  $i++;

                                              }

                                              echo"</div>";
                                              }
										  }
									   }
									   
                                          ?>
                                  
                                    <div class="col-md-12">
                                       <?= $form->field($model, 'short_descr')->textarea(['rows' => 4])->label("Short Description") ?>
                                       <?= $form->field($model, 'descr')->widget(CKEditor::className(), [
                                          'options' => ['rows' => 1],
                                          'preset' => 'full',
                                          'clientOptions' => [
                                              'filebrowserBrowseUrl' => Url::to(['uploadfile/browse']),
                                              'filebrowserUploadUrl' => Url::to(['uploadfile/url'])
                                          ]
                                          ])->label("Description") ?>
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
                                                      Html::img($main_image, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
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
                                                          Html::img($main_image, ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
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
                                      <?php
                                      // Usage with ActiveForm and model
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
                                <div class="row">
                                 <div class="col-md-12">
                                    <h4 class="head4-borderd">Please upload here all other images:</h4>
                                    <?php
                                       // Usage with ActiveForm and model
                                       echo $form->field($ProductImagesModel, 'other_image[]')->widget(FileInput::classname(),
                                           [
                                               'options' => ['accept' => 'image/*','multiple' => true],
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
                           </div>
                           <div class="tab-pane" id="tab_4">
                              <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
                              <?= $form->field($model, 'meta_description')->textarea(['rows' => 3]) ?>
                              <?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>
                           </div>
                           <div class="tab-pane" id="tab_5">
						   	<div class="form-group field-product-meta_title">
							<?php
								if($product_model){ ?>
								
										<label class="control-label" for="product-meta_title">Related Products</label>
										<br>
										<?php
										foreach($product_model as $product){
											 ?>
											<input type="checkbox" name="related[]"  value="<?= $product->id ?>" id="related[]" >&nbsp; <?= $product->name ?>  <br>
									<?php	} 
								}
								?>
						   
                           </div>
                           </div>
						   
                           <div class="tab-pane" id="tab_6">
						      <?= $form->field($model, 'featured')->dropDownList(['1' => 'Yes','0' => 'No']); ?>
						   <div class="form-group field-product-meta_title">
								<?php
								if($product_model){ ?>
									
										<label class="control-label" for="product-meta_title">Special Products</label>
										<br>
										<?php
										foreach($product_model as $product){
											 ?>
											<input type="checkbox" name="special[]"  value="<?= $product->id ?>" id="special[]" >&nbsp; <?= $product->name ?>  <br>
									<?php	} 
								}
								?>
							   
						    <!--?= $form->field($model, 'special')->dropDownList(
								$model->specialProducts,
								[
									'prompt'=>'- Select Product -',
									'class'=>'form-control select2'

								]
							);
							?-->
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
