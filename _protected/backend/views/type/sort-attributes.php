<?php

use yii\helpers\Html;
use yii\widgets\ListView;

$this->registerJsFile('http://code.jquery.com/ui/1.11.4/jquery-ui.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->view->theme->baseUrl.'/js/custom_ui.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->title = $category->name.' - Attribute Sorting';
$this->params['breadcrumbs'][] = ['label' => 'Attributes', 'url' => ['attributes/index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Value Sorting';
?>
    <div class="cities-view">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <p style="margin-bottom:0px;">
                        <?= Html::a('<i class="fa fa-angle-left"></i>Back to '.$category->name, ['view', 'id'=> $category->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Sort Z-A', ['sort-alphabetically', 'id' => $category->id, 'order' => -1], ['class' => 'btn btn-primary pull-right margin-right']) ?>
                        <?= Html::a('Sort A-Z', ['sort-alphabetically',  'id' => $category->id, 'order' => 1], ['class' => 'btn btn-primary pull-right margin-right']) ?>
                    </p>
                </div>
            </div>
            <div class="box box-solid">
                <div class="box-body">
                    <ul class="box-group" id="sortable">
                        <?php
                        foreach($values as $value){
                            ?>
                            <li id="<?= $value->id ?>">
                                <i class="fa fa-arrows"></i>
                                <?= $value->name ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
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