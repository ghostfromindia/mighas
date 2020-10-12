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
                            <li class="breadcrumb-item active" aria-current="page"><?php echo e($variant->name); ?></li>
                        </ol>
                    </nav>


                </div>
            </div>
        </div>
        <div class="block">
            <div class="container">
                <div class="product product--layout--standard" data-layout="standard">
                    <div class="product__content">

                        <!-- .product__gallery -->
                        <div class="product__gallery" >
                            <div class="product-gallery sticky" >
                                <div class="product-gallery__featured single-img-slide">
                                    <button class="product-gallery__zoom">
                                        <svg width="24px" height="24px">
                                            <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#zoom-in-24"></use>
                                        </svg>
                                    </button>
                                    <div class="owl-carousel" id="product-image">
                                        <?php if($variant->media): ?>
                                            <a href="<?php echo e(asset($variant->media->file_path)); ?>" target="_blank">
                                                <img src="<?php echo e(asset($variant->media->file_path)); ?>" alt="">
                                            </a>
                                        <?php else: ?>
                                            <a href="https://via.placeholder.com/500x500" target="_blank">
                                                <img src="https://via.placeholder.com/500x500" alt="">
                                            </a>
                                        <?php endif; ?>

                                        <?php if(isset($gallery)): ?>
                                            <a href="images/prd-1.png" target="_blank">
                                                <img src="images/prd-1.png" alt="">
                                            </a>
                                            <a href="images/prd-1.png" target="_blank">
                                                <img src="images/prd-1.png" alt="">
                                            </a>
                                            <a href="images/prd-1.png" target="_blank">
                                                <img src="images/prd-1.png" alt="">
                                            </a>
                                            <a href="images/prd-1.png" target="_blank">
                                                <img src="images/prd-1.png" alt="">
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="product-gallery__carousel thumb-slider">
                                    <div class="owl-carousel" id="product-carousel">
                                        <?php if($variant->media): ?>
                                            <a href="#" class="product-gallery__carousel-item">
                                                <img class="product-gallery__carousel-image"src="<?php echo e(asset($variant->media->file_path)); ?>" alt="">
                                            </a>
                                        <?php else: ?>
                                            <a href="#" class="product-gallery__carousel-item">
                                                <img class="product-gallery__carousel-image"src="https://via.placeholder.com/500x500" alt="">
                                            </a>
                                        <?php endif; ?>

                                        <?php if(isset($gallery)): ?>
                                            <a href="#" class="product-gallery__carousel-item">
                                                <img class="product-gallery__carousel-image" src="images/prd-1.png" alt="">
                                            </a>
                                            <a href="#" class="product-gallery__carousel-item">
                                                <img class="product-gallery__carousel-image" src="images/prd-1.png" alt="">
                                            </a>
                                            <a href="#" class="product-gallery__carousel-item">
                                                <img class="product-gallery__carousel-image" src="images/prd-1.png" alt="">
                                            </a>
                                            <a href="#" class="product-gallery__carousel-item">
                                                <img class="product-gallery__carousel-image" src="images/prd-1.png" alt="">
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- .product__gallery / end -->


                        <div class="  bg-white hykon-product-view">

                            <!-- .product__info -->

                            <div class="row">


                                <div class="col-md-8 ">

                                    <div class="product__info">
                                        <div class="product__wishlist-compare">
                                            <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="Wishlist">
                                                <svg width="16px" height="16px">
                                                    <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#wishlist-16"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="Compare">
                                                <svg width="16px" height="16px">
                                                    <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#compare-16"></use>
                                                </svg>
                                            </button>
                                        </div>
                                        <h1 class="product__name"><?php echo e($variant->name); ?></h1>

                                        <?php if(!empty($variant->inventory) && $variant->inventory->sale_price>0 ): ?>
                                        <div class="product__sidebar price-cnre  web-dis-none mob-dis-block">

                                            <p>M.R.P: <?php echo e($variant->inventory->retail_price); ?></p>
                                            <h5>You Save: ₹ 2000 (20%)</h5>
                                            <span> Inclusive of all taxes</span>
                                            <div class="product__prices">
                                                <?php echo e($variant->inventory->sale_price); ?>

                                            </div>

                                            <div class="web-dis-none mob-dis-block mob-btn-cntr">
                                                <div class="btn-cntr">
                                                    <form action="<?php echo e(url('cart/save')); ?>" method="post">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="variant_id" value="<?php echo e(encrypt($variant->id)); ?>">
                                                        <input type="hidden" name="quantity" value="<?php echo e(encrypt('1')); ?>">
                                                        <button type="submit" class="btn btn-primary btn-lg">book now</button>
                                                    </form>
                                                </div>
                                                <div class="btn-cntr">
                                                    <a class="btn btn-primary btn-clr-2 btn-lg" href="<?php echo e(url('company/buying-guide')); ?>" target="_blank">BUYING GUIDE</a>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <?php endif; ?>







                                        <?php if(!empty($product->variants) && count($product->variants)>1): ?>
                                            <div class="form-group product__option">
                                                <div class="input-radio-label">
                                                    <div class="input-radio-label__list">
                                                        <label class="product__option-label">Variants</label>
                                                        <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <label>
                                                            <a href="<?php echo e(url('products/'.$product->slug.'?variant='.$obj->slug)); ?>">
                                                                <span><?php echo e($obj->name); ?></span>
                                                            </a>
                                                        </label>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>


                                        <div class="product__description">
                                            <?php echo $product->top_description; ?>

                                        </div>


                                        <div class="del-policy">

                                            <h4><a href="<?php echo e(url('company/delivery-polices')); ?>" target="_blank"><i class="fas fa-truck"></i> Delivery Polices <i class="fa fa-arrow-right" aria-hidden="true"></i></a></h4>
                                            <?php if(auth()->guard()->check()): ?>
                                                <?php if(isset($variant)): ?>
                                                    <?php if(\App\Models\WishList::is_in($variant->id,\Illuminate\Support\Facades\Auth::user()->id)): ?>
                                                            <p style="margin-bottom: 0px"><i class="fas fa-heart "></i> Added in wishlist - <a
                                                                        href="<?php echo e(url('wishlist')); ?>">view wishlist</a></p>
                                                                <a href="javascript:void(0)"  class="add-to-wishlist" data-variant="<?php echo e(encrypt($variant->id)); ?>" alt="Remove from wishlist" style="font-size: 12px;
    font-weight: 600;
    color: #790000;"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a>
                                                        <?php else: ?>
                                                            <p class="add-to-wishlist" data-variant="<?php echo e(encrypt($variant->id)); ?>"><i class="fas fa-heart "></i> Add to wishlist</p>
                                                        <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            



                                        </div>

                                       




                                    </div>
                                </div>



                                <div class="col-md-4">
                                    <?php if(!empty($variant->inventory) && $variant->inventory->sale_price>0 ): ?>
                                        <div class="product__sidebar price-cnre  mob-dis-none">
                                            <p>M.R.P: <?php echo e(number_format($variant->inventory->retail_price)); ?></p>
                                            <?php if($variant->inventory->retail_price != $variant->inventory->sale_price): ?>
                                                <h5>You Save: ₹ <?php echo e(number_format($variant->inventory->retail_price-$variant->inventory->sale_price)); ?>

                                                    <?php $discount = $variant->inventory->retail_price-$variant->inventory->sale_price; ?>
                                                    (<?php echo e(round(($discount*100)/$variant->inventory->retail_price)); ?>%)</h5>
                                            <?php endif; ?>
                                            <span> Inclusive of all taxes</span>
                                            <div class="product__prices">
                                                ₹ <?php echo e(number_format($variant->inventory->sale_price)); ?>/-
                                            </div>

                                            <div class="btn-cntr">
                                                <form action="<?php echo e(url('cart/save')); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="variant_id" value="<?php echo e(encrypt($variant->id)); ?>">
                                                    <input type="hidden" name="quantity" value="<?php echo e(encrypt('1')); ?>">
                                                    <button type="submit" class="btn btn-primary btn-lg">book now</button>
                                                </form>
                                            </div>
                                            <div class="btn-cntr">
                                                <a class="btn btn-primary btn-clr-2 btn-lg"  href="<?php echo e(url('company/buying-guide')); ?>" target="_blank">BUYING GUIDE</a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>


                            </div>




                            <!-- .product__info / end -->




                        </div>










                    </div>
                </div>
            </div>
        </div>








        <!-- .block-products-carousel -->
        <div class="block block-products-carousel hykon-product-view" data-layout="grid-5">










            <div class="container">



                <div class="product-tabs prd-dtl-cntr">
                    <div class="product-tabs__list">
                        <?php if($variant->short_description != null): ?>
                        <a href="#tab-description" class="product-tabs__item product-tabs__item--active"><span>Description</span></a>
                        <?php endif; ?>
                        <?php if(count($attributes)>1): ?>
                        <a href="#tab-specification" class="product-tabs__item"><span>Specification</span></a>
                        <?php endif; ?>

                    </div>
                    <div class="product-tabs__content">
                        <?php if($variant->short_description != null): ?>
                        <div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
                            <div class="typography">
                               <?php echo $variant->short_description; ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(count($attributes)>1): ?>
                        <div class="product-tabs__pane" id="tab-specification">
                            <div class="spec">
                                <h3 class="spec__header">Specification</h3>
                                <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="spec__section">
                                    <h4 class="spec__section-title"><?php echo e($key); ?></h4>
                                    <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="spec__row">
                                        <div class="spec__name"><?php echo e($obj->attribute_name); ?></div>
                                        <div class="spec__value"><?php echo e($obj->attribute_value); ?></div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="spec__disclaimer" data-key="attribute-warning">
                                    <?php echo e(Key::get('attribute-warning')); ?>

                                </div>
                            </div>
                        </div>
                        <?php endif; ?>






                    </div>
                </div>



            </div>
        </div>


        <div class="block block-products-carousel hykon-product-view" data-layout="grid-5">










            <div class="container">





            <?php if($related && count($related)>1): ?>

                <div class="block-header rel-prd-cntr">
                    <h3 class="block-header__title">
                        <span>Related Products</span></h3>



                    <div class="block-header__arrows-list mob-dis-none">
                        <button class="block-header__arrow block-header__arrow--left" type="button">
                            <svg width="7px" height="11px">
                                <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-left-7x11"></use>
                            </svg>
                        </button>
                        <button class="block-header__arrow block-header__arrow--right" type="button">
                            <svg width="7px" height="11px">
                                <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-right-7x11"></use>
                            </svg>
                        </button>
                    </div>
                </div>


                <div class="block-products-carousel__slider rel-prd-cntr mob-dis-none">
                    <div class="block-products-carousel__preloader"></div>
                    <div class="owl-carousel">


                        <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="block-products-carousel__column">
                            <div class="block-products-carousel__cell">

                                <div class="product-card ">

                                    <div class="product-card__image">
                                        <?php if(isset($obj->default->media)): ?>
                                            <a href="<?php echo e(url('products/'.$obj->slug)); ?>"><img src="<?php echo e(asset($obj->default->media->file_path)); ?>" alt=""></a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-card__info">
                                        <div class="product-card__name">
                                            <a href="<?php echo e(url('products/'.$obj->slug)); ?>"><?php echo e($obj->product_name); ?> </a>
                                        </div>
                                        <?php if(isset($obj->default->inventory)): ?>
                                        <div class="btn-cntr"> <a class="<?php echo e(url('products/'.$obj->slug)); ?>"><?php echo e('₹ '.number_format($obj->default->inventory->sale_price)); ?> </a></div>
                                        <?php endif; ?>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </div>
                </div>
                    <?php endif; ?>
            </div>
        </div>
        <!-- .block-products-carousel / end -->
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
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/single_product.blade.php ENDPATH**/ ?>