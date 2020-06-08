<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo __('marquee_feature.create_feature'); ?></h1>
</header>

<section class="wrap">

    <form method="post" action="<?php echo Uri::to('admin/marquee-feature/add'); ?>" novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">
        <fieldset class="split">
            <p>
                <label for="label-name"><?php echo __('marquee_feature.name'); ?>:</label>
                <?php echo Form::text('name', Input::previous('name'), ['id' => 'label-name']); ?>
                <em><?php echo __('marquee_feature.name_explain'); ?></em>
            </p>
            <p>
                <label for="label-icon"><?php echo __('marquee_feature.icon'); ?>:</label>
                
                <?php echo Form::select('icon', $fontawesome, Input::previous('icon', $marquee_feature->icon), ['class' => 'font-awesome']) ?>
                <em><?php echo __('marquee_feature.icon_explain'); ?></em>
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

            <?php echo Html::link('admin/marquee-feature', __('global.cancel'), ['class' => 'btn cancel blue']); ?>
        </aside>

    </form>
</section>

<script src="<?php echo asset('app/views/assets/js/slug.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/upload-fields.js'); ?>"></script>

<?php echo $footer; ?>
