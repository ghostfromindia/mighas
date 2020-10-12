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
                            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                        </ol>
                    </nav>
                </div>
                <div class="page-header__title">
                    <h1>Shopping Cart</h1>
                </div>
            </div>
        </div>
        <?php if(count($cart)>0): ?>
        <div class="cart block">
            <div class="container">
                <?php echo $__env->make('hykon.components.logs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="cart-cntr">

                    <div class="row m-0 mob-dis-none">
                      <div class="col-xl-2 col-md-2 p-0"><div class="cart-hd">Image</div></div>
                      <div class="col-xl-3 col-md-3 p-0"><div class="cart-hd">Product</div></div>
                      <div class="col-xl-2 col-md-2 p-0"><div class="cart-hd">Price</div></div>
                      <div class="col-xl-2 col-md-2 p-0"><div class="cart-hd">Quantity</div></div>
                      <div class="col-xl-2 col-md-2 p-0"><div class="cart-hd">Total</div></div>
                      <div class="col-xl-1 col-md-1 p-0"><div class="cart-hd"> &nbsp;</div></div>
                    </div>
                     <?php $total = 0; ?>
                        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                                    <div class="mob-car-cnt">
                      <div class="row m-0">

                          <div class="col-xl-2 col-md-2 col-4 p-0">
                        <div class="cart-cnt">


                                    <?php if($obj->product->media): ?>
                                            <a href="<?php echo e('products/'.$obj->product->product->slug.'?variant='.$obj->product->slug); ?>"><img src="<?php echo e(asset($obj->product->media->file_path)); ?>" alt="" class="img-fluid"></a>
                                        <?php else: ?>
                                            <a href="<?php echo e('products/'.$obj->product->product->slug.'?variant='.$obj->product->slug); ?>"><img src="<?php echo e(Key::get('product-404')); ?>" alt="" class="img-fluid"></a>
                                    <?php endif; ?>
                               </div>
                      </div>


                                <div class="col-xl-3 col-md-3 col-8 p-0">
                        <div class="cart-cnt">
                        
                      
                     
                                    <a href="<?php echo e('products/'.$obj->product->product->slug.'?variant='.$obj->product->slug); ?>" class="cart-table__product-name"><?php echo e($obj->product->name); ?></a>
                                    <ul class="cart-table__options">
                                        <li>MRP : ₹<?php echo e($obj->retail_price); ?></li>
                                    </ul>
                                

                                  </div>
                      </div>




                                  <div class="col-xl-2 col-md-2 p-0 mob-dis-none">
                        <div class="cart-cnt text-left">
                      
                                 ₹<?php echo e(number_format($obj->price)); ?> 

                            </div></div>



                               <div class="col-xl-2 col-md-2 col-5 p-0">
                        <div class="cart-cnt text-left">
                         
                     
                    
 
                                    <div class="input-number">
                                        <input class="form-control input-number__input" type="number" min="1" value="<?php echo e($obj->quantity); ?>">
                                        <form action="<?php echo e(url('cart/save')); ?>" method="post"><?php echo csrf_field(); ?>
                                            <input type="hidden" name="variant_id" value="<?php echo e(encrypt($obj->product_id)); ?>">
                                            <input type="hidden" name="quantity" value="<?php echo e(encrypt('1')); ?>">
                                            <button class="input-number__add" type="submit"></button>
                                        </form>
                                        <form action="<?php echo e(url('cart/save')); ?>" method="post"><?php echo csrf_field(); ?>
                                            <input type="hidden" name="variant_id" value="<?php echo e(encrypt($obj->product_id)); ?>">
                                            <input type="hidden" name="quantity" value="<?php echo e(encrypt('-1')); ?>">
                                            <button class="input-number__sub" type="submit"></button>
                                        </form>
                                    </div>
                                


                                 </div>
                                  </div>




                                 <div class="col-xl-2 col-md-2 col-5 p-0">
                                    <div class="cart-cnt text-left"> 
                                 ₹<?php echo e(number_format($obj->price*$obj->quantity)); ?>

                                <?php $total = $total+$obj->price*$obj->quantity; ?>
                                </div>
                                </div>



                                
                                    <div class="col-xl-1 col-md-1 col-2 p-0">
                                    <div class="cart-cnt text-left"> 
 
                                    <button type="button" class="btn btn-light btn-sm btn-svg-icon">
                                        <svg width="12px" height="12px">
                                            <use xlink:href="images/sprite.svg#cross-12"></use>
                                        </svg>
                                    </button>
                                 
                                  </div>
                                </div>


                             </div>
                    </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     
                </div>


                <div class="cart__actions cart-cntr">
                    <form class="cart__coupon-form">
                        <label for="input-coupon-code" class="sr-only">Password</label>
                        <input type="text" class="form-control" id="input-coupon-code" placeholder="Coupon Code">
                        <button type="submit" class="btn btn-primary">Apply Coupon</button>
                    </form>
                </div>
                <div class="row justify-content-end pt-5 cart-check-cntr">
                    <div class="col-12 col-md-7 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Cart Totals</h3>
                                <table class="cart__totals">
                                    <thead class="cart__totals-header">
                                    <tr>
                                        <th>Subtotal</th>
                                        <td>₹<?php echo e(number_format($total)); ?></td>
                                    </tr>
                                    </thead>
                                    <tbody class="cart__totals-body">
                                <!--    <tr>
                                        <th>Shipping</th>
                                        <td>
                                            $25.00
                                            <div class="cart__calc-shipping"><a href="#">Calculate Shipping</a></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tax</th>
                                        <td>
                                            $0.00
                                        </td>
                                    </tr>  -->
                                    </tbody>
                                    <tfoot class="cart__totals-footer">
                                    <tr>
                                        <th>Total</th>
                                        <td>₹<?php echo e(number_format($total)); ?></td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <?php if(auth()->guard()->check()): ?>
                                    <a class="btn btn-primary btn-xl btn-block cart__checkout-button" href="<?php echo e(url('checkout/address?create='.encrypt(Auth::user()->id))); ?>">Proceed to checkout</a>
                                    <?php else: ?>
                                    <a class="btn btn-primary btn-xl btn-block cart__checkout-button" data-toggle="modal" href="#login-register">Please login to checkout</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 offset-md-4" align="center">
                    <img src="<?php echo e(Key::get('empty-cart')); ?>" width="100%">
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
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/cart.blade.php ENDPATH**/ ?>