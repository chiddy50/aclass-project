<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo __('service.services') ?></h1>

    <?php if ($services->count): ?>
        <nav>
            <?php echo Html::link('admin/services/add', __('service.create_service'), ['class' => 'btn']); ?>
        </nav>
    <?php endif; ?>
</header>

<section class="wrap">
    <?php if ($services->count): ?>
        <ul class="list">
            <?php foreach ($services->results as $service): ?>
            <li>
                <a href="<?php echo Uri::to('admin/services/edit/' . $service->id); ?>">
                <strong><?php echo $service->title; ?></strong>

                <span><?php echo $service->description; ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <aside class="paging"><?php echo $services->links(); ?></aside>
    <?php else: ?>

        <p class="empty posts">
        <span class="icon"></span>
            <?php echo __('service.noservice_desc'); ?><br>
            <?php echo Html::link('admin/services/add', __('service.create_service'), ['class' => 'btn']); ?>
        </p>

    <?php endif; ?>
  </section>
  <script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<?php echo $footer; ?>
