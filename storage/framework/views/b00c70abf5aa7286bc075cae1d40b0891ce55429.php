<?php
  $product_attributes = array();
  if($obj->attributes)
    $product_attributes = $obj->attributes->pluck('attribute_value_id')->toArray();
?>
<div class=" container container-fixed-lg">
  <div class="row">
    <?php if(count($attributes)>0): ?>
      <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-lg-4">
        <h5><?php echo e($attribute->attribute_name); ?></h5>
        <?php if($attribute->attribute_type == 'Selectable'): ?>
          <?php $__currentLoopData = $attribute->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="radio radio-success">
                <input type="radio" value="<?php echo e($value->id); ?>" name="attribute_<?php echo e($attribute->id); ?>"  id="value<?php echo e($value->id); ?>" <?php echo e(in_array($value->id, $product_attributes) ? "checked" : ""); ?>>
                <label for="value<?php echo e($value->id); ?>"><?php echo e($value->value); ?></label>     
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
          <div class="row column-seperation padding-5">
              <div class="form-group form-group-default">
                  <?php
                    $attr_value = null;
                    if($obj->attributes)
                    {
                      foreach($obj->attributes as $pAttr){
                        if($pAttr->attribute_id == $attribute->id)
                          $attr_value = $pAttr->attribute_value;
                      }
                    }
                  ?>
                  <?php echo e(Form::textarea('attribute_'.$attribute->id, $attr_value, array('class'=>'form-control'))); ?>

              </div>
          </div>
        <?php endif; ?>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
      <div class="no-result">
        <p>No specifications added for this category!</p>
      </div>
    <?php endif; ?>
  </div>
</div><?php /**PATH C:\xampp\htdocs\hykon\resources\views/admin/products/form/specifications.blade.php ENDPATH**/ ?>