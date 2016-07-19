<?php

use yii\helpers\Html;
use yii\widgets\ListView;

$this->registerJsFile('http://code.jquery.com/ui/1.11.4/jquery-ui.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->view->theme->baseUrl.'/js/custom_ui.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$id = $category->id;
if($id){
	$this->params['breadcrumbs'][] = ['label' => 'Main Categories', 'url' => ['index']];
	$parents = $category->parents();
	if($parents->count()){
		foreach($parents->all() as $parent){
			$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['index', 'id' => $parent->id]];
			$parent_id = $parent->id;
		}
		$this->title = 'Sub Category : '.$category->name;
		$this->params['breadcrumbs'][] = $category->name;
	} else {
		$this->title = 'Main Category : '.$category->name;
		$this->params['breadcrumbs'][] = $category->name;
	}	
} else {
	$this->title = $title;
	$this->params['breadcrumbs'][] = $this->title;
}
$this->params['breadcrumbs'][] = 'Value Sorting';
?>
    <div class="attributes-view">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <p style="margin-bottom:0px;">
                        <?= Html::a('<i class="fa fa-angle-left"></i>Back to Parent Category', ['index', 'id'=> $parent_id], ['class' => 'btn btn-primary']) ?>
						<?= Html::a('Edit Attributes', ['add-attributes','id'=>$category->id], ['class' => 'btn btn-primary']) ?>
                    </p>
                </div>
            </div>
            <div class="box">
			<div class="box-body">	
			<div class="col-md-12">
				<div class="box-header">
					<h3 class="box-title">General Attributes</h3>
				</div>
				<?php
					if(count($general_attrs)){
				?>
                    <ul data-id="<?=$id ?>" class="box-group" id="sortable1">
                        <?php
						
							foreach($general_attrs as $value){
								?>
								<li id="<?= $value->id ?>">
									<i class="fa fa-arrows"></i>
									<?= $value->name ?>
								</li>
								<?php
							}
				?>
				    </ul> 
				<?php
				    } else {
					?>
					<p style="margin-bottom:0px;">
                        <span>No Attributes are found.</span>
						<?= Html::a('Click here to add Attributes', ['add-attributes','id'=>$category->id], ['class' => '']) ?>
                    </p>
				<?php
				    }
                ?>
                   
                </div>

            </div>
        </div>
    </div>
    </div><?php
/**
 * Created by PhpStorm.
 * User: Gurwinder
 * Date: 2/15/2016
 * Time: 4:04 PM
 */