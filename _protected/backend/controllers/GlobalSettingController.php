<?php

namespace backend\controllers;

use Yii;
use common\models\Globalsetting;
use common\models\CategoryMap;
use common\models\GlobalSettingSearch;
use common\models\ProductMap;
use common\models\Products;
use common\models\ProductsParent;
use common\models\Brand;
use common\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\imagine\Image;
use kartik\file\FileInput;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use common\models\CsvImport;
use common\models\Attributes;
use common\models\AttributeValues;
use common\models\AttributesSearch;
use yii\helpers\ArrayHelper;

/**
 * GlobalSettingController implements the CRUD actions for GlobalSetting model.
 */
class GlobalSettingController extends BackendController
{
    public function behaviors()
    {
	    $behaviors = parent::behaviors();
		return $behaviors;
    }

    /**
     * Lists all GlobalSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GlobalSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GlobalSetting model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      /*   return $this->render('view', [
            'model' => $this->findModel($id),
        ]); */
		 return $this->redirect(['update', 'id' => 1 ]);
		
    }

    /**
     * Creates a new GlobalSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	 public function actionCreate()
    {
        $model = new Globalsetting();
		$image = UploadedFile::getInstance($model, 'fevicon_icon');
		$himage = UploadedFile::getInstance($model, 'logo');
        if ($model->load(Yii::$app->request->post())) {
				if($image != '')
				{
					$path = '';
					$mimage= $model->updateImage($image, $model->id,$path);
					$mimage1= $model->updateImage($himage, $model->id,$path);
					if($mimage==true && $mimage1==true)
						$model->fevicon_icon = $mimage;				
						$model->logo = $mimage1;				
				}	
				

				$model->save();				
				//$imagine->thumbnail($uploadLarge, 1000, 400)->save($filename, ['quality' => 80]);				
						
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
           /*  return $this->render('create', [
                'model' => $model,
            ]); */
			 return $this->redirect(['update', 'id' => 1 ]);
        }
    }
    /**
     * Updates an existing GlobalSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$image = UploadedFile::getInstance($model, 'fevicon_icon');
		$himage = UploadedFile::getInstance($model, 'logo');
		$himage_inner = UploadedFile::getInstance($model, 'innerlogo');
		$himage_video = UploadedFile::getInstance($model, 'videoPath');
        if ($model->load(Yii::$app->request->post())) {
			$path = '';
			$asdlogo = $model->getLogoFevicon();
			foreach($asdlogo as $asdlogo1 ){
				$fevicon = $asdlogo1->fevicon_icon;
				$logo = $asdlogo1->logo;
				$innerlogo = $asdlogo1->innerlogo;
			}
				if($image != '')
				{
					$imagine = new Image();		

					$mimage = 'fevicon.'. $image->extension;
					$model->fevicon_icon = "/uploads/".$mimage;	
				}
				else{
					$model->fevicon_icon = $fevicon;
				}
				if($himage != '')
				{
					$mimage1= $model->updateImage($himage, 1,$path,'logo');
					$model->logo = "/uploads/site/medium/".$mimage1;	
				}
				else{
					$model->logo = $logo;
				}		
				if($himage_inner != '')
				{
					$mimage2= $model->updateImage($himage_inner, 1,$path,'innerlogo');
					$model->innerlogo = "/uploads/site/medium/".$mimage2;
				}
				else{
					$model->innerlogo = $innerlogo;
				}


				$model->save();				
				//$imagine->thumbnail($uploadLarge, 1000, 400)->save($filename, ['quality' => 80]);				
						
            return $this->redirect(['update', 'id' => $model->id , 'save' => 'yes']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GlobalSetting model.
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
     * Finds the GlobalSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GlobalSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Globalsetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionUpload(){

		$model = new CsvImport;

		if($model->load(Yii::$app->request->post())){
			$feed_type = $model->feed_type;
			$language = $model->language;

			$entity_type = 9;
			$file = UploadedFile::getInstance($model,'file');
			$filename = 'Data.'.$file->extension;
			$upload = $file->saveAs('uploads/tmp/'.$filename);
			if($upload){
				define('CSV_PATH','uploads/tmp/');
				$csv_file = CSV_PATH . $filename;
				
				$catmodel = new CategoryMap();
				$categories = $catmodel->getcatImport($csv_file,$feed_type);
				if(count($categories) > 0){
					Yii::$app->getSession()->setFlash('danger', Yii::t('app', "Before product import all categories must map.Please map all the catgories given bellow."));
            
					return $this->render('categorymap',['model'=>$catmodel,'categories'=>$categories,'feed_type'=>$feed_type]);
				}
				
				if (($handle = fopen($csv_file, "r")) !== FALSE) {
					$i = 0;
					$mapdata = ProductMap::find()->where(['feed_id'=>$feed_type])->asArray()->one();
					$mapvalues = array_values($mapdata);
					unset($mapvalues[0]);
					$delimiter = $catmodel->detectDelimiter($csv_file);

					while (($rows = fgetcsv($handle,11000,$delimiter,'"',$delimiter)) !== FALSE) {
						
						$count = count($rows);
						$row = $rows;
				
						$err = array();
						if($i == 0){
							$colname = array();
							foreach($row as $key => $title){
								
								$attribute = Attributes::findOne(['name'=>$title,'feed_type'=>$feed_type]);

								if($attribute){
									$colname[$key] = $attribute->id;
								}else{						
									$attribute = new Attributes();
									$attribute->name = $title;
									$attribute->entity_id = $entity_type;
									$attribute->feed_type = $feed_type;
									if($attribute->save()){
										$colname[$key] = $attribute->id;
									}else{
										$err[] = $title;
										continue;
									}
									
								}
								
							}
							$i++;

							continue;	
						}

						foreach($row as $key => $row_data){
							if(count($row_data) != $count)
								$err[] = $row_data;
							
							$prod_val[$colname[$key]] = $row_data;
						}
						$productParent = Products::findOne(['offerid'=>$prod_val[$mapvalues[2]],'feed_id'=>$feed_type]);

						
						if($productParent){
							$product_parent_id = $productParent->product_id;	
						}else{
							$productparentmodel = new ProductsParent();
							$productparentmodel->save();

							$product_parent_id = $productparentmodel->id;
						}
						$productmodel = Products::findOne(['url'=>$prod_val[$mapvalues[1]],'feed_id'=>$feed_type,'language'=>$language]);
						if($productmodel){

						}else{						
							$productmodel = new Products();
						}
						$prod_val[$mapvalues[6]] = urlencode($prod_val[$mapvalues[6]]);
						
						$categoryid = CategoryMap::findOne(['name'=>$prod_val[$mapvalues[6]],'feed_type'=>$feed_type]);
						if(!$categoryid){
							$categoryid = 8622;
						}else{
							$categoryid = $categoryid->cat_id;
						}

						$productmodel->feed_id = $feed_type;
						$productmodel->url = $prod_val[$mapvalues[1]];
						$productmodel->offerid = $prod_val[$mapvalues[2]];
						$productmodel->language = $language;

						$productmodel->product_id = $product_parent_id;
						if(isset($prod_val[$mapvalues[2]]))
							$productmodel->offerid = $prod_val[$mapvalues[2]];
						
						
						$productmodel->description = $prod_val[$mapvalues[3]];
						$productmodel->image = $prod_val[$mapvalues[4]];
						$productmodel->price = $prod_val[$mapvalues[5]];
						
						$productmodel->category = $categoryid;
						
						$productmodel->name = $prod_val[$mapvalues[7]];
						if($prod_val[$mapvalues[8]] != ''){
							$brandmodel = Brand::findOne(['name'=>$prod_val[$mapvalues[8]]]);
							if($brandmodel){
								
							}else{
								$brandmodel = new Brand();							
								$brandmodel->name = $prod_val[$mapvalues[8]];
								$brandmodel->save();	 
							}	
							$vendorid = $brandmodel->id;
						}else{
							$vendorid = 1;
						}						
											
						
						$productmodel->vendor = $vendorid;
						$productmodel->stock = $prod_val[$mapvalues[9]];
						$productmodel->sku = $prod_val[$mapvalues[10]];
						$productmodel->global_id = $prod_val[$mapvalues[11]];
						
						$productmodel->status = 1;

						if($productmodel->save()){
							
							for($k=1;$k<12;$k++)
								unset($prod_val[$mapvalues[$k]]);
							
							foreach($prod_val as $key=>$prodval){
								//$attrmodel = AttributeValues::findOne(['attr_id'=>$key,'product_child_id'=>$productmodel->id]);
								$attrmodel = new AttributeValues;
								/* if($attrmodel){
									
								}else{
									$attrmodel = new AttributeValues();
								} */
								$attrmodel->attr_id = $key;
								$attrmodel->product_child_id = 1;
								$attrmodel->entity_id = 9;
								$attrmodel->value = $prodval;
								$attrmodel->status = 1;
								$attrmodel->save();
							}
							
						}else{
							print_r($productmodel->getErrors());
							die;
							continue;
						}
					}
					fclose($handle);
				}				
				

				unlink('uploads/tmp/'.$filename);

				Yii::$app->getSession()->setFlash('success', Yii::t('app', "All products imported successfully."));
						
				return $this->redirect(['products']);
			}
		}else{
			$languages = array();
			$languages[0]['id'] = 'en';
			$languages[0]['name'] = 'english';
			$languages[1]['id'] = 'fr';
			$languages[1]['name'] = 'french';
			$languages[2]['id'] = 'de';
			$languages[2]['name'] = 'dutch';
			
			$languages = ArrayHelper::map($languages,'id','name');
			return $this->render('upload',['model'=>$model,'languages'=> $languages]);
		}
	}	
	public function actionCategoryMap($id=0){
		
		if(Yii::$app->request->post()){
			
			$catids = array_filter(Yii::$app->request->post("catid"));
			$catnames = array_filter(Yii::$app->request->post("catname"));
			if($id == 0)
				$id = Yii::$app->request->post("feed_type");
			
			foreach($catids as $key => $cat){
				$model = new CategoryMap();
				$model->name = $catnames[$key];
				$model->cat_id = $cat;
				$model->feed_type = $id;
				
				$model->save();
			}
			Yii::$app->getSession()->setFlash('success', Yii::t('app', "Congratulations! all category mapped successfully.Now you can import products from this feed."));
		
			return $this->redirect(['global-setting/upload']);						
		}

	}		
	public function actionCategoryImport($id=0){

		$model = new CsvImport;
		if($model->load(Yii::$app->request->post())){

			$feed_type = $model->feed_type;
			$entity_type = 9;
			$file = UploadedFile::getInstance($model,'file');
			$filename = 'Data.'.$file->extension;
			$upload = $file->saveAs('uploads/tmp/'.$filename);
			if($upload){
				define('CSV_PATH','uploads/tmp/');
				$csv_file = CSV_PATH . $filename;
				$catmodel = new CategoryMap();
				$categories = $catmodel->getcatImport($csv_file,$feed_type);		
				unlink('uploads/tmp/'.$filename);

				if(count($categories) > 0){
					return $this->render('categorymap',['model'=>$catmodel,'categories'=>$categories,'feed_type'=>$feed_type]);
				}
				Yii::$app->getSession()->setFlash('success', Yii::t('app', "All categories in this feed already mapped.Now you can import products from this feed."));
            
				return $this->redirect(['global-setting/upload']);
			}
		}else{
			$model->feed_type = $id;
			return $this->render('uploadcategory',['model'=>$model]);
		}
	}


	public function actionFieldsImport($id=0)
	{
		$model = new CsvImport;
		if($model->load(Yii::$app->request->post())){
			$feed_type = $model->feed_type;
			$entity_type = 9;
			$file = UploadedFile::getInstance($model,'file');
			$filename = 'Data.'.$file->extension;
			$upload = $file->saveAs('uploads/tmp/'.$filename);
			if($upload){
				define('CSV_PATH','uploads/tmp/');
				$csv_file = CSV_PATH . $filename;
				$catmodel = new CategoryMap();
				$categories = $catmodel->getFieldImport($csv_file,$feed_type);		
				unlink('uploads/tmp/'.$filename);
				Yii::$app->getSession()->setFlash('success', Yii::t('app', "All fields imported successfully."));
            
				return $this->redirect(['feed-type/fields','id'=>$id]);
			}
		}else{
			$model->feed_type = $id;
			return $this->render('uploadcategory',['model'=>$model]);
		}
	}
	
}
