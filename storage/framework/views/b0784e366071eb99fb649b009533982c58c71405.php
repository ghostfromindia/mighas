<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'home'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('content'); ?>
    <!-- site__body -->
    <div class="site__body">
        <?php if(isset($map)): ?>
        <div class="block-map block">
            <div class="block-map__body">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3922.7894074202395!2d76.2176926142853!3d10.517246466801147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba7ee35ee5108fd%3A0x2b061f568a5030eb!2sHykon%20India%20Limited!5e0!3m2!1sen!2sin!4v1589984236037!5m2!1sen!2sin" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
        <?php endif; ?>
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
                            <li class="breadcrumb-item active" aria-current="page"><?php echo e($page->primary_heading); ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="page-header__title">
                    <h1><?php echo e($page->primary_heading); ?></h1>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="container">
                <div class="card mb-0">
                    <div class="card-body contact-us">
                        <div class="contact-us__container">
                            <div class="row">
                                <?php echo $page->content; ?>

                                <?php if(empty(session('contact-us-page'))): ?>
                                <div class="col-12 col-lg-6">
                                    <h4 class="contact-us__header card-title">Leave us a Message</h4>
                                    <span style="color: red" id="contact-us-form-error"></span>
                                    <form method="post" action="<?php echo e(url('lead')); ?>" id="contact-us-form"> <?php echo csrf_field(); ?>
                                        <input type="hidden" name="form" value="contact-us-page">
                                        <input type="hidden" name="type" value="lead">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="form-name">Your Name</label>
                                                <input type="text" id="form-name" name="name" class="form-control" placeholder="Your Name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="form-email">Email</label>
                                                <input type="email" id="form-email" name="email" class="form-control" placeholder="Email Address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="form-subject">Subject</label>
                                            <input type="text" id="form-subject" name="subject" class="form-control" placeholder="Subject">
                                        </div>
                                        <div class="form-group">
                                            <label for="form-message">Message</label>
                                            <textarea id="form-message" class="form-control" name="message" rows="4"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary"  id="contact-us-form-button">Send Message</button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-12 ">
                                    <hr/>
                                </div>
                            </div>


                            <?php if(count($branches) > 0): ?>
                            <div class="row">
                                <div class="col-12 col-lg-12 ">

                                    <h4 class="contact-us__header card-title">Branches</h4>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th scope="col">Sl. No.</th>
                                                <th scope="col">BRANCH</th>
                                                <th scope="col">CONTACT</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th scope="row"><?php echo e(++$loop->index); ?></th>
                                                <td><?php echo e($obj->branch_name); ?></td>
                                                <td><?php echo e($obj->address); ?></td>
                                            </tr>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <?php endif; ?>







                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- site__body / end -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/contact.blade.php ENDPATH**/ ?>