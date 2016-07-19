<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\checkbox\CheckboxX;

$this->registerJs("
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
                <h1>New Chapter Application</h1>
            </div>
            <div class="col-lg-12 well bs-component">

                <h1>New Aging2.0 Local Chapter Application</h1>
                <p>Aging2.0 is a global movement and we're looking for help from talented and motivated people to get involved in building up local communities in their area. Please use this form to share a little bit about yourself and why you're interested to become an Aging2.0 volunteer / Ambassador</p>
            </div>
            <div class="col-lg-12 well bs-component">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                <h2>Personal Information </h2>
                <hr/>
                <h4>Full Name</h4>
                <hr>

                <?= $form->field($model, 'first_name')->textInput(['placeholder'=>"First Name",'maxlength' => true]) ?>

                <?= $form->field($model, 'last_name')->textInput(['placeholder'=>"First Name",'maxlength' => true]) ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'organization')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['placeholder'=>'ex: myname@example.com','maxlength' => true]) ?>
                <hr/>
                <h4>Mailing Address</h4>
                <hr>
                <?= $form->field($model, 'address')->textInput(['placeholder'=>"Street Address",'maxlength' => true]) ?>
                <?= $form->field($model, 'street_address')->textInput(['placeholder'=>"Street Address Line 2",'maxlength' => true]) ?>
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
                <?= $form->field($model, 'address_zip')->textInput(["placeholder"=>"Postal / Zip Code",'maxlength' => true]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'personal_twitter')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'work_twitter')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'linkedin')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'organization_website')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'organization_descr')->textarea(['id'=>'organization_descr','rows' => 6])?>

                <?= $form->field($model, 'personal_website')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'summary_bio')->textarea(['id'=>'summary_bio','rows' => 6])?>


                <?= $form->field($model, 'skills')->textarea(['id'=>'skills','rows' => 6])?>
                <?= $form->field($model, 'headshot')->widget(FileInput::classname(),
                    [
                        'options' => ['accept' => 'image/*', 'value' => $model->headshot],
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                        ]
                    ]);
                ?>
                <?= $form->field($model, 'resume')->widget(FileInput::classname(),
                    [
                        'options' => ['accept' => 'file/*', 'value' => $model->resume],
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                        ]
                    ]);
                ?>
                <h2>2. Getting involved</h2>
                <hr/>
                <?= $form->field($model, 'events_attended')->textarea(['id'=>'events_attended','rows' => 6])?>
                <hr/>
                <h4>What STATE (optional) and COUNTRY would you like to start / join an Aging2.0 Chapter</h4>
                <hr>

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
                <?= $form->field($model, 'location_notes')->textarea(['id'=>'location_notes','rows' => 6])?>
                <?= $form->field($model, 'why_get_involved')->textarea(['id'=>'location_notes','rows' => 6])?>

                <?= $form->field($model, 'help_event')->dropDownList(
                    [
                        '1'=>'Yes', '0'=>'No',

                    ]
                )
                ?>

                <?= $form->field($model, 'activities_work')->textarea(['id'=>'activities_work','rows' => 6])?>

                <h4>How would you like to be involved?</h4>
                <hr>
                <?= $form->field($model, 'how_involved[]')->checkboxList($model->howInvolved) ?>
                <hr>
                <h4>How much experience in using web-based community tools (such as Eventbrite, Wordpress etc) </h4>
                <hr>
                <?= $form->field($model, 'experience_web')->radioList($model->webExp) ?>

                <h2>3. Partnerships and Collaborations</h2>
                <hr/>
                <?= $form->field($model, 'organization_affliation')->textarea(['id'=>'organization_affliation','rows' => 6])?>
                <?= $form->field($model, 'ideas_speaker')->textarea(['id'=>'ideas_speaker','rows' => 6])?>
                <?= $form->field($model, 'biggest_challenge')->textarea(['id'=>'biggest_challenge','rows' => 6])?>
                <?= $form->field($model, 'other_info')->textarea(['id'=>'other_info','rows' => 6])?>
                <?= $form->field($model, 'how_involved_other')->textarea(['id'=>'how_involved_other','rows' => 6])?>
                <div class="col-lg-12 well bs-component">
                <p>Values: the values of Aging2.0 are innovation, collaboration and respect for all ages. We expect all people applying for and working with Aging2.0 to uphold these values. </p>
               <p>Policies: please read all of the information at aging2.com/local and check the box below if you understand and agree to the policies outlined there. </p>
               <p>Subject to change: this program is subject to change. We will communicate with you updates about the program and your participation on a regular basis. </p>

                    <?=  $form->field($model, 'acceptance',[
                        'template' => '{label}{input}{error}',
                    ])->widget(CheckboxX::classname(), ['pluginOptions'=>['threeState'=>false]]); ?>
                    <label class="cbx-label" for="ChapterForm[acceptance]">Yes, I understand and am committed to the values and policies of Aging2.0</label>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<style>label {
        width: 100%;
    }</style>