<a href="<?php echo e($banner->call_to_action_url); ?>" class="banner <?php echo e($class ?? ''); ?>" style="background-image: url(<?php echo e($banner->image->path); ?>);" target="<?php echo e($banner->open_in_new_window ? '_blank' : '_self'); ?>">
    <div class="overlay"></div>

    <div class="display-table">
        <div class="display-table-cell">
            <div class="banner-content">
                <h3><?php echo e($banner->caption_1); ?></h3>
                <p><?php echo e($banner->caption_2); ?></p>
                <span>
                    <?php echo e($banner->call_to_action_text); ?>

                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                </span>
            </div>
        </div>
    </div>
</a>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/home/sections/partials/single_banner.blade.php ENDPATH**/ ?>