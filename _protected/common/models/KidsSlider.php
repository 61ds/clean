<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kids_slider".
 *
 * @property integer $id
 * @property string $img_title
 * @property string $img
 * @property string $url
 */
class KidsSlider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kids_slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_title', 'img', 'url'], 'required'],
            [['img_title', 'img', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img_title' => 'Alt Title',
            'img' => 'Image',
            'url' => 'Link',
        ];
    }
}
