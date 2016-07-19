<?php

namespace common\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "cart".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $user_id
 * @property integer $color
 * @property integer $width
 * @property integer $size
 * @property double $quantity
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product $product
 * @property DropdownValues $color0
 * @property DropdownValues $width0
 * @property DropdownValues $size0
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id','color', 'width', 'size', 'quantity'], 'required'],
            [['product_id', 'user_id', 'color', 'width', 'size', 'created_at', 'updated_at'], 'integer'],
            [['quantity'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['color'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownValues::className(), 'targetAttribute' => ['color' => 'id']],
            [['width'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownValues::className(), 'targetAttribute' => ['width' => 'id']],
            [['size'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownValues::className(), 'targetAttribute' => ['size' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'color' => 'Color',
            'width' => 'Width',
            'size' => 'Size',
            'quantity' => 'Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor0()
    {
        return $this->hasOne(DropdownValues::className(), ['id' => 'color']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidth0()
    {
        return $this->hasOne(DropdownValues::className(), ['id' => 'width']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize0()
    {
        return $this->hasOne(DropdownValues::className(), ['id' => 'size']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return CartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CartQuery(get_called_class());
    }

    public static function getCartItemsCount($userid=0){
        if($userid) {
            $query = Cart::find();
            $query->where(['user_id' => $userid]);
            return $query->count();
        }else{
            $session = Yii::$app->session;
            return count($session->get('cart'));
        }
    }

    //get all company stage
    public function getResetCart(){

        $carts = array();
        $session = Yii::$app->session;

        if (!$session->isActive) {
            // open a session
            $session->open();
        }

        if (!Yii::$app->user->isGuest) {
            $carts = array();
            $model = new Cart();
            $cartitems = $model->find()->where(['user_id' => Yii::$app->user->identity->id])->all();
            foreach ($cartitems as $cartitem) {
                $carts[$cartitem->varient_id]['product_id'] = $cartitem->product_id;
                $carts[$cartitem->varient_id]['color'] = $cartitem->color;
                $carts[$cartitem->varient_id]['size'] = $cartitem->size;
                $carts[$cartitem->varient_id]['width'] = $cartitem->width;
                $carts[$cartitem->varient_id]['quantity'] = $cartitem->quantity;
                $carts[$cartitem->varient_id]['id'] = $cartitem->id;
            }
        } else {
            if ($session->has('cart')) {
                $carts = $session->get('cart');
            }

        }
        $cart = array();
        $cart['total'] = 0;
        $cart['discount'] = 0;
        $cart['min']['value'] = 0;
        $cart['min']['id'] = 0;
        $cart['max']['id'] = 0;
        $cart['max']['value'] = 0;


        foreach($carts as $key => $cartitem ){
            if (($product = Product::findOne($cartitem['product_id'])) !== null) {
                if (($varient = VarientProduct::findOne($key)) !== null) {
                    if($varient->quantity < 1)
                        continue;

                }else{
                    continue;
                }
                if(isset($cartitem['id']))
                    $cart['items'][$key]['id'] = $cartitem['id'];



                $cart['items'][$key]['name'] = $product->name;
                $cart['items'][$key]['sku'] = $varient->sku;
                $cart['items'][$key]['color'] = $varient->color0->name;
                $cart['items'][$key]['size'] = $varient->size0->name;
                $cart['items'][$key]['product_id'] = $product->id;
                $cart['items'][$key]['quantity'] = $cartitem['quantity'];
                $cart['items'][$key]['singleprice'] = floatval($product->price + $varient->price);

                $cart['items'][$key]['img'] = Yii::$app->params['baseurl'].'/uploads/product/main/'.$product->id.'/custom1/'.$product->productImages->main_image;
                $cart['items'][$key]['width'] = $varient->width0->name;
                $cart['items'][$key]['discount'] = 0;
                $cart['items'][$key]['price'] = floatval($cartitem['quantity'] * ($product->price + $varient->price));

                if($cart['min']['value'] >  $cart['items'][$key]['singleprice']){
                    $cart['min']['value'] = $cart['items'][$key]['singleprice'];
                    $cart['min']['id'] = $key;
                }
                if($cart['max']['value'] <  $cart['items'][$key]['singleprice']){
                    $cart['max']['value'] = $cart['items'][$key]['singleprice'];
                    $cart['max']['id'] = $key;
                }
                $cart['total'] = floatval($cart['total'] + $cart['items'][$key]['price']);
                $cart['discount'] = floatval($cart['discount'] + $cart['items'][$key]['discount']);
            }else{
                continue;
            }


        }
        $cartModel = new Cart();
        $cartModel->getValidateDiscount();

        return $cart;

    }

    public function getFinalCart(){
        $cartModel = new Cart();
        $cart = $cartModel->getResetCart();

        $session = Yii::$app->session;

        $min_carts = array();
        foreach($cart['items'] as $key => $cartprod){
            if($key != $cart['max']['id'])
                $min_carts[$key] = $cartprod['product_id'];;
        }
        $min_prod = array();
        $min_prod['id'] = 0;
        $min_prod['value'] = 0;
        $cart['discount'] = 0;
        $valid = 0;
        $cart['subtotal'] = $cart['total'];
        $cart['payment_method'] = 1;

        if ($session->has('payment_method')) {
            $cart['payment_method'] = $session->get('payment_method');
        }
        $cart['cod'] = 0;
        if($cart['payment_method'] == 1){
            $cart['cod'] = round((2 * $cart['subtotal'])/100);
        }else{
            $cart['cod'] = 0;
        }
        if ($session->has('discountid')) {
            $discountid = $session->get('discountid');

            $discountModel = DiscountCode::find()->where(['id'=>$discountid,'status'=>0])->one();
            if ($discountModel !== null && $discountModel->discount->status == 1 && $discountModel->discount->locked == 0 && ($discountModel->discount->quantity_left > 0)) {
                $products = unserialize($discountModel->discount->discount_products);
                if ($discountModel->discount->coupon_type == 0) {
                    if($discountModel->discount->discount_choice == 0){
                        if($cart['total'] > $discountModel->discount->minimum_amount) {
                            if ($discountModel->discount->discount_type == 0) {
                                $cart['discount'] = $discountModel->discount->discount_amount;
                            } else {
                                $cart['discount'] = round(($discountModel->discount->discount_amount * ($cart['total'])) / 100);
                            }
                        }


                    }else if($discountModel->discount->discount_choice == 1){
                        if($cart['total'] > $discountModel->discount->minimum_amount) {
                            foreach ($products as $product) {
                                if (in_array($product, $min_carts)) {
                                    $key = array_search($product, $min_carts);
                                    if ($min_prod['id'] == 0 || $min_prod['value'] > $cart['items'][$key]['singleprice']) {
                                        $min_prod['id'] = $key;
                                        $min_prod['value'] = $cart['items'][$key]['singleprice'];
                                        $valid = 1;
                                    }

                                }
                            }
                        }
                        if($valid){
                            if($discountModel->discount->discount_type == 0) {
                                $cart['items'][$min_prod['id']]['discount']  = $discountModel->discount->discount_amount ;
                            }else{
                                $cart['items'][$min_prod['id']]['discount']  = round(($discountModel->discount->discount_amount * ( $cart['items'][$min_prod['id']]['singleprice']))/100) ;
                            }

                        }
                    }else if($discountModel->discount->discount_choice == 2){
                        if($cart['total'] > $discountModel->discount->minimum_amount) {
                            foreach ($products as $product) {
                                if (in_array($product, $min_carts)) {
                                    $key = array_search($product, $min_carts);
                                    if ($discountModel->discount->discount_type == 0) {
                                        $cart['items'][$key]['discount'] = $discountModel->discount->discount_amount;
                                    } else {
                                        $cart['items'][$key]['discount'] = round(($discountModel->discount->discount_amount * ($cart['items'][$key]['singleprice'])) / 100);
                                    }

                                }
                            }
                        }

                    }else if($discountModel->discount->discount_choice == 3){
                        if($cart['total'] > $discountModel->discount->minimum_amount){
                            if($discountModel->discount->discount_type == 0){
                                $cart['discount'] = $discountModel->discount->discount_amount;
                            }else{
                                $cart['discount'] = round(($discountModel->discount->discount_amount * ($cart['total']))/100) ;
                            }
                        }


                    }else if($discountModel->discount->discount_choice == 4){
                        if($cart['total'] > $discountModel->discount->minimum_amount) {
                            foreach ($products as $product) {
                                $productModel = Product::findOne($product);
                                $specials = unserialize($productModel->special);
                                if (count($specials) > 0) {
                                    foreach ($specials as $sproduct) {
                                        if (in_array($sproduct, $min_carts)) {
                                            $key = array_search($sproduct, $min_carts);
                                            if ($discountModel->discount->discount_type == 0) {
                                                $cart['items'][$key]['discount'] = $discountModel->discount->discount_amount;
                                            } else {
                                                $cart['items'][$key]['discount'] = round(($discountModel->discount->discount_amount * ($cart['items'][$sproduct]['singleprice'])) / 100);
                                            }

                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if($discountModel->locked == 1){
                        if($discountModel->discount->discount_choice == 0){
                            if($cart['total'] > $discountModel->discount->minimum_amount) {
                                if ($discountModel->discount->discount_type == 0) {
                                    $cart['discount'] = $discountModel->discount->discount_amount;
                                } else {
                                    $cart['discount'] = round(($discountModel->discount->discount_amount * ($cart['total'])) / 100);
                                }
                            }


                        }else if($discountModel->discount->discount_choice == 1){
                            if($cart['total'] > $discountModel->discount->minimum_amount) {
                                foreach ($products as $product) {
                                    if (in_array($product, $min_carts)) {
                                        $key = array_search($product, $min_carts);
                                        if ($min_prod['id'] == 0 || $min_prod['value'] > $cart['items'][$key]['singleprice']) {
                                            $min_prod['id'] = $key;
                                            $min_prod['value'] = $cart['items'][$key]['singleprice'];
                                            $valid = 1;
                                        }

                                    }
                                }
                            }
                            if($valid){
                                if($discountModel->discount->discount_type == 0) {
                                    $cart['items'][$key]['discount']  = $discountModel->discount->discount_amount ;
                                }else{
                                    $cart['items'][$key]['discount']  = round(($discountModel->discount->discount_amount * ( $cart['items'][$key]['singleprice']))/100) ;
                                }

                            }
                        }else if($discountModel->discount->discount_choice == 2){
                            if($cart['total'] > $discountModel->discount->minimum_amount) {
                                foreach ($products as $product) {
                                    if (in_array($product, $min_carts)) {
                                        $key = array_search($product, $min_carts);
                                        if ($discountModel->discount->discount_type == 0) {
                                            $cart['items'][$key]['discount'] = $discountModel->discount->discount_amount;
                                        } else {
                                            $cart['items'][$key]['discount'] = round(($discountModel->discount->discount_amount * ($cart['items'][$key]['singleprice'])) / 100);
                                        };
                                    }
                                }
                            }

                        }else if($discountModel->discount->discount_choice == 3){

                            if($cart['total'] > $discountModel->discount->minimum_amount) {
                                if ($discountModel->discount->discount_type == 0) {
                                    $cart['discount'] = $discountModel->discount->discount_amount;
                                } else {
                                    $cart['discount'] = round(($discountModel->discount->discount_amount * ($cart['total'])) / 100);
                                }
                            }

                        }else if($discountModel->discount->discount_choice == 4){
                            if($cart['total'] > $discountModel->discount->minimum_amount) {
                                foreach ($products as $product) {
                                    $productModel = Product::findOne($product);
                                    $specials = unserialize($productModel->special);
                                    if (count($specials) > 0) {
                                        foreach ($specials as $sproduct) {
                                            if (in_array($sproduct, $min_carts)) {
                                                $key = array_search($sproduct, $min_carts);
                                                if ($discountModel->discount->discount_type == 0) {
                                                    $cart['items'][$key]['discount'] = $discountModel->discount->discount_amount;
                                                } else {
                                                    $cart['items'][$key]['discount'] = round(($discountModel->discount->discount_amount * ($cart['items'][$key]['singleprice'])) / 100);
                                                }

                                            }
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
            }

        }

        $finalcart['discount'] = 0;
        foreach($cart['items'] as $key => $cartitem ){
                $finalcart['discount'] = floatval($cartitem['discount'] + $finalcart['discount']);
        }
        $cart['total'] =  floatval($cart['total']+ $cart['cod'] - $finalcart['discount'] - $cart['discount']);
        $cart['discount'] = floatval($finalcart['discount'] + $cart['discount']);

        return $cart;
    }

    public function getValidateDiscount()
    {

        $session = Yii::$app->session;
        $cartModel = new Cart();
        if ($session->has('discountid')) {

            $discountid = $session->get('discountid');
            $now = time();

            $discount = DiscountCode::find()->where(['id' => $discountid,'status'=>0])->one();
            if ($discount) {
                $diff = round(abs($now-$discount->updated_at) / 60);

                if($diff > 10){

                    $cartModel->getRemoveDiscount();
                }
            } else {
                $session->remove('discountid');

            }
        }else{
            $cartModel->getRemoveDiscount();
        }
        return true;
    }

    public function getRemoveDiscount()
    {
        $session = Yii::$app->session;
        if ($session->has('discountid')) {

            $discountid = $session->get('discountid');

            $discount = DiscountCode::find()->where(['id' => $discountid,'status'=>0])->one();
            if ($discount) {
                $discount->locked = 0;
                $discount->save();

                $discModel = Discount::findOne($discount->discount_id);
                if($discModel->quantity_used > 0)
                    $discModel->quantity_used = $discModel->quantity_used - 1;
                if($discModel->quantity_left !=  $discModel->quantity)
                 $discModel->quantity_left = $discModel->quantity_left + 1;

                $discModel->save();

                $session->remove('discountid');

            } else {

                $session->remove('discountid');

            }
        }else{

            $discounts = DiscountCode::find()->where(['locked'=>1])->all();
            if ($discounts) {
                $now = time();
                foreach ($discounts as $discount) {
                    $diff = round(abs($now - $discount->updated_at) / 60);

                    if ($diff > 10) {
                        $discount->locked = 0;
                        $discount->save();

                        $discModel = Discount::findOne($discount->discount_id);
                        if($discModel->quantity_used > 0)
                            $discModel->quantity_used = $discModel->quantity_used - 1;
                        if($discModel->quantity_left !=  $discModel->quantity)
                            $discModel->quantity_left = $discModel->quantity_left + 1;
                        $discModel->save();

                    }
                }
            }

        }
        return true;
    }
    /**
     * @param $id
     * @return int
     */
    public function getValidateCart($id){
        $cartModel = new Cart();
        $carts = $cartModel->getResetCart();

        $min_carts = array();
        foreach($carts['items'] as $key => $cartprod){
            if($key != $carts['max']['id'])
                $min_carts[$key] = $cartprod['product_id'];
        }
        $valid =0;

        $discountModel = DiscountCode::find()->where(['code' => $id, 'status' => 0])->one();
        if ($discountModel !== null && $discountModel->discount->status == 1 && $discountModel->discount->locked == 0 && ($discountModel->discount->quantity_left > 0)) {

            $products = unserialize($discountModel->discount->discount_products);

            if ($discountModel->discount->discount_choice == 0) {
                if($carts['total'] > $discountModel->discount->minimum_amount) {
                    $valid = 1;
                }
            } else if ($discountModel->discount->discount_choice == 1 && $discountModel->locked==0) {
                if(count($min_carts) < 1) {
                    return 0;
                }
                if($carts['total'] > $discountModel->discount->minimum_amount) {
                    foreach ($products as $product) {

                        if (in_array($product, $min_carts)) {
                            $valid = 1;
                            break;
                        }
                    }
                }
                if(!$valid){
                    $valid = 2;
                }
            } else if ($discountModel->discount->discount_choice == 2  && $discountModel->locked==0) {
                if(count($min_carts) < 1) {
                    return 0;
                }
                if($carts['total'] > $discountModel->discount->minimum_amount) {
                    foreach ($products as $product) {
                        if (in_array($product, $min_carts)) {
                            $valid = 1;
                            break;
                        }
                    }
                }
                if(!$valid){
                    $valid = 2;
                }

            } else if ($discountModel->discount->discount_choice == 3) {
                if($carts['total'] > $discountModel->discount->minimum_amount){
                    $valid = 1;
                }

            } else if ($discountModel->discount->discount_choice == 4  && $discountModel->locked==0 ) {
                if($carts['total'] > $discountModel->discount->minimum_amount) {
                    if (count($min_carts) < 1) {
                        return 0;
                    }
                    foreach ($products as $product) {
                        $productModel = Product::findOne($product);
                        $specials = unserialize($productModel->special);
                        if (count($specials) > 0) {
                            foreach ($specials as $sproduct) {
                                if (in_array($sproduct, $min_carts)) {
                                    $valid = 1;
                                    break;
                                }
                            }
                        }
                    }
                }
                if(!$valid){
                    $valid = 2;
                }


            }

                return $valid;
            }


    }
}
