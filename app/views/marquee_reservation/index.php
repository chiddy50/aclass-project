<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo 'Marquee Reservations'; ?></h1>

    <?php if ($marquee_reservations->count): ?>
        <nav>
            <?php echo Html::link('admin/marquee-reservation/add', __('marquee_reservation.create_reservation'), ['class' => 'btn']); ?>
        </nav>
    <?php endif; ?>
</header>

<section class="wrap">
    <?php if ($marquee_reservations->count): ?>
        <ul class="list">
            <?php foreach ($marquee_reservations->results as $reservation): ?>
            <li>
                <a href="<?php echo Uri::to('admin/marquee-reservation/edit/' . $reservation->id); ?>">
                <strong><?php echo $reservation->name; ?></strong>

                <span><?php echo $reservation->email; ?></span>
                <span><?php echo $reservation->telephone; ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <aside class="paging"><?php echo $marquee_reservations->links(); ?></aside>
    <?php else: ?>

        <p class="empty posts">
            <span class="icon"></span>
            <?php echo __('marquee_reservation.nomarquee_reservation_desc'); ?><br>
            <?php echo Html::link('admin/marquee-reservation/add', __('marquee_reservation.create_reservation'), ['class' => 'btn']); ?>
        </p>

    <?php endif; ?>

  </section>
  <script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<?php echo $footer; ?>
