<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "discount_code".
 *
 * @property integer $id
 * @property integer $discount_id
 * @property string $code
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Discount $discount
 */
class DiscountCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount_code';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discount_id', 'code'], 'required'],
            [['discount_id', 'status','locked', 'created_at', 'updated_at'], 'integer'],
            [['code'], 'string', 'max' => 50],
            ['code', 'unique'],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discount_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'discount_id' => 'Discount ID',
            'code' => 'Code',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(Discount::className(), ['id' => 'discount_id']);
    }

    /**
     * @inheritdoc
     * @return DiscountCodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiscountCodeQuery(get_called_class());
    }
}
