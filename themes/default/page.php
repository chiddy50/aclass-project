<?php foreach(Registry::get('pages') as $page): ?>

	<div id="<?php echo $page->slug ?>" class="popup-section about-section typo-light">
		<div class="close-section">
			<a href="#" class="button button-icon color-button-white fs-30 border-op-light-2 radius-full"><i
					class="pe-7s-close"></i></a>
		</div>

		<div class="inner-section animated" data-anim-in="fadeIn" data-anim-out="fadeOut">
			<div class="container">

				<div class="row gt60">
					<?php if($page->image): ?>
					<div class="col-lg-6">
						<div class="image-wrapper animated" data-anim-in="fadeInRight"
							data-ckav-smd="margin-b-30">
							<img class="radius-10" src="<?php echo UPLOAD_DIR . DS . $page->image; ?>" alt="about image">
						</div>
					</div>
					<div class="col-lg-6">
					<?php else: ?>
					<div class="col-lg-12">
					<?php endif;?>
						<div class="section-heading-wrapper" data-ckav-smd="align-center">
							<h2 class="heading-section text-upper default bold-900 animated"
								data-anim-in="fadeInUp" data-ckav-smd="medium">About us</h2>
							<p class="heading-section-sub small margin-b-0 animated" data-anim-in="fadeInUp|0.1"
								data-ckav-smd="mini">
								<?php echo site_meta('about_page_header'); ?>
							</p>
						</div>
						<hr class="color-border-default margin-tb-30 width-px-50 margin-l-0 border-t-2 animated"
							data-anim-in="fadeInUp|0.2" data-ckav-smd="margin-auto">
						<p class="margin-b-20 animated" data-anim-in="fadeInUp|0.2">
						<?php echo site_meta('about_page_body1'); ?>
						</p>
						<ul class="list-1 color-text-white font-01" data-ckav-smd="align-left margin-b-30">
							<?php foreach (services_list() as $value): ?>
                                <li class="margin-b-5 animated" data-anim-in="fadeInUp|0.3">
                                    <i class="list-bullet margin-r-10 color-text-default fas fa-angle-right"></i>
                                <?php echo $value->service; ?>
                                </li>
							<?php endforeach; ?>
							<li class="margin-b-5 animated" data-anim-in="fadeInUp|0.3">
                                <i class="list-bullet margin-r-10 color-text-default fas fa-angle-right"></i>
							and much more
							</li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>

<?php endforeach; ?>
