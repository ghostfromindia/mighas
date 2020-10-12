<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui/css/blog.css')); ?>">
<?php $__env->stopSection(); ?>
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
                                <use xlink:href="images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>Blog Detail</h1>
            </div>
        </div>
    </div>
</div>
<section class="blog_detail">

    <div class="container">
        <div class="index-filter-bar color-scheme-light minimal">
            <div class="index-sort-w">
                <div class="index-sort-label"><i class=""></i><span>Order By</span></div>
                <div class="index-sort-options">
                    <a href="<?php echo e(url('blog?sort=latest')); ?>" class="index-sort-option index-sort-hearts">Latest</a>
                    <a href="<?php echo e(url('blog?sort=views')); ?>"  class="index-sort-option index-sort-views">Most Views</a>
                </div>
            </div>
        </div>
        <div class="row">

            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                <div class="post-blog__single">
                    <div class="post-media-body">
                        <div class="figure-link-w">
                            <a href="<?php echo e(url('blog/'.$obj->slug)); ?>" class="figure-link ">
                                <figure class="abs-image">
                                    <?php if(isset($obj->featured_image)): ?>
                                        <img src="<?php echo e($obj->featured_image->file_path); ?>" class="attachment-pluto" alt="">
                                    <?php else: ?>
                                        <img src="" class="attachment-pluto" alt="">
                                    <?php endif; ?>
                                </figure>
                            </a>
                        </div>
                    </div>
                    <div class="post-content-body">
                        <h4 class="post-title entry-title">
                            <a href="<?php echo e(url('blog/'.$obj->slug)); ?>"><?php echo e($obj->primary_heading); ?></a>
                        </h4>
                        <div class="post-content entry-summary">
                            <span><?php echo e($obj->short_description); ?></span>
                            <div class="read-more-link">
                                <a href="<?php echo e(url('blog/'.$obj->slug)); ?>">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="post-meta entry-meta td-tm">
                        <div class="meta-date meta_inner">
                            <i class="fas fa-clock"></i>
                            <time class="entry-date updated"><?php echo e(\Carbon\Carbon::parse($obj->created_at)->format('d F')); ?></time>
                        </div>

                        <div class="meta-like meta_inner">
                            <a href="#" class="os-like-button">
                                           <span class="os-like-button-icon">
                                              <i class="fas fa-eye"></i>
                                              </span>
                                <span class="os-like-button-sub-label osetin-vote-count">
                                                 <?php echo e($obj->views); ?>

                                              </span>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>


</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/blog.blade.php ENDPATH**/ ?>