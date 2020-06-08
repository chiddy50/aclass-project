<div id="reservations" class="popup-section contact-section typo-light">

    <div class="close-section">
        <a href="#" class="button button-icon color-button-white fs-30 border-op-light-2 radius-full"><i
                class="pe-7s-close"></i></a>
    </div>

    <div class="inner-section animated" data-anim-in="fadeIn" data-anim-out="fadeOut">
        <div class="container">

            <div class="row gt60">
                <div class="col-lg-6">

                    <div class="section-heading-wrapper" data-ckav-smd="align-center margin-t-30">
                        <h2 class="heading-section text-upper default bold-900"
                            data-anim-in="fadeInRight|0.1" data-ckav-smd="medium margin-b-0">Make a Reservation
                        </h2>
                    </div>
                    <hr class="color-border-default margin-tb-30 width-px-50 margin-l-0 border-t-2 animated"
                        data-anim-in="fadeInRight|0.2" data-ckav-smd="margin-auto">
                    <form id="reservation-form"
                        class="form-control-op-light-02 " data-anim-in="fadeInRight|0.2"
                        data-ckav-smd="align-center">
                        <input type="hidden" id="reservation_token" value="<?php echo Registry::get('token'); ?>" />
                        <div class="field-wrp">

                            <div class="form-group">
                                <input class="form-control radius-10" required=""
                                    data-msg="Please enter name." type="text" name="name" id="user_name"
                                    placeholder="Enter your name">
                            </div>

                            <div class="form-group">
                                <input class="form-control radius-10"  required=""
                                    data-msg="Please enter email." type="email" name="email" id="user_email"
                                    placeholder="Enter your email">
                            </div>

                            <div class="form-group">
                                <input class="form-control radius-10" required=""
                                    data-msg="Please phone number." type="text" name="phone" id="user_phone"
                                    placeholder="Enter your phone number">
                            </div>

                            <div class="form-group">
                                <select name="event_marquee" class="form-control radius-10"
                                 required="" data-msg="Please enter event marquee." id="user_marquee">
                                    <option value="0" selected disbaled>Choose a Marquee</option>
                                    <?php foreach (event_marquees() as $value): ?>
                                        <option value="<?php echo $value->id ?>"><?php echo $value->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <button type="submit" class="button submit-reservation radius-10 solid color-button-default margin-0">
                            <i class="fa fa-envelope-o "></i> SUBMIT</button>
                    </form>
                </div>

                <div class="col-lg-6">
                    <div class="container">
                        <h3>Pick Date</h3>
                        <input type="text" id="picker" class="form-control">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


