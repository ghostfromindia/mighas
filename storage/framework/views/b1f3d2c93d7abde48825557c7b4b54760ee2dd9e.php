<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'career'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('content'); ?>
    <div class="site__body">
        <div class="  block m-0 ">
            <div class="row">
                <div class="col-12 col-lg-12  ">
                    <div class="block-slideshow__body ">
                        <div class="block-slideshow__slide  "  >
                            <?php if($page->banner_image): ?>
                                <img src="<?php echo e(asset($page->banner_image->file_path)); ?>" width="100%" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="page-header">
            <div class="page-header__container container  ">
                <div class="warranty-banner">
                    <h2><?php echo e($page->primary_heading); ?></h2>
                    <p><?php echo $page->content; ?></p>
                </div>


                <div class="row faq">
                    <div class="col-xl-12 col-lg-12">
                        <div class="accordion" id="accordionExample">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">




                                <?php for($i=0;$i<10;$i++): ?>

                                    <div class="card">
                                        <div class="card-header">
                                            <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">


                                                <h2 class="mb-0" itemprop="name">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                                            data-target="#collapseOne-<?php echo e($i); ?>" aria-expanded="false" aria-controls="collapseOne" style="color: black">
                                                        Job title here...</button>
                                                </h2>


                                                <div id="collapseOne-<?php echo e($i); ?>" class="collapse" data-parent="#accordionExample">
                                                    <div class="card-body career-cntr">
                                                        <div itemprop="text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.  </div>

                                                        <h5>spec</h5>
                                                        <ul>
                                                            <li>Lorem Ipsum</li>
                                                            <li>Lorem Ipsum</li>
                                                            <li>Lorem Ipsum</li>
                                                            <li>Lorem Ipsum</li>
                                                            <li>Lorem Ipsum</li>
                                                        </ul>

                                                    </div>


                                                    <button type="button" class="btn btn-primary" onclick="resume(this)" data-job="Lorem Ipsum">
                                                        Post your resume
                                                    </button>

                                                </div>





                                            </div>
                                        </div>
                                    </div>

                                <?php endfor; ?>



                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Post your resume <br><small id="job-post"></small></h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo e(url('company/career')); ?>" id="career-form" enctype="multipart/form-data"> <?php echo csrf_field(); ?>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Name</label>
                                <input type="text" name="name" class="form-control"  required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <input type="hidden" name="job" id="job">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Your resume</label>
                            <input type="file" name="cv" class="form-control-file" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Submt</button>
                    </form>
                </div>

            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>


<?php $__env->startSection('bottom'); ?>
    <script src="<?php echo e(asset('assets/js/additional-methods.min.js')); ?>"></script>
    <script>

        <?php if(session('success')): ?>
        Swal.fire(
            'success!',
            '<?php echo e(session('success')); ?>',
            'success'
        )
        <?php endif; ?>


        function resume(item) {
           $('#job-post').html($(item).data('job'))
           $('#job').val($(item).data('job'))

           $('#staticBackdrop').modal(true);
        }



    </script>

    <script>
        $("#career-form").validate({
            rules:{
                cv:{
                    required:true,
                    extension: "pdf"
                }
            },
            messages: {
                cv:{
                    required:"input type is required",
                    extension:"select valid input file format"
                }
            }
        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hykon\resources\views/hykon/pages/career.blade.php ENDPATH**/ ?>