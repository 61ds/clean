<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "states".
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 *
 * @property Countries $country
 */
class States extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'states';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['country_id'], 'required','message' => Yii::t('app', 'Please select the country to view states')],
            [['country_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 30]
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
            'country_id' => 'Country',
			'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(Cities::className(), ['state_id' => 'id']);
    }
    public function getActivecities()
    {
        return $this->hasMany(Cities::className(), ['state_id' => 'id', 'status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }
	
	public function getCountries(){
		$countries=Countries::find()->orderBy('name')->all();
		return ArrayHelper::map($countries,'id','name');
	}
	//get all cities related to this state model
    public function getStates()
    {

        $states = $this->find()->where(['country_id' => $this->country_id, 'status' => 1])->orderBy('name')->all();
        $html = '<option value="">- Select State -</option>';
        foreach($states as $state){
            $html .= '<option value="'.$state->id.'">'.$state->name.'</option>';
        }
        return $html;
    }
    public function getStatesArray(){
        $states = $this->find()->where(['country_id' => $this->country_id, 'status' => 1])->orderBy('name')->all();
        return ArrayHelper::map($states,'id','name');
    }

    /**
     * @inheritdoc
     * @return StatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatesQuery(get_called_class());
    }
}
