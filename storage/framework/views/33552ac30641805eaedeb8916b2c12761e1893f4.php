<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'home'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui/css/news.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="site__body">
        <div class="  block m-0 ">
            <div class="row">
                <div class="col-12 col-lg-12  ">
                    <div class="block-slideshow__body ">
                        <div class="block-slideshow__slide  ">
                            <img src="<?php echo e(Key::get('news_events_banner')); ?>" width="100%" />
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
                            <li class="breadcrumb-item active" aria-current="page">News & Events</li>
                        </ol>
                    </nav>
                </div>
                <div class="block block-products-carousel hykon-product-view" data-layout="grid-5">
                    <div class="container">
                        <div class="product-tabs prd-dtl-cntr">
                            <div class="product-tabs__list">
                                <a href="#tab-description"
                                   class="product-tabs__item <?php if($type == 'News'): ?> product-tabs__item--active <?php endif; ?>"><span>News
                                            </span></a>
                                <a href="#tab-specification" class="product-tabs__item  <?php if($type == 'Events'): ?> product-tabs__item--active <?php endif; ?>"><span>Events</span></a>
                            </div>
                            <div class="product-tabs__content">
                                <div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
                                    <div class="typography">
                                        <div class="row">
                                            <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-md-4 col-sm-6 col-12">
                                                <div class="news-box">
                                                    <div class="new-thumb">
                                                        <?php if(isset($obj->featured_image)): ?>
                                                            <a href="<?php echo e(url('news/'.$obj->slug)); ?>"><img src="<?php echo e($obj->featured_image->file_path); ?>"  alt=""></a>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="new-txt">
                                                        <ul class="news-meta">
                                                            <li><?php echo e(\Carbon\Carbon::parse($obj->created_at)->format('d F Y')); ?></li>
                                                            <li><?php echo e($obj->views); ?> Views</li>
                                                        </ul>
                                                        <h6><a href="<?php echo e(url('news/'.$obj->slug)); ?>"><?php echo e($obj->primary_heading); ?></a></h6>
                                                        <p><?php echo e($obj->short_description); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-tabs__pane" id="tab-specification">
                                    <div class="typography">
                                        <div class="row mt40px">
                                            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-4">
                                                <div class="block event-teaser">
                                                    <a href="<?php echo e(url('event/'.$obj->slug)); ?>">
                                                        <div class="hd-evt">
                                                            <div class="hdevt--item">
                                                                <img src="<?php echo e(asset('hykon-ui')); ?>/images/event-icon-round.svg">
                                                            </div>
                                                            <div class="hdevt--item">
                                                                <header>
                                                                        <span class="event-teaser__date">
                                                                               <b>Date : <?php echo e(Carbon\Carbon::parse($obj->event_date_time)->format('d F Y')); ?></b><br>
                    <b>Time : <?php echo e(Carbon\Carbon::parse($obj->event_date_time)->format('h:i')); ?></b>
                                                                        </span>
                                                                </header>
                                                            </div>
                                                        </div>

                                                        <h3 class="h3--bold">
                                                            <?php echo e($obj->primary_heading); ?>

                                                        </h3>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/news.blade.php ENDPATH**/ ?>