

<div id="portfolio" class="popup-section portfolio-section typo-light">
    <div class="close-section">
        <a href="#" class="button button-icon color-button-white fs-30 border-op-light-2 radius-full"><i
                class="pe-7s-close"></i></a>
    </div>

    <div class="inner-section animated" data-anim-in="fadeIn" data-anim-out="fadeOut">
        <div class="container">

            <div class="portfolio-widget grid-portfolio portfolio-row grid-03"
                data-ckav-md="grid-02" data-ckav-sm="grid-01">
                <?php foreach (event_marquees() as $event): ?>
                    <div class="portfolio-col animated" data-anim-in="fadeInUp|0.1">
                        <figure class="hover-box hover-box-01 <?php echo $event->id; ?>" data-zoom-gallery="yes">
                            <div class="overlay flex-bl typo-light"
                                data-linear-gradient="rgba(31,34,41,0.5)|rgba(31,34,41,1)">
                                <div class="info-text text-center">
                                    <?php foreach($event->images() as $image): ?>
                                    <a title="<?php echo $event->title; ?>" href="<?php echo UPLOAD_DIR . DS . $image->img_name; ?>" class="zoom-img button <?php if($image->is_banner == 0) echo 'd-none'; ?> button-icon radius-full margin-lr-5 color-button-default solid">
                                        <i class="icon-magnifier"></i>
                                    </a>
                                    <?php endforeach; ?>
                                    <a data-marquee="<?php echo $event->id; ?>" href="#reservations" class="navigation-a section-post button button-icon radius-full margin-lr-5 color-button-default solid">
                                        <i class="icon-clock"></i>
                                    </a>
                                    <h3 class="heading-content tiny bold-600 margin-b-5 margin-t-30"><?php echo $event->title; ?></h3>
                                    <p class="mr-0 fs12 op-08"> <?php echo $event->description; ?> </p>
                                    <small class="mr-0 fs12 op-08">
                                        Banquet Capacity: <?php echo $event->banquet_capacity; ?>
                                    </small>
                                    <br>
                                    <small class="mr-0 fs12 op-08">
                                        Theatre Capacity: <?php echo $event->theatre_capacity; ?>
                                    </small>
                                </div>
                            </div>
                            <?php if($event->bannerImage()): ?>
                            <img src="<?php echo THUMBNAIL_DIR . DS . 'thumb_' . $event->bannerImage()->img_name; ?>" alt="<?php echo $event->title; ?>">
                            <?php endif; ?>
                        </figure>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


