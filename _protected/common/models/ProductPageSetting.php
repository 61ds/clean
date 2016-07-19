<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use common\models\Testimonial;

/**
 * This is the model class for table "product_page_setting".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $video
 * @property string $product_slides
 * @property string $name
 *
 * @property Category $category
 */
class ProductPageSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_page_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id','name'], 'required'],
            [['category_id','testimonial'], 'integer'],
            [['video', 'banner', 'testimonial_banner', 'name'], 'string', 'max' => 255],
            [['product_slides'], 'string', 'max' => 2550],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'video' => 'Video',
            'product_slides' => 'Product Slides',
            'testimonial' => 'Select TestiMonial',
            'banner' => 'Banner',
            'testimonial_banner' => 'TestiMonial Banner',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
	public function getTestimonial(){
        $test = Testimonial::find()->where(['status' => 1])->orderBy('name')->all();
        return ArrayHelper::map($test,'id','name');
    }
}
