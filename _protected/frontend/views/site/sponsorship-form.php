<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;


$this->registerJs("
    var stopValidation = false;
    $( '.category_choice_1','.like_to_host_div','category_choice_2','.like_to_apply_div','pitch_div').hide();
    $('.hear_div').hide();

	$('#characterLeft').text('25 words left');
	$('#descr').keyup(function () {
	    var len = $(this).val().split(' ').length;
	    var count = $(this).val().length;
		var max = 3;
		if (len > max) {
		    $(this).val( $(this).val().substring(0, count-1));
			$('#characterLeft').text(' you have reached the limit');
		} else {
			var ch = max - len;

			$('#characterLeft').text(ch + ' words left');
		}
	});
");

?>

<div class="startup-form-form">
    <div class="col-lg-12 ">

        <div class="row">
            <div class="col-lg-12 well bs-component">
                <h1>Aging2.0 Sponsorship</h1>
                <p>
                    Thank you for sponsoring Aging2.0. Please complete this form to process your payment.
                </p>
            </div>
            <div class="col-lg-12 well bs-component">
                <h1>Contact Info</h1>
            </div>
            <div class="col-lg-12 well bs-component">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                <h2>Personal Information </h2>
                <hr/>

                <?= $form->field($model, 'organization')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['placeholder'=>'ex: myname@example.com','maxlength' => true]) ?>
                <h3>Contact telephone</h3>
                <?= $form->field($model, 'phone_country_code')->textInput(['placeholder'=>'Country Code','maxlength' => true]); ?>
                <?= $form->field($model, 'phone_area_code')->textInput(['placeholder'=>'Area Code','maxlength' => true]) ?>
                <?= $form->field($model, 'phone_number')->textInput(['placeholder'=>'Phone Number','maxlength' => true]) ?>
                <hr>
                <h3>Address</h3>
                <hr/>
                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'street_address')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'address_country')->dropDownList(
                    $model->countries,
                    [
                        'prompt'=>'- Select Country -',
                        'class'=>'form-control select2',
                        'id'=>'country',
                        'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/active-states?id=').'"+$(this).val(), function( data ) {
                                $( "select#state" ).empty();
                                $( "select#city" ).html(data.cities);
                                $( "select#state" ).html( data.states );
                            });'

                    ]
                )
                ?>

                <?= $form->field($model, 'address_state')->dropDownList(
                    array(),
                    [
                        'prompt'=>'- Select State -',
                        'class'=>'form-control select2',
                        'id'=>'state',
                        'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/active-cities?id=').'"+$(this).val(), function( data ) {
                                $( "select#city" ).empty();
                                $( "select#city" ).html( data );
                            });'
                    ]
                )
                ?>
                <?= $form->field($model, 'address_city')->dropDownList(
                    array(),
                    [
                        'prompt'=>'- Select City -',
                        'class'=>'form-control select2',
                        'id'=>'city',
                    ]
                )
                ?>

                <?= $form->field($model, 'address_zip')->textInput(['maxlength' => true]) ?>
                <hr/>
                    <h2>Marketing Info</h2>
                <hr/>

                <?= $form->field($model, 'logo')->widget(FileInput::classname(),
                    [
                        'options' => ['accept' => 'image/*', 'value' => $model->logo],
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                        ]
                    ]);
                ?>
                <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'facebook')->textInput(['placeholder'=>'www.facebook.com/','maxlength' => true]) ?>
                <?= $form->field($model, 'summary')->textarea(['id'=>'summary','rows' => 6])?>
                <?= $form->field($model, 'sponsoring')->dropDownList(
                    $model->sponsor,
                    [
                        'prompt'=>'- Select Sponsor -',
                        'class'=>'form-control select2'

                    ]
                )
                ?>

                <?= $form->field($model, 'sponsoring_other')->dropDownList(
                    $model->chapters,
                    [
                        'prompt'=>'- Select Chapter -',
                        'class'=>'form-control select2'

                    ]
                )
                ?>
                <?= $form->field($model, 'item_description')->textarea(['id'=>'item_description','rows' => 6])?>
                    <hr/>
                    <h2>Sponsorship info</h2>
                    <hr/>
                <?= $form->field($model, 'agreed_amount')->textInput(['placeholder'=>'$$.$$','maxlength' => true]) ?>
                <?= $form->field($model, 'event_date')->widget(\yii\jui\DatePicker::classname(), [
                    'options' =>['class'=> 'form-control'],
                    //'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                ]) ?>
                <?= $form->field($model, 'notes')->textarea(['id'=>'notes','rows' => 6])?>
                <?= $form->field($model, 'preferred_payment')->dropDownList(
                    $model->sponsorpayment,
                    [
                        'prompt'=>'- Select Sponsor Payment
                         Type -',
                        'class'=>'form-control select2'

                    ]
                )
                ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
