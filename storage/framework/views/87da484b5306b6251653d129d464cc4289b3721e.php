<div class="category-menu-wrapper pull-left hidden-sm <?php echo e($shouldExpandCategoryMenu ? 'visible' : ''); ?>">
    <div class="category-menu-dropdown dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bars" aria-hidden="true"></i>
        <?php echo e(setting('storefront_category_menu_title')); ?>

    </div>

    <ul class="dropdown-menu vertical-mega-menu">
        <?php echo $__env->renderEach('public.partials.mega_menu.menu', $categoryMenu->menus(), 'menu'); ?>
    </ul>
</div>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/partials/category_menu.blade.php ENDPATH**/ ?>