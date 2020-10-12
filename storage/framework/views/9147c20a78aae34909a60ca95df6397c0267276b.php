<?php $__env->startSection('head'); ?>
    <style type="text/css">
        .info-box {
            display: block;
            min-height: 90px;
            background: #fff;
            width: 100%;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            border-radius: 2px;
            margin-bottom: 15px;
        }

        .info-box-content {
            padding: 5px 10px;
            margin-left: 90px;
        }

        .info-box-text {
            display: block;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: uppercase;
        }

        .info-box-number {
            display: block;
            font-weight: bold;
            font-size: 18px;
        }

        .info-box-icon {
    border-top-left-radius: 2px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 2px;
    display: block;
    float: left;
    height: 90px;
    width: 90px;
    text-align: center;
    font-size: 45px;
    line-height: 90px;
    background: rgba(0,0,0,0.2);
    color: #fff;
}
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
            <div class="row">
                
                 <?php if(null!== session('status')): ?>
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                 </div>
                <?php endif; ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Disable Out of of stock products</span>
                            <a href="<?php echo e(url('admin/switch/out-of-stock/hide')); ?>" class="btn btn-success m-t-10">Disable</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>


                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Enable Out of of stock products</span>
                            <a href="<?php echo e(url('admin/switch/out-of-stock/show')); ?>" class="btn btn-success m-t-10">Enable</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>



                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><a href="<?php echo e(url('admin/orders/1')); ?>" class="text-dark">Pending Orders</a></span>
                      <span class="info-box-number"><?php echo e($pending_orders); ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fa fa-globe" aria-hidden="true"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><a href="<?php echo e(url('admin/orders/4')); ?>" class="text-dark">Pending Return Requests</a></span>
                      <span class="info-box-number"><?php echo e($pending_return_requests); ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fa fa-users" aria-hidden="true"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><a href="<?php echo e(url('admin/users')); ?>" class="text-dark">New Members</a></span>
                      <span class="info-box-number"><?php echo e($new_members); ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fa fa-cog" aria-hidden="true"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><a href="<?php echo e(url('admin/products')); ?>" class="text-dark">Low Stock Products</a></span>
                      <span class="info-box-number"><?php echo e($low_stocks); ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 m-b-10 hidden-xlg">

                    <div id="sales-chart"></div>

                </div>
                <div class="col-md-6 m-b-10 hidden-xlg">

                    <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle full-height d-flex flex-column">
                        <div class="card-header  top-right">
                            <div class="card-controls">
                                <ul>
                                    <li><a data-toggle="refresh" class="card-refresh text-black" href="#"><i class="card-icon card-icon-refresh"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="padding-25">
                            <div class="pull-left">
                                <h2 class="text-success no-margin">Today's Sale</h2>
                            </div>
                            <?php if($todays_sale>0): ?>
                                <h3 class="pull-right semi-bold"><sup>
                                    <small class="semi-bold">₹</small>
                                    </sup> <?php echo e($todays_sale); ?>

                                </h3>
                            <?php endif; ?>
                            <div class="clearfix"></div>
                        </div>
                        <div class="auto-overflow widget-11-2-table">
                            <table class="table table-condensed table-hover">
                                <tbody>
                                    <?php if(count($todays_order)>0): ?>
                                        <?php $__currentLoopData = $todays_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="font-montserrat all-caps fs-12 w-50"><?php echo e($order->name); ?></td>
                                                <td class="font-montserrat all-caps fs-12 w-50">#<?php echo e($order->order_reference_number); ?></td>
                                                <td class="text-right b-r b-dashed b-grey w-25">
                                                    <span class="hint-text small">Qty <?php echo e($order->quantity); ?></span>
                                                </td>
                                                <td class="w-25">
                                                    <span class="font-montserrat fs-18">₹<?php echo e($order->sale_price); ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50 text-danger" colspan="4" style="text-align: center;">Business hours will resume soon..</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="padding-25 mt-auto">
                            <p class="small no-margin">
                                <a href="<?php echo e(url('admin/orders')); ?>"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i> <span class="hint-text ">Show all..</span></a>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
    </div>
<?php $__env->stopSection(); ?>
    <?php $__env->startSection('bottom'); ?>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
    <script src="<?php echo e(asset('assets/js/highcharts.js')); ?>"></script>

    <script type="text/javascript">

        var markers = <?php echo json_encode($sales, 15, 512) ?>;
        markers = jQuery.parseJSON(markers);
        console.log(markers);

        var dt = new Date();
        dt.setDate( dt.getDate() - 6 );

        Highcharts.chart('sales-chart', {

            title: {
                text: 'Sales for the 7 days'
            },

            yAxis: {
                title: {
                    text: 'Sale'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            xAxis: {
                type: 'datetime'
            },
            plotOptions: {
                series: {
                    pointStart: Date.UTC(dt.getFullYear(), dt.getMonth(), dt.getDate()),
                    pointInterval: 24 * 3600 * 1000 // one day
                }
            },

            series: [{
                name: 'Sales',
                data: markers
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
        </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>