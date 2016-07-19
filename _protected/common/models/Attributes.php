<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "attributes".
 *
 * @property integer $id
 * @property string $name
 * @property integer $entity_id
 * @property string $lower_limit
 * @property string $upper_limit
 * @property integer $status
 *
 * @property Entity $entity
 */
class Attributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name', 'entity_id'], 'required'],
            [['parent_id','entity_id', 'mtype', 'filterable', 'searchable', 'isvariant', 'status'], 'integer'],
            [['lower_limit', 'upper_limit'], 'integer'],
            [['upper_limit'], 'compare', 'compareAttribute'=>'lower_limit','type'=>'number', 'operator'=>'>=', 'skipOnEmpty'=>true, 'message'=>''],
            [['name', 'display_name'], 'string', 'max' => 100]
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
            'parent_id' => 'Parent Attribute',
            'entity_id' => 'Attribute Category',
            'lower_limit' => 'Lower Limit',
            'upper_limit' => 'Upper Limit',
            'mtype' => 'Measurement Position',
            'filterable' => 'Filterable',
            'searchable' => 'Searchable',
            'isvariant' => 'Use as Variant',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(Entity::className(), ['id' => 'entity_id']);
    }
    public function getEntities()
    {
        $programs = Entity::find()->orderBy('name')->all();
        return ArrayHelper::map($programs,'id','name');
    }
	public function getAllAttributes()
    {
        $attributes = $this->find()->orderBy('name')->all();
		$arr = ArrayHelper::map($attributes,'id','name');
		return array("0"=>"Default Attribute") + $arr;
    }
	public function getDropdownValues()
    {
        $attr_values = DropdownValues::find()->where(['attribute_id' => $this->id])->orderBy('sort_order');

        return $attr_values;
        //return $this->hasMany(DropdownValues::className(), ['attribute_id' => 'id']);
    }
    public function getDropdownValuesAsc()
    {
        $attr_values = DropdownValues::find()->where(['attribute_id' => $this->id])->orderBy(['name' => SORT_ASC])->all();
        $i = 1;
        foreach($attr_values as $value){
            $model = DropdownValues::findOne($value->id);
            $model->sort_order = $i;
            $model->save();
            $i++;
        }
    }
    public function getDropdownValuesDesc()
    {
        $attr_values = DropdownValues::find()->where(['attribute_id' => $this->id])->orderBy(['name' => SORT_DESC])->all();

        $i = 1;
        foreach ($attr_values as $value) {
            $model = DropdownValues::findOne($value->id);
            $model->sort_order = $i;
            $model->save();
            $i++;
        }
    }
    public function getEntityfilter(){
        $arr = array();
        $entities=Entity::find()->orderBy('name')->all();
        foreach($entities as $entity){
            $arr[$entity->id] = $entity->name;
        }
        return $arr;
    }

    /**
     * @inheritdoc
     * @return AttributesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AttributesQuery(get_called_class());
    }
}
