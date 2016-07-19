<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model common\models\AmbsOnboarding */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("
            var stopValidation = false;
            $('#address_all').find('input').val('0');
            $('#check_transfer').find('input').val('0');
            $('#bank_transfer').find('input').val('0');
            $('#paypal_transfer').find('input').val('0');
            $('#bank_country').val('1');
            $('#bank_state').append('<option value=1>My option</option>');
            $('#bank_state').val('1');
    $('#ambsonboarding-preferred_payment').change(function () {
      var value = $(this).val();

      if(value == 1){
            $('#bank_transfer').hide();
            $('#paypal_transfer').hide();
            $('#check_transfer').show();
            $('#address_all').show();
            $('#address_all').find('input').val('');
            $('#check_transfer').find('input').val('');
            $('#bank_transfer').find('input').val(0);
            $('#paypal_transfer').find('input').val(0);
      }else if(value == 2){
            $('#check_transfer').hide();
            $('#paypal_transfer').hide();
            $('#bank_transfer').show();
            $('#address_all').show();
            $('#address_all').find('input').val('');
            $('#check_transfer').find('input').val('0');
            $('#bank_transfer').find('input').val('');
            $('#paypal_transfer').find('input').val('0');
      }else if(value == 3){
            $('#check_transfer').hide();
            $('#paypal_transfer').show();
            $('#bank_transfer').hide();
            $('#address_all').hide();
            $('#address_all').find('input').val('0');
            $('#check_transfer').find('input').val('0');
            $('#bank_transfer').find('input').val('0');
            $('#paypal_transfer').find('input').val('');
            $('#bank_country').val('1');
            $('#bank_state').append('<option value=1>My option</option>');
            $('#bank_state').val('1');
      }else{
            $('#check_transfer').hide();
            $('#paypal_transfer').hide();
            $('#bank_transfer').hide();
            $('#address_all').hide();
            $('#address_all').find('input').val('0');
            $('#check_transfer').find('input').val('0');
            $('#bank_transfer').find('input').val('0');
            $('#paypal_transfer').find('input').val('0');
            $('#bank_country').val('1');
            $('#bank_state').append('<option value=1>My option</option>');
            $('#bank_state').val('1');
      }
    });


");
?>

<div class="startup-form-form">
    <div class="col-lg-12 ">

        <div class="row">



            <div class="col-lg-12 well bs-component">

                <h1> Aging2.0 Chapter Onboarding</h1>
                <p>Congratulations on being approved to run an Aging2.0 Chapter! Please complete this form which includes the License Agreement and financial information so that we can ensure that you receive Chapter revenues. Please review the Chapter rules here: http://j.mp/a2chapter-groundrules</p>
            </div>
    <div class="col-lg-12 well bs-component">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
        <h2>1. Ambassador information</h2>
        <hr/>
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <h4>Phone Number</h4>
     <hr>
    <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <?= $form->field($model, 'country_code')->textInput() ?>
    </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
        <?= $form->field($model, 'area_code')->textInput() ?>
    </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
        <?= $form->field($model, 'phone_number')->textInput() ?>
    </div>
    </div>

        <h2>2. Chapter information</h2>

        <hr/>
        <?= $form->field($model, 'chapter')->dropDownList(
            $model->chapters,
            [
                'prompt'=>'- Select Chapter -',
                'class'=>'form-control select2'

            ]
        )
        ?>
    <?= $form->field($model, 'chapter_country')->dropDownList(
        $model->countries,
        [
            'prompt'=>'- Select Country -',
            'class'=>'form-control select2',
            'id'=>'chapter_country',
            'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/active-states?id=').'"+$(this).val(), function( data ) {
                                $( "select#chapter_state" ).empty();
                                $( "select#chapter_city" ).html(data.cities);
                                $( "select#chapter_state" ).html( data.states );
                            });'

        ]
    )
    ?>

    <?= $form->field($model, 'chapter_state')->dropDownList(
        array(),
        [
            'prompt'=>'- Select State -',
            'class'=>'form-control select2',
            'id'=>'chapter_state',
            'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/active-cities?id=').'"+$(this).val(), function( data ) {
                                $( "select#chapter_city" ).empty();
                                $( "select#chapter_city" ).html( data );
                            });'
        ]
    )
    ?>
    <?= $form->field($model, 'chapter_city')->dropDownList(
        array(),
        [
            'prompt'=>'- Select City -',
            'class'=>'form-control select2',
            'id'=>'chapter_city',
        ]
    )
    ?>

    <?= $form->field($model, 'twitter_handle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chapter_email')->textInput(['maxlength' => true]) ?>
    <hr><h4>Chapter mailing address </h4><hr>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'street_address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address_country')->dropDownList(
        $model->countries,
        [
            'prompt'=>'- Select Country -',
            'class'=>'form-control select2',
            'id'=>'address_country',
            'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/active-states?id=').'"+$(this).val(), function( data ) {
                                $( "select#address_state" ).empty();
                                $( "select#address_city" ).html(data.cities);
                                $( "select#address_state" ).html( data.states );
                            });'

        ]
    )
    ?>

    <?= $form->field($model, 'address_state')->dropDownList(
        array(),
        [
            'prompt'=>'- Select State -',
            'class'=>'form-control select2',
            'id'=>'address_state',
            'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/active-cities?id=').'"+$(this).val(), function( data ) {
                                $( "select#address_city" ).empty();
                                $( "select#address_city" ).html( data );
                            });'
        ]
    )
    ?>
    <?= $form->field($model, 'address_city')->dropDownList(
        array(),
        [
            'prompt'=>'- Select City -',
            'class'=>'form-control select2',
            'id'=>'address_city',
        ]
    )
    ?>


    <?= $form->field($model, 'address_zip')->textInput() ?>
        <h2>3. Aging2.0 License Form</h2>
        <hr/>
        <p>Please complete the Aging2.0 License Agreement. It is mandatory that all active Chapters have a signed active License Agreement, which is current for 12 months. This document provides you a license to use the Aging2.0 brand in connection with your Chapter activities, and provides a simple partnership framework.  </p>
        <hr/>
        <h2>4. Tax Information</h2>
        <hr/>
        <h4>Important information re taxes</h4>
        <hr>
        <p>
            We need the tax information of the person or organization receiving money for the Chapter. No payments will be made without a completed W-9 (U.S.-based individuals / organizations) or a W-8 (non-U.S.-based individuals)
        </p>
        <h5><a href="http://j.mp/aging2-w9">Complete the W9 here </a>(US)</h5>
        <h5><a href="http://bit.ly/aging2-w8">Complete the W8 here </a>(US)</h5>
        <h6>For additional questions on this please contact the Aging2.0 Controller:</h6>
        <h6><a href="mailto:kduwa@formationdevelopment.com">kduwa@formationdevelopment.com</a></h6>
     <?= $form->field($model, 'file')->widget(FileInput::classname(),
            [
                'options' => ['accept' => 'file/*', 'value' => $model->file],
                'pluginOptions' => [
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                ]
            ]);
     ?>



    <?= $form->field($model, 'preferred_payment')->dropDownList(
            [
                ''=>'- Select Payment -', '1'=>'Check', '2'=>'Electronic Bank Transfer','3'=>'Paypal',

            ]
        )
    ?>
    <div id="bank_transfer" style="display:none">
        <?= $form->field($model, 'account_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bank_account')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'aba_routing')->textInput(['maxlength' => true]) ?>
    </div>
    <div id="check_transfer" style="display:none">
        <?= $form->field($model, 'check_to')->textInput(['maxlength' => true]) ?>
    </div>
    <div id="address_all" style="display:none">
        <?= $form->field($model, 'bank_address')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bank_street_address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'bank_country')->dropDownList(
            $model->countries,
            [
                'prompt'=>'- Select Country -',
                'class'=>'form-control select2',
                'id'=>'bank_country',
                'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/active-states?id=').'"+$(this).val(), function( data ) {
                                $( "select#bank_state" ).empty();
                                $( "select#bank_city" ).html(data.cities);
                                $( "select#bank_state" ).html( data.states );
                            });'

            ]
        )
        ?>

        <?= $form->field($model, 'bank_state')->dropDownList(
            array(),
            [
                'prompt'=>'- Select State -',
                'class'=>'form-control select2',
                'id'=>'bank_state',
                'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/active-cities?id=').'"+$(this).val(), function( data ) {
                                $( "select#bank_city" ).empty();
                                $( "select#bank_city" ).html( data );
                            });'
            ]
        )
        ?>
        <?= $form->field($model, 'bank_city')->dropDownList(
            array(),
            [
                'prompt'=>'- Select City -',
                'class'=>'form-control select2',
                'id'=>'bank_city',
            ]
        )
        ?>

        <?= $form->field($model, 'bank_zip')->textInput() ?>
    </div>
    <div id="paypal_transfer" style="display:none">
        <?= $form->field($model, 'paypal_email')->textInput(['maxlength' => true]) ?>
    </div>

    <h2>6. Final Checklist</h2>
    <hr/>
    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

        </div>
      </div>
  </div>
</div>
<style>label {
        width: 100%;
    }</style>
