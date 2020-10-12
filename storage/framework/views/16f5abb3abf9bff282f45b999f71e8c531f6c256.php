<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = $category->slug; ?> <?php endif; ?>
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
                                <a href="<?php echo e(url($category->slug)); ?>"><?php echo e($category->category_name); ?></a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="block-finder__header text-center">
                    <h1 class="block-finder__title"><?php echo e($category->category_name); ?></h1>
                    <div class="block-finder__subtitle"><?php echo e($category->top_content); ?></div>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="shop-layout shop-layout--sidebar--start">
                <div class="shop-layout__sidebar">
                    <div class="block block-sidebar block-sidebar--offcanvas--mobile">
                        <div class="block-sidebar__backdrop"></div>
                        <div class="block-sidebar__body">
                            <div class="block-sidebar__header">
                                <div class="block-sidebar__title">Filters</div>
                                <button class="block-sidebar__close" type="button">
                                    <svg width="20px" height="20px">
                                        <use xlink:href="<?php echo e(asset('hykon-ui')); ?>images/sprite.svg#cross-20"></use>
                                    </svg>
                                </button>
                            </div>
                            <div class="block-sidebar__item">
                                <div class="left-filter widget-filters widget widget-filters--offcanvas--mobile"
                                     data-collapse data-collapse-opened-class="filter--opened">
                                    <form action="<?php echo e(url(Request::path())); ?>" method="get">
                                    <h4 class="widget-filters__title widget__title">FILTERS</h4>


                                    <div class="widget-filters__list">


                                        <div class="widget-filters__item">
                                            <div class="filter filter--opened" data-collapse-item>
                                                <button type="button" class="filter__title" data-collapse-trigger>
                                                    Category
                                                    <svg class="filter__arrow" width="12px" height="7px">
                                                        <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-down-12x7"></use>
                                                    </svg>
                                                </button>
                                                <?php if(Input::get('category')): ?>
                                                        <?php $cat_array = Input::get('category'); ?>
                                                    <?php else: ?>
                                                        <?php $cat_array = []; ?>
                                                <?php endif; ?>
                                                <div class="filter__body" data-collapse-content>
                                                    <div class="filter__container">
                                                        <div class="filter-list">
                                                            <div class="filter-list__list">
                                                                <?php $__currentLoopData = $list_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <label class="filter-list__item ">
                                                                        <span class="filter-list__input input-check">
                                                                            <span class="input-check__body">
                                                                                <input class="input-check__input" type="checkbox" name="category[]" value="<?php echo e($obj->id); ?>" <?php if(in_array($obj->id,$cat_array)): ?> checked <?php endif; ?>>
                                                                                <span class="input-check__box"></span>
                                                                                <svg class="input-check__icon" width="9px" height="7px">
                                                                                    <use xlink:href="images/sprite.svg#check-9x7"></use>
                                                                                </svg>
                                                                            </span>
                                                                        </span>
                                                                        <span class="filter-list__title">
                                                                            <?php echo e($obj->category_name); ?>

                                                                        </span>
                                                                </label>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <?php if(count($products) > 0 && $min != $max): ?>
                                            <div class="widget-filters__item">
                                                <div class="filter filter--opened" data-collapse-item>
                                                    <button type="button" class="filter__title" data-collapse-trigger>
                                                        Price
                                                        <svg class="filter__arrow" width="12px" height="7px">
                                                            <use xlink:href="images/sprite.svg#arrow-rounded-down-12x7"></use>
                                                        </svg>
                                                    </button>
                                                    <div class="filter__body" data-collapse-content>
                                                        <div class="filter__container">
                                                            <div class="filter-price" data-min="<?php echo e($min); ?>" data-max="<?php echo e($max); ?>"
                                                                 data-from="<?php echo e($min); ?>" data-to="<?php echo e($max); ?>">
                                                                <div class="filter-price__slide" id="price_range"></div>
                                                                <div class="filter-price__title">Price: ₹<span class="filter-price__min-value"><?php echo e($from); ?></span> – ₹<span class="filter-price__max-value"><?php echo e($to); ?></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="from" value="<?php echo e($from); ?>">
                                            <input type="hidden" name="to" value="<?php echo e($to); ?>">
                                        <?php endif; ?>


                                    </div>
                                    <div class="widget-filters__actions d-flex">
                                        <button class="btn btn-primary btn-sm">Filter</button>
                                        <button class="btn btn-secondary btn-sm">Reset</button>
                                    </div>
                                    </form>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
                <?php if(count($products)>0): ?>
                    <div class="shop-layout__content">
                    <div class="block">
                        <div class="products-view">
                            <div class="products-view__options">
                                <div class="view-options view-options--offcanvas--mobile">
                                    <div class="view-options__filters-button">
                                        <label class="web-dis-none mob-dis-block text-light" >Filter</label>
                                        <button type="button" class="filters-button">
                                            <svg class="filters-button__icon" width="16px" height="16px">
                                                <use xlink:href="images/sprite.svg#filters-16"></use>
                                            </svg>
                                            <span class="filters-button__title">Filters</span>
                                        </button>
                                    </div>
                                    <div class="view-options__layout">
                                        <label class="web-dis-none mob-dis-block text-light" >View</label>
                                        <div class="layout-switcher">
                                            <div class="layout-switcher__list">
                                                <button data-layout="grid-3-sidebar" data-with-features="false" title="Grid" type="button" class="layout-switcher__button ">
                                                    <svg width="16px" height="16px">
                                                        <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#layout-grid-16x16"></use>
                                                    </svg>
                                                </button>
                                                <button data-layout="list" data-with-features="false" title="List" type="button" class="layout-switcher__button  layout-switcher__button--active ">
                                                    <svg width="16px" height="16px">
                                                        <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#layout-list-16x16"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="view-options__divider"></div>
                                    <div class="view-options__control">
                                        <label for="">Sort By</label>
                                        <div>
                                            <select class="form-control form-control-sm" name="" id="">
                                                <option value="">Default</option>
                                                <option value="">Name (A-Z)</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="products-view__list products-list" data-layout="list" data-with-features="false">
                                <div class="products-list__body">
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($obj->default): ?>
                                        <div class="products-list__item prd-filt-list">
                                        <div class="product-card ">

                                            <div class="product-card__badges-list">
                                                <div class="product-card__badge product-card__badge--new"><?php echo e($obj->default->product->category->category_name); ?></div>
                                            </div>
                                            <div class="product-card__image">

                                                <a href="<?php echo e('products/'.$obj->slug); ?>">
                                                    <?php if(isset($obj->default->media)): ?>
                                                            <img src="<?php echo e(asset($obj->default->media->file_path)); ?>" alt="">
                                                        <?php else: ?>
                                                            <img src="https://via.placeholder.com/300x200" alt="">
                                                    <?php endif; ?>
                                                </a>
                                            </div>

                                            <div class="product-card__info">
                                                <h2 class="product-card__name">
                                                    <a href="<?php echo e(url('products/'.$obj->slug)); ?>"><?php echo e($obj->product_name); ?></a>
                                                </h2>

                                         

                                                <?php if($obj->variants && count($obj->variants)>1): ?>
                                                <div class="product-card__lpd">
                                                    <p class="avial-variables">Available Variants</p>
                                                    <ul class="product-card__features-list">
                                                    <?php $__currentLoopData = $obj->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><a href="<?php echo e(url('products/'.$o->product->slug.'?variant='.$o->slug)); ?>"><?php echo e($o->name); ?></a></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                                <?php endif; ?>




                                            </div>

                                             <div class="product-card__actions">
                                               

                                                       <?php if($obj->default->inventory->sale_price >0): ?>
                                                    <div class="product-card__prices">
                                                        <?php if($obj->default->inventory): ?>
                                                            MRP: <span><?php echo e(number_format($obj->default->inventory->sale_price)); ?>/-</span>
                                                        <?php endif; ?>
                                                    </div>



                                                <div class="product-card__buttons text-center" style="margin-top: 10px">
                                                    <?php if(isset($obj->default)): ?>
                                                        <form action="<?php echo e(url('cart/save')); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="variant_id" value="<?php echo e(encrypt($obj->default->id)); ?>">
                                                            <input type="hidden" name="quantity" value="<?php echo e(encrypt('1')); ?>">
                                                            <button type="submit" class="btn btn-primary">book now</button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <a href="<?php echo e(url('products/'.$obj->slug)); ?>" class="btn btn-primary" type="button" >view details</a>
                                                    <div class="clearfix"></div>

                                                </div>
                                                     <?php endif; ?>

                                                 

                                             </div>




                                        </div>
                                    </div>
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
                    line-height: 30px;
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
                    margin: 5px 0px 0px 0px;
                    font-weight: 500; 
                    width: fit-content;
                }
.product-card__features-list a {
    color: #333;
    font-size: 13px;
}
.prd-filt-list .product-card__lpd { 
     border-bottom: 0px; 
    padding: 10px 0 0;
    margin-bottom: 0px;
}

            </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
            <script>
                $( document ).ready(function() {
                    var slider  = document.getElementById('price_range');
                    $('.filter-price__min-value').html(<?php echo e($from); ?>)
                    $('.filter-price__max-value').html(<?php echo e($to); ?>)
                    noUiSlider.create(slider , {
                        start: [<?php echo e($from); ?>, <?php echo e($to); ?>],
                        connect: true,
                        range: {
                            'min': [<?php echo e($min); ?>],
                            'max':[<?php echo e($max); ?>]
                        }
                    });

                    slider.noUiSlider.on('end', function (values, handle) {
                        $('input[name=from]').val(Math.round(values[0]))
                        $('input[name=to]').val(Math.round(values[1]))
                        $('.filter-price__min-value').html(Math.round(values[0]))
                        $('.filter-price__max-value').html(Math.round(values[1]))
                    });


                });
            </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/category_store.blade.php ENDPATH**/ ?>