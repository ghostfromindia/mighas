<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = $category->slug; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::category_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::category_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::category_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::category_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::category_meta($slug,'js')); ?>

<?php $__env->startSection('content'); ?>
    <!-- site__body -->
    <div class="site__body inner-body">




        <div class="  block m-0 ">
            <div class="row">
                <div class="col-12 col-lg-12  ">
                    <div class="block-slideshow__body ">
                        <div class="block-slideshow__slide  "  >
                            <?php if($category->banner): ?>
                                <img src="<?php echo e($category->banner->file_path); ?>" width="100%" />
                            <?php else: ?>
                                <img src="https://via.placeholder.com/1919x671" width="100%" />
                            <?php endif; ?>
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
                            <li class="breadcrumb-item active" aria-current="page"><?php echo e($category->category_name); ?></li>
                        </ol>
                    </nav>
                </div>

                <div class="block-finder__header text-center pb-0">
                    <h1 class="block-finder__title"><?php echo e($category->category_name); ?></h1>
                    <div class="block-finder__subtitle"><?php echo $category->top_description; ?></div>
                    <?php if(isset($category->brochure)): ?>
                        <a class="btn btn-secondary" href="<?php echo e(asset($category->brochure->file_path)); ?>" target="_blank"><i class="fas fa-file-download"></i> DOWNLOAD BROCHURE</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <div class="container">


            <?php $__currentLoopData = $category_by_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



                <?php if($loop->index % 2 == 0): ?>
                    <div class="block cat-list" data-aos="fade-left">
                        <div class="row">
                            <div class="col-12 col-lg-5  ">

                                <?php if($obj->primary): ?>
                                        <img src="<?php echo e($obj->primary->file_path); ?>" class=img-fluid />
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/614x573" class=img-fluid />
                                <?php endif; ?>

                            </div>
                            <div class="col-12 col-lg-7  ">
                                <div class="block-banner__body">
                                    <h3 class="block-banner__title"><?php echo e($obj->category_name); ?></h3>
                                    <div class="block-banner__text"><?php echo $obj->top_description; ?></div>
                                    <div class="block-banner__btn-cntr">
                                        <?php if($obj->has_products() > 0): ?>
                                            <a class="btn btn-primary" href="<?php echo e(url($category->slug.'/'.$obj->slug)); ?>"><i class="far fa-file-pdf"></i> VIEW PRODUCTS</a>
                                        <?php endif; ?>
                                            <?php if(isset($obj->brochure)): ?>
                                                <a class="btn btn-secondary" href="<?php echo e(asset($obj->brochure->file_path)); ?>" target="_blank"><i class="fas fa-file-download"></i> DOWNLOAD</a>
                                            <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="block cat-list list-rht" data-aos="fade-right">
                        <div class="row">

                            <div class="col-12 col-lg-7  ">
                                <div class="block-banner__body">
                                    <h3 class="block-banner__title"><?php echo e($obj->category_name); ?></h3>
                                    <div class="block-banner__text"><?php echo $obj->top_description; ?></div>
                                    <div class="block-banner__btn-cntr">
                                        <?php if($obj->has_products() > 0): ?>
                                        <a class="btn btn-primary" href="<?php echo e(url($category->slug.'/'.$obj->slug)); ?>"><i class="far fa-file-pdf"></i> VIEW PRODUCTS</a>
                                        <?php endif; ?>

                                        <?php if(isset($obj->brochure)): ?>
                                        <a class="btn btn-secondary" href="<?php echo e(asset($obj->brochure->file_path)); ?>" target="_blank"><i class="fas fa-file-download"></i> DOWNLOAD</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5  ">
                                <?php if($obj->primary): ?>
                                    <img src="<?php echo e($obj->primary->file_path); ?>" class=img-fluid />
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/614x573" class=img-fluid />
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hykon\resources\views/hykon/pages/category.blade.php ENDPATH**/ ?>