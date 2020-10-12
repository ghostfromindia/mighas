<ul>
                                    <li class="account-nav__item  <?php if(Route::current()->getName() == 'account'): ?> account-nav__item--active <?php endif; ?>">
                                        <a href="<?php echo e(route('account')); ?>">Dashboard</a>
                                    </li>
                                    <li class="account-nav__item  <?php if(Route::current()->getName() == 'account.edit-profile'): ?> account-nav__item--active <?php endif; ?>">
                                        <a href="<?php echo e(route('account.edit-profile')); ?>">Edit Profile</a>
                                    </li>
                                    <li class="account-nav__item  <?php if(Route::current()->getName() == 'account.orders' || Route::current()->getName() == 'account.orders-details'): ?> account-nav__item--active <?php endif; ?>">
                                        <a href="<?php echo e(route('account.orders')); ?>">Orders</a>
                                    </li>
                                    <li class="account-nav__item  <?php if(Route::current()->getName() == 'account.addresses'): ?> account-nav__item--active <?php endif; ?>">
                                        <a href="<?php echo e(route('account.addresses')); ?>">Addresses</a>
                                    </li>
                                    <li class="account-nav__item">
                                        <a href="javascript::void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                           <?php echo csrf_field(); ?>
                                        </form>
                                    </li>
                                </ul><?php /**PATH /home/works/public_html/hykon-beta/resources/views/client/includes/account_menu.blade.php ENDPATH**/ ?>