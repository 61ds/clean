<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dropdown_values".
 *
 * @property integer $id
 * @property string $name
 * @property integer $attribute_id
 * @property integer $sort_order
 * @property integer $status
 *
 * @property Attributes $attribute
 */
class DropdownValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dropdown_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'attribute_id'], 'required'],
            [['attribute_id', 'sort_order', 'status'], 'integer'],
            ['name', 'unique', 'targetAttribute' => ['name', 'attribute_id']],
            [['name','displayname'], 'string', 'max' => 50]
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
            'attribute_id' => 'Attribute ID',
            'display_name' => 'Display Name',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttr()
    {
        return $this->hasOne(Attributes::className(), ['id' => 'attribute_id']);
    }

    /**
     * @inheritdoc
     * @return DropdownValuesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DropdownValuesQuery(get_called_class());
    }
	
	public function getAttrValues($id=0){		
		$attrvalues = DropdownValues::find()->where(['attribute_id' => $id])->orderBy('sort_order')->all();
		$arr = array();
		foreach($attrvalues as $val){
			$values[] = ['id'=>$val->id,'name'=>$val->name];
		}
		$attrvalues = ArrayHelper::map($values,'id','name');
		
		return $attrvalues;		
	}

}

