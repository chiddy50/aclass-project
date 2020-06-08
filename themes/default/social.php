<div id="social" class="popup-section social-section typo-light">

    <!-- CLOSE BUTTON -->
    <div class="close-section">
        <a href="#" class="button button-icon color-button-white fs-30 border-op-light-2 radius-full"><i
                class="pe-7s-close"></i></a>
    </div>

    <div class="inner-section animated" data-anim-in="fadeIn" data-anim-out="fadeOut">
        <div class="container">

            <div class="row">
                <?php if(site_meta('facebook')): ?>
                <div class="col align-center animated" data-anim-in="fadeInUp|0.1"
                    data-ckav-smd="margin-b-30">
                    <a target="_blank" href="<?php echo site_meta('facebook'); ?>"
                        class="button button-icon-xlarge color-button-white border-op-light-2 radius-10"><i
                            class="fab fa-facebook-f"></i></a>
                </div>
                <?php endif; ?>

                <?php if(site_meta('twitter')): ?>
                <div class="col align-center animated" data-anim-in="fadeInUp|0.2"
                    data-ckav-smd="margin-b-30">
                    <a target="_blank" href="<?php echo site_meta('twitter'); ?>"
                        class="button button-icon-xlarge color-button-white border-op-light-2 radius-10"><i
                            class="fab fa-twitter"></i></a>
                </div>
                <?php endif; ?>

                <?php if(site_meta('instagram')): ?>
                <div class="col align-center animated" data-anim-in="fadeInUp|0.4"
                    data-ckav-smd="margin-b-30">
                    <a target="_blank" href="<?php echo site_meta('instagram'); ?>"
                        class="button button-icon-xlarge color-button-white border-op-light-2 radius-10"><i
                            class="fab fa-instagram"></i></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
