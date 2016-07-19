<?php

namespace common\config;

use Yii;
use yii\base\BootstrapInterface;
use common\models\SettingAttributes;
use common\models\Discount;
/*
/* The base class that you use to retrieve the settings from the database
*/

class settings implements BootstrapInterface {

    private $db;

    public function __construct() {
        $this->db = Yii::$app->db;
    }

    /**
    * Bootstrap method to be called during application bootstrap stage.
    * Loads all the settings into the Yii::$app->params array
    * @param Application $app the application currently running
    */

    public function bootstrap($app) {
		$setting_model = new SettingAttributes();
		$set_id = array(1,2,3,4,5);
		foreach($set_id as $set_id1){
			$setting_models = $setting_model->getSiteInfo($set_id1);
			//echo"<pre>";print_r($setting_models);
			foreach ($setting_models as $key => $val) {
				Yii::$app->params['settings'][$key] = $val;
			}				
		}//die;
		Yii::$app->params['adminEmail'] = Yii::$app->params['settings']['admin_mail'];
		Yii::$app->params['siteName'] = Yii::$app->params['settings']['site_meta_title'];

		$session = Yii::$app->session;

		if (!$session->isActive) {
			// open a session
			$session->open();
		}

		if ($session->getHasSessionId()) {

		}else{
			$session->setId(sha1(md5('123'.time())));
		}
		
		//thumb,medium,large image path
		Yii::$app->params['uploadThumbs'] = 'thumbs';
		Yii::$app->params['uploadLarge'] = 'large';
		Yii::$app->params['uploadMedium'] = 'medium';
		Yii::$app->params['uploadMain'] = 'main';
		Yii::$app->params['custom1'] = 'custom1';
		Yii::$app->params['custom2'] = 'custom2';
		Yii::$app->params['custom3'] = 'custom3';
		Yii::$app->params['custom4'] = 'custom4';

		
		Yii::$app->params['baseurl'] = str_replace('/backend','',\Yii::$app->request->baseUrl);
		Yii::$app->params['uploadurl'] = str_replace('/backend','',Yii::getAlias('@webroot'));
		
		Yii::$app->params['folders']['name'] = array('uploadMain','uploadLarge','uploadThumbs','uploadMedium');
		Yii::$app->params['folders']['size'] = array('uploadMain'=>'','uploadLarge'=>'800','uploadThumbs'=>'150','uploadMedium'=>'500');
		
		
		//update all coupon
		$couponModel = Discount::find()->where(['status'=>1])->all();
		foreach($couponModel as $coupon){
			$coupon->locked = 0;
			if($coupon->start_date > time() ){
				$coupon->locked = 1;
			}
			if($coupon->end_date < time() ){
				$coupon->locked = 1;

			}
			$coupon->save();
		}
    }

}