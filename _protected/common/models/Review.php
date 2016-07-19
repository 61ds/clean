<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $rating
 * @property string $name
 * @property string $summary
 * @property string $review
 * @property integer $product_id
 *
 * @property User $user
 * @property Product $product
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rating', 'name', 'summary', 'review', 'product_id'], 'required'],
            [['user_id', 'rating', 'product_id'], 'integer'],
            [['review'], 'string'],
            [['name', 'summary'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'rating' => 'Rating',
            'name' => 'Name',
            'summary' => 'Summary',
            'review' => 'Review',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
