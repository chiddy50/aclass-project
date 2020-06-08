<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo 'Event Marquee'; ?></h1>

    <?php if ($event_marquees->count): ?>
        <nav>
            <?php echo Html::link('admin/event-marquee/add', __('event_marquee.create_marquee'), ['class' => 'btn']); ?>
            <?php echo Html::link('admin/marquee-feature', 'Marquee Features', ['class' => 'btn blue']); ?>
        </nav>
    <?php endif; ?>

</header>

<section class="wrap">
    <?php if ($event_marquees->count): ?>
        <ul class="list">
            <?php foreach ($event_marquees->results as $event): ?>
            <li>
                <a href="<?php echo Uri::to('admin/event-marquee/edit/' . $event->id); ?>">
                <strong><?php echo $event->title; ?></strong>

                <span><?php echo $event->description; ?></span>
                <em class="status <?php echo $event->status; ?>"
                    title="<?php echo __('global.' . $event->status); ?>">
                    <?php echo $event->status == 1 ? 'Active': 'Inactive'; ?>
                </em>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <aside class="paging"><?php echo $event_marquees->links(); ?></aside>
    <?php else: ?>

        <p class="empty posts">
        <span class="icon"></span>
            <?php echo __('event_marquee.noevent_marquee_desc'); ?><br>
            <?php echo Html::link('admin/event-marquee/add', __('event_marquee.create_marquee'), ['class' => 'btn']); ?>
        </p>

    <?php endif; ?>
  </section>

  <script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<?php echo $footer; ?>
