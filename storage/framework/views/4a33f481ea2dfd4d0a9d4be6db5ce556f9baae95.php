<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="container">
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">All Pages</span>
                <div >
                    <div class="btn-group">
                        <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                        <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="<?php echo e(route($route.'.index')); ?>" >
                            <thead id="column-search">
                            <tr>
                                <th class="table-width-10">ID</th>
                                <th class="table-width-120">Type</th>
                                <th class="table-width-120">Slug</th>
                                <th class="table-width-120">Title</th>
                                <th class="table-width-120">Browser title</th>
                                <th class="nosort nosearch table-width-10">Status</th>
                                <th class="nosort nosearch table-width-10">Edit</th>
                                <th class="nosort nosearch table-width-10">Delete</th>
                            </tr>

                            <tr>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-10 searchable-input">Type</th>
                                <th class="table-width-10 searchable-input">Slug</th>
                                <th class="table-width-120 searchable-input">Title</th>
                                <th class="table-width-120 searchable-input">Browser title</th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nosort nosearch table-width-10"></th>
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

    <script>
        var my_columns = [
            {data: null, name: 'id'},
            {data: 'type', name: 'type'},
            {data: 'slug', name: 'slug'},
            {data: 'name', name: 'name'},
            {data: 'browser_title', name: 'browser_title'},
            {data: 'status', name: 'status'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [4, 'desc'];
    </script>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hykon\resources\views/admin/pages/index.blade.php ENDPATH**/ ?>