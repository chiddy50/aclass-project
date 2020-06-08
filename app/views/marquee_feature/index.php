<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo 'Marquee Features'; ?></h1>

    <?php if ($marquee_features->count): ?>
        <nav>
            <?php echo Html::link('admin/marquee-feature/add', __('marquee_feature.create_feature'), ['class' => 'btn']); ?>
        </nav>
    <?php endif; ?>
</header>

<section class="wrap">
    <?php if ($marquee_features->count): ?>
        <ul class="list">
            <?php foreach ($marquee_features->results as $feature): ?>
            <li>
                <a href="<?php echo Uri::to('admin/marquee-feature/edit/' . $feature->id); ?>">
                    <strong><?php echo $feature->name; ?></strong>
                    <span><i class="fa <?php echo $feature->icon; ?>"></i></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <aside class="paging"><?php echo $marquee_features->links(); ?></aside>
    <?php else: ?>

        <p class="empty posts">
        <span class="icon"></span>
            <?php echo __('marquee_feature.nomarquee_feature_desc'); ?><br>
            <?php echo Html::link('admin/marquee-feature/add', __('marquee_feature.create_feature'), ['class' => 'btn']); ?>
        </p>

    <?php endif; ?>
  </section>
  <script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<?php echo $footer; ?>
