<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property string $name
 * @property integer $state_id
 * @property integer $status
 *
 * @property States $state
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'state_id'], 'required'],
            [['state_id', 'status'], 'integer'],
			[['description'], 'string'],
            [['name'], 'string', 'max' => 40]
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
            'state_id' => 'State ID',
			'description' => 'Description',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::className(), ['id' => 'state_id']);
    }

    public function getCities()
    {
        $cities = $this->find()->where(['state_id' => $this->state_id, 'status' => 1])->orderBy('name')->all();
        $html = '<option value="">- Select City -</option>';
        foreach($cities as $city){
            $html .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        return $html;
    }

    public function getCitiesArray(){
        $cities = $this->find()->where(['state_id' => $this->state_id, 'status' => 1])->orderBy('name')->all();
        return ArrayHelper::map($cities,'id','name');
    }

    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }
}
