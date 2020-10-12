<?php $__env->startSection('head'); ?>
##parent-placeholder-1a954628a960aaef81d7b2d4521929579f3541e6##
<link href="<?php echo e(asset('assets/css/star-rating-svg.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">All Reviews</span>
            </div>

            <!-- START card -->
            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="<?php echo e(url('admin/reviews')); ?>" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10">ID</th>
                            <th class="table-width-120">Product Name</th>
                            <th class="table-width-120">Title</th>
                            <th class="table-width-120">Rating</th>
                            <th class="nosort nosearch table-width-10">Status</th>
                            <th class="nosort nosearch table-width-10">Edit</th>
                            <th class="nosort nosearch table-width-10">Delete</th>
                            <th class="nodisplay"></th>
                        </tr>

                        <tr>
                            <th class="table-width-10 nosort nosearch"></th>
                            <th class="table-width-120 searchable-input">Product Name</th>
                            <th class="table-width-120 searchable-input">Title</th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nodisplay"></th>
                        </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>
                </div>
            </div>
            <!-- END card -->
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    <script src="<?php echo e(asset('assets/js/jquery.star-rating-svg.min.js')); ?>"></script>
    <script type="text/javascript">
      var my_columns = [
          {data: null, name: 'slno'},
          {data: 'name', name: 'product_variants.name'},
          {data: 'title', name: 'title'},
          {data: 'rating', name: 'rating'},
          {data: 'status', name: 'status'},
          {data: 'action_edit', name: 'action_edit'},
          {data: 'action_delete', name: 'action_delete'},
          {data: 'updated_at', name: 'updated_at'}
      ];
      var slno_i = 0;
      var order = [7, 'desc'];

      $(function(){
        $(".ratings").starRating({
            starSize: 25,
            readOnly: true
        });
      })
    </script>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/reviews/index.blade.php ENDPATH**/ ?>