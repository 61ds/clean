<?php
namespace frontend\controllers;

use common\models\CompanyCategory;
use common\models\LoginForm;
use common\models\User;
use common\models\StartupForm;
use common\models\SponsorshipForm;
use common\models\AmbsOnboarding;
use common\models\ChapterForm;
use common\models\HearAbout;
use frontend\models\AccountActivation;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use yii\web\UploadedFile;

use common\traits\ImageUploadTrait;
use common\traits\FileUploadTrait;

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, password reset.
 */
class SiteController extends Controller
{
    use ImageUploadTrait;
    use FileUploadTrait;
    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Declares external actions for the controller.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

//------------------------------------------------------------------------------------------------//
// STATIC PAGES
//------------------------------------------------------------------------------------------------//

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays the about static page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays the contact static page and sends the contact email.
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->contact(Yii::$app->params['adminEmail'])) 
            {
                Yii::$app->session->setFlash('success', 
                    'Thank you for contacting us. We will respond to you as soon as possible.');
            } 
            else 
            {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } 
        
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

//------------------------------------------------------------------------------------------------//
// LOG IN / LOG OUT / PASSWORD RESET
//------------------------------------------------------------------------------------------------//

    /**
     * Logs in the user if his account is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['lwe'];

        // if 'lwe' value is 'true' we instantiate LoginForm in 'lwe' scenario
        $model = $lwe ? new LoginForm(['scenario' => 'lwe']) : new LoginForm();

        // now we can try to log in the user
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
        {
            return $this->goBack();
        }
        // user couldn't be logged in, because he has not activated his account
        elseif($model->notActivated())
        {
            // if his account is not activated, he will have to activate it first
            Yii::$app->session->setFlash('error', 
                'You have to activate your account first. Please check your email.');

            return $this->refresh();
        }    
        // account is activated, but some other errors have happened
        else
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

/*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->sendEmail()) 
            {
                Yii::$app->session->setFlash('success', 
                    'Check your email for further instructions.');

                return $this->goHome();
            } 
            else 
            {
                Yii::$app->session->setFlash('error', 
                    'Sorry, we are unable to reset password for email provided.');
            }
        }
        else
        {
            return $this->render('requestPasswordResetToken', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try 
        {
            $model = new ResetPasswordForm($token);
        } 
        catch (InvalidParamException $e) 
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) 
            && $model->validate() && $model->resetPassword()) 
        {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }
        else
        {
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }       
    }    

//------------------------------------------------------------------------------------------------//
// SIGN UP / ACCOUNT ACTIVATION
//------------------------------------------------------------------------------------------------//

    /**
     * Signs up the user.
     * If user need to activate his account via email, we will display him
     * message with instructions and send him account activation email
     * ( with link containing account activation token ). If activation is not
     * necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary,
     * @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {  
        // get setting value for 'Registration Needs Activation'
        $rna = Yii::$app->params['rna'];

        // if 'rna' value is 'true', we instantiate SignupForm in 'rna' scenario
        $model = $rna ? new SignupForm(['scenario' => 'rna']) : new SignupForm();

        // collect and validate user data
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            // try to save user data in database
            if ($user = $model->signup()) 
            {
                // if user is active he will be logged in automatically ( this will be first user )
                if ($user->status === User::STATUS_ACTIVE)
                {
                    if (Yii::$app->getUser()->login($user)) 
                    {
                        return $this->goHome();
                    }
                }
                // activation is needed, use signupWithActivation()
                else 
                {
                    $this->signupWithActivation($model, $user);

                    return $this->refresh();
                }            
            }
            // user could not be saved in database
            else
            {
                // display error message to user
                Yii::$app->session->setFlash('error', 
                    "We couldn't sign you up, please contact us.");

                // log this error, so we can debug possible problem easier.
                Yii::error('Signup failed! 
                    User '.Html::encode($user->username).' could not sign up.
                    Possible causes: something strange happened while saving user in database.');

                return $this->refresh();
            }
        }
                
        return $this->render('signup', [
            'model' => $model,
        ]);     
    }

    /**
     * Sign up user with activation.
     * User will have to activate his account using activation link that we will
     * send him via email.
     *
     * @param $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // try to send account activation email
        if ($model->sendAccountActivationEmail($user)) 
        {
            Yii::$app->session->setFlash('success', 
                'Hello '.Html::encode($user->username).'. 
                To be able to log in, you need to confirm your registration. 
                Please check your email, we have sent you a message.');
        }
        // email could not be sent
        else 
        {
            // display error message to user
            Yii::$app->session->setFlash('error', 
                "We couldn't send you account activation email, please contact us.");

            // log this error, so we can debug possible problem easier.
            Yii::error('Signup failed! 
                User '.Html::encode($user->username).' could not sign up.
                Possible causes: verification email could not be sent.');
        }
    }

/*--------------------*
 * ACCOUNT ACTIVATION *
 *--------------------*/

    /**
     * Activates the user account so he can log in into system.
     *
     * @param  string $token
     * @return \yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionActivateAccount($token)
    {
        try 
        {
            $user = new AccountActivation($token);
        } 
        catch (InvalidParamException $e) 
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($user->activateAccount()) 
        {
            Yii::$app->session->setFlash('success', 
                'Success! You can now log in. 
                Thank you '.Html::encode($user->username).' for joining us!');
        }
        else
        {
            Yii::$app->session->setFlash('error', 
                ''.Html::encode($user->username).' your account could not be activated, 
                please contact us!');
        }

        return $this->redirect('login');
    }

    /**
     * Displays the about static page.
     *
     * @return string
     */
    public function actionOnboarding()
    {
        $model = new AmbsOnboarding();
        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $logo = UploadedFile::getInstance($model, 'file');

				if($logo)
				{
					$name = time();
					$size = Yii::$app->params['folders']['size'];
					$main_folder = "onborading/docs";
					$image_name= $this->uploadFileDocs($logo,$name,$main_folder,$size);
					$model->file =  $image_name;

				}
                if( $model->preferred_payment == 3){
                $model->account_name = "";
                $model->bank_name = "";
                $model->bank_account = "";
                $model->aba_routing  = "";
                $model->check_to = "";
                $model->bank_address = "";
                $model->bank_street_address = "";
                $model->bank_country =  "0";
                $model->bank_state = "0";
                $model->bank_city = "0";
            }elseif($model->preferred_payment == 1){
                $model->account_name = "";
                $model->bank_name = "";
                $model->bank_account = "";
                $model->aba_routing = "";
                $model->paypal_email = "";
            }else{
                $model->paypal_email = "";
                $model->check_to = "";
            }
			
           // echo"<pre>";print_r($model);die;
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Form has been Submitted successfully!'));
                return $this->redirect(['index']);
            }else{
                echo"<pre>";
                print_r($model->getErrors());
                print_r( $model);die;
            }

        }else{
            return $this->render('chapter-onbording', ['model' => $model]);
        }

    }
    public function actionSponsorship()
    {
        $model = new SponsorshipForm();
        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $logo = UploadedFile::getInstance($model, 'logo');

            if($logo)
            {
                $name = time();
                $size = Yii::$app->params['folders']['size'];
                $main_folder = "sponsor/images";
                $image_name= $this->uploadImage($logo,$name,$main_folder,$size);
                $model->logo =  $image_name;

            }
            $model->event_date =  $timestamp = strtotime($model->event_date);
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Form has been Submitted successfully!'));
                return $this->redirect(['index']);
            }else{
                echo"<pre>";
                print_r($model->getErrors());
                print_r( $model);die;
            }

        }else{
            return $this->render('sponsorship-form', ['model' => $model]);
        }

    }
    public function actionChapter()
    {
        $model = new ChapterForm();
        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $headshot = UploadedFile::getInstance($model, 'headshot');
            $resume = UploadedFile::getInstance($model, 'resume');
            if($headshot)
            {
                $name = time();
                $size = Yii::$app->params['folders']['size'];
                $main_folder = "chapter/images";
                $image_name= $this->uploadImage($headshot,$name,$main_folder,$size);
                $model->headshot =  $image_name;

            }

            if($resume != '')
            {
                $name = time();
                $main_folder = 'chapter/resume';
                $file_name= $this->uploadFileDocs($resume,$name,$main_folder,$size);
                $model->resume = $file_name;
            }


            $model->how_involved = serialize($model->how_involved);
			
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Form has been Submitted successfully!'));
                return $this->redirect(['index']);
            }else{
                echo"<pre>";
                print_r($model->getErrors());
                print_r( $model);die;
            }

        }else {
            return $this->render('chapter-form', ['model' => $model]);
        }
    }
    public function actionStartup()
    {
        $model = new StartupForm();
        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $logo = UploadedFile::getInstance($model, 'logo');
            $summary = UploadedFile::getInstance($model, 'summary');

            if($logo)
            {
                $name = time();
                $size = Yii::$app->params['folders']['size'];
                $main_folder = "startup/images";
                $image_name= $this->uploadImage($logo,$name,$main_folder,$size);
                $model->logo =  $image_name;
            }
            if($summary != '')
            {
                $name = time();
                $main_folder = 'startup/docs';
                $file_name= $this->uploadFile($summary,$name,$main_folder);
                $model->summary = $file_name;
            }

            if (($cat_model = CompanyCategory::findOne($model->category)) !== null) {
                if($cat_model->isdescription != 1){
                    $model->category_other = 'empty';
                }
            }
            if (($hear_model = HearAbout::findOne($model->hear)) !== null) {
                if($hear_model->isdescription != 1){
                    $model->hear_other = 'empty';
                }
            }

            if($model->like_to_apply != 1){
               $model->first_choice = 0;
               $model->second_choice = 0;
               $model->third_choice = 0;
            }

            if ($model->pitch_events != 1){
               $model->pitch_city = 0;
               $model->pitch_winner = 0;
            }

            $model->technology = serialize($model->technology);
            $model->strategic_priority = serialize($model->strategic_priority);
            $model->pitch_city = serialize($model->pitch_city);
            $model->category_choice = serialize($model->category_choice);
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Page has been updated successfully!'));
                return $this->redirect(['index']);
            }

        }else {

            $model->category_other = "other categories";
            $model->first_choice = 1;
            $model->pitch_city = 2;
            $model->hear_other = "please define";
            $model->pitch_winner = 1;

            return $this->render('startup', ['model' => $model]);
        }
    }

}
