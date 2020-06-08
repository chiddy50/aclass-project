<?php echo $header; ?>

<header class="wrap">
  <h1>Services List</h1>

    <?php if ($services_list->count): ?>
        <nav>
            <?php echo Html::link('admin/services-list/add', 'Create a new Service', ['class' => 'btn']); ?>
        </nav>
    <?php endif; ?>
</header>

<section class="wrap">
    <?php if ($services_list->count): ?>
        <ul class="list">
            <?php foreach ($services_list->results as $service): ?>
            <li>
                <a href="<?php echo Uri::to('admin/services-list/edit/' . $service->id); ?>">

                <span><?php echo $service->service; ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <aside class="paging"><?php echo $services_list->links(); ?></aside>
    <?php else: ?>

        <p class="empty posts">
        <span class="icon"></span>
            <?php echo 'You don’t have any Service!'; ?><br>
            <?php echo Html::link('admin/services-list/add', 'Create a new Service', ['class' => 'btn']); ?>
        </p>

    <?php endif; ?>
  </section>
  <script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<?php echo $footer; ?>
