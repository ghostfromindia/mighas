<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'home'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('content'); ?>
    <!-- site__body -->
    <div class="site__body">
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
                            <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                        </ol>
                    </nav>
                </div>
                <div class="page-header__title">
                    <h1>Wishlist</h1>
                </div>
            </div>
        </div>
        <?php if(count($wishlist)>0): ?>
            <div class="block wish-list-cntr">
                <div class="container">
                    <table class="wishlist table  bg-white mob-dis-none">
                        <thead class="wishlist__head">
                        <tr class="wishlist__row">
                            <th class="wishlist__column wishlist__column--image"><b>Image</b></th>
                            <th class="wishlist__column wishlist__column--product"><b>Product</b></th>
                            <th class="wishlist__column wishlist__column--stock"><b>Stock Status</b></th>
                            <th class="wishlist__column wishlist__column--price"><b>Price</b></th>
                            <th class="wishlist__column wishlist__column--tocart"></th>
                            <th class="wishlist__column wishlist__column--remove"></th>
                        </tr>
                        </thead>
                        <tbody class="wishlist__body">
                        <?php $__currentLoopData = $wishlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="wishlist__row">
                            <td class="wishlist__column wishlist__column--image">
                                <?php if($obj->product_details->media): ?>
                                    <a href="<?php echo e(url('products'.$obj->product_details->product->slug.'?variant='.$obj->product_details->slug)); ?>">
                                        <img src="<?php echo e($obj->product_details->media->file_path); ?>" alt="">
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td class="wishlist__column wishlist__column--product">
                                <a href="<?php echo e(url('products'.$obj->product_details->product->slug.'?variant='.$obj->product_details->slug)); ?>" class="wishlist__product-name"><?php echo e($obj->product_details->name); ?></a>
                            </td>
                            <td class="wishlist__column wishlist__column--stock">
                                <?php if(\App\Models\Products\Variants::inStock($obj->product_details->id,'check')): ?>
                                        <div class="badge badge-success">In Stock</div>
                                    <?php else: ?>
                                        <div class="badge badge-error">Out of Stock</div>
                                <?php endif; ?>
                            </td>
                            <td class="wishlist__column wishlist__column--price">
                                <?php if($obj->product_details->inventory): ?>
                                    <?php echo e('₹ '.number_format($obj->product_details->inventory->sale_price)); ?>

                                <?php endif; ?>
                            </td>
                            <td class="wishlist__column wishlist__column--tocart">
                                <?php if($obj->product_details->inventory): ?>
                                    <form action="<?php echo e(url('cart/save')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="variant_id" value="<?php echo e(encrypt($obj->product_details->id)); ?>">
                                        <input type="hidden" name="quantity" value="<?php echo e(encrypt('1')); ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Add To Cart</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td class="wishlist__column wishlist__column--remove">
                                <a href="javascript:void(0)"  class="add-to-wishlist" data-variant="<?php echo e(encrypt($obj->product_details->id)); ?>" alt="Remove from wishlist" style="font-size: 12px;
    font-weight: 600;
    color: #790000;"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>


                    <div class="row  web-dis-none mob-dis-block">
                        <div class="col-md-12 ">
                            <?php $__currentLoopData = $wishlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="hykon-wsh">
                                <?php if($obj->product_details->media): ?>
                                    <a href="<?php echo e(url('products'.$obj->product_details->product->slug.'?variant='.$obj->product_details->slug)); ?>">
                                        <img src="<?php echo e($obj->product_details->media->file_path); ?>" alt="">
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo e(url('products'.$obj->product_details->product->slug.'?variant='.$obj->product_details->slug)); ?>" class="wishlist__product-name"><?php echo e($obj->product_details->name); ?></a>

                                <div class="  wishlist__column--price mb-2 mt-1">      <?php if(\App\Models\Products\Variants::inStock($obj->product_details->id,'check')): ?>
                                        <div class="badge badge-success">In Stock</div>
                                    <?php else: ?>
                                        <div class="badge badge-error">Out of Stock</div>
                                    <?php endif; ?> <?php if($obj->product_details->inventory): ?>
                                        <?php echo e('₹ '.number_format($obj->product_details->inventory->sale_price)); ?>

                                    <?php endif; ?></div>
                                <?php if($obj->product_details->inventory): ?>
                                    <form action="<?php echo e(url('cart/save')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="variant_id" value="<?php echo e(encrypt($obj->product_details->id)); ?>">
                                        <input type="hidden" name="quantity" value="<?php echo e(encrypt('1')); ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Add To Cart</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                    </div>









                </div>
            </div>
        <?php else: ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 offset-4" align="center">
                        <img src="<?php echo e(Key::get('empty-wishlist')); ?>" width="100%">
                        <a href="<?php echo e(url('products')); ?>" class="btn btn-primary btn-sm" style="margin-bottom: 100px;">Continue Shopping <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!-- site__body / end -->
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
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/wishlist.blade.php ENDPATH**/ ?>