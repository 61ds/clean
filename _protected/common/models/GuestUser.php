<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "guest_user".
 *
 * @property integer $id
 * @property string $email
 * @property integer $phone
 * @property string $ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class GuestUser extends \yii\db\ActiveRecord
{
    public $new_account;
    public $password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guest_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'ip','password'], 'required'],
            [['phone', 'status', 'created_at', 'updated_at','new_account'], 'integer'],
            [['email', 'ip'], 'string', 'max' => 50],
            ['email','validateGuest'],
        ];
    }
    public function validateGuest($attribute, $params)
    {
        $users = User::find()->where(['email'=>$this->$attribute])->one();
        if(count($users)>0){
            $this->addError($attribute, 'Account already exist! You cannot checkout as guest');
        }

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
            'email' => 'Email',
            'phone' => 'Phone',
            'ip' => 'Ip',
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return GuestUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GuestUserQuery(get_called_class());
    }
}
