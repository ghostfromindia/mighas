<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'leadership'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('content'); ?>
    <div class="site__body inner-body">
        <div class="  block m-0 ">
            <div class="row">
                <div class="col-12 col-lg-12  ">
                    <div class="block-slideshow__body ">
                        <div class="block-slideshow__slide  "  >
                            <?php if($pages->banner_image): ?>
                                <img src="<?php echo e(asset($pages->banner_image->file_path)); ?>" width="100%" />
                            <?php endif; ?>
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
                            <li class="breadcrumb-item active" aria-current="page">Leadership</li>
                        </ol>
                    </nav>
                </div>

                <div class="block-finder__header text-center">
                    <h1 class="block-finder__title"><?php echo e($pages->primary_heading); ?></h1>
                    <div class="block-finder__subtitle"><?php echo $pages->content; ?></div>
                </div>



            </div>
        </div>










        <div class="block ">
            <div class="container">


                <div class="row">



                    <?php if(isset($banner->photos)): ?>
                    <div class="col-md-12">
                        <ul class="grid cs-style-1">
                            <?php $__currentLoopData = $banner->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(isset($obj->media)): ?>
                                    <li>
                                        <figure>
                                            <img src="<?php echo e(asset($obj->media->file_path)); ?>" alt="img01">
                                            <figcaption>
                                                <h3><?php echo e($obj->title); ?></h3>
                                                <span><?php echo e($obj->alt_text); ?></span>
                                            </figcaption>
                                        </figure>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>



























                </div>






            </div>
        </div>


















    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/leadership.blade.php ENDPATH**/ ?>