<?php

namespace frontend\controllers;

use common\models\AllcountriesSearch;
use common\models\Attributes;
use common\models\CategoryChoices;
use common\models\HearAbout;
use common\models\CompanyCategory;
use common\models\AttributesSearch;
use common\models\AttributeValues;
use common\models\Cities;
use common\models\CitiesSearch;
use common\models\Countries;
use common\models\CountriesSearch;
use common\models\Entity;
use common\models\InactiveCitiesSearch;
use common\models\InactiveStatesSearch;
use common\models\States;
use common\models\StatesSearch;
use common\traits\AjaxStatusTrait;
use common\traits\StatusChangeTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * CountryController implements the CRUD actions for Countries model.
 */
class StartupController extends FrontendController
{

	public $entity_id = 1;

    public function actionActiveStates($id)
    {
        $model = new States();
        $model->country_id = $id;
        $states = $model->getStates();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'states' => $states,
            'cities' => '<option value="">- Select City -</option>',
        ];
    }
    public function actionActiveCities($id)
    {
        $model = new Cities();
        $model->state_id = $id;
        $cities = $model->getCities();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            $cities
        ];
    }

    public function actionCategoryChoices($id)
    {
        $model = new CategoryChoices();
        $model->category_id = $id;
        $cat =  CompanyCategory::findOne($id);
        $choices = $model->getActiveChoices();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'choices' => $choices,
            'isdescr' => $cat->isdescription,
        ];
    }

    public function actionHearAbout($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (($model = HearAbout::findOne($id)) !== null) {

            return [
                'isdescr' => $model->isdescription,
            ];
        }else{

            return [
                'isdescr' => 0,
            ];
        }

    }
}
