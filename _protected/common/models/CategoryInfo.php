<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category_info".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property string $descr
 * @property string $banner
 * @property string $image
 * @property string $meta_title
 * @property string $meta_descr
 * @property string $meta_key
 *
 * @property Category $cat
 */
class CategoryInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id'], 'required'],
            [['cat_id'], 'integer'],
            [['descr', 'meta_descr', 'meta_key'], 'string'],
            [['banner', 'image', 'meta_title'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'descr' => 'Descr',
            'banner' => 'Banner',
            'image' => 'Image',
            'meta_title' => 'Meta Title',
            'meta_descr' => 'Meta Descr',
            'meta_key' => 'Meta Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }

    /**
     * @inheritdoc
     * @return CategoryInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryInfoQuery(get_called_class());
    }
}
