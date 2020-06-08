<div id="popup-content" class="white-popup-block popup-content animate fadeInDown mfp-hide radius-6">
    <div class="pop-header padding-b-0" data-ckav-sm="padding-30 padding-b-0">
        <div class="square-90 iconwrp fs-80 margin-0 color-text-default"><i class="pe-7s-bell"></i></div>
        <h2 class="heading-section default bold-900 text-upper mr-0" data-ckav-sm="small">Make a Reservation</h2>
    </div>
    <div class="pop-body padding-t-20" data-ckav-sm="padding-30 padding-t-30">

        <div class="form-block">

            <form action=""
                class="form-widget form-control-op-02" novalidate="novalidate">
                <div class="field-wrp">
                    <input type="hidden" name="to" value="c.kav.art@gmail.com">

                    <div class="row gt10">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control radius-6" data-label="Name" required=""
                                    data-msg="Please enter name." type="text" name="name"
                                    placeholder="Enter your name">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control radius-6" data-label="Email" required=""
                                    data-msg="Please enter email." type="email" name="email"
                                    placeholder="Enter your email">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control radius-6" data-label="Telephone" required=""
                                    data-msg="Please enter phone no." type="text" name="telephone"
                                    placeholder="Enter your telephone no">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="event_marquee" class="form-control radius-6" data-label="EventMarquee"
                                 required="" data-msg="Please enter event marquee.">
                                    <option selected disbaled>Choose a Marquee</option>
                                    <?php foreach (event_marquees() as $value): ?>
                                        <option value="<?php echo $value->id ?>"><?php echo $value->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control radius-6" data-label="ReferenceNo" required=""
                                    data-msg="Please enter reference no." type="text" name="reference_no"
                                    placeholder="Enter your reference no">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control radius-6" data-label="ReservationDate" required=""
                                    data-msg="Please enter reservation date." type="date" name="reservation_date">
                            </div>
                        </div>

                    </div>
                </div>
                <button type="submit" class="button radius-6 solid color-button-default width-100 margin-0"><i
                        class="fa fa-envelope-o"></i> SUBMIT</button>
            </form>
        </div>
    </div>
</div>
