<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "input_type".
 *
 * @property integer $id
 * @property string $input_name
 */
class InputType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'input_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['input_name'], 'required'],
            [['input_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'input_name' => 'Input Name',
        ];
    }
}
