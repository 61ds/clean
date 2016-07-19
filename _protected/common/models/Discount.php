<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "discount".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $coupon_type
 * @property string $coupon_code
 * @property integer $uses_per_coupon
 * @property integer $uses_per_customer
 * @property integer $start_date
 * @property integer $end_date
 * @property integer $discount_type
 * @property integer $discount_amount
 * @property integer $quantity
 * @property integer $quantity_used
 * @property integer $quantity_left
 * @property integer $status
 * @property integer $locked
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property DiscountCode[] $discountCodes
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount';
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
            [['name', 'description', 'coupon_code','start_date', 'end_date', 'discount_amount', 'discount_choice', 'quantity'], 'required'],
            [['coupon_type', 'uses_per_coupon', 'uses_per_customer', 'discount_type', 'discount_choice', 'quantity', 'quantity_used', 'quantity_left', 'status', 'locked', 'created_at', 'updated_at'], 'integer'],
            [['minimum_amount','discount_amount'], 'number'],
            [['name'], 'string', 'max' => 100],
            ['coupon_code', 'unique'],
            [['description'], 'string', 'max' => 1000],
            [['discount_products'], 'safe'],
            [['coupon_code'], 'string', 'max' => 25],
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
            'description' => 'Description',
            'coupon_type' => 'Coupon Type',
            'coupon_code' => 'Coupon Code',
            'uses_per_coupon' => 'Uses Per Coupon',
            'uses_per_customer' => 'Uses Per Customer',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'discount_type' => 'Discount Type',
            'discount_amount' => 'Discount Amount',
            'discount_products' => 'Discount Products',
            'discount_choice' => 'Discount Choice',
            'minimum_amount' => 'Minimum Amount',
            'quantity' => 'Quantity',
            'quantity_used' => 'Quantity Used',
            'quantity_left' => 'Quantity Left',
            'status' => 'Status',
            'locked' => 'Locked',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscountCodes()
    {
        return $this->hasMany(DiscountCode::className(), ['discount_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DiscountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiscountQuery(get_called_class());
    }

    //get all company stage
    public function getAllProducts(){
        $products = Product::find()->where(['status' => 1])->orderBy('id')->all();
        return ArrayHelper::map($products,'id','name');
    }




}
