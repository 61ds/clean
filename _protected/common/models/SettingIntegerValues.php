<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setting_integer_values".
 *
 * @property integer $id
 * @property integer $setting_id
 * @property integer $setting_attribute_id
 * @property integer $value
 *
 * @property Settings $setting
 * @property SettingAttributes $settingAttribute
 */
class SettingIntegerValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting_integer_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_id', 'setting_attribute_id', 'value'], 'required'],
            [['setting_id', 'setting_attribute_id', 'value'], 'integer']
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
    public function getSetting()
    {
        return $this->hasOne(Settings::className(), ['id' => 'setting_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingAttribute()
    {
        return $this->hasOne(SettingAttributes::className(), ['id' => 'setting_attribute_id']);
    }
}
