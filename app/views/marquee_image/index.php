<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo 'Marquee Image'; ?></h1>

    <?php if ($marquee_images->count): ?>
        <nav>
            <?php echo Html::link('admin/marquee-image/add', __('marquee_image.create_image'), ['class' => 'btn']); ?>
        </nav>
    <?php endif; ?>
</header>

<section class="wrap">
    <?php if ($marquee_images->count): ?>
        <ul class="list">
            <?php foreach ($marquee_images->results as $image): ?>
            <li>
                <a href="<?php echo Uri::to('admin/marquee-image/edit/' . $image->id); ?>">
                <strong><?php echo $image->img_name; ?></strong>

                <em class="status <?php echo $image->is_banner; ?>"
                    title="<?php echo $image->is_banner == 1 ? 'A Banner' : 'Not a Banner'; ?>">
                    <?php echo $image->is_banner == 1 ? 'It\'s a banner': 'Not a banner'; ?>
                </em>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <aside class="paging"><?php echo $marquee_images->links(); ?></aside>
    <?php else: ?>

        <p class="empty posts">
        <span class="icon"></span>
            <?php echo __('marquee_image.nomarquee_image_desc'); ?><br>
            <?php echo Html::link('admin/marquee-image/add', __('marquee_image.create_image'), ['class' => 'btn']); ?>
        </p>

    <?php endif; ?>
  </section>
  <script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<?php echo $footer; ?>
