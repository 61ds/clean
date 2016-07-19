<?php
namespace backend\assetBundles;

use Yii;
use yii\base\Exception;
use yii\web\AssetBundle;
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);


/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';
    
    public $css = [
        'css/bootstrap.min.css',
        'css/AdminLTE.min.css',
    ];
    public $js = [
	 'js/app.min.js',
	 'js/custom.js',
    ];
    
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',		
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    public $skin = '_all-skins';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }

        parent::init();
    }
}

