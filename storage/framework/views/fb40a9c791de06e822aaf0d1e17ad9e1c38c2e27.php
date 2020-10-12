<div class="settings-item w-100 confirm-wrap">
    <?php
    if($obj->type != 'Image')
        $validate = true;
    else
        $validate = false;
    ?>
        <?php echo e(Form::open(['url' => route('admin.settings.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'SettingsFrm', 'data-validate'=>$validate])); ?>

            <input type="hidden" name="id" value="<?php echo e(encrypt($obj->id)); ?>">
            <input type="hidden" name="type" value="<?php echo e($obj->type); ?>">
                                <?php if($obj->type != 'Image'): ?>
                                <div class="column-seperation padding-5 text-field">
                                    <div class="form-group form-group-default required">
                                        <label>Value</label>
                                        <?php echo e(Form::text("value", $obj->value, array('class'=>'form-control', 'id' => 'value_1'))); ?>


                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="column-seperation padding-5 image-field">
                                    <div class="fileinput fileupload-exists center-block" data-provides="fileupload" >
                                      <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 100px; height: 100px;">
                                        <img src="<?php echo e(asset('public/'.$obj->media->file_path)); ?>"  alt="<?php echo e($obj->value); ?>"/>
                                      </div>
                                      <div>
                                        <span class="btn-file">
                                            <input type="file" name="image" id="image_1" >
                                        </span>
                                      </div>
                                    </div>
                                    <p class="help-block text-info text-center">Click on the image to change</p>
                                </div>
                                <?php endif; ?>
        <?php echo e(Form::close()); ?>                
</div>
<?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/settings/edit.blade.php ENDPATH**/ ?>