<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'home'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('hykon-ui/css/history.css')); ?>">
<style>
    .ct_tt_logo_img {
        width: 170px;
        height: 170px;
        border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border: 20px solid #efefee;
        transform: translate(0, 0);
        object-fit: contain;
        background: white;
    }
    .ct_tt_logo_img_scaled {
        top: 0;
        left: 0;
        width: 170px;
        height: 170px;
        border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border: 20px solid #efefee;
        position: absolute;
        opacity: 0;
        object-fit: contain;
        background: white;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="site__body inner-body">




        <div class="  block m-0 ">
            <div class="row">
                <div class="col-12 col-lg-12  ">
                    <div class="block-slideshow__body ">
                        <div class="block-slideshow__slide  "  >
                            <?php if(isset($slider)): ?>
                                <?php if(isset($slider->photos[0]->media)): ?>
                                    <img src="<?php echo e(asset($slider->photos[0]->media->file_path)); ?>" width="100%" />
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="history-head">History</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-header">
            <div class="page-header__container container">
                <div class="page-header__breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(url('/')); ?>">Home</a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">History</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="header-top-p">
            <div class="header-top-p header-top-bg"></div>
            <div id="ss-container" class="ss-container">

                <div id="ytbgvideo"></div>
                <div id="ct_tt_logo" class="ct_tt_logo">
                    <a href="#">
                        <img class="ct_tt_logo_img" src="<?php echo e(Key::get('site_logo')); ?>" alt="logo">
                        <img class="ct_tt_logo_img_scaled" src="<?php echo e(Key::get('site_logo')); ?>" alt="logo">
                    </a>
                </div>
                <div class="ct_tt_container_border"></div>
                <div class="ct_innercon">
                    <span class="cont_ssway"></span>
                    <div class="ct_tt_container">
                        <div id="main" class="ss-stand-alone fullwidthrow">
                            <div class="ct_tt_timeline_row post-10 post type-post status-publish format-standard has-post-thumbnail hentry category-category-1" style="opacity: 1;">
                                <div class="time-dot-date time-dot-show">

                                </div>

                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="ct_tt_timeline_row post-62 post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized" style="opacity: 1;">
                                        <div class="time-dot-date time-dot-show">
                                            <div class="time-dot-dateinner">
                                                <?php echo e(Carbon\Carbon::parse($obj->event_date_time)->format('d F Y')); ?>

                                            </div>
                                        </div>

                                        <div class="time-dot  time-dot-show"></div>
                                        <div class="ct_tt_timeline_left empty-left span3 wow rollIn"  >
                                            <div class="arrow-side time-dot-show"></div>
                                            <div class="empty-right  ">
                                                <div class="ct_tt_view ct_tt_img_hoverfx">
                                                    <?php if($obj->featured_image): ?>
                                                        <img src="<?php echo e(asset($obj->featured_image->file_path)); ?>" />
                                                    <?php endif; ?>
                                                    <div class="ct_tt_mask">
                                                        <a href="http://themes.cray.bg/share-it/wp-content/uploads/2015/03/def-17.jpg" class="info" rel="prettyPhotoImages[62]">
                                                            <svg width="100px" height="100px" viewBox="0 0 300 300" style="enable-background:new 0 0 300 300;" xml:space="preserve">
                                                       <line class="st0" x1="150.881" y1="36.392" x2="150.881" y2="259.611"></line>
                                                                <line class="st0" x1="39.271" y1="148.001" x2="262.49" y2="148.001"></line>
                                                   </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ct_tt_timeline_right empty-right span3 wow lightSpeedIn"  >
                                            <div class="arrow-side time-dot-show"></div>
                                            <div class="ct_tt_timelieholder">
                                                <div class="ct_tt_ttcontent">
                                                    <h3 class="content-title link_dots_effect">
                                                        <a id="62" href="http://themes.cray.bg/share-it/bakery/"><?php echo e($obj->name); ?></a>
                                                    </h3>
                                                    <p><?php echo $obj->content; ?></p>
                                                </div>
                                            </div>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>

    <script src="<?php echo e(asset('hykon-ui/js/functions.js')); ?>"></script>
    <script>

        jQuery(document).ready(function($) {
            var alterClass = function() {
                var ww = document.body.clientWidth;
                if (ww < 768) {

                    $(window).scroll(function () {
                        if ($(this).scrollTop() > 50) {
                            $('.ct_tt_logo').addClass("sticky1");
                            $('.ct_tt_container_border').addClass("sticky2");

                        } else {
                            $('.ct_tt_logo').removeClass("sticky1");
                            $('.ct_tt_container_border').removeClass
                            ("sticky2");
                        }
                    });



                } else if (ww >= 401) {



                    $(window).scroll(function () {
                        if ($(this).scrollTop() > 550) {
                            $('.ct_tt_logo').addClass("sticky1");
                            $('.ct_tt_container_border').addClass("sticky2");

                        } else {
                            $('.ct_tt_logo').removeClass("sticky1");
                            $('.ct_tt_container_border').removeClass
                            ("sticky2");
                        }
                    });



                };
            };
            $(window).resize(function(){
                alterClass();
            });
            //Fire it when the page first loads:
            alterClass();
        });
    </script>
    <script>
        svg4everybody();
    </script>

    <script>
        $(document).ready(function(){

            AOS.init({
                easing: 'ease-out-back',
                duration: 1000
            });




            $('input.search__input').focus(function() {
                $('.autocomplete-cntr').show();
                $(document).bind('focusin.autocomplete-cntr click.autocomplete-cntr',function(e) {
                    if ($(e.target).closest('.autocomplete-cntr, input.search__input').length) return;
                    $(document).unbind('.autocomplete-cntr');
                    $('.autocomplete-cntr').fadeOut('medium');
                });
            });
            $('.autocomplete-cntr').hide();





        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/history.blade.php ENDPATH**/ ?>