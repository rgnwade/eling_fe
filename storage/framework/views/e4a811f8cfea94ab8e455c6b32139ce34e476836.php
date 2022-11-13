<a href="<?php echo e($bannerSectionTwoBanner->call_to_action_url); ?>" class="banner banner-lg" style="background-image: url(<?php echo e($bannerSectionTwoBanner->image->path); ?>);" target="<?php echo e($bannerSectionTwoBanner->open_in_new_window ? '_blank' : '_self'); ?>">
    <div class="overlay"></div>

    <div class="display-table">
        <div class="display-table-cell">
            <div class="banner-content">
                <h2><?php echo e($bannerSectionTwoBanner->caption_1); ?></h2>
                <p><?php echo e($bannerSectionTwoBanner->caption_2); ?></p>
                <span>
                    <?php echo e($bannerSectionTwoBanner->call_to_action_text); ?>

                    <?php if($bannerSectionTwoBanner->call_to_action_text): ?> 
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
</a>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/home/sections/banner_section_2.blade.php ENDPATH**/ ?>