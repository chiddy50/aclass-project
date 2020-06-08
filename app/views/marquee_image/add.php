<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo __('marquee_image.create_image'); ?></h1>
</header>

<section class="wrap">

  <form method="post" action="<?php echo Uri::to('admin/marquee-image/add'); ?>" enctype="multipart/form-data" novalidate>

    <input name="token" type="hidden" value="<?php echo $token; ?>">

    <fieldset class="split">
        <p>
            <label for="label-img_name"><?php echo __('marquee_image.img_name'); ?>:</label>
            <?php echo Form::file('img_name', ['id' => 'label-img_name']); ?>
            <em><?php echo __('marquee_image.img_name_explain'); ?></em>
        </p>
        <p>
            <label for="label-event_marquee"><?php echo "Event Marquee"; ?>:</label>
            <?php
                $marquee = [];
                $id = [];
                foreach ($event_marquees as $key => $value) {
                    $marquee[] = $value->title;
                    $id[] = $value->id;
                }
                $event_marquee = array_combine($id, $marquee);
             ?>
            <?php echo Form::select('event_marquee', [$event_marquee], false, ['id' => 'label-event_marquee']); ?>
            <em><?php echo ''; ?></em>
        </p>
        <p>
            <label for="label-is_banner"><?php echo "Is Banner?"; ?>:</label>
            <?php echo Form::select('is_banner', [1 => 'Yes', 0 => 'No'], true, ['id' => 'label-is_banner']); ?>
            <em><?php echo 'The status to indicate banner.'; ?></em>
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

        <?php echo Html::link('admin/marquee-image', __('global.cancel'), ['class' => 'btn cancel blue']); ?>
    </aside>

  </form>


</section>

<script src="<?php echo asset('app/views/assets/js/slug.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/upload-fields.js'); ?>"></script>

<?php echo $footer; ?>
