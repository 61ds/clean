<?php

namespace common\models;
use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "billing_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $fname
 * @property string $lname
 * @property string $address
 * @property string $email
 * @property integer $phone
 * @property string $company
 * @property integer $city_id
 * @property integer $state_id
 * @property integer $country_id
 * @property integer $zip
 * @property integer $is_shipping
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property Cities $city
 * @property States $state
 * @property Countries $country
 */
class BillingAddress extends \yii\db\ActiveRecord
{
    public $confirm_email;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'billing_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fname', 'lname', 'address', 'email', 'phone', 'company', 'city_id', 'state_id', 'country_id', 'zip', 'is_shipping'], 'required'],
            [['user_id', 'guest_id', 'phone', 'city_id', 'state_id', 'country_id', 'zip', 'is_shipping', 'created_at', 'updated_at'], 'integer'],
            [['fname', 'lname'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 250],
            [['email', 'company'], 'string', 'max' => 100],
            ['confirm_email', 'compare', 'compareAttribute' => 'email', 'operator' => '=='],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['guest_id'], 'exist', 'skipOnError' => true, 'targetClass' => GuestUser::className(), 'targetAttribute' => ['guest_id' => 'id']],
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
            'fname' => 'First name',
            'lname' => 'Last name',
            'address' => 'Address',
            'email' => 'Email',
            'phone' => 'Phone',
            'company' => 'Company',
            'city_id' => 'City ',
            'state_id' => 'State ',
            'country_id' => 'Country ',
            'zip' => 'Zip',
            'is_shipping' => 'Is Shipping',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::className(), ['id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(GuestUser::className(), ['id' => 'guest_id']);
    }
	public function getCities(){
        $cities = Cities::find()->where(['status' => 1])->orderBy('name')->all();
        return ArrayHelper::map($cities,'id','name');
    }
	public function getIndiacity($state){
        $cities = Cities::find()->where(['status' => 1,'state_id' => $state])->orderBy('name')->all();
        return ArrayHelper::map($cities,'id','name');
    }
    //get all states
    public function getIndiastates()
    {
        $states = States::find()->where(['status' => 1,'country_id' => 101])->orderBy('name')->all();
        return ArrayHelper::map($states,'id','name');
    } 
	public function getStates()
    {
        $states = States::find()->where(['status' => 1])->orderBy('name')->all();
        return ArrayHelper::map($states,'id','name');
    }

    //get all countries
    public function getCountries()
    {
        $countries = Countries::find()->where(['status' => 1])->orderBy('name')->all();
        return ArrayHelper::map($countries,'id','name');
    }

    /**
     * @inheritdoc
     * @return BillingAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BillingAddressQuery(get_called_class());
    }
}
