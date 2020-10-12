<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'home'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('head'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="site__body">
        <div class="  block m-0 ">
            <div class="row">
                <div class="col-12 col-lg-12  ">
                    <div class="block-slideshow__body ">
                        <div class="block-slideshow__slide  "  >
                                <img src="<?php echo e(Key::get('about_banner_image')); ?>" width="100%" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-header">
            <div class="page-header__container container leadership-cntr">
                <div class="page-header__breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(url('/')); ?>">Home</a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">ABout us</li>
                        </ol>
                    </nav>
                </div>
                <div class="block-finder__header text-left about-page">
                    <div class="row">
                        <div class="col-xl-12">
                            <img src="<?php echo e(Key::get('about_intro_image')); ?>" class="img-fluid js-tilt float-right mob-dis-none " >
                            <h1 class="block-finder__title"> <?php echo e(Key::get('about_title')); ?> </h1>
                            <div class="block-finder__subtitle">
                                <?php echo Key::get('about_description'); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="block cat-list    " >
                    <div class="row">
                        <div class="col-12 col-lg-5 mob-dis-none ">
                            <img src="<?php echo e(Key::get('about_mission_image')); ?>" class="img-fluid">
                        </div>
                        <div class="col-12 col-lg-7  ">
                            <div class="block-banner__body">
                                <h3 class="block-banner__title"><?php echo e(Key::get('about_mission_title')); ?></h3>
                                <div class="block-banner__text"><?php echo e(Key::get('about_mission_desc')); ?></div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5 web-dis-none mob-dis-block ">
                            <img src="<?php echo e(Key::get('about_mission_image')); ?>" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="block cat-list list-rht  "  >
                    <div class="row">
                        <div class="col-12 col-lg-7  ">
                            <div class="block-banner__body">
                                <h3 class="block-banner__title"><?php echo e(Key::get('about_vision_title')); ?> </h3>
                                <div class="block-banner__text"><?php echo e(Key::get('about_vision_desc')); ?></div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5  ">
                            <img src="<?php echo e(Key::get('about_vision_image')); ?>" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="block block-products-carousel hykon-product-view" data-layout="grid-5">
                    <div class="container">
                        <div class="product-tabs prd-dtl-cntr">
                            <div class="product-tabs__list">
                                <a href="#tab-description" class="product-tabs__item product-tabs__item--active"><span>Why Hykon ?</span></a>
                                <a href="#tab-specification" class="product-tabs__item"><span>Highlights</span></a>
                            </div>
                            <div class="product-tabs__content">
                                <div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
                                    <div class="typography">

                                            <?php echo Key::get('why_hykon'); ?>


                                    </div>
                                </div>
                                <div class="product-tabs__pane" id="tab-specification">
                                    <div class="typography">

                                            <?php echo Key::get('about_highlights'); ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--    <div class="block  hykon-product-view" data-layout="grid-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 news-posts">
                                <div class="block-posts__slider block-posts__slider-news"  >
                                    <h3 class="block-header__title">News</h3>
                                    <button class="block-header__arrow block-header__arrow--left news" type="button">
                                        <svg width="7px" height="11px">
                                            <use xlink:href="images/sprite.svg#arrow-rounded-left-7x11"></use>
                                        </svg>
                                    </button>
                                    <button class="block-header__arrow block-header__arrow--right news" type="button">
                                        <svg width="7px" height="11px">
                                            <use xlink:href="images/sprite.svg#arrow-rounded-right-7x11"></use>
                                        </svg>
                                    </button>
                                    <div class="owl-carousel news">
                                        <div class="post-card  ">
                                            <div class="post-card__image">
                                                <div class="inner-block">
                                                    <div class="slider-top-right"></div>
                                                </div>
                                                <a href="">
                                                    <img src="images/dome-1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card__info">
                                                <div class="post-card__content">
                                                    Lorem ipsum dolor sit amet, consectetur
                                                </div>
                                                <div class="post-card__read-more">
                                                    <a href="" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-card  ">
                                            <div class="post-card__image">
                                                <div class="inner-block">
                                                    <div class="slider-top-right"></div>
                                                </div>
                                                <a href="">
                                                    <img src="images/dome-1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card__info">
                                                <div class="post-card__content">
                                                    Lorem ipsum dolor sit amet, consectetur
                                                </div>
                                                <div class="post-card__read-more">
                                                    <a href="" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-card  ">
                                            <div class="post-card__image">
                                                <div class="inner-block">
                                                    <div class="slider-top-right"></div>
                                                </div>
                                                <a href="">
                                                    <img src="images/dome-1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card__info">
                                                <div class="post-card__content">
                                                    Lorem ipsum dolor sit amet, consectetur
                                                </div>
                                                <div class="post-card__read-more">
                                                    <a href="" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-card  ">
                                            <div class="post-card__image">
                                                <div class="inner-block">
                                                    <div class="slider-top-right"></div>
                                                </div>
                                                <a href="">
                                                    <img src="images/dome-1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card__info">
                                                <div class="post-card__content">
                                                    Lorem ipsum dolor sit amet, consectetur
                                                </div>
                                                <div class="post-card__read-more">
                                                    <a href="" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 media-posts">
                                <div class="block-posts__slider block-posts__slider-media"  >
                                    <h3 class="block-header__title">Media</h3>
                                    <button class="block-header__arrow block-header__arrow--left media" type="button">
                                        <svg width="7px" height="11px">
                                            <use xlink:href="images/sprite.svg#arrow-rounded-left-7x11"></use>
                                        </svg>
                                    </button>
                                    <button class="block-header__arrow block-header__arrow--right media" type="button">
                                        <svg width="7px" height="11px">
                                            <use xlink:href="images/sprite.svg#arrow-rounded-right-7x11"></use>
                                        </svg>
                                    </button>
                                    <div class="owl-carousel">
                                        <div class="post-card  ">
                                            <div class="post-card__image">
                                                <div class="inner-block">
                                                    <div class="slider-top-right"></div>
                                                </div>
                                                <a href="">
                                                    <img src="images/dome-1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card__info">
                                                <div class="post-card__content">
                                                    asd
                                                </div>
                                                <div class="post-card__read-more">
                                                    <a href="" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-card  ">
                                            <div class="post-card__image">
                                                <div class="inner-block">
                                                    <div class="slider-top-right"></div>
                                                </div>
                                                <a href="">
                                                    <img src="images/dome-1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card__info">
                                                <div class="post-card__content">
                                                    Lorem ipsum dolor sit amet, consectetur
                                                </div>
                                                <div class="post-card__read-more">
                                                    <a href="" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-card  ">
                                            <div class="post-card__image">
                                                <div class="inner-block">
                                                    <div class="slider-top-right"></div>
                                                </div>
                                                <a href="">
                                                    <img src="images/dome-1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card__info">
                                                <div class="post-card__content">
                                                    Lorem ipsum dolor sit amet, consectetur
                                                </div>
                                                <div class="post-card__read-more">
                                                    <a href="" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-card  ">
                                            <div class="post-card__image">
                                                <div class="inner-block">
                                                    <div class="slider-top-right"></div>
                                                </div>
                                                <a href="">
                                                    <img src="images/dome-1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card__info">
                                                <div class="post-card__content">
                                                    Lorem ipsum dolor sit amet, consectetur
                                                </div>
                                                <div class="post-card__read-more">
                                                    <a href="" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  -->
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/about.blade.php ENDPATH**/ ?>