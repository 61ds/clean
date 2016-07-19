<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $name
 *
 * @property SettingAttributes[] $settingAttributes
 * @property SettingIntegerValues[] $settingIntegerValues
 * @property SettingTextValues[] $settingTextValues
 * @property SettingTextareaValue[] $settingTextareaValues
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingAttributes()
    {
        return $this->hasMany(SettingAttributes::className(), ['setting_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingIntegerValues()
    {
        return $this->hasMany(SettingIntegerValues::className(), ['setting_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingTextValues()
    {
        return $this->hasMany(SettingTextValues::className(), ['setting_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingTextareaValues()
    {
        return $this->hasMany(SettingTextareaValue::className(), ['setting_id' => 'id']);
    }
}
