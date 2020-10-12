<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'home'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('content'); ?>
    <!-- site__body -->
    <div class="site__body inner-body">
        <div class="page-header">
            <div class="page-header__container container">
                <div class="page-header__breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(url('/')); ?>">Home</a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#"><?php echo e($keyword); ?></a>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="block-finder__header text-center">
                    <h1 class="block-finder__title">Search results for <?php echo e($keyword); ?></h1>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="shop-layout shop-layout--sidebar--start">

                <?php if(count($products)>0): ?>
                    <div class="shop-">
                    <div class="block">
                        <div class="products-view">

                            <div class="products-view__list products-list" data-layout="list" data-with-features="false">
                                <div class="products-list__body">
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($obj->variant && $obj->variant->inventory): ?>
                                            <?php if($obj->variant->inventory->sale_price > 0): ?>
                                                <div class="products-list__item prd-filt-list">
                                        <div class="product-card ">

                                            <div class="product-card__badges-list">
                                                <div class="product-card__badge product-card__badge--new"><?php echo e($obj->variant->product->category->category_name); ?></div>
                                            </div>
                                            <div class="product-card__image">

                                                <a href="<?php echo e($obj->variant->slug); ?>">
                                                    <?php if(isset($obj->variant->media)): ?>
                                                            <img src="<?php echo e(asset($obj->variant->media->file_path)); ?>" alt="">
                                                        <?php else: ?>
                                                            <img src="https://via.placeholder.com/300x200" alt="">
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                            <div class="product-card__info">
                                                <h2 class="product-card__name">
                                                    <a href="<?php echo e(url('products/'.$obj->variant->product->slug.'/?variant='.$obj->variant->slug)); ?>"><?php echo e($obj->variant->name); ?></a>
                                                </h2>


                                                <div class="product-card__prices">
                                                    <?php if($obj->variant->inventory): ?>
                                                        MRP: <span><?php echo e(number_format($obj->variant->inventory->sale_price)); ?>/-</span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if($obj->variant->product->variants && count($obj->variant->product->variants)>1): ?>
                                                <div class="product-card__lpd">
                                                    <p class="avial-variables">Available Variants</p>
                                                    <ul class="variant_list">
                                                    <?php $__currentLoopData = $obj->variant->product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><a href="<?php echo e(url('products/'.$o->product->slug.'?variant='.$o->slug)); ?>"><?php echo e($o->name); ?></a></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                                <?php endif; ?>

                                                <div class="product-card__buttons" style="margin-top: 10px">
                                                    <a href="<?php echo e(url('products/'.$obj->variant->product->slug.'/?variant='.$obj->variant->slug)); ?>" class="btn btn-primary" type="button">book now</a>
                                                    <a href="<?php echo e(url('products/'.$obj->variant->product->slug.'/?variant='.$obj->variant->slug)); ?>" class="btn btn-primary" type="button">view details</a>
                                                    <div class="clearfix"></div>
                                                </div>



                                            </div>

                                        </div>
                                    </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-12">
                            No products available
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- site__body / end -->
    <div class="block call-action">
        <div class="container">
            <div class="d-flex justify-content-center">
                <h3>HAVE QUESTIONS?</h3>
                <a>Get In Touch</a>

            </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('head'); ?>
            <style>
                .variant_list{
                    padding: 0px;
                    margin: 0px;
                }
                .variant_list li{
                    display: inline;
                    border: 1px solid #cec8c8;
                    margin-right: 10px;
                    padding: 2px 10px;
                    border-radius: 4px;
                }
                .variant_list li a{
                    color: black;
                }
                .variant_list li a:hover{
                    color: white;
                }


                .variant_list li:hover{
                    color: white;
                    background: #008dd2;
                }

                .avial-variables{
                    padding: 0px;
                    margin: 5px 0px 10px 0px;
                    font-weight: 500;
                    border-bottom: 1px dotted #e8e8e8;
                    width: fit-content;
                }


            </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/search.blade.php ENDPATH**/ ?>