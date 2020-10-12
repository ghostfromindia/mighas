<?php $__env->startSection('content'); ?>

    <div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(url('/')); ?>">Home</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="<?php echo e(asset('client')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">My Account</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>My Account</h1>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-3 d-flex">
                            <div class="account-nav flex-grow-1">
                                <h4 class="account-nav__title">Navigation</h4>
                                <?php echo $__env->make('client.includes.account_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                            <div class="dashboard">
                                <div class="dashboard__profile card profile-card">
                                    <div class="card-body profile-card__body">

                                        <div class="profile-card__name"><?php echo e(Auth::user()->full_name); ?></div>
                                        <div class="profile-card__email"><?php if(Auth::user()->email): ?> <?php echo e(Auth::user()->email); ?> <?php endif; ?></div>
                                        <div class="profile-card__email"><?php if(Auth::user()->username): ?> <?php echo e(Auth::user()->username); ?> <?php endif; ?></div>
                                        <div class="profile-card__edit">
                                            <a href="<?php echo e(route('account.edit-profile')); ?>" class="btn btn-secondary btn-sm">Manage Profile</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="dashboard__address card address-card address-card--featured" <?php if(!$address): ?> style="display: none;" <?php endif; ?> id="address-home-display">
                                    <?php echo $__env->make('client.includes.address', ['address'=>$address, 'from'=>'home'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <?php if(!$address): ?>
                                    <div class="dashboard__address" id="address-home-new-add">
                                        <div class="card-body profile-card__body p-0">
                                            <a href="<?php echo e(url('account/address/home')); ?>" class="w-100 addresses-list__item--new show-modal" data-target="#common-modal">
                                                <div class="addresses-list__plus"></div>
                                                <div class="btn btn-secondary btn-sm">Add New Address</div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <div class="modal fade" id="common-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-3">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/customers/index.blade.php ENDPATH**/ ?>