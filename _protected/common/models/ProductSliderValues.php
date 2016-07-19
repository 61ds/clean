<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_slider_values".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $attr_id
 * @property string $value
 * @property integer $status
 *
 * @property Product $product
 * @property Attributes $attr
 */
class ProductSliderValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_slider_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'attr_id', 'value'], 'required'],
            [['product_id', 'attr_id', 'status'], 'integer'],
            [['value'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['attr_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attributes::className(), 'targetAttribute' => ['attr_id' => 'id']],
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
            'attr_id' => 'Attr ID',
            'value' => 'Value',
            'status' => 'Status',
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
     * @return \yii\db\ActiveQuery
     */
    public function getAttr()
    {
        return $this->hasOne(Attributes::className(), ['id' => 'attr_id']);
    }

    /**
     * @inheritdoc
     * @return ProductSliderValuesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductSliderValuesQuery(get_called_class());
    }
}
