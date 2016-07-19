<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<?php 

	// VIEW - views/product/index.php
	use kartik\tree\TreeView;
	use common\models\Menu;
	echo TreeView::widget([
		// single query fetch to render the tree
		// use the Product model you have in the previous step
		'query' => Menu::find()->addOrderBy('root, lft'), 
		'headingOptions' => ['label' => 'Menu'],
		'fontAwesome' => false,     // optional
		'isAdmin' => true,         // optional (toggle to enable admin mode)
		'displayValue' => 0,        // initial display value
		'softDelete' => true,       // defaults to true
		'cacheSettings' => [        
			'enableCache' => true   // defaults to true
		],
		'nodeAddlViews' => [
		\kartik\tree\Module::VIEW_PART_2 => '@backend/views/menu/custom' // set a path accessible
	]
	]);

	?>


</div>
