<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assetBundles;

use Yii;
use yii\web\AssetBundle;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BrowseAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';
    public $css = [
        'css/dist/styles.css',
        'css/dist/sweetalert.css',
    ];
    public $js = [
		'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js',
		'js/dist/jquery.lazyload.min.js',
		'js/dist/js.cookie-2.0.3.min.js',
		'js/dist/sweetalert.min.js',
		'js/dist/function.js',
    ];
    public $depends = [
       
    ];
}
