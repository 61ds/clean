<?php
namespace common\models;

use yii\base\Model;
use Yii;
class RegistrationForm extends Model
{
	// use ModuleTrait;
    /**
     * Add a new field
     * @var string
     */
    public $phone;
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['phone', 'required'];
        $rules[] = ['fname', 'required'];
        $rules[] = ['email', 'required'];
        $rules[] = ['lname', 'required'];
        $rules[] = ['phone', 'integer'];
        $rules[] = ['fname', 'string'];
        $rules[] = ['lname', 'string'];
        $rules[] = ['email', 'email'];
        unset($rules['usernameRequired']);
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['phone'] = \Yii::t('user', 'phone');
        return $labels;
    }

    /**
     * @inheritdoc
     */
 
    public function register()
    {
		
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);
		$user->username = $this->email;
        if (!$user->register()) {
            return false;
        }

        if (($profile = Profile::findOne($user->id)) !== null) {

            $profile->updateAttributes(['fname' => $this->fname , 'phone' => $this->phone]);	
		}else{

			$profile = new Profile();
			$profile->id = $user->id;
			$profile->fname = $this->fname;
			$profile->lname = $this->lname;
			$profile->email = $this->email;	
			$profile->phone = $this->phone;	
			$profile->save();
		}
	
		
        return true;
    }
	

}