<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $fname
 * @property string $lname
 * @property integer $phone
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property User[] $users
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */ 
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fname', 'lname', 'phone'], 'required'],
            [['phone', 'user_id','created_at', 'updated_at'], 'integer'],
            [['fname', 'lname'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'fname' => 'Fname',
            'lname' => 'Lname',
            'phone' => 'Phone',
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
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['profile_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProfileQuery the active query used by this AR class.
     */
   /*  public static function find()
    {
        return new ProfileQuery(get_called_class());
    } */
} 
