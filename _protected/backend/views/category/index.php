<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

use kartik\tree\TreeView;
use common\models\Category;
	
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form ActiveForm */
$this->title = 'Manage Category Tree';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body table-responsive">
				<?php 
					echo TreeView::widget([
						// single query fetch to render the tree
						// use the Product model you have in the previous step
						'query' => Category::find()->addOrderBy('root, lft'), 
						'headingOptions' => ['label' => 'Categories'],
						'fontAwesome' => false,     // optional
						'isAdmin' => true,         // optional (toggle to enable admin mode)
						'displayValue' => 0,        // initial display value
						'softDelete' => true,       // defaults to true
						'cacheSettings' => [        
							'enableCache' => false   // defaults to true
						],
						'nodeActions' => [
							\kartik\tree\Module::NODE_MANAGE => Url::to(['/category/manage']),
							\kartik\tree\Module::NODE_SAVE => Url::to(['/category/save']),
							\kartik\tree\Module::NODE_REMOVE => Url::to(['/category/remove']),
							\kartik\tree\Module::NODE_MOVE => Url::to(['/category/move']),
						],
						'nodeAddlViews' => [
						\kartik\tree\Module::VIEW_PART_2 => '@backend/views/category/custom' // set a path accessible
					]
					]);

					?>
				</div>
			</div>
		</div>
    </div>
</div><!-- category-index -->
