<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui/css/news.css')); ?>">
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
                                    <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                            <li class="breadcrumb-item">
                                <?php if($type == 'News'): ?>
                                    <a href="<?php echo e(url('news')); ?>">News</a>
                                <?php else: ?>
                                    <a href="<?php echo e(url('blog')); ?>">Blogs</a>
                                <?php endif; ?>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo e($blog->primary_heading); ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="page-header__title">
                    <h1><?php echo e($blog->primary_heading); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <section class="blog_detail">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-8 col-sm-12 col-12 blog_detail__col">
                    <div class="ec-share">
                        <div class="ecs_item">
                            <div class="s-share">
                                <ul class="s-share-list small">
                                    <a class="url-item" target="_blank" href="#" rel="noopener">
                                        <li class="share facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </li>
                                    </a>
                                    <a class="url-item" target="_blank" href="#" rel="noopener">
                                        <li class="share twitter">
                                            <i class="fab fa-twitter"></i>
                                        </li>
                                    </a>
                                    <a class="url-item" target="_blank" href="#" rel="noopener">
                                        <li class="share gplus">
                                            <i class="fab fa-google-plus-g"></i>
                                        </li>
                                    </a>
                                    <a class="url-item" target="_blank" href="#" rel="noopener">
                                        <li class="share instagram">
                                            <i class="fab fa-instagram"></i>
                                        </li>
                                    </a>
                                </ul>
                            </div>
                        </div>
                        <div class="ecs_item">
                            <div class="s-date">
                                <span class="e-e"><?php echo e(Carbon\Carbon::parse($blog->created_at)->format('d F Y')); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="entry_content">
                        <div class="blog_thumbnail">
                            <?php if(isset($blog->featured_image)): ?>
                                <img src="<?php echo e(asset($blog->featured_image->file_path)); ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <?php echo $blog->top_description; ?>

                        <?php echo $blog->content; ?>

                        <?php echo $blog->bottom_description; ?>

                    </div>

                </div>
                <div class="col-md-4 col-sm-12 col-12 rt-imp-blk">
                    <!-- <div class="important_links test1">
                      <div class="header_top text-center">
                          <h3>Quick <span>Links</span></h3>
                      </div>
                      <a href="#">
                          <p><i class="fas fa-angle-double-right"></i> License</p>
                      </a>
                      <a href="#">
                          <p><i class="fas fa-angle-double-right"></i> Business Guide</p>
                      </a>
                      <a href="#">
                          <p><i class="fas fa-angle-double-right"></i> Business Services</p>
                      </a>
                      <a href="#">
                          <p><i class="fas fa-angle-double-right"></i> Office Spaces</p>
                      </a>
                  </div> -->
                    <!-- ///// -->
                    <?php if(count($related) > 0): ?>
                    <div class="important_links test2">
                        <div class="header_top text-center">
                            <h3>Related <span>Links</span></h3>
                        </div>
                        <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(url('blog/'.$obj->slug)); ?>">
                                <p><i class="fas fa-angle-double-right"></i> <?php echo e($obj->primary_heading); ?></p>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                    <!-- ///// -->
                    <?php if(empty(session('blog-enquiry'))): ?>
                    <div class="enquiries__form floating-div">
                        <div class="form-wrapper contact-form-wrapper form-white-bg">
                            <div class="header_top text-center">
                                <h3>Enquiry <span>Form</span></h3>
                            </div>
                            <span style="color: red" id="blog-enquiry-error"></span>
                            <form id="blog-enquiry" action="<?php echo e(url('lead')); ?>"  method="post"> <?php echo csrf_field(); ?>
                                <input type="hidden" name="form" value="blog-enquiry">
                                <input type="hidden" name="type" value="lead">

                                <div class="row">
                                    <div class="col-12 col-md-12" style="margin-bottom: 10px">
                                        <input type="text" name="name" class="form-control"
                                               placeholder="Your Name">
                                    </div>
                                    <div class="col-12 col-md-6" style="margin-bottom: 10px">
                                        <input type="email" name="email" class="form-control"
                                               placeholder="Email ID">
                                    </div>
                                    <div class="col-12 col-md-6" style="margin-bottom: 10px">
                                        <input type="text" name="phone"  class="form-control" placeholder="Phone">
                                    </div>
                                    <div class="col-12 col-md-12" style="margin-bottom: 10px">
                                         <textarea cols="10" rows="5"  class="form-control" name="message"
                                                   placeholder="Message"></textarea>
                                    </div>
                                </div>

                                    <button type="submit"  id="blog-enquiry-submit"
                                            class="button button--solid button--block">Submit</button>

                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/blog_details.blade.php ENDPATH**/ ?>