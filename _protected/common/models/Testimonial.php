<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use  yii\db\ActiveRecord;
/**
 * This is the model class for table "testimonial".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_descr
 * @property string $descr
 * @property string $feat_image
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Testimonial extends ActiveRecord
{
    public function behaviors()
    {
        return [
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
			],
		];
	}	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testimonial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'descr'], 'required'],
            [['short_descr', 'descr'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'feat_image'], 'string', 'max' => 255]
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
            'short_descr' => 'Short Descr',
            'descr' => 'Descr',
            'feat_image' => 'Feat Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return TestimonialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestimonialQuery(get_called_class());
    }
}
