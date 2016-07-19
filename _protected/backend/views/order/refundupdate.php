<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Invoice:#1021';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'invoice';
?>
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Order #<?= $orderdetail['id'] ?>
                <span><span class="label <?php if($orderdetail['payment_status'] == 'Paid'){ echo 'label-success'; }else{ echo 'label-danger'; } ?>"><?= $orderdetail['payment_status'] ?></span>
                <span class="label <?php if($orderdetail['status_id'] == 2 && $orderdetail['status_id'] == 1){ echo 'label-success'; }else{ echo 'label-danger'; } ?>"><?= $orderdetail['status'] ?></span></span>
                <small class="pull-right">Date: <?=  \Yii::t('app', '{0, date}', $orderdetail['created_at']) ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <?= $orderdetail['usertype'] ?>
            <address>
                <strong> <?= $orderdetail['fname'] ?> <?= $orderdetail['lname'] ?></strong><br>
                Phone: <?= $orderdetail['phone'] ?><br>
                Email: <?= $orderdetail['email'] ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Billing Address
            <address>
                <strong> <?= $orderdetail['billing']['fname'] ?> <?= $orderdetail['billing']['lname'] ?></strong><br>
                <?= $orderdetail['billing']['address'] ?><br>
                <?= $orderdetail['billing']['city'] ?>,<?= $orderdetail['billing']['state'] ?>, <?= $orderdetail['billing']['country'] ?> <?= $orderdetail['billing']['zip'] ?><br>
                Phone: <?= $orderdetail['billing']['phone'] ?><br>
                Email: <?= $orderdetail['billing']['email'] ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Shipping Address
            <address>
            <?php if($orderdetail['billing']['is_shipping']){
                ?>
                <strong> <?= $orderdetail['shipping']['fname'] ?> <?= $orderdetail['shipping']['lname'] ?></strong><br>
                <?= $orderdetail['shipping']['address'] ?><br>
                <?= $orderdetail['shipping']['city'] ?>,<?= $orderdetail['shipping']['state'] ?>, <?= $orderdetail['shipping']['country'] ?> <?= $orderdetail['shipping']['zip'] ?><br>
                Phone: <?= $orderdetail['shipping']['phone'] ?><br>
                Email: <?= $orderdetail['shipping']['email'] ?>

                <?php
            }else{
                ?>
                <strong> Same as Billing Adress</strong><br>
                <?php
            } ?>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Article ID #</th>
                    <th>Sku</th>
                    <th>Size:Width:Color</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach( $orderdetail['items'] as $item){ ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['article_id'] ?></td>
                        <td><?= $item['sku'] ?></td>
                        <td><?= $item['size'] ?><br><?= $item['width'] ?><br><?= $item['color'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><i aria-hidden="true" class="fa fa-inr"></i><?= $item['defaultrate'] ?></td>
                        <td><i aria-hidden="true" class="fa fa-inr"></i><?= $item['discount'] ?></td>
                        <td><i aria-hidden="true" class="fa fa-inr"></i><?= $item['total'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <p class="lead">Payment Method: <strong><?= $orderdetail['payment'] ?></strong></p>

            <div class="order-comments">
                <div class="comments">
                    <ul>
                    <?php foreach($comments as $comment){
                    ?>
                        <li><?= $comment->comment ?> <span class="label <?php if($comment->status == 2){ echo 'label-success'; }else{ echo 'label-danger'; } ?>"><?= $comment->status0->name ?></span></span> <small class="pull-right"><?=  \Yii::t('app', '{0, date}', $comment->created_at) ?></small></li>
                    <?php
                    } ?>
                    </ul>
                </div>
                <?php $form = ActiveForm::begin(); ?>


                <?= $form->field($model, 'status')->dropDownList(
                    $model->getOrderStatus(),
                    [
                        'prompt'=>'- Update Order Status -',
                        'class'=>'form-control select2'

                    ]
                )
                ?>
				<?= $form->field($models, 'is_refunded')->dropDownList(
                    array(0 => 'Refund In Progress',1 => 'Refunded',2=>'No Refund Applicable'),
                    [
                        'prompt'=>'- Update Refund Status -',
                        'class'=>'form-control select2'

                    ]
                )
                ?>
                <?= $form->field($model, 'comment')->textArea(['rows' => '3'])->label(false) ?>

                <?= $form->field($model, 'notify')->checkbox(['value' => true])->label(false); ?>
                <div class="form-group">
                    <?= Html::submitButton('Update Order', ['class' =>'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td><i aria-hidden="true" class="fa fa-inr"></i><?= $orderdetail['subtotal'] ?></td>
                    </tr>
                    <tr>
                        <th>Discount</th>
                        <td><i aria-hidden="true" class="fa fa-inr"></i><?= $orderdetail['discount'] ?></td>
                    </tr>
                    <?php if($orderdetail['payment_id'] == 1){ ?>
                    <tr>
                        <th>COD</th>
                        <td><i aria-hidden="true" class="fa fa-inr"></i><?= $orderdetail['cod_charge'] ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th>Shipping:</th>
                        <td><i aria-hidden="true" class="fa fa-inr"></i><?= $orderdetail['shipping'] ?></td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td><i aria-hidden="true" class="fa fa-inr"></i><?= $orderdetail['total'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">

        </div>
    </div>
</section>