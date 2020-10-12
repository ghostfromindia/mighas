<?php $__env->startSection('head'); ?>
<style type="text/css">
  .admin-menu-list{
    max-height: 200px;
    overflow: auto;
  }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            <?php if($obj->id): ?>
                <span class="page-heading">EDIT MENU</span>
            <?php else: ?>
                <span class="page-heading">Create NEW MENU</span>
            <?php endif; ?>
            <div >
                <div class="btn-group">
                    <a href="<?php echo e(route($route.'.index')); ?>"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    <?php if($obj->id): ?>
                    <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                    </a>
                    <a href="<?php echo e(route($route.'.destroy', [encrypt($obj->id)])); ?>" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="<?php echo e(route($route.'.index')); ?>"><i class="fa fa-trash"></i> Delete</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">
                <?php if($obj->id): ?>
                    <form method="POST" action="<?php echo e(route($route.'.update')); ?>" class="p-t-15" id="MenuFrm" data-validate=true>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route($route.'.store')); ?>" class="p-t-15" id="MenuFrm" data-validate=true>
                <?php endif; ?>
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" <?php if($obj->id): ?> value="<?php echo e(encrypt($obj->id)); ?>" <?php endif; ?> id="inputId">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row column-seperation padding-5">
                                <div class="form-group form-group-default required">
                                    <label>Menu name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo e($obj->name); ?>" required="">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row column-seperation padding-5">
                                <div class="form-group form-group-default form-group-default-select2">
                                  <label>Menu Position</label>
                                  <select name="position" class="full-width select2_input">
                                    <option value="Header" <?php if($obj->position == 'Header'): ?> selected="selected" <?php endif; ?>>Header</option>
                                    <option value="Footer" <?php if($obj->position == 'Footer'): ?> selected="selected" <?php endif; ?>>Footer</option>
                                    <option value="Main Menu" <?php if($obj->position == 'Main Menu'): ?> selected="selected" <?php endif; ?>>Main Menu</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row column-seperation padding-5">
                                <div class="form-group form-group-default form-group-default-select2">
                                  <label>Menu Type</label>
                                  <select name="menu_type" class="full-width select2_input">
                                    <option value="0" <?php if($obj->menu_type == '0'): ?> selected="selected" <?php endif; ?>>Normal</option>
                                    <option value="1" <?php if($obj->menu_type == '1'): ?> selected="selected" <?php endif; ?>>Mega Menu</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row column-seperation padding-5">
                                <div class="form-group form-group-default required">
                                    <label>Menu Order</label>
                                    <input type="number" name="menu_order" class="form-control" value="<?php echo e($obj->menu_order); ?>" >
                                </div>
                            </div>
                        </div>
                        <p class="col-md-12">Menu Settings ( Select and add menus to right )  </p> 
                            <div class="col-md-4"> 
                              <div class="custom-accordion">
                                <div class="accord-header">Pages<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content accord-on">
                                  <?php if($pages): ?>
                                    <div class="admin-menu-list">
                                      <?php echo $pages; ?>

                                    </div>
                                    <p class="text-right mt-2">
                                      <button type="button" id="add-page-links" class="btn btn-primary btn-sm add-links">Add to Menu</button>
                                    </p>
                                  <?php endif; ?>
                                </div>
                                <div class="accord-header">Internal Links<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content">
                                  <?php if($front_pages): ?>
                                      <div class="admin-menu-list">
                                        <?php echo $front_pages; ?>

                                      </div>
                                      <p class="text-right mt-2">
                                        <button type="button" id="add-internal-links" class="btn btn-primary btn-sm add-links">Add to Menu</button>
                                      </p>
                                  <?php endif; ?>
                                </div>
                                <div class="accord-header">Categories<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content">
                                  <?php if($categories): ?>
                                      <div class="admin-menu-list">
                                        <?php echo $categories; ?>

                                      </div>
                                      <p class="text-right mt-2">
                                        <button type="button" id="add-category-links" class="btn btn-primary btn-sm add-links">Add to Menu</button>
                                      </p>
                                  <?php endif; ?>
                                </div>
                                <div class="accord-header">Brands<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content">
                                  <?php if($brands): ?>
                                      <div class="admin-menu-list">
                                        <?php echo $brands; ?>

                                      </div>
                                      <p class="text-right mt-2">
                                        <button type="button" id="add-brand-links" class="btn btn-primary btn-sm add-links">Add to Menu</button>
                                      </p>
                                  <?php endif; ?>
                                </div>
                                <div class="accord-header">Custom Links<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content">
                                  <div class="row column-seperation padding-5">
                                      <div class="form-group form-group-default required">
                                          <label>Link Text</label>
                                          <input type="text" name="custom_link_text" class="form-control" id="inputCustomLinkText">
                                      </div>
                                  </div>
                                  <div class="row column-seperation padding-5">
                                      <div class="form-group form-group-default required">
                                          <label>Url</label>
                                          <input type="text" name="custom_url" class="form-control" id="inputCustomUrl">
                                      </div>
                                  </div>
                                  <div class="row column-seperation padding-5">
                                    <div class="checkbox">
                                      <input type="checkbox" id="inputTarget"><label for="inputTarget"> New Window</label>
                                    </div>
                                  </div>
                                  <div class="row column-seperation padding-5 text-right">
                                      <button type="button" id="add-custom-links" class="btn btn-primary btn-sm">Add to Menu</button>
                                  </div>
                                </div>
                              </div> 
                            </div>
                            <div class="col-md-8">
                              <div class="dd">
                                  <ol class="dd-list custom-accordion-menu">
                                    <?php if($obj->id && $obj->menu_items): ?>
                                      <?php echo $__env->make('admin.menus.menu', ['items'=>$obj->menu_items], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
                                  </ol>
                              </div>
                              <input type="hidden" name="menu_settings" id="inputMenuSettings">
                              <span class="error"></span>
                            </div>
                            <div class="col-md-12">
                              <div class="btn-holder text-right">
                                  <button type="button" class="btn btn-primary m-2" id="save-btn">Save</button>
                              </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    <script src="<?php echo e(asset('assets/js/jquery.nestable.js')); ?>"></script> 
    <script type="text/javascript">
        $(document).ready(function(){
            $('.dd').nestable({ 
                expandBtnHTML: '',
                collapseBtnHTML: ''
              });
            var validator = $("#MenuFrm").validate({
                ignore: [],
                errorPlacement: function(error, element){
                    $(element).each(function (){
                        $(this).parent('div').find('span.error').html(error);
                    });
                },
                rules: {
                  name: "required",
                  menu_settings: "required",
                },
                messages: {
                  name: "Enter menu name",
                  menu_settings: "Setup a menu using menu settings",
                },
              });

            $(document).on('click', '#save-btn', function(){
              if($('.dd').nestable('serialize') != '')
                $('#inputMenuSettings').val(JSON.stringify($('.dd').nestable('serialize')));
              if($("#MenuFrm").valid())
              {
                $('#MenuFrm').submit();
              }
            })

            $(document).on('click', '#add-custom-links', function(){
                var name = $('#inputCustomLinkText').val();
                var url = $('#inputCustomUrl').val();
                if(name != '' && url != '')
                {
                    $('#inputCustomLinkText').removeClass('errorBox');
                    $('#inputCustomUrl').removeClass('errorBox');
                    var id = 'custom_link-'+name;
                    var target_blank = 0;
                    var checked = "";
                    if($("#inputTarget").is(":checked"))
                    {
                      target_blank = 1
                      checked = "checked";
                    }
                    var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="pull-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div><div class="accord-content"><div class="form-group required"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/></div><div class="form-group required"><label class="control-label" for="inputCode">Url</label><input type="text" name="menu['+id+'][url]" class="form-control" value="'+url+'"/></div><div class="form-group required"><div class="checkbox"><input type="checkbox" name="menu['+id+'][target_blank]" '+checked+' id="target-'+id+'"/><label for="target-'+id+'"> New Window</label></div></div><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/><input type="hidden" name="menu['+id+'][original_title]" value="'+name+'"/><p class="menu-original-text"> Original: '+name+'</p><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
                    var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
                    $('.dd > .dd-list').append(html);
                    $('input').iCheck({
                      checkboxClass: 'icheckbox_square-blue',
                      radioClass: 'iradio_square-blue',
                      increaseArea: '20%' // optional
                    });
                    $('.dd').nestable();
                    $('#inputCustomLinkText').val('');
                    $('#inputCustomUrl').val('');
                    $("#inputTarget").iCheck('uncheck');
                }
                else{
                  if(name == "")
                    $('#inputCustomLinkText').addClass('errorBox');
                  else
                    $('#inputCustomLinkText').removeClass('errorBox');

                  if(url == "")
                    $('#inputCustomUrl').addClass('errorBox');
                  else
                    $('#inputCustomUrl').removeClass('errorBox');
                }
            });

            $(document).on('click', '.add-links', function(){
                var id = $(this).attr('id');
                var link_class = ''
                if(id == 'add-page-links')
                  link_class = 'page_links';
                else if(id == 'add-internal-links')
                  link_class = 'frontpage_links';
                else if(id == 'add-category-links')
                  link_class = 'category_links';
                else if(id == 'add-brand-links')
                  link_class = 'brand_links';


                $("."+link_class+":checked").each(function () {
                    var id = $(this).val();
                    var name = $(this).attr('data-name');
                    var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="pull-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div><div class="accord-content"><div class="form-group required"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/><input type="hidden" name="menu['+id+'][id]" value="'+$(this).attr('data-id')+'"/><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/></div><p class="menu-original-text"> Original: '+name+'</p><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
                    var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
                    $('.dd > .dd-list').append(html);
                    $('.dd').nestable();
                    $(this).prop('checked', false);
                });
            });

            $(document).on('click', '.custom-accordion .accord-header', function(){
                if($(this).next("div").is(":visible")){
                  $(this).next("div").slideUp("slow");
                  $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
                } else {
                  $(".custom-accordion .accord-content").slideUp("slow");
                  $('.toggle-arraow').each(function(i, e) {
                    $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
                  });
                  $(this).next("div").slideToggle("slow");
                  $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
                }
            });

            $(document).on('click', '.custom-accordion-menu .accord-header', function(){
                if($(this).next("div").is(":visible")){
                  $(this).next("div").slideUp("slow");
                  $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
                } else {
                  $(".custom-accordion-menu .accord-content").slideUp("slow");
                  $('.toggle-arraow').each(function(i, e) {
                    $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
                  });
                  $(this).next("div").slideToggle("slow");
                  $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
                }
            });

            $(document).on('click', '.remove-menu', function(){
              $(this).parents('.accord-content').parent().remove();
              $('.dd').nestable();
            });

            $(document).on('keyup', '.menu-title-input', function(){
              $(this).parents('.accord-content').siblings('.accord-header').find('.menu-title').html($(this).val());
            })
        
          });
    </script>
##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/menus/form.blade.php ENDPATH**/ ?>