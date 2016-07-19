<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "entity".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 *
 * @property Attributes[] $attributes
 */
class Entity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 100]
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
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrs()
    {
        return $this->hasMany(Attributes::className(), ['entity_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return EntityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EntityQuery(get_called_class());
    }
}
