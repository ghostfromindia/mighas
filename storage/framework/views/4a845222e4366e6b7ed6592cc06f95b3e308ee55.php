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
    <!-- site__body -->
    <div class="  block m-0  event-banner-bg">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-12 col-lg-8  ">
                    <?php if($event->featured_image): ?>
                        <img src="<?php echo e(asset($event->featured_image->file_path)); ?>" width="100%" />
                    <?php endif; ?>
                </div>
                <div class="col-12 col-lg-4  ">
                    <h3><?php echo e($event->primary_heading); ?></h3>
                    <b><?php echo e(Carbon\Carbon::parse($event->event_date_time)->format('Y')); ?></b><br>
                    
                    <p><?php echo e($event->short_description); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-header">
        <div class="page-header__container container  ">

            <div class="block-finder__header text-left">
                <div class="row">
                    <div class="col-xl-8 col-md-8">
                        <div class="block-finder__subtitle text-left event-det">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">ABOUT EVENT</a>
                                </li>
                                <?php if($event->top_description): ?>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">EVENT DETAIL</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                   <?php echo $event->content; ?>

                                </div>
                                <?php if($event->top_description): ?>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <?php echo $event->top_description; ?>

                                </div>
                                <?php endif; ?>

                            </div>



                        </div>
                    </div>

                    <div class="col-md-4 col-md-4">
                        <?php if(empty(session('event-enquiry'))): ?>
                            <div class="enquiries__form floating-div">
                                <div class="form-wrapper contact-form-wrapper form-white-bg">
                                    <div class="header_top text-center">
                                        <h3>Enquiry <span>Form</span></h3>
                                    </div>
                                    <span style="color: red" id="blog-enquiry-error"></span>
                                    <form id="blog-enquiry" action="<?php echo e(url('lead')); ?>"  method="post"> <?php echo csrf_field(); ?>
                                        <input type="hidden" name="form" value="event-enquiry">
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
                <hr/>
            </div>



            <?php if(count($upcoming_events) > 0): ?>
            <div class="block-finder__header text-left  ">
                <div class="container">

                    <div class="past-events">
                        <div class="pe-head text-center">
                            <h2>Upcoming Events</h2>
                        </div>
                        <div class="pe-list">
                            <?php $__currentLoopData = $upcoming_events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row pe--row justify-content-center align-self-center">
                                    <div class="col-md-3 p-0 align-self-center">
                                        <div class="pesingle-left">
                                            <?php if($obj->featured_image): ?>
                                                <a href="<?php echo e(url('event/'.$obj->slug)); ?>"><img src="<?php echo e(asset($obj->featured_image->file_path)); ?>" alt=""></a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="bottom_btn">
                                    <span class="btn-vw">
                                        <a href="<?php echo e(url('event/'.$obj->slug)); ?>">View Event</a>
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-md-9 p-0">
                                        <div class="pesingle-right">
                                    <span class="list-card__date">
                                        <?php echo e(\Carbon\Carbon::parse($obj->event_date_time)->format('Y')); ?>

                                    </span>
                                            <span class="list-card__title">
                                                <a href="<?php echo e(url('event/'.$obj->slug)); ?>"> <?php echo e($obj->primary_heading); ?></a>
                                    </span>
                                        </div>
                                        <div class="bottom_s_pe">
                                            <div class="bottom_s_pe-item">
                                                <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                            </div>
                                            <div class="bottom_s_pe-item">
                                                <i class="fab fa-twitter" aria-hidden="true"></i>
                                            </div>
                                            <div class="bottom_s_pe-item">
                                                <i class="fab fa-linkedin" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif; ?>


            <?php if(count($past_events) > 0): ?>
            <div class="block-finder__header text-left    ">
                <div class="pe-head text-center">
                    <h2>Past Events</h2>
                </div>
                <div class="row me--row">
                    <?php $__currentLoopData = $upcoming_events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3">
                        <div class="me-single">
                            <div class="mes-img">
                                <?php if($obj->featured_image): ?>
                                    <a href="<?php echo e(url('event/'.$obj->slug)); ?>"><img src="<?php echo e(asset($obj->featured_image->file_path)); ?>" alt=""></a>
                                <?php endif; ?>
                            </div>
                            <div class="me_detail">
                            <span class="list-card__date">
                               <?php echo e(\Carbon\Carbon::parse($obj->event_date_time)->format('Y')); ?>

                            </span>
                                <span class="list-card__title">
                                <a href="<?php echo e(url('event/'.$obj->slug)); ?>"> <?php echo e($obj->primary_heading); ?></a>
                            </span>
                            </div>
                            <div class="bottom_s_pe me_s_pe">
                                <div class="bottom_s_pe-item">
                                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                </div>
                                <div class="bottom_s_pe-item">
                                    <i class="fab fa-twitter" aria-hidden="true"></i>
                                </div>
                                <div class="bottom_s_pe-item">
                                    <i class="fab fa-linkedin" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
            <?php endif; ?>


        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hykon\resources\views/hykon/pages/event_details.blade.php ENDPATH**/ ?>