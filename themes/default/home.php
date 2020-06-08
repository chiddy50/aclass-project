<?php theme_include('header'); ?>
    <div id="loader">
        <div class="load-three-bounce">
            <div class="load-child bounce1"></div>
            <div class="load-child bounce2"></div>
            <div class="load-child bounce3"></div>
        </div>
    </div>
    <div class="ckav-body">
        <header class="header-area intro-element padding-l-20">
            <div class="container-fluid">
                <div class="logo-wrp flex-lc">
                    <a href="" class="logo-link width-px-80" data-ckav-smd="width-px-60">
                        <img src="<?php echo theme_url('/images/logo.png'); ?>" alt="logo">
                    </a>
                </div>
            </div>
        </header>
        <?php theme_include('navigation'); ?>
        <div class="home-area intro-section flex-cc" data-ckav-smd="padding-b-0 flex-cc">
            <div class="container zindex-1 intro-element">
                <div class="intro-text typo-light" data-ckav-smd="align-center">
                    <h2 class="heading xlarge bold-900 text-upper" data-ckav-smd="large">A-CLASS</h2>
                    <p class="heading-sub width-50 " data-ckav-smd="width-100 mini">
                        Bringing reality to your dream event.
                    </p>
                    <a href="#reservations"
                        class="navigation-a section-post button button-xlarge color-button-default color-hov-button-white solid radius-10 rounded-0"
                        data-ckav-smd="button-medium">Make Reservation</a>
                </div>
            </div>
            <div class="bg-hasolder zindex-0">
                <b data-bgholder="overlay" class="full-wh zindex-2"
                    data-radial-gradient="rgba(0, 0, 0, 0)|rgba(0, 0, 0, 0.7)"></b>
                <b data-bgholder="slideshow" class="full-wh bg-cover bg-cc zindex-1"
                    data-slide-image="<?php echo $slider_images; ?>"></b>
            </div>
        </div>
        <div class="social-area intro-element">
            <a href="#social" class="section-post button button-icon color-button-white border-op-light-2 radius-full">
                <i class="icon-share"></i>
            </a>
        </div>
        <div class="popup-area">
            <div class="popup-overlay" data-bg-color="rgba(0,0,0,0.8)"></div>

            <?php theme_include('page'); ?>
            <?php theme_include('services'); ?>
            <?php theme_include('event_halls'); ?>
            <?php theme_include('contact'); ?>
            <?php theme_include('social'); ?>
            <?php theme_include('reservations'); ?>
        </div>
        <div class="footer-area intro-element">
            <div class="container">
                <p class="c-text">
                    <a class="c-text" href="javascript:void(0);">&copy; <?php echo date('Y'); ?> <?php echo site_name(); ?>. All rights reserved.</a>
                </p>
            </div>
        </div>
        <?php theme_include('reservation'); ?>
    </div>

<?php theme_include('footer'); ?>
