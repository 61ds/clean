<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property integer $seller_id
 * @property integer $category_id
 * @property integer $quantity
 * @property integer $price
 * @property integer $market_price
 * @property string $banner
 * @property string $images
 * @property string $description
 * @property integer $status
 * @property integer $soldout
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Category $category
 * @property User $seller
 */
class ProductForm extends Model
{
	public $category;
	public $step;


    public function rules()
    {
        return [
            [['category'], 'required'],
            [['seller_id', 'category_id', 'quantity', 'price', 'market_price', 'status', 'soldout'], 'integer'],
            [['description','related'], 'string'],
            [['name','special'], 'string', 'max' => 110],
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
            'seller_id' => 'Seller ID',
            'category[1]' => 'Category1',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'market_price' => 'Market Price',
            'description' => 'Description',
            'status' => 'Status',
            'soldout' => 'Soldout',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'special' => 'Special Product',
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
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
	public function getCategories($id=0){
		if($id){
			$category = Category::findOne(['id' => $id]);
			$query = $category->children(1);
		} else {
			$query = Category::find()->where(['lvl'=>0]);
		}		
		
		$arr = array();
		foreach($query->all() as $q){
			$arr[] = ['id'=>$q->id,'name'=>$q->name];
		}
		$categories = ArrayHelper::map($arr,'id','name');
		
		return $categories;		
	}
	public function getCategoriesCount($id){
		$category = Category::findOne(['id' => $id]);
		$query = $category->children(1);
		
		$arr = array();
		foreach($query->all() as $q){
			$arr[] = ['id'=>$q->id,'name'=>$q->name];
		}
	
		
		return count($arr);		
	}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(User::className(), ['id' => 'seller_id']);
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

}
