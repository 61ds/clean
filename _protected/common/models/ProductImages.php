<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_images".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $main_image
 * @property string $filp_image
 * @property string $other_image
 *
 * @property Product $product
 */
class ProductImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
            [['product_id'], 'integer'],
            [['other_image'], 'string'],
            [['main_image', 'flip_image','home_image'], 'string', 'max' => 100],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'main_image' => 'Main Image',
            'flip_image' => 'Flip Image',
            'other_image' => 'Other Image',
            'home_image' => 'Home Image',
            'video' => 'featured Video',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return ProductImagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductImagesQuery(get_called_class());
    }
}
