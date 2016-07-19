<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category_attributes".
 *
 * @property integer $category_id
 * @property string $attributes
 * @property integer $status
 *
 * @property Category $category
 */
class CategoryAttributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'status'], 'integer'],
            [['general_attributes', 'slider_attributes'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'general_attributes' => 'General Attributes',
            'slider_attributes' => 'Slider Attributes',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     * @return CategoryAttributesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryAttributesQuery(get_called_class());
    }
}
