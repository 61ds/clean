<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_type".
 *
 * @property integer $id
 * @property string $name
 */
class MenuType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_type';
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
     * @inheritdoc
     * @return MenuTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuTypeQuery(get_called_class());
    }
}
