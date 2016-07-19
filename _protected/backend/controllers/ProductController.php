<?php

namespace backend\controllers;

use common\models\DropdownValues;
use common\models\Sizewidth;
use common\models\VarientProductSearch;
use Yii;
use common\models\Product;
use common\models\CsvImport;
use common\models\ProductSearch;
use common\models\ProductForm;
use common\models\Category;
use common\models\Attributes;
use common\models\VarientProduct;
use common\models\ProductSliderValues;
use common\models\ProductDropdownValues;
use common\models\ProductImages;
use common\models\DropdownValuesSearch;
use common\models\ProductTextValues;
use common\models\ProductDescValues;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use common\traits\ImageUploadTrait;
use yii\web\UploadedFile;
/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BackendController
{
    use ImageUploadTrait;
	public $enableCsrfValidation = false;

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
		$model = new Product();
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($start=0)
    {

		$session = Yii::$app->session;

        if (!$session->isActive){
            // open a session
            $session->open();
        }

        $model = new Product();
        $product_model = Product::find()->where(['status' => 1])->all();
        $ProductImagesModel = new ProductImages();
        if($start ==1){
            $session->remove('category_id');
            $session->remove('user_id');
            $session->remove('last_selected_step');
            $session->remove('selected_categories');

            return $this->redirect(['create']);
        }
        if(Yii::$app->request->isPost){

            if(Yii::$app->request->post('step')=="sc"){
                $selected_categories = Yii::$app->request->post('ProductForm')['category'];
                $model->category_id = $selected_categories[count($selected_categories)-1];

                //store sc data to session
                $session->set('category_id', $model->category_id);
                $session->set('last_selected_step', "sc");
                $session->set('user_id', Yii::$app->user->identity->id);
                $session->set('selected_categories', json_encode($selected_categories));

                $categoryModel = Category::findOne($model->category_id);

                if (($attrsModel = $categoryModel->categoryAttributes) === null) {
                    $attrsModel = $categoryModel->createAttrsModel;
                }

                $general_added = unserialize($attrsModel->general_attributes);

                $general_attrs = array();
                foreach($general_added as $attr){
                    $general_attrs[] = Attributes::findOne(['id'=>$attr]);
                }
                $ProductImagesModel = new ProductImages();
                return $this->render('addproduct', [
                    'model' => $model,
                    'general_attrs' => $general_attrs,
                    'dropdownmodel' => new DropdownValuesSearch(),
                    'category' => $categoryModel,
                    'ProductImagesModel' => $ProductImagesModel,
                    'product_model' => $product_model,

                ]);

            }else if(Yii::$app->request->post('step')=="pbi"){

                $main_image = UploadedFile::getInstance($ProductImagesModel, 'main_image');
                $home_image = UploadedFile::getInstance($ProductImagesModel, 'home_image');
                $video = UploadedFile::getInstance($ProductImagesModel, 'video');
                $main_image = UploadedFile::getInstance($ProductImagesModel, 'main_image');

                $flip_image = UploadedFile::getInstance($ProductImagesModel, 'flip_image');
                $other_images = UploadedFile::getInstances($ProductImagesModel, 'other_image');

                //product save
                if($model->load(Yii::$app->request->post())){
                    $model->category_id = $session->get('category_id');
					$model->related = serialize(Yii::$app->request->post('related'));
					$model->special = serialize(Yii::$app->request->post('special'));
                    if($model->save()){
						
                        //save dropdown values
                        foreach($model->general_attrs as $key=>$gen_attrs){
							
							$check_type =  Attributes::find()->where(['id'=>$key])->one();
							if($check_type->entity_id == 2){
								$ProductDropdownValues = new ProductDropdownValues;
								$ProductDropdownValues->value_id = $gen_attrs;
							}elseif($check_type->entity_id == 4){
								$ProductDropdownValues = new ProductDescValues;
								$ProductDropdownValues->value = $gen_attrs;
								$ProductDropdownValues->attr_id = $key;
								$ProductDropdownValues->status = 1;
							}elseif($check_type->entity_id == 1){
								$ProductDropdownValues = new ProductTextValues;
								$ProductDropdownValues->value = $gen_attrs;
								$ProductDropdownValues->attr_id = $key;
								$ProductDropdownValues->status = 1;
							}
                            $ProductDropdownValues->product_id = $model->id;
                            $ProductDropdownValues->save();
                        }
						 foreach($model->optional_attrs as $key=>$optional_attrs){
							$check_type =  Attributes::find()->where(['id'=>$key])->one();
							if($check_type->entity_id == 2){
								$ProductDropdownValues = new ProductDropdownValues;
								$ProductDropdownValues->value_id = $optional_attrs;
							}elseif($check_type->entity_id == 4){
								$ProductDropdownValues = new ProductDescValues;
								$ProductDropdownValues->value = $optional_attrs;
								$ProductDropdownValues->status = 1;
								$ProductDropdownValues->attr_id = $key;
							}elseif($check_type->entity_id == 1){
								$ProductDropdownValues = new ProductTextValues;
								$ProductDropdownValues->value = $optional_attrs;
								$ProductDropdownValues->status = 1;
								$ProductDropdownValues->attr_id = $key;
							}
                            
                            $ProductDropdownValues->product_id = $model->id;
                             $ProductDropdownValues->save();
							
                        }

                        $size = Yii::$app->params['folders']['size'];
                        $folder = array('uploadMain','uploadLarge','uploadThumbs','uploadMedium','custom1','custom2','custom3','custom4');

                        $size['custom1'] = '99x111';
                        $size['custom2'] = '300x450';
                        $size['custom3'] = '220x330';
                        $size['custom4'] = '562x525';
                        $ProductImagesModel->product_id = $model->id;
                        //save main image
                        if($main_image)
                        {
                            $name = time().$model->id;
                            $main_folder = "product/main/".$model->id;
                            $image_name= $this->uploadImage($main_image,$name,$main_folder,$size,$folder);
                            $ProductImagesModel->main_image = $image_name;
                        }
                        if($home_image)
                        {
                            $name = time().$model->id;
                            $main_folder = "product/home/".$model->id;
                            $image_name1 = $this->uploadImage($home_image,$name,$main_folder,$size,$folder);
                            $ProductImagesModel->home_image = $image_name1;
                        }
                        if($video)
                        {
                            $name = time().$model->id;
                            $main_folder = "product/video/".$model->id;
                            $image_name2 = $this->uploadFile($video,$name,$main_folder);
                            $ProductImagesModel->video = $image_name2;
                        }
                        if($flip_image)
                        {
                            $name = time().$model->id;
                            $main_folder = "product/flip/".$model->id;
                            $image_name3 = $this->uploadImage($flip_image,$name,$main_folder,$size,$folder);
                            $ProductImagesModel->flip_image = $image_name3;
                        }
                        //save all other images
                        if($other_images)
                        {

                            $prod_otherimages = array();
                            foreach($other_images as $other_image){

                                $name = time().$model->id;
                                $main_folder = "product/other/".$model->id;
                                $image_name4 = $this->uploadImage($other_image,$name,$main_folder,$size,$folder);
                                $prod_otherimages[] = $image_name4;
                            }
                            $ProductImagesModel->other_image = serialize($prod_otherimages);
                        }
                        $ProductImagesModel->save();

                    }else{
                        print_r($model->getErrors());
                        die;
                    }
                }else{
                    print_r($model->getErrors());
                    die;
                }
                $session->remove('category_id');
                $session->remove('user_id');
                $session->remove('last_selected_step');
                $session->remove('selected_categories');
                Yii::$app->getSession()->setFlash('success', Yii::t('app', "Congratulations! your product is successfully created and sent to admin for approval."));
                $model = new ProductForm();
				return $this->redirect(['index']);
               /*  return $this->render('select-category', [
                    'model' => $model,
                ]); */
            }

        } else {
				if ($session->has('last_selected_step')){

                $selected_categories = json_decode($session->get('selected_categories'));

                //update previous product
                if($session->get('last_selected_step')=="sc"){
                    if(Yii::$app->user->identity->id !== $session->get('user_id')){
                        return $this->redirect(['select-category']);
                    }
                    $model->category_id = $session->get('category_id');

                    $categoryModel = Category::findOne($model->category_id);

                    if (($attrsModel = $categoryModel->categoryAttributes) === null) {
                        $attrsModel = $categoryModel->createAttrsModel;
                    }

                    $general_added = unserialize($attrsModel->general_attributes);

                    $general_attrs = array();
                    foreach($general_added as $attr){
                        $general_attrs[] = Attributes::findOne(['id'=>$attr]);
                    }
                    $ProductImagesModel = new ProductImages();
                    return $this->render('addproduct', [
                        'model' => $model,
                        'general_attrs' => $general_attrs,
                        'dropdownmodel' => new DropdownValuesSearch,
                        'category' => $categoryModel,
                        'ProductImagesModel' => $ProductImagesModel,
						'product_model' => $product_model,
                    ]);

                }else if($session->get('last_selected_step')=="pbi"){
                    $selected_categories = Yii::$app->request->post('ProductForm')['category'];
                    $model->category_id = $selected_categories[count($selected_categories)-1];

                    //store sc data to session
                    $session->set('category_id', $model->category_id);
                    $session->set('user_id', Yii::$app->user->identity->id);

                    $categoryModel = Category::findOne($model->category_id);
                    if (($attrsModel = $categoryModel->categoryAttributes) === null) {
                        $attrsModel = $categoryModel->createAttrsModel;
                    }
                    $general_added = unserialize($attrsModel->general_attributes);
                    $general_attrs = array();
                    foreach($general_added as $attr){
                        $general_attrs[] = Attributes::findOne(['id'=>$attr]);
                    }
                    $general_added = unserialize($attrsModel->optional_attributes);
                    $optional_attrs = array();
                    foreach($general_added as $attr){
                        $general_attrs[] = Attributes::findOne(['id'=>$attr]);
                    }
                    $ProductImagesModel = new ProductImages();
                    return $this->render('addproduct', [
                        'model' => $model,
                        'general_attrs' => $general_attrs,
                        'dropdownmodel' => new DropdownValuesSearch,
                        'category' => $categoryModel,
                        'ProductImagesModel' => $ProductImagesModel,
						'product_model' => $product_model,
                    ]);

                }
            }else{
                //add new product
                $model = new ProductForm();
                $session->remove('category_id');
                $session->remove('user_id');
                $session->remove('last_selected_step');
                $session->remove('selected_categories');
                return $this->render('select-category', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionSubcategories($id)
    {
        $model = new ProductForm();
        $result = $model->getCategories($id);
        $count = $model->getCategoriesCount($id);
        if($count){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'result' => $result,
                'count' => $count,
            ];
        } else {

            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'result' => $result,
                'count' => $count,
            ];
        }

    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$categoryModel = Category::findOne($model->category_id);
		$product_model = Product::find()->where(['status' => 1])->all();
        if (($attrsModel = $categoryModel->categoryAttributes) === null) {
            $attrsModel = $categoryModel->createAttrsModel;
        }

        $general_added = unserialize($attrsModel->general_attributes);

        $general_attrs = array();
        foreach($general_added as $attr){
            $general_attrs[] = Attributes::findOne(['id'=>$attr]);
        }
		
        $ProductImagesModel =ProductImages::find()->where(['product_id' => $model->id])->one();
        if(Yii::$app->request->isPost){
			if(Yii::$app->request->post('step')=="sc"){
                $selected_categories = Yii::$app->request->post('ProductForm')['category'];

                //store sc data to session
                $session->set('category_id', $model->category_id);
                $session->set('last_selected_step', "sc");
                $session->set('user_id', Yii::$app->user->identity->id);
                $session->set('selected_categories', json_encode($selected_categories));

                $categoryModel = Category::findOne($model->category_id);

                if (($attrsModel = $categoryModel->categoryAttributes) === null) {
                    $attrsModel = $categoryModel->createAttrsModel;
                }

                $general_added = unserialize($attrsModel->general_attributes);

                $general_attrs = array();
                foreach($general_added as $attr){
                    $general_attrs[] = Attributes::findOne(['id'=>$attr]);
                }
                $ProductImagesModel = new ProductImages();
                return $this->render('addproduct', [
                    'model' => $model,
                    'general_attrs' => $general_attrs,
                    'dropdownmodel' => new DropdownValuesSearch(),
                    'category' => $categoryModel,
                    'ProductImagesModel' => $ProductImagesModel,
                    'product_model' => $product_model,

                ]);

            }else if(Yii::$app->request->post('step')=="pbi"){

                $main_image = UploadedFile::getInstance($ProductImagesModel, 'main_image');
                $home_image = UploadedFile::getInstance($ProductImagesModel, 'home_image');
                $video = UploadedFile::getInstance($ProductImagesModel, 'video');
                $main_image = UploadedFile::getInstance($ProductImagesModel, 'main_image');

                $flip_image = UploadedFile::getInstance($ProductImagesModel, 'flip_image');
                $other_images = UploadedFile::getInstances($ProductImagesModel, 'other_image');

                //product save
                if($model->load(Yii::$app->request->post())){
                    $model->category_id = $model->category_id;
					$model->related = serialize(Yii::$app->request->post('related'));
					$model->special = serialize(Yii::$app->request->post('special'));
					
                    if($model->save()){
						
                        //save dropdown values
						ProductDropdownValues::deleteAll(['product_id'=>$model->id]);
						ProductDescValues::deleteAll(['product_id'=>$model->id]);
						ProductTextValues::deleteAll(['product_id'=>$model->id]);
                        foreach($model->general_attrs as $key=>$gen_attrs){
							$check_type =  Attributes::find()->where(['id'=>$key])->one();
							if($check_type->entity_id == 2){
								
								$ProductDropdownValues = new ProductDropdownValues;
								$ProductDropdownValues->value_id = $gen_attrs;
							}elseif($check_type->entity_id == 4){
								
								$ProductDropdownValues = new ProductDescValues;
								$ProductDropdownValues->value = $gen_attrs;
								$ProductDropdownValues->attr_id = $key;
								$ProductDropdownValues->status = 1;
							}elseif($check_type->entity_id == 1){
								$ProductDropdownValues = new ProductTextValues;
								$ProductDropdownValues->value = $gen_attrs;
								$ProductDropdownValues->attr_id = $key;
								$ProductDropdownValues->status = 1;
							}
                            $ProductDropdownValues->product_id = $model->id;
                            $ProductDropdownValues->save();
                        }
						 foreach($model->optional_attrs as $key=>$optional_attrs){
							$check_type =  Attributes::find()->where(['id'=>$key])->one();
							if($check_type->entity_id == 2){
								$ProductDropdownValues = new ProductDropdownValues;
								$ProductDropdownValues->value_id = $optional_attrs;
							}elseif($check_type->entity_id == 4){
								$ProductDropdownValues = new ProductDescValues;
								$ProductDropdownValues->value = $optional_attrs;
								$ProductDropdownValues->status = 1;
								$ProductDropdownValues->attr_id = $key;
							}elseif($check_type->entity_id == 1){
								$ProductDropdownValues = new ProductTextValues;
								$ProductDropdownValues->value = $optional_attrs;
								$ProductDropdownValues->status = 1;
								$ProductDropdownValues->attr_id = $key;
							}
                            
                            $ProductDropdownValues->product_id = $model->id;
                             $ProductDropdownValues->save();
							
                        }
                        $size = Yii::$app->params['folders']['size'];
                        $folder = array('uploadMain','uploadLarge','uploadThumbs','uploadMedium','custom1','custom2','custom3','custom4');

                        $size['custom1'] = '99x111';
                        $size['custom2'] = '300x450';
                        $size['custom3'] = '400x296';
                        $size['custom4'] = '789x737';
                        $ProductImagesModel->product_id = $model->id;
                        //save main image
                        if($main_image)
                        {
                            $name = time().$model->id;
                            $main_folder = "product/main/".$model->id;
                            $image_name= $this->uploadImage($main_image,$name,$main_folder,$size,$folder);
                            $ProductImagesModel->main_image = $image_name;
                        }
                        if($home_image)
                        {
                            $name = time().$model->id;
                            $main_folder = "product/home/".$model->id;
                            $image_name1 = $this->uploadImage($home_image,$name,$main_folder,$size,$folder);
                            $ProductImagesModel->home_image = $image_name1;
                        }
                        if($video)
                        {
                            $name = time().$model->id;
                            $main_folder = "product/video/".$model->id;
                            $image_name2 = $this->uploadFile($video,$name,$main_folder);
                            $ProductImagesModel->video = $image_name2;
                        }
                        if($flip_image)
                        {
                            $name = time().$model->id;
                            $main_folder = "product/flip/".$model->id;
                            $image_name3= $this->uploadImage($flip_image,$name,$main_folder,$size,$folder);
                            $ProductImagesModel->flip_image = $image_name3;
                        }
                        //save all other images
                        if($other_images)
                        {

                            $prod_otherimages = array();
                            foreach($other_images as $other_image){

                                $name = time().$model->id;
                                $main_folder = "product/other/".$model->id;
                                $image_name4= $this->uploadImage($other_image,$name,$main_folder,$size,$folder);
                                $prod_otherimages[] = $image_name4;
                            }
                            $ProductImagesModel->other_image = serialize($prod_otherimages);
                        }
                        $ProductImagesModel->save();

                    }else{
                        print_r($model->getErrors());
                        die;
                    }
                }else{
                    print_r($model->getErrors());
                    die;
                }
                Yii::$app->getSession()->setFlash('success', Yii::t('app', "Congratulations! your product is successfully updated."));
            }
            return $this->redirect(['index']);
        } else {
           return $this->render('updateproduct', [
                    'model' => $model,
                    'general_attrs' => $general_attrs,
                    'dropdownmodel' => new DropdownValuesSearch(),
                    'category' => $categoryModel,
                    'ProductImagesModel' => $ProductImagesModel,
                    'product_model' => $product_model,

                ]);
        }
    }

    public function actionViewitems($id)
    {
        $searchModel = new VarientProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);
        $model = new VarientProduct();
        return $this->render('items', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
	public function actionUpload(){

		$model = new CsvImport;

		if($model->load(Yii::$app->request->post())){
			
			$file = UploadedFile::getInstance($model,'file');
			$filename = 'Data.'.$file->extension;
			$upload = $file->saveAs('uploads/tmp/'.$filename);
			if($upload){
				define('CSV_PATH','uploads/tmp/');
				$csv_file = CSV_PATH . $filename;
				$filde = fopen($csv_file,"r");
				$titles = null;
				while (($data = fgetcsv($filde)) !== FALSE) {
					if ($titles === null) {
						$titles = $data;
						break;
					}
					
				}
				while (($data = fgetcsv($filde, 11000, ",")) !== FALSE) {
					$product = new Product();
					$product_images = new ProductImages();
					$prosave = 0;
					for($i = 0;$i< count($titles);$i++){
						
							if($i < 21){
								$product->$titles[$i] = $data[$i];
								
								echo $titles[$i].'<br>';
							}else if($i < 27){
								if($prosave == 0){
									if($product->slug == ""){
										$product->slug = $product->id;
									}
									$product->general_attrs = 1;
					
									if(!$product->save()){
										echo'<pre>';print_r($product->getErrors());echo"</pre>";
									}
									$prosave =1;
								}
								
								$product_images->$titles[$i] = $data[$i];
								$product_images->product_id = $product->id;

							}else{
								$check_type =  Attributes::find()->where(['name'=>$titles[$i]])->one();
								if($check_type->entity_id == 2){
									$ProductDropdownValues = new ProductDropdownValues;
									$ProductDropdownValues->value_id = $data[$i];
								}elseif($check_type->entity_id == 4){
									$ProductDropdownValues = new ProductDescValues;
									$ProductDropdownValues->value = $data[$i];
									$ProductDropdownValues->attr_id = $check_type->id;
									$ProductDropdownValues->status = 1;
								}elseif($check_type->entity_id == 1){
									$ProductDropdownValues = new ProductTextValues;
									$ProductDropdownValues->value =$data[$i];
									$ProductDropdownValues->attr_id = $check_type->id;
									$ProductDropdownValues->status = 1;
								}
								$ProductDropdownValues->product_id = $data[0];
								if(!$ProductDropdownValues->save()){
									echo'<pre>';print_r($ProductDropdownValues->getErrors());die;
								}
								
							}

					}
					if(!$product_images->save()){
						echo'<pre>';print_r($product_images->getErrors());die;
					}
				}				
			}
		}else{
			return $this->render('upload',['model'=>$model]);
		}
	}
    public function actionGenerate($id)
    {
        $model = new VarientProduct();
        $model->product_id = $id;



        if ($model->load(Yii::$app->request->post())) {
            $product = Product::findOne($id);
            $group = Sizewidth::findOne($product->size_width_id);

            $sizes = unserialize($group->size);
            $widths = unserialize($group->width);

            foreach($model->colors as $color){
                foreach($sizes as $size){
                    foreach($widths as $width){
                        $varmodel = new VarientProduct();
                        $searchvarient = VarientProduct::find()->where(['color'=>$color,'width'=>$width,'size'=>$size,'product_id'=>$model->product_id])->one();
                         if ($searchvarient !== null)
                            continue;
						
                        $colormodel = DropdownValues::findOne($color);
                        $widthmodel = DropdownValues::findOne($width);
                        $sizemodel = DropdownValues::findOne($size);
                        $varmodel->color = $color;
                        $varmodel->colors = 'red';
                        $varmodel->width = $width;
                        $varmodel->quantity = $product->quantity;
                        $varmodel->size = $size;
                        $varmodel->product_id = $model->product_id;
                        $varmodel->price = 0;
                        $varmodel->sku = $product->article_id.'-'.$colormodel->name.'-'.$widthmodel->name.'-'.$sizemodel->name;
                        $varmodel->save();
                    }
                }
            }

            Yii::$app->getSession()->setFlash('success', Yii::t('app', "Congratulations! items successfully created."));
            return $this->redirect(['varient-product/index','id'=>$model->product_id]);
        }else {
            return $this->render('generate-items', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
