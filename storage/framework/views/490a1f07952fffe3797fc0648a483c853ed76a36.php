<?php $__env->startSection('head'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">Add new Settings </span>
          <div >
              <div class="btn-group">
                  <a href="<?php echo e(url('admin/settings')); ?>" class="btn btn-success"><i class="fa fa-list"></i> List General Settings</a>
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                <?php echo e(Form::open(['url' => route('admin.settings.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'SettingsFrm'])); ?>


                <div class="padding-20">
                        <div class="settings-item row">
                            <div class="col-md-3">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Type</label>
                                        <?php echo Form::select('type[]', array('Text'=>'Text', 'Image'=>'Image'), null, array('class'=>'form-control select2_input full-width select2-dropdown input_type', 'id'=>'type_1'));; ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Key</label>
                                        <?php echo e(Form::text("code[]", null, array('class'=>'form-control', 'id' => 'code_1'))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row column-seperation padding-5 text-field">
                                    <div class="form-group form-group-default required">
                                        <label>Value</label>
                                        <?php echo e(Form::text("value[]", null, array('class'=>'form-control', 'id' => 'value_1'))); ?>


                                    </div>
                                </div>
                                <div class="row column-seperation padding-5 image-field" style="display: none;">
                                    <div class="fileinput fileinput-new" data-provides="fileinput" >
                                      <a href="#" class="file-remove" data-dismiss="fileinput"><i class="fa  fa-times-circle"></i></a>
                                      <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 100px; height: 100px;"></div>
                                      <div>
                                        <span class="btn-file">
                                          <input type="file" name="image[]" id="image_1" >
                                        </span>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 center-block">
                                
                            </div>
                          </div>
                          <div class="row bottom-btn">
                            <div class="col-md-12" align="right">
                                <a href="javascript:void(0);" class="btn btn-success btn-addnew">Add New</a>
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
  <script type="text/javascript" src="<?php echo e(asset('public/js/fileinput.js')); ?>"></script>

    <script>
      var idInc = 2;
      $(document).ready(function(){

        $(document).on('change', '.input_type', function(){
          if($(this).val() == 'Image')
          {
            $(this).parents('.settings-item').find('.image-field').show();
            $(this).parents('.settings-item').find('.text-field').hide();
          }
          else{
            $(this).parents('.settings-item').find('.image-field').hide();
            $(this).parents('.settings-item').find('.text-field').show();
          }
        });

        $(document).on('click', '.btn-addnew', function(){
          var html ='<div class="settings-item row "><div class="col-md-3"><div class="row column-seperation padding-5"><div class="form-group form-group-default form-group-default-select2 required"><label>Type</label><select class="form-control select2_input full-width select2-dropdown input_type" name="type[]" id="type_'+idInc+'"><option value="Text">Text</option><option value="Image">Image</option><option value="Url">Url</option></select></div></div></div><div class="col-md-4"><div class="row column-seperation padding-5"><div class="form-group form-group-default required"><label>Key</label><input class="form-control" name="code[]" type="text" id="code_'+idInc+'"></div></div></div><div class="col-md-4"><div class="row column-seperation padding-5 text-field"><div class="form-group form-group-default required"><label>Value</label><input class="form-control" name="value[]" type="text" id="value_'+idInc+'"></div></div><div class="row column-seperation padding-5 image-field" style="display: none;"><div class="fileinput fileinput-new" data-provides="fileinput" ><a href="#" class="file-remove" data-dismiss="fileinput"><i class="fa  fa-times-circle"></i></a><div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 100px; height: 100px;"></div><div><span class="btn-file"><input type="file" name="image[]" id="image_'+idInc+'"></span></div></div></div></div><div class="col-md-1 center-block"><div class="form-group"><a href="javascript:void(0);" class="btn btn-danger remove-row">X</a></div></div></div>';
          $(html).insertBefore('.bottom-btn');
          $('.input_type').select2();
          idInc++;
        });

        $(document).on('click', '.remove-row', function(){
          $(this).parents('.settings-item').remove();
        })

        $.extend( $.validator.prototype, {
          checkForm: function () {
            this.prepareForm();
            for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
              if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
                for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                this.check(this.findByName(elements[i].name)[cnt]);
                }
              } else {
                this.check(elements[i]);
              }
            }
            return this.valid();
          },
          showErrors: function( errors ) {
          if ( errors ) {
            var validator = this;

            // Add items to error list and map
            $.extend( this.errorMap, errors );
            this.errorList = $.map( this.errorMap, function( message, name ) {
              return {
                message: message,
                element: validator.findById(name)[0]
              };
            });

            // Remove items from success list
            this.successList = $.grep( this.successList, function( element ) {
              return !( element.name in errors );
            } );
          }
          if ( this.settings.showErrors ) {
            this.settings.showErrors.call( this, this.errorMap, this.errorList );
          } else {
            this.defaultShowErrors();
          }
        },
        findById: function( id ) {
          // select by name and filter by form for performance over form.find(“[id=…]”)
          var form = this.currentForm;
          return $(document.getElementById(id)).map(function(index, element) {
          return element.form == form && element.id == id && element || null;
          });
        },
      });

       var validator = $('#SettingsFrm').validate({
          rules: {
            "code[]": "required",
            "value[]": {
              required:{
                depends: function(element){
                  var id = element.id;
                  var data = id.split('_');
                  var type_id = data[1];
                  if($('#type_'+type_id).val()!='Image')
                  {
                    return true;
                  }
                }
              }
            },
            "image[]": {
              required:{
                depends: function(element){
                  var id = element.id;
                  var data = id.split('_');
                  var type_id = data[1];
                  if($('#type_'+type_id).val() =='Image')
                  {
                    return true;
                  }
                }
              }
            },
          },
          messages: {
            "code[]": "Key cannot be blank",
            "value[]": "Value cannot be blank",
            "image[]": "Value image cannot be blank",
          },
        });
      });
    </script>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/settings/form.blade.php ENDPATH**/ ?>