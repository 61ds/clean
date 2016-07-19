<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "varient_product".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $sku
 * @property integer $color
 * @property integer $size
 * @property integer $width
 * @property integer $price
 * @property integer $status
 *
 * @property Product[] $products
 * @property Product $product
 * @property DropdownValues $color0
 * @property DropdownValues $size0
 * @property DropdownValues $width0
 */
class VarientProduct extends \yii\db\ActiveRecord
{
    public $colors;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'varient_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'sku', 'color', 'colors','size','quantity', 'width'], 'required'],
            [['product_id', 'color', 'size', 'width', 'status'], 'integer'],
            [['sku'], 'string', 'max' => 255],
            [['colors'], 'safe'],
            [['price'], 'number'],
            [['color', 'width','size','product_id'], 'unique', 'targetAttribute' => ['color', 'width','size','product_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['color'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownValues::className(), 'targetAttribute' => ['color' => 'id']],
            [['size'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownValues::className(), 'targetAttribute' => ['size' => 'id']],
            [['width'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownValues::className(), 'targetAttribute' => ['width' => 'id']],
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
            'product_id' => 'Product ID',
            'sku' => 'Sku',
            'color' => 'Color',
            'size' => 'Size',
            'width' => 'Width',
            'price' => 'Price',
            'status' => 'Status',
            'quantity' => 'Quantity',
            'colors' => 'Color',
            'created_at' => 'Color',
            'updated_at' => 'Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['varient_id' => 'id']);
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
    public function getSize0()
    {
        return $this->hasOne(DropdownValues::className(), ['id' => 'size']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidth0()
    {
        return $this->hasOne(DropdownValues::className(), ['id' => 'width']);
    }

    /**
     * @inheritdoc
     * @return VarientProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VarientProductQuery(get_called_class());
    }
    public function getAllcolor()
    {
        $attr = Attributes::find()->where(['name' => 'color'])->one();
        $attrvalues = array();
        if($attr){
            $attrvalues = DropdownValues::find()->where(['attribute_id' => $attr->id])->orderBy('name')->all();
        }
        return ArrayHelper::map($attrvalues,'id','name');
    }
    public function getAllsize()
    {
        $attr = Attributes::find()->where(['name' => 'size'])->one();
        $attrvalues = array();
        if($attr){
            $attrvalues = DropdownValues::find()->where(['attribute_id' => $attr->id])->orderBy('name')->all();
        }
        return ArrayHelper::map($attrvalues,'id','name');
    }
    public function getAllwidth()
    {
        $attr = Attributes::find()->where(['name' => 'width'])->one();
        $attrvalues = array();
        if($attr){
            $attrvalues = DropdownValues::find()->where(['attribute_id' => $attr->id])->orderBy('name')->all();
        }
        return ArrayHelper::map($attrvalues,'id','name');
    }
    public function getAvailattr($id=0,$name)
    {
        $attr = Attributes::find()->where(['name' => $name])->one();

        if($attr){
            $attrvalues = DropdownValues::find()->where(['attribute_id' => $attr->id])->orderBy('name')->all();
            $color_id = $this->find()->where(['product_id' => $id])->andWhere(['<>','quantity', 0])->distinct($name)->select($name)->all();
            $array_color = ArrayHelper::map($attrvalues,'id','name');
            $array_attr = array();
            if($color_id){
                foreach($color_id as $col){
                    $array_attr[] = array('id'=>$col->$name , 'name'=>$array_color[$col->$name]);
                }

            }

        }

        return ArrayHelper::map($array_attr,'id','name');
    }

    public function getQuantity($id=0)
    {
        $product = Product::findOne($id);
        $array_attr[] = array('id'=>'' , 'name'=>'Select Quantity');
        if($product->quantity > 0){
            for($i=1; $i<= $product->quantity; $i++){
                $array_attr[] = array('id'=>$i , 'name'=>$i);
            }
        }

        return ArrayHelper::map($array_attr,'id','name');
    }
}
