<div class="mobilemenu">
    <div class="mobilemenu__backdrop"></div>
    <div class="mobilemenu__body">
        <div class="mobilemenu__header">
            <div class="mobilemenu__title">Menu</div>
            <button type="button" class="mobilemenu__close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="mobilemenu__content">
            <ul class="mobile-links mobile-links--level--0" data-collapse data-collapse-opened-class="mobile-links__item--open">

                <?php echo app('arrilot.widget')->run('HykonMobileMenu', ['menu_position' => 'Main Menu']); ?>

            </ul>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\hykon\resources\views/hykon/menu/mobile.blade.php ENDPATH**/ ?>