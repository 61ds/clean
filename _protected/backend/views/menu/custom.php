
<?php

	$this->registerJs(
		'$("#menu-selectdata").empty();
		$(".field-menu-selectdata").hide();'
	);

	echo $form->field($node, 'menu_type')->dropDownList(
	$node->menuTypes,
	['prompt'=>'Select Menu Type',
	'onchange'=>'
		
		$("#menu-link").val("");
		if($(this).val() != 2 && $(this).val() != ""){
			$.post( "'.Yii::$app->urlManager->createUrl('menu/values?id=').'"+$(this).val(), function( data ) {
				if(data.result){
					$( "select#menu-selectdata" ).html( data.result );
					$(".field-menu-selectdata").show();
				}
		   });
		}else{
			$("#menu-link").attr("readonly", false);

			$("#menu-link").val("");
			$("#menu-selectdata").empty();
			$(".field-menu-selectdata").hide();
			$(".field-menu-link").show();


		}
	',
	'class'=>'form-control select2']
	);

?>

<?= $form->field($node, 'selectdata')->dropDownList(array(),
	['prompt'=>'Select Data',
	'onchange'=>'
		pid = $("#menu-menu_type").val();
		if(pid != ""){
			url = "";
			if(pid == 1){ url = ""; }

			link = $(this).val();
			name = $("#menu-selectdata option:selected").text();
			$("#menu-link").val(url+""+link+".html");

			linkurl = "slug="+link+"&type="+pid;
			$.post( "'.Yii::$app->urlManager->createUrl('menu/term-value?').'"+linkurl, function( data ) {
				if(data.result){
					$("#menu-term_id").val(data.result);
				}
		   });
			$("#menu-name").val(name);
			$(".field-menu-link").hide();
		}else{
			$("#menu-name").val("");
			$("#menu-link").val("");


		}
	',
	'class'=>'form-control select2'])->label('Select option'); ?>
	
	<?= $form->field($node, 'status')->dropDownList(['1' => 'Active','0' => 'Inactive']); ?>

	<?= $form->field($node, 'term_id')->hiddenInput(); ?>

	<?php
		if($node->menu_type == 1 || $node->menu_type == 3){
			//echo $form->field($node, 'link')->textInput(['maxlength' => true,'readonly'=>true]);
					
		}else{ 
			echo $form->field($node, 'link')->textInput(['maxlength' => true]); 
		}
	?>
					
							