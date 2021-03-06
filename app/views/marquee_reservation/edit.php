<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo "Editing ".$marquee_reservation->name; ?></h1>
</header>

<section class="wrap">
  <form method="post" action="<?php echo Uri::to('admin/marquee-reservation/edit/' . $marquee_reservation->id); ?>" novalidate>
    <input name="token" type="hidden" value="<?php echo $token; ?>">

    <fieldset class="split">
        <p>
            <label for="label-name"><?php echo __('marquee_reservation.name'); ?>:</label>
            <?php echo Form::text('name', Input::previous('name', $marquee_reservation->name), ['id' => 'label-name']); ?>
            <em><?php echo __('marquee_reservation.name_explain'); ?></em>
        </p>
        <p>
            <label for="label-email"><?php echo __('marquee_reservation.email'); ?>:</label>
            <?php echo Form::text('email', Input::previous('email', $marquee_reservation->email), ['id' => 'label-email']); ?>
            <em><?php echo __('marquee_reservation.email_explain'); ?></em>
        </p>
        <p>
            <label for="label-telephone"><?php echo __('marquee_reservation.telephone'); ?>:</label>
            <?php echo Form::text('telephone', Input::previous('telephone', $marquee_reservation->telephone), ['id' => 'label-telephone']); ?>
            <em><?php echo __('marquee_reservation.telephone_explain'); ?></em>
        </p>
        <p>
            <label for="label-reference_no"><?php echo __('marquee_reservation.reference_no'); ?>:</label>
            <?php echo Form::text('reference_no', Input::previous('reference_no', $marquee_reservation->reference_no), ['id' => 'label-reference_no']); ?>
            <em><?php echo __('marquee_reservation.reference_no_explain'); ?></em>
        </p>
        <p>
            <?php
                $marquee = [];
                $id = [];
                foreach ($event_marquees as $key => $value) {
                    $marquee[] = $value->title;
                    $id[] = $value->id;
                }
                $event_marquee = array_combine($id, $marquee);
            ?>
            <label for="label-event_marquee"><?php echo "Event Marquee"; ?>:</label>
            <?php echo Form::select('event_marquee', [$event_marquee], Input::previous('event_marquee', $marquee_reservation->event_marquee), ['id' => 'label-event_marquee']); ?>
            <em><?php echo ''; ?></em>
        </p>
        <p>
            <label for="label-reservation_date"><?php echo __('marquee_reservation.reservation_date'); ?>:</label>
            <?php echo Form::date('reservation_date', Input::previous('reservation_date', $marquee_reservation->reservation_date), ['id' => 'label-reservation_date']); ?>
            <em><?php echo __('marquee_reservation.reservation_date_explain'); ?></em>
        </p>
        <?php foreach ($fields as $field): ?>
        <p>
            <label for="extend_<?php echo $field->key; ?>"><?php echo $field->label; ?>:</label>
            <?php echo Extend::html($field); ?>
        </p>
        <?php endforeach; ?>
    </fieldset>

    <aside class="buttons">
        <?php echo Form::button(__('global.save'), ['type' => 'submit', 'class' => 'btn']); ?>

        <?php echo Html::link('admin/marquee-reservation', __('global.cancel'), ['class' => 'btn cancel blue']); ?>

        <?php echo Html::link('admin/marquee-reservation/delete/' . $marquee_reservation->id, __('global.delete'), [
            'class' => 'btn delete red'
        ]); ?>
    </aside>
  </form>
</section>

<script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/slug.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/upload-fields.js'); ?>"></script>

<?php echo $footer; ?>
