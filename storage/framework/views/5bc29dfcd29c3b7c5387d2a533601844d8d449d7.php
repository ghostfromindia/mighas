<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">All Offers</span>
              <div >
                  <div class="btn-group">
                      <a href="<?php echo e(url('admin/offers/create')); ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                  </div>
              </div>
            </div>
            <!-- START card -->
            <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="<?php echo e(url('admin/offers')); ?>" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10">ID</th>
                            <th class="table-width-120">Name</th>
                            <th class="table-width-120">Type</th>
                            <th class="table-width-120">Validity Start Date</th>
                            <th class="table-width-120">Validity End Date</th>
                            <th class="table-width-120">Created On</th>
                            <th class="nosort nosearch table-width-10">Status</th>
                            <th class="nosort nosearch table-width-10">Edit</th>
                            <th class="nosort nosearch table-width-10">Delete</th>
                        </tr>

                        <tr>
                            <th class="table-width-10 nosort nosearch"></th>
                            <th class="table-width-10 searchable-input">Name</th>
                            <th class="table-width-120"><?php echo Form::select('type', array(''=>'All', 'Price'=>'Price', 'Combo'=>'Combo', 'Free'=>'Free'), null, array('class'=>'select-box-input select2-dropdown'));; ?></th>
                            <th class="table-width-120 searchable-input">Validity Start Date</th>
                            <th class="table-width-120 searchable-input">Validity End Date</th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                        </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>
            </div>
            <!-- END card -->
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>

    <script>
        var my_columns = [
            {data: null, name: 'id'},
            {data: 'offer_name', name: 'offer_name'},
            {data: 'type', name: 'type'},
            {data: 'validity_start_date', name: 'validity_start_date'},
            {data: 'validity_end_date', name: 'validity_end_date'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'is_active', name: 'is_active'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [5, 'asc'];
    </script>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/offers/index.blade.php ENDPATH**/ ?>