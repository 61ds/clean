<?php

namespace common\models;

use Yii;
use common\models\CategoryInfo;
/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property string $name
 * @property integer $status
 * @property string $slug
 * @property string $icon
 * @property integer $icon_type
 * @property integer $active
 * @property integer $selected
 * @property integer $disabled
 * @property integer $readonly
 * @property integer $visible
 * @property integer $collapsed
 * @property integer $movable_u
 * @property integer $movable_d
 * @property integer $movable_l
 * @property integer $movable_r
 * @property integer $removable
 * @property integer $removable_all
 */
class Category extends \kartik\tree\models\Tree
{

    public $image;
    public $meta_key;
    public $descr;
    public $meta_descr;
    public $meta_title;
    public $banner;
    public $video;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['descr', 'safe'];
        $rules[] = ['slug', 'string'];
        $rules[] = ['status', 'integer'];
        $rules[] = [['image','banner','video','meta_descr','meta_title'], 'safe'];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'lvl' => 'Lvl',
            'name' => 'Name',
            'status' => 'Status',
            'slug' => 'Slug',
            'icon' => 'Icon',
            'icon_type' => 'Icon Type',
            'active' => 'Active',
            'selected' => 'Selected',
            'disabled' => 'Disabled',
            'readonly' => 'Readonly',
            'visible' => 'Visible',
            'collapsed' => 'Collapsed',
            'movable_u' => 'Movable U',
            'movable_d' => 'Movable D',
            'movable_l' => 'Movable L',
            'movable_r' => 'Movable R',
            'removable' => 'Removable',
            'removable_all' => 'Removable All',
        ];
    }
    public function getCategoryAttributes()
    {
        $model = CategoryAttributes::findOne(['category_id' => $this->id]);
        return $model;
    }

    public function getCreateAttrsModel()
    {
        $model = new CategoryAttributes();
        $model->category_id = $this->id;
        $model->general_attributes = serialize(array());
        $model->slider_attributes = serialize(array());
        $model->save();
        return $model;
    }
    public function getCategories($id){

    }
    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
	public function getCatBanner()
    {
        return $this->hasOne(CategoryInfo::className(), ['cat_id' => 'id']);
    }
}
