<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>



        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    [
                        'label' => 'Orders Management',
                        'icon' => 'fa fa-product-hunt',
                        'url' => 'javascript:void(0);',
                        'items' => [
                            ['label' => 'All Orders', 'icon' => 'fa fa-angle-right', 'url' => ['/order'],'active' => ($this->context->route == 'order/index'),],
							['label' => 'Refunds Request', 'icon' => 'fa fa-angle-right', 'url' => ['/order/refund'],'active' => ($this->context->route == 'order/refund'),],

                        ],
                    ],
                    [
                        'label' => 'Pages Management',
                        'icon' => 'fa fa-product-hunt',
                        'url' => 'javascript:void(0);',
                        'items' => [
                            ['label' => 'All Pages', 'icon' => 'fa fa-angle-right', 'url' => ['/pages'],'active' => ($this->context->route == 'pages/index'),],
                            ['label' => 'Add Page', 'icon' => 'fa fa-angle-right', 'url' => ['/pages/create'],'active' => ($this->context->route == 'pages/create'),],

                        ],
                    ],
                    [
                        'label' => 'Product Management',
                        'icon' => 'fa fa-sitemap',
                        'url' => '#',
                        'items' => [
                            ['label' => 'All products/Articles', 'icon' => 'fa fa-angle-right', 'url' => ['/product'],'active' => ($this->context->route == 'product/index'|| $this->context->route == 'varient-product/create'|| $this->context->route == 'varient-product/index'|| $this->context->route == 'varient-product/update'),],
                            ['label' => 'Add products', 'icon' => 'fa fa-angle-right', 'url' => ['/product/create'],'active' => ($this->context->route == 'product/create'),],
                            ['label' => 'Size width category', 'icon' => 'fa fa-angle-right', 'url' => ['/sizewidth'],'active' => ($this->context->route == 'sizewidth/index' || $this->context->route == 'sizewidth/create' || $this->context->route == 'sizewidth/index'),],
                            ['label' => 'Product Page Setting', 'icon' => 'fa fa-angle-right', 'url' => ['/product-page-setting'],'active' => ($this->context->route == 'product-page-setting/index' || $this->context->route == 'product-page-setting/create' || $this->context->route == 'product-page-setting/index'),],
							['label' => 'Women Page Listing', 'icon' => 'fa fa-angle-right', 'url' => ['/women-page-setting'],'active' => ($this->context->route == 'women-page-setting/index' || $this->context->route == 'product-page-setting/create' || $this->context->route == 'women-page-setting/update'),],
							['label' => 'Kids Slider below Banner', 'icon' => 'fa fa-angle-right', 'url' => ['/kids-slider'],'active' => ($this->context->route == 'kids-slider/index' || $this->context->route == 'kids-slider/create' || $this->context->route == 'kids-slider/update'),],
                            ['label' => 'Kids Footer', 'icon' => 'fa fa-angle-right', 'url' => ['/kids-setting'],'active' => ($this->context->route == 'kids-setting/index' || $this->context->route == 'kids-setting/create' || $this->context->route == 'kids-setting/update'),],
                        ],
                    ],
					[   'label' => 'Import Products',
                        'icon' => 'fa fa-cogs',
                        'url' => ['/product/upload'],
                        	
					],	
                    [
                        'label' => 'Category Management',
                        'icon' => 'fa fa-sitemap',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Category Tree', 'icon' => 'fa fa-angle-right', 'url' => ['/category'],'active' => ($this->context->route == 'category/index'),],
                            ['label' => 'Add/Remove Attributes', 'icon' => 'fa fa-angle-right', 'url' => ['/type'],'active' => ($this->context->route == 'type/index'),],
                        ],
                    ],

                    [
                        'label' => 'Attribute Management',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Attributes', 'icon' => 'fa fa-angle-right', 'url' => ['/attributes'],'active' => ($this->context->route == 'attributes/index')],
                            ['label' => 'Input Type', 'icon' => 'fa fa-angle-right', 'url' => ['/entity'],'active' => ($this->context->route == 'entity/index')],
                        ],
                    ],
                    [
                        'label' => 'Slider Management',
                        'icon' => 'fa fa-picture-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'All Slider', 'icon' => 'fa fa-file-image-o ', 'url' => ['/slider'],],
                            ['label' => 'Add New Slider', 'icon' => 'fa fa-plus', 'url' => ['/slider/create'],],
                        ],
                    ],

                    [
                        'label' => 'Coupon Management',
                        'icon' => 'fa fa-commenting-o',
                        'url' => 'javascript:void(0);',
                        'items' => [
                            ['label' => 'All Coupons', 'icon' => 'fa fa-angle-right', 'url' => ['/discount'],'active' => ($this->context->route == 'discount/index' || $this->context->route == 'discount-code/create' || $this->context->route == 'discount/update' || $this->context->route == 'discount-code/update' || $this->context->route == 'discount-code/index'),],
                            ['label' => 'Add Coupon', 'icon' => 'fa fa-angle-right', 'url' => ['/discount/create'],'active' => ($this->context->route == 'discount/create'),],

                        ],
                    ],
                    [
                        'label' => 'Testimonial Management',
                        'icon' => 'fa fa-commenting-o',
                        'url' => 'javascript:void(0);',
                        'items' => [
                            ['label' => 'All Testimonials', 'icon' => 'fa fa-angle-right', 'url' => ['/testimonial'],'active' => ($this->context->route == 'testimonial/index'),],
                            ['label' => 'Add testimonial', 'icon' => 'fa fa-angle-right', 'url' => ['/testimonial/create'],'active' => ($this->context->route == 'testimonial/create'),],

                        ],
                    ],
					[
                        'label' => 'Newsletter Subscriber',
                        'icon' => 'fa fa-newspaper-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'All Subscribers', 'icon' => 'fa fa-newspaper-o ', 'url' => ['/newsletter'],],
                            ['label' => 'Add New Subscriber', 'icon' => 'fa fa-plus', 'url' => ['/newsletter/create'],],
                        ],
                    ],
                    [
                        'label' => 'User Management',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'All Users', 'icon' => 'fa fa-file-code-o', 'url' => ['/user'],'active' => ($this->context->route == 'user/index')],
                            ['label' => 'Add New User', 'icon' => 'fa fa-dashboard', 'url' => ['/user/create'],'active' => ($this->context->route == 'user/create')],
                        ],
                    ],
                    [
                        'label' => 'Location Management',
                        'icon' => 'fa fa-map-marker',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Active Countries', 'icon' => 'fa fa-angle-right', 'url' => ['countries/index'],'active' => ($this->context->route == 'countries/index' || $this->context->route == 'countries/viewstates' || $this->context->route == 'countries/inactive-states' || $this->context->route == 'countries/viewcities' || $this->context->route == 'countries/inactive-cities')],
                            ['label' => 'All Countries', 'icon' => 'fa fa-angle-right', 'url' => ['/countries/all'],'active' => ($this->context->route == 'countries/all')],
                        ],
                    ],

                    ['label' => 'Menu Management', 'icon' => 'fa fa-bars', 'url' => ['/menu'],'active' => ($this->context->route == 'menu/index'),],

                    [   'label' => 'Website Settings',
                        'icon' => 'fa fa-cogs',
                        'url' => ['/setting-attributes/globalsetting'],

                    ],
                ],

            ]
        ) ?>
    </section>

</aside>
