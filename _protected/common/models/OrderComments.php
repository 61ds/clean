<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "order_comments".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $status
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Orders $order
 * @property OrderStatus $status0
 */
class OrderComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'status', 'comment'], 'required'],
            [['order_id', 'status', 'created_at', 'updated_at','notify'], 'integer'],
            [['comment'], 'string', 'max' => 1000],
            [['order_id', 'status'], 'unique', 'targetAttribute' => ['order_id', 'status']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::className(), 'targetAttribute' => ['status' => 'id']],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'status' => 'Status',
            'notify' => 'Notify Customer',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status']);
    }

    /**
     * @inheritdoc
     * @return OrderCommentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderCommentsQuery(get_called_class());
    }

    public function getOrderStatus()
    {
        $group = OrderStatus::find()->orderBy('id')->all();
        return ArrayHelper::map($group,'id','name');
    }
}
