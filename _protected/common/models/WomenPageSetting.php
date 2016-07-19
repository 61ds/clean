<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "women_page_setting".
 *
 * @property integer $id
 * @property string $banner1
 * @property string $banner2
 * @property string $banner3
 * @property string $banner4
 * @property string $banner5
 * @property string $banner6
 */
class WomenPageSetting extends \yii\db\ActiveRecord
{
	public $banner11;
	public $banner21;
	public $banner31;
	public $banner41;
	public $banner51;
	public $banner61;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'women_page_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['banner11', 'banner21', 'banner31', 'banner41', 'banner51', 'banner61'], 'safe'],
            [['banner1', 'banner2', 'banner3', 'banner4', 'banner5', 'banner6'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner1' => 'Banner1',
            'banner2' => 'Banner2',
            'banner3' => 'Banner3',
            'banner4' => 'Banner4',
            'banner5' => 'Banner5',
            'banner6' => 'Banner6',
        ];
    }
}
