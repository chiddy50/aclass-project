<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo __('event_marquee.create_marquee'); ?></h1>
</header>

<section class="wrap">

    <form method="post" action="<?php echo Uri::to('admin/event-marquee/add'); ?>" novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="split">
            <p>
                <label for="label-title"><?php echo __('event_marquee.title'); ?>:</label>
                <?php echo Form::text('title', Input::previous('title'), ['id' => 'label-title']); ?>
                <em><?php echo __('event_marquee.title_explain'); ?></em>
            </p>
            <p>
                <label for="label-banquet_capacity"><?php echo __('event_marquee.banquet_capacity'); ?>:</label>
                <?php echo Form::number('banquet_capacity', Input::previous('banquet_capacity'), ['id' => 'label-banquet_capacity']); ?>
                <em><?php echo __('event_marquee.banquet_capacity_explain'); ?></em>
            </p>
            <p>
                <label for="label-theatre_capacity"><?php echo __('event_marquee.theatre_capacity'); ?>:</label>
                <?php echo Form::text('theatre_capacity', Input::previous('theatre_capacity'), ['id' => 'label-theatre_capacity']); ?>
                <em><?php echo __('event_marquee.theatre_capacity_explain'); ?></em>
            </p>
            <p>
                <label for="label-status"><?php echo "Status"; ?>:</label>
                <?php echo Form::select('status', [1 => 'active', 0 => 'Inactive'], true, ['id' => 'label-status']); ?>
                <em><?php echo 'The status for your event marquee.'; ?></em>
            </p>
            <p>
                <label for="label-description"><?php echo __('event_marquee.description'); ?>:</label>
                <?php echo Form::textarea('description', Input::previous('description'), ['id' => 'label-description']); ?>
                <em><?php echo __('event_marquee.description_explain', 'The description for your category.'); ?></em>
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

            <?php echo Html::link('admin/event-marquee', __('global.cancel'), ['class' => 'btn cancel blue']); ?>
        </aside>

    </form>
</section>

<script src="<?php echo asset('app/views/assets/js/slug.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/upload-fields.js'); ?>"></script>

<?php echo $footer; ?>
