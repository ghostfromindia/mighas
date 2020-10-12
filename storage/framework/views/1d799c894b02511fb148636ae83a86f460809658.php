<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="container">
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">All Categories</span>
                <div >
                    <div class="btn-group">
                        <a href="<?php echo e(url('admin/category/import')); ?>" class="btn btn-success"><i class="fa fa-arrow-down"></i> Import</a> &nbsp;&nbsp;
                        <a href="<?php echo e(route('admin.category.create')); ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                        <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="<?php echo e(url('admin/category')); ?>" >
                            <thead id="column-search">
                            <tr>
                                <th class="table-width-10">ID</th>
                                <th class="table-width-120">Slug</th>
                                <th class="table-width-120">Category name</th>
                                <th class="table-width-120">Browser title</th>
                                <th class="table-width-120">Meta Keywords</th>
                                <th class="nosort nosearch table-width-10">Edit</th>
                                <th class="nosort nosearch table-width-10">Delete</th>
                                <th class="nodisplay"></th>
                            </tr>

                            <tr>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-10 searchable-input">Slug</th>
                                <th class="table-width-120 searchable-input">Category name</th>
                                <th class="table-width-120 searchable-input">Browser title</th>
                                <th class="table-width-120 searchable-input">Meta Keywords</th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nodisplay"></th>
                            </tr>

                            </thead>
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
            {data: 'slug', name: 'slug'},
            {data: 'category_name', name: 'category_name'},
            {data: 'browser_title', name: 'browser_title'},
            {data: 'meta_keywords', name: 'meta_keywords'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'},
            {data: 'updated_at', name: 'updated_at'}
        ];
        var slno_i = 0;
        var order = [7, 'desc'];
    </script>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/category/home.blade.php ENDPATH**/ ?>