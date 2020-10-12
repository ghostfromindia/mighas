<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'home'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('content'); ?>

    <div class="site__body home-page">
        <div class="  block index-banner">
            <div class="top-pattern web-dis-none mob-dis-block">
                  <img src="<?php echo e(asset('hykon-ui')); ?>/images/patt-top.png">
               </div>

            <div class="row">
                <div class="col-12 col-lg-12  ">
                    <div class="block-slideshow__body">
                        <div class="block-slideshow__slide home-scroll-banner"  >

                            <?php if(isset($slider)): ?>
                                <?php if(isset($slider->photos[0]->media)): ?>
                                    <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop"
                                         style="background-image: url('<?php echo e(asset($slider->photos[0]->media->file_path)); ?>')"></div>
                                <?php endif; ?>
                                <?php else: ?>
                                <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop"
                                     style="background-image: url('https://via.placeholder.com/1920x826')"></div>
                            <?php endif; ?>

                            <?php if(isset($slider_mobile)): ?>
                                    <?php if(isset($slider_mobile->photos[0]->media)): ?>
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile"
                                 style="background-image: url('<?php echo e(asset($slider_mobile->photos[0]->media->file_path)); ?>')"></div>
                                    <?php endif; ?>
                            <?php else: ?>
                                    <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile"
                                         style="background-image: url('https://via.placeholder.com/468x60')"></div>

                             <?php endif; ?>

                            <div class="container">
                                <div class="banner-caption">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <h3>Popular Right Now  </h3>
                                            <div class="pagination" id="slick-wrapper">
                                                <?php $__currentLoopData = $popular_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="slick-item"><span class="pagination-item  |  animate"><a href="<?php echo e(url($obj->slug)); ?>"><?php echo e($obj->category_name); ?></a></span></div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <?php if(isset($slider->photos[0])): ?>
                                                <?php echo $slider->photos[0]->description; ?>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="patt-banner">
                <img src="<?php echo e(asset('hykon-ui')); ?>/images/footer-patern.png" height="150" />

            </div>



        </div>

        <div class="block block-posts block-posts--layout--list-sm domestic" data-layout="list-sm">
            <h3 class="block-header__title">Domestic</h3>
            <div class="container">
                <div class="block-posts__slider2 domestic" data-aos="fade-right">
                    
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
                    <div class="owl-carousel">
                        <?php $__currentLoopData = $domestic_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="post-card  ">
                            <div class="post-card__image">
                                <div class="inner-block">
                                    <div class="slider-top-right"></div>
                                </div>

                                <a href="<?php echo e(url($obj->slug)); ?>">
                                    <?php if(isset($obj->banner)): ?>
                                            <img src="<?php echo e(asset($obj->banner->file_path)); ?>" alt="">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/432x234" alt="">
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="post-card__info">
                                <div class="post-card__category">
                                    <a href="<?php echo e(url($obj->slug)); ?>">Special Offers</a>
                                </div>
                                <div class="post-card__name">
                                    <a href="<?php echo e(url($obj->slug)); ?>"><?php echo e($obj->category_name); ?></a>
                                </div>
                                <div class="post-card__content">
                                    <?php echo e($obj->page_title); ?>

                                </div>
                                <div class="post-card__read-more">
                                    <a href="<?php echo e(url($obj->slug)); ?>" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- .block-posts / end -->

        <!-- .block-posts -->
        <div class="block block-posts2 block-posts--layout--list-sm domestic" data-layout="list-sm">
             <h3 class="block-header__title corporate web-dis-none mob-dis-block">corporate</h3>
            <div class="container">
                <div class="block-posts__slider2 corporate"  data-aos="fade-left">
                    
                    <button class="block-header__arrow block-header__arrow--left2" type="button">
                        <svg width="7px" height="11px">
                            <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-left-7x11"></use>
                        </svg>
                    </button>
                    <button class="block-header__arrow block-header__arrow--right2" type="button">
                        <svg width="7px" height="11px">
                            <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-right-7x11"></use>
                        </svg>
                    </button>
                    <div class="owl-carousel">
                        <?php $__currentLoopData = $corporate_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="post-card  ">
                            <div class="post-card__image">
                                <div class="inner-block">
                                    <div class="slider-top-right"></div>
                                </div>
                                <a href="<?php echo e(url($obj->slug)); ?>">
                                    <?php if(isset($obj->banner)): ?>
                                        <img src="<?php echo e(asset($obj->banner->file_path)); ?>" alt="">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/432x234" alt="">
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="post-card__info">
                                <div class="post-card__category">
                                    <a href="<?php echo e(url($obj->slug)); ?>">Special Offers</a>
                                </div>
                                <div class="post-card__name">
                                    <a href="<?php echo e(url($obj->slug)); ?>"><?php echo e($obj->category_name); ?></a>
                                </div>
                                <div class="post-card__content">
                                    <?php echo e($obj->page_title); ?>

                                </div>
                                <div class="post-card__read-more">
                                    <a href="<?php echo e(url($obj->slug)); ?>" class=" ">See Products <i class="fas fa-caret-right"></i> </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <h3 class="block-header__title corporate mob-dis-none ">corporate</h3>
        </div>
        <!-- .block-posts / end -->
        <!-- .block-posts -->
        <div class="block  upadates" >
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="inner-rht-space">
                            <h3><?php echo e(Key::get('hl-title')); ?></h3>
                            <p><?php echo e(Key::get('hl-description')); ?></p>
                            <div class="row ser-hm">
                                <div class="col-md-6">
                                    <img src="<?php echo e(Key::get('hl-s1-icon')); ?>" />
                                    <h4><?php echo e(Key::get('hl-s1-title')); ?></h4>
                                    <p><?php echo e(Key::get('hl-s1-summary')); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <img src="<?php echo e(Key::get('hl-s2-icon')); ?>" />
                                    <h4><?php echo e(Key::get('hl-s2-title')); ?></h4>
                                    <p><?php echo e(Key::get('hl-s2-summary')); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <img src="<?php echo e(Key::get('hl-s3-icon')); ?>" />
                                    <h4><?php echo e(Key::get('hl-s3-title')); ?></h4>
                                    <p><?php echo e(Key::get('hl-s3-summary')); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <img src="<?php echo e(Key::get('hl-s4-icon')); ?>" />
                                    <h4><?php echo e(Key::get('hl-s4-title')); ?></h4>
                                    <p><?php echo e(Key::get('hl-s4-summary')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 block-posts3  block-posts--layout--list-sm  " data-layout="list-sm">
                        <div class="inner-lft-space">
                            <h2>latest upadates</h2>
                            <div class="block-posts__slider3 ">
                                <div class="owl-carousel">
                                    <?php $__currentLoopData = $latest_updates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="post-card  ">
                                        <div class="date"><?php echo e(\Carbon\Carbon::parse($obj->created_at)->format('d  F  Y')); ?></div>
                                        <div class="post-card__image">
                                            <a href="<?php echo e(url('blog/'.$obj->slug)); ?>">
                                                <?php if(isset($obj->featured_image)): ?>
                                                    <img src="<?php echo e(asset($obj->featured_image->file_path)); ?>" alt="">
                                                    <?php else: ?>
                                                    <img src="https://via.placeholder.com/455x211" alt="">
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="post-card__info">
                                            <div class="post-card__name">
                                                <a href="<?php echo e(url('blog/'.$obj->slug)); ?>"><?php echo e($obj->primary_heading); ?></a>
                                            </div>
                                            <div class="post-card__content">
                                              <?php echo e($obj->short_description); ?>

                                            </div>
                                        </div>
                                        <div class="btn-cntr">
                                            <a class="btn btn-primary btn-lg" href="<?php echo e(url('blog/'.$obj->slug)); ?>">Read More</a>
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
        <!-- .block-posts / end -->
        <!-- .block-products-carousel -->

        <!-- .block-products-carousel / end -->
        <!-- .block-banner -->
        <div class="block block-banner messages-cntr">
            <div class="container">
                <div class="row m-0">
                    <div class="col-md-5 p-0 text-center">
                        <img src="<?php echo e(asset(Key::get('cmd-image'))); ?>" class="img-fluid" width="400" />
                    </div>
                    <div class="col-md-7 p-0">
                        <div class="container" style="max-width: 650px;">
                            <div   class="block-banner__body">
                                <div class="block-banner__title"><?php echo e(Key::get('cmd-message-title')); ?></div>
                                <div class="block-banner__text"><?php echo e(Key::get('cmd-message-description')); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-3">
                                    <h2 class="timer count-title count-number" data-to="<?php echo e(Key::get('start-up')); ?>" data-speed="1500"></h2>
                                    <span>  Start Up</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h2 class="timer count-title count-number" data-to="<?php echo e(Key::get('employees')); ?>" data-speed="1500"></h2>
                                    <span>Employees</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h2 class="timer count-title count-number" data-to="<?php echo e(Key::get('companies')); ?>" data-speed="1500"></h2>
                                    <span>Companies</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h2 class="timer count-title count-number" data-to="<?php echo e(Key::get('crore-turnover')); ?>" data-speed="1500"></h2>
                                    <span>  Crore Turnover</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .block-banner / end -->
        <?php if(isset($awards)): ?>
            <div class="block block-banner awards">
            <div href="<?php echo e(asset('hykon-ui')); ?>/" class="block-banner__body">
                <div class="block-banner__image block-banner__image--desktop" style="background-image: url('<?php echo e(asset(Key::get('award-block-desktop-image'))); ?>'); background-attachment: fixed; background-size: cover;"></div>
                <div class="block-banner__image block-banner__image--mobile" style="background-image: url('<?php echo e(asset(Key::get('award-block-mobile-image'))); ?>');background-attachment: fixed;"></div>
                <div class="container" style="max-width: 800px;">
                    <div class="row m-0">
                        <div class="col-md-12">
                            <div class="block-banner__title"> <span>Awards</span> and Recognitions </div>
                        </div>
                        <?php if($awards->photos): ?>
                            <?php $__currentLoopData = $awards->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($obj->media): ?>
                                <div class="col-6 col-md-4 p-0">
                                    <div class="awa-list">
                                        <div class="inner-block">
                                            <div class="slider-top-right"></div>
                                        </div>
                                        <img src="<?php echo e(asset($obj->media->file_path)); ?>" class="img-fluid" width="130" />
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- .block-brands -->
        <?php if(isset($clients)): ?>
            <div class="block block-brands clients">
            <div class="container">
                <div class="block-brands__slider">
                    <div class="owl-carousel">
                        <?php if($clients->photos): ?>
                            <?php $__currentLoopData = $clients->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($obj->media): ?>
                                    <div class="block-brands__item">
                            <a href="javascript:void(0)"><img src="<?php echo e(asset($obj->media->file_path)); ?>" alt=""></a>
                        </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- .block-brands / end -->
        <div class="block block-banner store">
            <div class="container">
                <div class="block-banner__title"> Store Near You </div>
                <form class="form-inline">
                    <div class="form-group mb-2 cl-1">
                        <select class="js-example-basic-single form-control " name="state">
                        </select>
                    </div>
                    <div class="form-group ml-sm-3 mb-2  cl-2">
                        <select class="js-example-basic-single form-control " name="district">
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2 cl-3">
                        <select class="js-example-basic-single form-control " name="dealers">
                        </select>
                    </div>
                    <button type="button" onclick="fetch()" class="btn btn-primary mb-2 cl-4"><i class="fas fa-search"></i> <span> Search </span></button>
                </form>

                <div class="row mt-3" id="branch_results">
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('head'); ?>
    <style>
        .branch-results{ 
            border-radius: 5px;
            padding: 20px;
            color: #fff;
            background: #3970ad;
            position: relative;
        }
        .branch-results::after{ 
            content: "";
            position: absolute;
            left: 10px;
            top: 10px;
            border: 1px solid #fff;
            width: calc(100% - 20px);
            height: calc(100% - 20px);
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    <script>
        $( document ).ready(function() {

            function build_temp_brach(slug,name,address,mobile) {
                if(mobile == null){
                    return '<div class="col-12 col-md-6"><a href="'+baseUrl+'/store-locator/'+slug+'/"><div class="branch-results"><b>'+name+'</b><p>'+address+'</p></div></a></div>'
                }
                return '<div class="col-12 col-md-6"><a href="'+baseUrl+'/store-locator/'+slug+'/"><div class="branch-results"><b>'+name+'</b><p>'+address+'<br>Call '+mobile+'</p></div></a></div>'
            }

            function fetch_branch(state=null,district=null,brach=null) {
                $.get('<?php echo e(url('branch/list')); ?>?district='+district+'&state='+state+'&dealer='+brach).done(function (data) {
                    data = JSON.parse(data)
                    var op = '';
                    data.forEach(function (item) {
                        op += build_temp_brach(item.slug,item.name,item.address,item.mobile);
                    })
                    $('#branch_results').html(op);
                });
            }


                $.get('<?php echo e(url('/branch/states/')); ?>').done(function (data) {
                    data = JSON.parse(data)
                    var op = '<option>Choose a state</option>';
                    data.forEach(function (item) {
                        console.log(item.name)
                        op += '<option value="'+item.id+'">'+item.name+'</option>'
                    })
                    $('select[name=state]').html(op);
                    // fetch_branch();
                })

                $('select[name=state]').change(function () {
                    var state = $('select[name=state]').val();
                    $.get('<?php echo e(url('/branch/states')); ?>/'+state).done(function (data) {
                        data = JSON.parse(data)
                        var op = '<option>Choose a district</option>';
                        data.forEach(function (item) {
                            console.log(item.name)
                            op += '<option value="'+item.id+'">'+item.name+'</option>'
                        })
                        $('select[name=district]').html(op);
                    });
                    fetch_branch(state);
                })

                $('select[name=district]').change(function () {
                    var state = $('select[name=state]').val();
                    var district = $('select[name=district]').val();
                    $.get('<?php echo e(url('branch/states/branch/')); ?>/'+district).done(function (data) {
                        data = JSON.parse(data)
                        var op = '<option>Choose a branch</option>';
                        data.forEach(function (item) {
                            console.log(item.name)
                            op += '<option value="'+item.id+'">'+item.name+'</option>'
                        })
                        $('select[name=dealers]').html(op);
                    });
                    fetch_branch(state,district);
                })

            function fetch() {
                var state = $('select[name=state]').val();
                var district = $('select[name=district]').val();
                var dealers = $('select[name=dealers]').val();
                fetch_branch(state,district,dealers);
            }







        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hykon\resources\views/hykon/pages/home.blade.php ENDPATH**/ ?>