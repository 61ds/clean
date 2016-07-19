<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_dropdown_values".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $value_id
 * @property integer $status
 *
 * @property Product $product
 * @property DropdownValues $value
 */
class ProductDropdownValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_dropdown_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'value_id'], 'required'],
            [['product_id', 'value_id', 'status'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['value_id'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownValues::className(), 'targetAttribute' => ['value_id' => 'id']],
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
            'value_id' => 'Value ID',
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
    public function getValue()
    {
        return $this->hasOne(DropdownValues::className(), ['id' => 'value_id']);
    }

    /**
     * @inheritdoc
     * @return ProductDropdownValuesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductDropdownValuesQuery(get_called_class());
    }
}
