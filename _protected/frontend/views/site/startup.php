<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

$this->registerJs("
	$('#characterLeft').text('25 words left');
	$('#descr').keyup(function () {
	    var len = $(this).val().split(' ').length;
	    var count = $(this).val().length;
		var max = 25;
		if (len > max) {
		    $(this).val( $(this).val().substring(0, count-1));
			$('#characterLeft').text(' you have reached the limit');
		} else {
			var ch = max - len;

			$('#characterLeft').text(ch + ' words left');
		}
	});

    $('#startupform-strategic_priority input').change(function () {
        var maxAllowed = 2;

        var cnt = $('#startupform-strategic_priority input:checked').length;

        if (cnt > maxAllowed)
        {
         $(this).prop('checked', false);
        }
    });

    $('#startupform-technology input').change(function () {
      var maxAllowed = 3;

      var cnt = $('#startupform-technology input:checked').length;

      if (cnt > maxAllowed)
      {
         $(this).prop('checked', false);
     }
    });

    $('#category_choice input').change(function () {
      var maxAllowed = 3;

      var cnt = $('#category_choice input:checked').length;

      if (cnt > maxAllowed)
      {
         $(this).prop('checked', false);
     }
    });

");

?>

<div class="startup-form-form">
    <div class="col-lg-12 ">

        <div class="row">
            <div class="col-lg-12 well bs-component">

                <h1>Startup Submission</h1>
                <p>
                    Please fill out this form to submit your company into the Aging2.0 Startup Database.
                    Aging2.0 will use this this information to better understand your startup and to connect
                    you with opportunities across the Aging2.0 network (corporate partner introductions, conference panels,
                    press mentions, investor introductions, events, etc.). This is also the entry form for
                    Aging2.0's 2016 Global Startup Search.
                </p>
                <p>
                    All information will by default be kept within Aging2.0 but please do not submit anything here you wouldn't feel
                    comfortable sharing among customers and partners. Please continue to follow Aging2.0 through our newsletter (<a href="www.aging2.com/join" target="_blank">www.aging2.com/join</a>).
                </p>
                <p>
                    Questions? Contact <a href="mailto:michelle@aging2.com">michelle@aging2.com</a>.
                </p>
            </div>

            <div class="col-lg-12 well bs-component">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <h2>Personal Information </h2>
                    <hr/>
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                     <?= $form->field($model, 'job_title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'linkedin')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'twitter')->textInput(['placeholder'=>'@Aging20','maxlength' => true]) ?>
                     <hr/>
                    <h2>Startup Information</h2>
                    <hr/>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'address')->textInput(['placeholder'=>'Street address','maxlength' => true]) ?>

                    <?= $form->field($model, 'street_address')->textInput(['placeholder'=>'Street address 2','maxlength' => true])->label(false) ?>

                    <?= $form->field($model, 'address_zip')->textInput(['placeholder'=>'Postal / Zip Code ','maxlength' => true])->label(false) ?>

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
                    )->label(false)
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
                    )->label(false)
                    ?>
                    <?= $form->field($model, 'address_city')->dropDownList(
                        array(),
                        [
                            'prompt'=>'- Select City -',
                            'class'=>'form-control select2',
                            'id'=>'city',
                        ]
                    )->label(false)
                    ?>

                    <?= $form->field($model, 'descr',
                        ['template' => '{label}{input}<div id="characterLeft"></div>{error}'])->textarea(['id'=>'descr','rows' => 6]) ?>


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

                    <?= $form->field($model, 'angel_list')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'stage')->dropDownList(
                        $model->stages,
                        [
                            'prompt'=>'- Select Company Stages -',
                            'class'=>'form-control select2',

                        ]
                    )
                    ?>

                    <?= $form->field($model, 'summary')->widget(FileInput::classname(),
                        [
                            'options' => ['accept' => '*', 'value' => $model->summary],
                            'pluginOptions' => [
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                            ]
                        ]);
                    ?>

                    <?= $form->field($model, 'video')->textInput(['placeholder'=>'http://www.vimeo.com...','maxlength' => true]) ?>

                    <?= $form->field($model, 'category')->dropDownList(
                        $model->categories,
                        [
                            'prompt'=>'- Select category -',
                            'class'=>'form-control select2',
                            'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/category-choices?id=').'"+$(this).val(), function( data ) {
                                if(data.isdescr){
                                    $( "#startupform-category_other" ).val("");
                                    $( ".category_choice_1" ).hide();
                                    $( ".category_choice_2" ).show();
                                }else{
                                     $( "#startupform-category_other" ).val("please define");
                                    $( ".category_choice_2" ).hide();
                                    $( "#category_choice" ).html( data.choices );
                                    $( ".category_choice_1" ).show();

                                }
                            });'
                        ]
                    )
                    ?>
                    <div class="category_choice_1">
                        <?= $form->field($model, 'category_choice[]')->checkboxList(array(),['id'=>'category_choice']) ?>
                    </div>
                    <div class="category_choice_2">
                        <?= $form->field($model, 'category_other')->textarea(['rows' => 6]) ?>
                    </div>

                    <?= $form->field($model, 'technology[]')->checkboxList($model->technologies) ?>

                    <?= $form->field($model, 'target_customer')->textInput(['placeholder'=>'Senior, Family Caregiver, Senior Care (AL, IL, SNF)...','maxlength' => true]) ?>

                    <?= $form->field($model, 'business_model')->textInput(['placeholder'=>'B2B, B2C, B2B2C, other (please explain)','maxlength' => true]) ?>

                    <?= $form->field($model, 'competitors')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'capital_raised')->dropDownList(
                        $model->capitals,
                        [
                            'prompt'=>'- Select option -',
                            'class'=>'form-control select2',
                        ]
                    )
                    ?>

                    <?= $form->field($model, 'revenue')->dropDownList(
                        $model->revenues,
                        [
                            'prompt'=>'- Select revenue -',
                            'class'=>'form-control select2',
                        ]
                    )
                    ?>

                    <p>
                        Please note: The 2016 Global Startup Search is aimed primarily at startups with less
                        than $3m in funding and annual revenues, although exceptions will be made
                        in certain circumstances. For more information, contact <a href="mailto:info@aging2.com">info@aging2.com</a>.
                    </p>

                <?= $form->field($model, 'strategic_priority[]')->checkboxList($model->strategicPriorities) ?>

                    <h2>2016 Global Startup Search</h2>

                    <p>Aging2.0's 2016 Global Startup Search is a competition for aging-focused startups to showcase their
                        company to an international audience, be part of a global community and win prizes.
                        Startups can select up to 3 cities in order of preference to apply to pitch at, and the
                        local chapters / organizing cities will be notified of their interest. Please list your city
                        choices below. See more information, and a list of participating cities / countries here: <a target="_blank" href="http://aging2.com/gss">aging2.com/gss</a>.
                    </p>

                    <?= $form->field($model, 'like_to_apply')->dropDownList(
                        ['1'=>'Yes, I would like to be part of the 2016 Search','0'=>' No thank you, I\'d just like to submit my company to the Aging2.0 Startup Database at this time '],
                        [
                            'prompt'=>'- Select option -',
                            'class'=>'form-control select2',
                            'onchange'=> '
                                if($(this).val() == 1){
                                    $(".like_to_apply_div").show();
                                }else{
                                    $(".like_to_apply_div").hide();
                                }
                            '
                        ]
                    )
                    ?>
                    <div class="like_to_apply_div">
                        <?= $form->field($model, 'first_choice')->dropDownList(
                            $model->chapters,
                            [
                                'prompt'=>'- Select choice -',
                                'class'=>'form-control select2',
                            ]
                        )
                        ?>
                        <?= $form->field($model, 'second_choice')->dropDownList(
                            $model->chapters,
                            [
                                'prompt'=>'- Select choice -',
                                'class'=>'form-control select2',
                            ]
                        )
                        ?>

                        <?= $form->field($model, 'third_choice')->dropDownList(
                            $model->chapters,
                            [
                                'prompt'=>'- Select choice -',
                                'class'=>'form-control select2',
                            ]
                        )
                        ?>
                    </div>
                    <?= $form->field($model, 'like_to_host')->dropDownList(
                        ['1'=>'Yes, I would be interested to host / co-organize a local event near me','0'=>'No thanks, I\'ll just check the website for city updates '],
                        [
                            'prompt'=>'- Select option -',
                            'class'=>'form-control select2',
                            'onchange'=> '
                                if($(this).val() == 1){
                                    $(".like_to_host_div").show();
                                }else{
                                    $(".like_to_host_div").hide();
                                }'
                        ]
                    )
                    ?>
                    <div class="like_to_host_div">
                        Please complete <a href="https://form.jotform.com/60397719381970" target="_blank">this form</a> to offer to host an event near you.
                    </div>
                    <p>
                        Local event hosts will contact you in the coming weeks if you're chosen to pitch at their event.
                        See more information at <a href="http://www.aging2.com/gss" target="_blank">www.aging2.com/gss</a>.
                    </p>

                    <?= $form->field($model, 'pitch_events')->dropDownList(
                        ['1'=>'Yes','0'=>'No'],
                        [
                            'prompt'=>'- Select option -',
                            'class'=>'form-control select2',
                            'onchange'=> '
                                if($(this).val() == 1){
                                    $(".pitch_div").show();
                                }else{
                                    $(".pitch_div").hide();
                            }'
                        ]
                    )
                    ?>
                    <div class="pitch_div">
                        <?= $form->field($model, 'pitch_city')->dropDownList(
                            $model->eventsList,
                            [
                                'multiple'=>'multiple',
                                'prompt'=>'- Select option -',
                                'class'=>'form-control select2',
                            ]
                        )
                        ?>

                        <?= $form->field($model, 'pitch_winner')->dropDownList(
                            ['1'=>'Yes','0'=>'No'],
                            [
                                'prompt'=>'- Select option -',
                                'class'=>'form-control select2',
                            ]
                        )
                        ?>
                    </div>

                    <?= $form->field($model, 'why_pitch')->textarea(['rows' => 6]) ?>
                    <hr/>
                    <h2>Additional Opportunities</h2>
                     <hr/>
                    <?= $form->field($model, 'newsletter')->radioList(['1'=>'Yes, sign me up! ','0'=>'No, not at this time']) ?>

                    <?= $form->field($model, 'interested_in_joining')->radioList(['1'=>'Yes, send more more information! ','0'=>'No, not at this time']) ?>

                    <p>
                        <a href="http://www.aging2.com/blog/aarp-foundation-aging2-collaborate-2016-aging-in-place-50k-challenge/" target="_blank">2016 Aging in Place $50K Challenge</a>
                    </p>
                    <p>
                        The AARP Foundation, in collaboration with Aging 2.0, invites startups from across
                        the United States to apply for the 2016 Aging in Place $50K Challenge.
                        Competitors will have a chance to win a $50,000 cash prize for the most innovative
                        solution that will help low-income adults 50 and older continue to live safely,
                        independently and comfortably in their own homes as they age.
                    </p>
                    <p>
                        Applications for the 2016 Aging in Place $50K Challenge are now open and will close on May 2, 2016.
                        The winner will be announced in July 2016.
                    </p>
                    <p>
                        To apply, <a href="https://app.reviewr.com/aarp/site/AARPfoundation" target="_blank">CLICK HERE</a> and follow the instructions to complete your application.
                    </p>

                    <?= $form->field($model, 'hear')->dropDownList(
                        $model->hearAbout,
                        [
                            'prompt'=>'- Select option -',
                            'class'=>'form-control select2',
                            'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('startup/hear-about?id=').'"+$(this).val(), function( data ) {

                                if(data.isdescr == 1){
                                    $("#startupform-hear_other").val("");
                                    $(".hear_div").show();
                                }else{
                                    $("#startupform-hear_other").val("Please define");
                                    $(".hear_div").hide();
                                }
                            });'
                        ]
                    )
                    ?>
                    <div class="hear_div">
                        <?= $form->field($model, 'hear_other')->textarea(['rows' => 6]) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                    </div>

            <?php ActiveForm::end(); ?>
        </div>
        </div>
    </div>
</div>
