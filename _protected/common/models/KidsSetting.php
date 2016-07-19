<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kids_setting".
 *
 * @property integer $id
 * @property string $img_title
 * @property integer $status
 * @property string $img
 * @property string $url
 */
class KidsSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kids_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_title', 'status', 'url'], 'required'],
            [['status'], 'integer'],
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
            'img_title' => 'Img Title',
            'status' => 'Status',
            'img' => 'Img',
            'url' => 'Url',
        ];
    }
}
