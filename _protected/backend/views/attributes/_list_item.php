<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<li id="<?= $model->id ?>" class="panel box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">
            <a data-toggle="collapse" data-parent="#sortable" href="#w<?= $model->id ?>">
                <?= $model->name ?>
            </a>
        </h4>
        <span class="pull-right"><?= Html::a('<i class="fa fa-pencil"></i>', ['update-attribute-value', 'id' => $model->id,'university'=>$model->id], ['class' => 'text-muted']) ?></span>
    </div>
    <div id="w<?= $model->id ?>" class="panel-collapse collapse">
        <div class="box-body">

        </div>
    </div>
</li>