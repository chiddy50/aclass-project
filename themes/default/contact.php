<div id="contact" class="popup-section contact-section typo-light">

    <div class="close-section">
        <a href="#" class="button button-icon color-button-white fs-30 border-op-light-2 radius-full"><i
                class="pe-7s-close"></i></a>
    </div>

    <div class="inner-section animated" data-anim-in="fadeIn" data-anim-out="fadeOut">
        <div class="container">

            <div class="row gt60">
                <div class="col-lg-6">
                    <div class="map-wrapper height-px-300 margin-b-40 animated" data-anim-in="fadeInUp">
                        <?php echo Html::decode(site_meta('location_iframe')); ?>                        
                    </div>

                    <div class="info-obj margin-b-0 info-box-01 img-l gap-20 mini animated"
                        data-anim-in="fadeInUp|0.1" data-ckav-smd="margin-b-30 align-left">
                        <div class="img"><span class="iconwrp"><i class="pe-7s-mail"></i></span></div>
                        <div class="info">
                            <h3 class="heading-content tiny bold-600 margin-b-5">Email</h3>
                            <p class="margin-b-0"><?php echo site_meta('email'); ?></p>
                        </div>
                    </div>

                    <hr class="border-op-light-2 margin-tb-20">

                    <div class="info-obj margin-b-0 info-box-01 img-l gap-20 mini animated"
                        data-anim-in="fadeInUp|0.2" data-ckav-smd="margin-b-30 align-left">
                        <div class="img"><span class="iconwrp"><i class="pe-7s-headphones"></i></span></div>
                        <div class="info">
                            <h3 class="heading-content tiny bold-600 margin-b-5">Phone</h3>
                            <p class="margin-b-0"><?php echo site_meta('phone'); ?></p>
                        </div>
                    </div>

                    <hr class="border-op-light-2 margin-tb-20">

                    <div class="info-obj margin-b-0 info-box-01 img-l gap-20 mini animated"
                        data-anim-in="fadeInUp|0.3" data-ckav-smd="margin-b-30 align-left">
                        <div class="img"><span class="iconwrp"><i class="pe-7s-map-2"></i></span></div>
                        <div class="info">
                            <h3 class="heading-content tiny bold-600 margin-b-5">Address</h3>
                            <p class="margin-b-0"><?php echo site_meta('address'); ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">

                    <div class="section-heading-wrapper" data-ckav-smd="align-center margin-t-30">
                        <h2 class="heading-section text-upper default bold-900 animated"
                            data-anim-in="fadeInRight|0.1" data-ckav-smd="medium margin-b-0">Drop us line
                        </h2>
                    </div>
                    <hr class="color-border-default margin-tb-30 width-px-50 margin-l-0 border-t-2 animated"
                        data-anim-in="fadeInRight|0.2" data-ckav-smd="margin-auto">
                    <form id="contact" action="/contact" method="post"
                        class="form-widget form-control-op-light-02 animated" data-anim-in="fadeInRight|0.2"
                        data-ckav-smd="align-center">
                        <input type="hidden" value="<?php echo Registry::get('token'); ?>" />
                        <div class="field-wrp">
                            
                            <div class="row gt10">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control radius-10" data-label="Name" required=""
                                            data-msg="Please enter name." type="text" name="name"
                                            placeholder="Enter your name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control radius-10" data-label="Email" required=""
                                            data-msg="Please enter email." type="email" name="email"
                                            placeholder="Enter your email">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input class="form-control radius-10" required="" data-label="Phone"
                                    data-msg="Please phone number." type="text" name="phone"
                                    placeholder="Enter your phone number">
                            </div>

                            <div class="form-group">
                                <input class="form-control radius-10" data-label="Subject" type="text"
                                    name="subject" placeholder="Enter subject">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control radius-10" data-label="Message" required=""
                                    data-msg="Please enter your message." name="message"
                                    placeholder="Add your message" cols="30" rows="6"></textarea>
                            </div>
                        </div>
                        <button type="submit"
                            class="button radius-10 solid color-button-default margin-0"><i
                                class="fa fa-envelope-o"></i> SUBMIT</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
