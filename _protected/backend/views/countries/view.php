<?php

use yii\helpers\Html;

$this->registerJsFile('http://code.jquery.com/ui/1.11.4/jquery-ui.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/custom_ui.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->title = $model->name.' - Details';
$this->params['breadcrumbs'][] = ['label' => 'Active Countries', 'url' => ['countries/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['countries/viewstates', 'country_id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cities-view">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <ul class="box-group" id="sortable">

                        <?php
                        foreach($attributes as $attribute){
                            $attribute->item = $model->id;
                            ?>
                            <li id="<?= $attribute->id ?>" class="panel box box-primary">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#sortable" href="#w<?= $attribute->id ?>">
                                            <?= $attribute->name ?>
                                        </a>
                                    </h4>
                                    <span class="pull-right"><?= Html::a('<i class="fa fa-pencil"></i>', ['update-attribute-value', 'id' => $attribute->id,'country'=>$model->id], ['class' => 'text-muted']) ?></span>
                                </div>
                                <div id="w<?= $attribute->id ?>" class="panel-collapse collapse">
                                    <div class="box-body">
                                        <?= $attribute->attrvalue['value']?$attribute->attrvalue['value']:"Not Set"; ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</div>
