<style>
div#imp{height:300px !important}
</style>
<div id="services" class="popup-section services-section typo-light">

    <!-- CLOSE BUTTON -->
    <div class="close-section">
        <a href="#" class="button button-icon color-button-white fs-30 border-op-light-2 radius-full"><i
                class="pe-7s-close"></i></a>
    </div>

    <div class="inner-section animated" data-anim-in="fadeIn" data-anim-out="fadeOut">
        <div class="container">

            <div class="row gt60">
                <div class="col-lg-8">
                    <div class="row gt10 margin-b-10" data-ckav-smd="margin-b-0">
                        <?php foreach (services() as $service): ?>
                            <div class="col-lg-6 animated margin-b-10" data-anim-in="fadeInUp|0.1"
                            data-ckav-smd="margin-b-30">
                                <div id="imp" class="info-obj radius-10 margin-b-0 center info-box-01 img-t padding-40 gap-20 mini bgcolor-default" style="height:300px">
                                    <div class="img"><span class="iconwrp color-text-white"><i
                                                class="fa <?php echo $service->icon; ?>"></i></span></div>
                                    <div class="info">
                                        <h3 class="heading-content bold-700 text-upper margin-b-10 tiny">
                                            <?php echo $service->title; ?>
                                        </h3>
                                        <p class="margin-b-0"><?php echo $service->description; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
                <div class="col-lg-4" data-ckav-smd="margin-t-30">
                    <div class="section-heading-wrapper" data-ckav-smd="align-center">
                        <h2 class="heading-section text-upper default bold-900 animated"
                            data-anim-in="fadeInRight|0.1" data-ckav-smd="medium">Services</h2>
                        <p class="heading-section-sub small margin-b-0 animated"
                            data-anim-in="fadeInRight|0.1" data-ckav-smd="mini">
                            <?php echo site_meta('service_text2'); ?>
                        </p>
                    </div>
                    <hr class="color-border-default margin-tb-30 width-px-50 margin-l-0 border-t-2 animated"
                        data-anim-in="fadeInRight|0.2" data-ckav-smd="margin-auto margin-tb-20">
                    <p class="margin-b-20 animated" data-anim-in="fadeInRight|0.2"
                        data-ckav-smd="align-center">
                        <?php echo site_meta('service_text'); ?>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

