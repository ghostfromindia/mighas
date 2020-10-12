<?php if($address): ?>
   <?php if($address->is_default == 1 && $from == 'home'): ?>
   <div class="address-card__badge">Default Address</div>
   <?php elseif($address->is_default == 1): ?>
   <div class="address-card__badge">Default</div>
   <?php endif; ?>
   <div class="address-card__body" id="card-body-<?php echo e($address->id); ?>">
      <div class="address-card__name"><?php echo e($address->full_name); ?></div>
      <div class="address-card__row">
         <?php echo e($address->address1); ?>

         <br/>
         <?php if($address->address2): ?>
            <?php echo e($address->address2); ?>

            <br/>
         <?php endif; ?>
         <?php if($address->landmark): ?>
            <?php echo e($address->landmark); ?>

            <br/>
         <?php endif; ?>
         <?php echo e($address->city); ?>, 
         <?php echo e($address->state_name); ?>,
         <?php echo e($address->pincode); ?>

      </div>
      <div class="address-card__row">
         <div class="address-card__row-title">Phone Number</div>
         <div class="address-card__row-content"><?php echo e($address->phone); ?></div>
      </div>
      <div class="address-card__row">
         <div class="address-card__row-title">Address Type</div>
         <?php if($address->type == 1): ?>
            <div class="address-card__row-content">Home</div>
         <?php else: ?>
            <div class="address-card__row-content">Work</div>
         <?php endif; ?>
      </div>
      <div class="address-card__row" <?php if($from != 'cart'): ?> style="display:none" <?php endif; ?>>
         <a href="<?php echo e(url('account/address/add-delivery-instructions', [$address->id])); ?>" data-target="#common-modal" class="address-deliver show-modal text-secondary" style="text-decoration:underline;" id="address-deliver-<?php echo e($address->id); ?>" data-id="<?php echo e($address->id); ?>" >Add delivery instructions</a>
      </div>
      <div class="address-card__footer">
         <?php if($from == 'home'): ?>
            <a href="<?php echo e(url('account/address', ['home', $address->id])); ?>" class="show-modal" data-target="#common-modal">Edit Address</a>
         <?php else: ?>
            <a href="<?php echo e(url('account/address', ['address', $address->id])); ?>" class="show-modal" data-target="#common-modal">Edit</a>
            <a href="javascript:void(0)" class="address-list-default" id="address-list-default-<?php echo e($address->id); ?>" data-id="<?php echo e($address->id); ?>" <?php if($address->is_default == 1): ?> style="display:none" <?php endif; ?>>&nbsp;|&nbsp;Make Default</a>
            
         <?php endif; ?>
            <?php if($from == 'cart'): ?>
            <div align="center" onclick="deliverHere(<?php echo e($address->id); ?>)" style="cursor:pointer;background: rgb(136, 111, 168); width: 100%; padding: 10px; color: white; font-weight: bold;">
               Deliver Here
            </div>
            <?php endif; ?>

      </div>
   </div>
<?php endif; ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/client/includes/address.blade.php ENDPATH**/ ?>