<nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">

        <?php echo e(Key::get('site_name')); ?>

        <div class="sidebar-header-controls">
            <button type="button" class="btn btn-link d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
            </button>
        </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu" style="margin-top: 20px;">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <?php echo app('arrilot.widget')->run('AdminMenu'); ?>

        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/common/nav.blade.php ENDPATH**/ ?>