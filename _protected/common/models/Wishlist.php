<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wishlist".
 *
 * @property integer $client_id
 * @property string $uni_courses
 */
class Wishlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wishlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id'], 'integer'],
            [['products'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'products' => 'Products',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::className(), ['id' => 'client_id']);
    }

    public function getInwishlist($id)
    {
        if(Yii::$app->user->isGuest){
            return true;
        } else {
            $products = unserialize($this->products);
            if(in_array($id,$products)){
                return "false";
            }
            return "true";
        }

    }

    public static function getCoursesCount($userid){

        $products = unserialize(Wishlist::findOne(['client_id'=>$userid])->products);
        $fav_coourses_count = Product::find()->where(['id'=>$products])->count();
        return $fav_coourses_count;

    }

    public static function getWishlistObj(){

        if(Yii::$app->user->isGuest){
            $wishlist = new Wishlist();
        }else{

            $client_id = Yii::$app->user->identity->id;
            if(($wishlist = Wishlist::findOne(['client_id'=> $client_id]))==null){
                $wishlist = new Wishlist();
                $wishlist->client_id = $client_id;
                $wishlist->products = serialize(array());
                $wishlist->save();
            }
        }
        return $wishlist;
    }


    /**
     * @inheritdoc
     * @return WishlistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WishlistQuery(get_called_class());
    }
}
