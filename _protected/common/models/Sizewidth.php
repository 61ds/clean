<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "sizewidth".
 *
 * @property integer $id
 * @property string $name
 * @property string $size
 * @property string $width
 * @property integer $created_at
 * @property integer $updated_at
 */
class Sizewidth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sizewidth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','size','width'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 100],
            [['size','width'], 'safe'],
        ];
    }
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'size' => 'Size',
            'width' => 'Width',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * @inheritdoc
     * @return SizewidthQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SizewidthQuery(get_called_class());
    }

    public function getAllsize()
    {
        $attr = Attributes::find()->where(['name' => 'size'])->one();
        $attrvalues = array();
        if($attr){
            $attrvalues = DropdownValues::find()->where(['attribute_id' => $attr->id])->orderBy('name')->all();
        }

        return ArrayHelper::map($attrvalues,'id','name');
    }
    public function getAllwidth()
    {
        $attr = Attributes::find()->where(['name' => 'width'])->one();
        $attrvalues = array();
        if($attr){
            $attrvalues = DropdownValues::find()->where(['attribute_id' => $attr->id])->orderBy('name')->all();
        }
        return ArrayHelper::map($attrvalues,'id','name');
    }
}
