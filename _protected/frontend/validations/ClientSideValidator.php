<?php
namespace frontend\validations;

use common\models\ChapterForm;
use yii\validators\Validator;

class ClientSideValidator extends Validator
{

    public function init()
    {
        parent::init();
        $this->message = 'field is required.';
    }

    public function validateAttribute($model, $attribute)
    {
    /*https://github.com/yiisoft/yii2/blob/master/docs/guide/input-validation.md#using-client-side-validation-*/
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
            $emails = json_encode(ChapterForm::find()->select('email')->asArray()->column());
            $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            return <<<JS
        var def = $.Deferred();

            if (value != '') {
            stopValidation = true;
            def.reject();
            }
            if (attribute.name=='email') {
                if ($.inArray(value, $emails) === -1) {
                    messages.push('Email not exist, please enter your previous email which you entered while submitting chapter form.If still facing issue contact Us');
                }
            }
            if (value == '') {

                    messages.push($message);
                    def.resolve();

            }

            deferred.push(def);
JS;
        }


}