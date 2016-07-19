<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $items_count
 * @property string $price_total
 * @property string $delivery_charges
 * @property string $grand_total
 * @property integer $status
 * @property integer $locked
 * @property integer $payment_method
 * @property integer $payment_status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderItems[] $orderItems
 * @property User $user
 * @property OrderStatus $status0
 * @property PaymentMethods $paymentMethod
 */
class Orders extends \yii\db\ActiveRecord
{

    public $production_url;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_method'], 'required'],
            [['user_id', 'guest_id','is_refunded','refund_request','discount_id', 'items_count', 'status', 'locked', 'payment_method', 'payment_status', 'created_at', 'updated_at'], 'integer'],
            [['price_total', 'delivery_charges', 'grand_total','discount','cod_charge'], 'number'],
            [['production_url'],'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['payment_method'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentMethods::className(), 'targetAttribute' => ['payment_method' => 'id']],
            [['guest_id'], 'exist', 'skipOnError' => true, 'targetClass' => GuestUser::className(), 'targetAttribute' => ['guest_id' => 'id']],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiscountCode::className(), 'targetAttribute' => ['discount_id' => 'id']],
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
            'user_id' => 'User ID',
            'guest_id' => 'Guest ID',
            'items_count' => 'Items Count',
            'cod_charge' => 'COD Charge',
            'price_total' => 'Price Total',
            'delivery_charges' => 'Delivery Charges',
            'grand_total' => 'Grand Total',
            'discount' => 'Discount',
            'discount_id' => 'Discount ID',
            'status' => 'Status',
            'locked' => 'Locked',
            'payment_method' => 'Payment Method',
            'payment_status' => 'Payment Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_refunded' => 'Refund',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);
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
    public function getStatus0()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount0()
    {
        return $this->hasOne(DiscountCode::className(), ['id' => 'discount_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMethod()
    {
        return $this->hasOne(PaymentMethods::className(), ['id' => 'payment_method']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(GuestUser::className(), ['id' => 'guest_id']);
    }

    /**
     * @inheritdoc
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }
    public function getPayments()
    {
        $group = PaymentMethods::find()->orderBy('method')->all();
        return ArrayHelper::map($group,'id','method');
    }

    public function getOrderStatus()
    {
        $group = OrderStatus::find()->orderBy('id')->all();
        return ArrayHelper::map($group,'id','name');
    }
    public function getOrderDetail($id)
    {
        $data = Orders::findOne($id);
        $orderdetail = array();
        $orderdetail['id'] = $data->id;
        $orderdetail['created_at'] = $data->created_at;
        $orderdetail['payment'] = $data->paymentMethod->method;
        $orderdetail['payment_id'] = $data->payment_method;
        $orderdetail['status'] = $data->status0->name;
        $orderdetail['status_id'] = $data->status;
        $orderdetail['subtotal'] = $data->price_total;
        $orderdetail['discount'] = $data->discount;
        $orderdetail['shipping'] = $data->delivery_charges;
        $orderdetail['cod_charge'] = $data->cod_charge;
        $orderdetail['total'] = $data->grand_total;
        if($data->payment_status)
            $orderdetail['payment_status'] = 'Paid';
        else
            $orderdetail['payment_status'] = 'Pending';

        if($data->user_id != ''){
            $orderdetail['usertype'] = 'User Details';
            $add = BillingAddress::find()->where(['user_id'=>$data->user_id])->one();
            $ship = ShippingAddress::find()->where(['user_id'=>$data->user_id])->one();

            $orderdetail['fname'] = $data->user->profiles->fname;
            $orderdetail['lname'] = $data->user->profiles->lname;
            $orderdetail['phone'] = $data->user->profiles->phone;
            $orderdetail['email'] = $data->user->email;
            $orderdetail['id'] = $data->user_id;

            $orderdetail['billing']['fname'] = $add->fname;
            $orderdetail['billing']['lname'] = $add->lname;
            $orderdetail['billing']['address'] = $add->address;
            $orderdetail['billing']['email'] = $add->email;
            $orderdetail['billing']['phone'] = $add->phone;
            $orderdetail['billing']['city'] = $add->city->name;
            $orderdetail['billing']['state'] = $add->state->name;
            $orderdetail['billing']['country'] = $add->country->name;
            $orderdetail['billing']['zip'] = $add->zip;
            $orderdetail['billing']['is_shipping'] = $add->is_shipping;

            if($add->is_shipping != 0){
                $orderdetail['shipping']['fname'] = $ship->fname;
                $orderdetail['shipping']['lname'] = $ship->lname;
                $orderdetail['shipping']['address'] = $ship->address;
                $orderdetail['shipping']['email'] = $ship->email;
                $orderdetail['shipping']['phone'] = $ship->phone;
                $orderdetail['shipping']['city'] = $ship->city->name;
                $orderdetail['shipping']['state'] = $ship->state->name;
                $orderdetail['shipping']['country'] = $ship->country->name;
                $orderdetail['shipping']['zip'] = $ship->zip;
                $orderdetail['shipping']['is_shipping'] = $ship->is_shipping;
            }

        }else{
            $add = BillingAddress::find()->where(['guest_id'=>$data->guest_id])->one();
            $ship = ShippingAddress::find()->where(['guest_id'=>$data->user_id])->one();

            $orderdetail['usertype'] = 'Guest Details';
            $orderdetail['fname'] = $data->guest->fname;
            $orderdetail['lname'] = $data->guest->lname;
            $orderdetail['phone'] = $data->guest->phone;
            $orderdetail['email'] = $data->guest->email;
            $orderdetail['id'] = $data->guest_id;

            $orderdetail['billing']['fname'] = $add->fname;
            $orderdetail['billing']['lname'] = $add->lname;
            $orderdetail['billing']['address'] = $add->address;
            $orderdetail['billing']['email'] = $add->email;
            $orderdetail['billing']['phone'] = $add->phone;
            $orderdetail['billing']['city'] = $add->city->name;
            $orderdetail['billing']['state'] = $add->state->name;
            $orderdetail['billing']['country'] = $add->country->name;
            $orderdetail['billing']['zip'] = $add->zip;
            $orderdetail['billing']['is_shipping'] = $add->is_shipping;

            if($add->is_shipping != 0){
                $orderdetail['shipping']['fname'] = $ship->fname;
                $orderdetail['shipping']['lname'] = $ship->lname;
                $orderdetail['shipping']['address'] = $ship->address;
                $orderdetail['shipping']['email'] = $ship->email;
                $orderdetail['shipping']['phone'] = $ship->phone;
                $orderdetail['shipping']['city'] = $ship->city->name;
                $orderdetail['shipping']['state'] = $ship->state->name;
                $orderdetail['shipping']['country'] = $ship->country->name;
                $orderdetail['shipping']['zip'] = $ship->zip;
                $orderdetail['shipping']['is_shipping'] = $ship->is_shipping;
            }


        }
        foreach($data->orderItems as $item){
            $orderdetail['items'][$item->id]['product_id'] = $item->product_id;
            $orderdetail['items'][$item->id]['name'] = $item->product->name;
            $orderdetail['items'][$item->id]['article_id'] = $item->product->article_id;
            $orderdetail['items'][$item->id]['quantity'] = $item->quantity;
            $orderdetail['items'][$item->id]['defaultrate'] = $item->defaultrate;
            $orderdetail['items'][$item->id]['sku'] = $item->varient->sku;
            $orderdetail['items'][$item->id]['size'] = $item->varient->size0->displayname;
            $orderdetail['items'][$item->id]['width'] = $item->varient->width0->displayname;
            $orderdetail['items'][$item->id]['color'] = $item->varient->color0->displayname;
            $orderdetail['items'][$item->id]['discount'] = $item->discount;
            $orderdetail['items'][$item->id]['total'] = $item->total;
        }

        return $orderdetail;
    }


     public function encrypt($plainText,$key)
    {
        $secretKey = hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
        $plainPad = pkcs5_pad($plainText, $blockSize);
        if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1)
        {
            $encryptedText = mcrypt_generic($openMode, $plainPad);
            mcrypt_generic_deinit($openMode);

        }
        return bin2hex($encryptedText);
    }

    public function decrypt($encryptedText,$key)
    {
        $secretKey = hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText=hextobin($encryptedText);
        $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
        mcrypt_generic_init($openMode, $secretKey, $initVector);
        $decryptedText = mdecrypt_generic($openMode, $encryptedText);
        $decryptedText = rtrim($decryptedText, "\0");
        mcrypt_generic_deinit($openMode);
        return $decryptedText;

    }
    //*********** Padding Function *********************

    public function pkcs5_pad ($plainText, $blockSize)
    {
        $pad = $blockSize - (strlen($plainText) % $blockSize);
        return $plainText . str_repeat(chr($pad), $pad);
    }

    //********** Hexadecimal to Binary function for php 4.0 version ********

    public function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString="";
        $count=0;
        while($count<$length)
        {
            $subString =substr($hexString,$count,2);
            $packedString = pack("H*",$subString);
            if ($count==0)
            {
                $binString=$packedString;
            }

            else
            {
                $binString.=$packedString;
            }

            $count+=2;
        }
        return $binString;
    }

}
