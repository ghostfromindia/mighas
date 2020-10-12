<div class="settings-item w-100 confirm-wrap">
    <?php if($obj->id): ?>
        <?php
            $category_id = $obj->category_id;
        ?>
        <?php echo e(Form::open(['url' => route('admin.category.attribute.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'AttributeFrm'])); ?>

        <input type="hidden" name="id" value="<?php echo e(encrypt($obj->id)); ?>" id="inputId">
    <?php else: ?>
        <?php echo e(Form::open(['url' => route('admin.category.attribute.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'AttributeFrm'])); ?>

    <?php endif; ?>

        <?php if(isset($category_id)): ?>
            <input type="hidden" name="category_id" value="<?php echo e($category_id); ?>">
        <?php else: ?>
            <div class="column-seperation padding-5 text-field">
                <div class="form-group form-group-default required">
                    <label>Category</label>
                    <?php
                        $category_url = url('select2/categories');
                        $categories = [];
                        if($obj->category_id)
                            $categories = [$obj->category_id => $obj->category->category_name];
                    ?>
                    <?php echo e(Form::select("category_id", $categories, $obj->category_id, array('class'=>'form-control select2_input full-width', 'id' => 'category', 'data-select2-url'=>$category_url, 'data-placeholder'=>'Choose category'))); ?>


                </div>
            </div>
        <?php endif; ?>
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Group</label>
                <?php echo e(Form::select("group_id", App\Models\Category\CategoryAttributeGroups::listForSelect('--- Select a Group ---', $category_id), $obj->group_id, array('class'=>'full-width select2-dropdown', 'id' => 'group_id'))); ?>

            </div>
        </div>
        <p class="text-right"><a href="javadcript:void(0)" id="create_new_group">Create New Group</a></p>
        <div class="column-seperation padding-5 text-field" id="new-group-sec" style="display: none;">
            <div class="form-group form-group-default required">
                <label>Group Name</label>
                <?php echo e(Form::text("group_name", null, array('class'=>'form-control', 'id' => 'group_name'))); ?>

            </div>
        </div>
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Name</label>
                <?php echo e(Form::text("attribute_name", $obj->attribute_name, array('class'=>'form-control', 'id' => 'attribute_name'))); ?>

            </div>
        </div>
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default">
                <label>Attribute Type</label>
                <?php echo Form::select('attribute_type', array('Running Text'=>'Running Text', 'Selectable'=>'Selectable'), $obj->attribute_type, array('class'=>'full-width select2-dropdown', 'id'=>'inputAttributeType'));; ?>

            </div>
        </div>
        <div class="column-seperation text-field addmore_holder" <?php if(!$obj->id || $obj->attribute_type == 'Running Text'): ?> style="display: none;" <?php endif; ?>>
            <label>Possible Values</label>
            <div class="input-group add-more-first">
                <input type="text" class="form-control" name="value[]">
                <div class="input-group-append">
                    <a href="javascript:void(0);" class="input-group-text primary addmore_text"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <?php if($obj->id && $obj->values): ?>
                <?php $__currentLoopData = $obj->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" name="value_edit[<?php echo e($value->id); ?>]" value="<?php echo e($value->value); ?>">
                        <div class="input-group-append">
                            <a href="javascript:void(0);" class="input-group-text danger addmore_text_remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <div class="column-seperation padding-5 text-field variant-level-holder" <?php if(!$obj->id || $obj->attribute_type == 'Running Text'): ?> style="display: none;" <?php endif; ?>>
            <div class="form-group form-group-default">
                <label>Variant Level</label>
                <?php echo Form::select('show_as_variant', array('0'=>'None', '1'=>'Level1', '2'=>'Level2', '3'=>'Level3'), $obj->show_as_variant, array('class'=>'full-width select2-dropdown', 'id'=>'inputStatus'));; ?>

            </div>
        </div>
    <?php echo e(Form::close()); ?>

</div><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/category/attributes/form.blade.php ENDPATH**/ ?>