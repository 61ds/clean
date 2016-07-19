<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $status
 * @property string $meta_keywords
 * @property string $meta_desc
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'description'], 'required'],
            [['description'], 'string'],
            [['status'], 'integer'],
            [['name', 'slug', 'meta_keywords', 'meta_desc', 'meta_title', 'featured_image'], 'string', 'max' => 255],
            [['slug'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'status' => 'Status',
            'meta_keywords' => 'Meta Keywords',
            'meta_desc' => 'Meta Description',
            'meta_title' => 'Meta Title',
            'featured_image' => 'Featured Image',
        ];
    }

    /**
     * @inheritdoc
     * @return PagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PagesQuery(get_called_class());
    }
	public function getFeaturedImage($ids)
	{
		$programs = Pages::find('featured_image')->where(['id'=>$ids])->one();
		return $programs;
	}
}
