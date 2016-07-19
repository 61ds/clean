<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Generate Items';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('
function validateSelect(){
    var value = $("#varientproduct-colors").val();
    if(value == null || value ==""){
        $(".field-varientproduct-colors").addClass("has-error");
         $(".help-block").show();
          $("#w0").attr("disable", "disabled");
        return event.preventDefault();

    }else{
        $("#w0").removeAttr( "disable" )
        $(".field-varientproduct-colors").removeClass("has-error");
        $(".help-block").hide();
    }
}
$("button.btn-success").click(function(){
    validateSelect();
});
$("#varientproduct-colors").change(function(){
    validateSelect();
});
$("#varientproduct-colors").select(function(){
    validateSelect();
});
');
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'colors')->dropDownList(
        $model->allcolor,
        [
            'prompt'=>'- Select color -',
            'class'=>'form-control select2 required',
            'multiple' => 'multiple'

        ]
    );
    ?>
    <div class="help-block" style="display:none; color:red;">Please Select atleast One.</div>

    <div class="form-group">
        <?= Html::submitButton('Generate', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
