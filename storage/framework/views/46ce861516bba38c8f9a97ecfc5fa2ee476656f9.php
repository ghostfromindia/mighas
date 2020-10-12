<?php $__env->startSection('head'); ?>
  <style type="text/css">
    .dataTables_wrapper .row > div{
      display: block !important;
    }

    div.dataTables_wrapper div.dataTables_length label {
        font-weight: normal;
        text-align: left;
        white-space: nowrap;
    }

    div.dataTables_wrapper div.dataTables_filter {
        text-align: right;
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 75px;
        display: inline-block;
    }
  </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
                        <!-- START BREADCRUMB -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/products')); ?>">All Products</a></li>
                <li class="breadcrumb-item active"><?php echo e($obj->product_name); ?></li>
            </ol>
                        <!-- END BREADCRUMB -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">Edit Product</span>
          <div >
              <div class="btn-group">
                  <a href="<?php echo e(url('admin/products')); ?>" class="btn btn-success"><i class="fa fa-list"></i> List Products</a>
                  <?php if($obj->id): ?>
                    <a href="<?php echo e(url('admin/products/create')); ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                    <a href="<?php echo e(url('admin/products/variants/create', [$obj->id])); ?>" class="btn btn-success"> <i class="fa fa-plus"></i> Add New Varient</a>
                    <a href="<?php echo e(url('admin/products/destroy', [encrypt($obj->id)])); ?>" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="<?php echo e(url('admin/products')); ?>"><i class="fa fa-trash"></i> Delete</a>
                  <?php endif; ?>
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                <?php echo e(Form::open(['url' => route('admin.products.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'ProductFrm'])); ?>

                <input type="hidden" name="id" value="<?php echo e(encrypt($obj->id)); ?>" id="inputId">
                <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a <?php if(!$tab): ?> class="active show" <?php endif; ?> data-toggle="tab" role="tab"
                           data-target="#tab1Basic"
                        href="#" aria-selected="true">Basic Details</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" role="tab"
                           data-target="#tab2Basic"
                        href="#" aria-selected="true">SEO</a>
                    </li>
                    <?php if($varients >1): ?>
                      <li class="nav-item">
                          <a <?php if($tab == 'variants'): ?> class="active show" <?php endif; ?> data-toggle="tab" role="tab"
                             data-target="#tab3Basic"
                          href="#" aria-selected="true">Variants</a>
                      </li>
                    <?php else: ?>
                      <li class="nav-item">
                          <a data-toggle="tab" role="tab"
                             data-target="#tab3Basic"
                          href="#" aria-selected="true">Product Details</a>
                      </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a data-toggle="tab" role="tab"
                           data-target="#tab4Basic"
                        href="#" aria-selected="true">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" role="tab"
                           data-target="#tab5Basic"
                        href="#" aria-selected="true">Specifications</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane <?php if(!$tab): ?> active show <?php endif; ?>" id="tab1Basic">
                        <div class="row">
                            <?php echo $__env->make('admin.products.form.basic', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2Basic">
                        <div class="row">
                            <?php echo $__env->make('admin.products.form.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <?php if($varients >1): ?>
                    <div class="tab-pane <?php if($tab == 'variants'): ?> active show <?php endif; ?>" id="tab3Basic">
                        <div >
                            <?php echo $__env->make('admin.products.variants.list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <?php else: ?>
                      <div class="tab-pane" id="tab3Basic">
                        <div class="row">
                          <?php echo $__env->make('admin.products.variants.product_common', ['product'=>$obj, 'from_product'=>1, 'obj'=>$parent_varient], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                      </div>
                    <?php endif; ?>
                    <div class="tab-pane" id="tab4Basic">
                          <?php echo $__env->make('admin.products.variants.gallery', ['product'=>$obj, 'gallery'=>$gallery], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="tab-pane" id="tab5Basic">
                        <?php echo $__env->make('admin.products.form.specifications', ['attributes'=>$attributes], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    <script>
      var my_columns = [
            {data: null, name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'is_default', name: 'is_default'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
      var slno_i = 0;
      var order = [4, 'desc'];

      

      $(document).ready(function(){

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          $('#datatable').css("width", '100%')
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
        });  

        var validator = $('#UserFrm').validate({
          ignore: [],
          invalidHandler: function() {
            if(validator.numberOfInvalids())
            {
                if($('.alert-error').length>0)
                    $('.alert-error').remove();
                  var html = '<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Error:</strong>Oops! look like you have missed some important fields, please check all tabs.</div>';
                  $( html ).insertBefore( ".page-wrapper" );
            }
          },
          rules: {
            first_name: "required",
            last_name: "required",
            email: {
              required: true,
              email: true,
              remote: {
                  url: "<?php echo e(url('validation/user')); ?>",
                  data: {
                    id: function() {
                      return $( "#inputId" ).val();
                  }
                }
              }
            },
            password: {
              required: function(element){
                  return $("#inputId").length<=0;
              }
            },
            password_confirmation: {
              equalTo: "#password",
            },
            phone_number: {
              digits : true,
              maxlength : 10,
            },
          },
          messages: {
            first_name: "First name cannot be blank",
            last_name: "Last name cannot be blank",
            email: {
              required: "Email address cannot be blank",
              remote: "Email is already in use",
            },
            password: "Password cannot be blank",
          },
        });
      });
    </script>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>