<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setting_textarea_value".
 *
 * @property integer $id
 * @property integer $setting_id
 * @property integer $setting_attribute_id
 * @property string $value
 *
 * @property SettingAttributes $settingAttribute
 * @property Settings $setting
 */
class SettingTextareaValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $content;
    public static function tableName()
    {
        return 'setting_textarea_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_id', 'setting_attribute_id', 'value'], 'required'],
            [['setting_id', 'setting_attribute_id'], 'integer'],
            [['value'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'setting_id' => 'Setting ID',
            'setting_attribute_id' => 'Setting Attribute ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingAttribute()
    {
        return $this->hasOne(SettingAttributes::className(), ['id' => 'setting_attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasOne(Settings::className(), ['id' => 'setting_id']);
    }
}
