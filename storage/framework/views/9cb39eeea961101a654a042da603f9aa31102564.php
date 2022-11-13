<div class="modal fade" id="popup-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="width: fit-content;">
            <div class="modal-body clearfix">
                <button type="button" class="btn-close" data-dismiss="modal">
                    &times;
                </button>

                <div class="quick-view clearfix">

                    <div class="quick-view-image">
                        <a href="<?php echo e($popUpBanner->call_to_action_url); ?>"
                            target="<?php echo e($bannerSectionTwoBanner->open_in_new_window ? '_blank' : '_self'); ?>">
                            <div class="base-image" style="border:0px;">
                                <img src="<?php echo e($popUpBanner->image->path); ?>" style="width: 100%; max-width:700px;
                                height: auto;">
                            </div>
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $('#popup-modal').modal('show');
</script><?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/popup.blade.php ENDPATH**/ ?>