<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo "Editing ".$service->title; ?></h1>
</header>

<section class="wrap">
    <form method="post" action="<?php echo Uri::to('admin/services/edit/' . $service->id); ?>" novalidate>
        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="split">
            <p>
                <label for="label-title"><?php echo __('service.title'); ?>:</label>
                <?php echo Form::text('title', Input::previous('title', $service->title), ['id' => 'label-title']); ?>
                <em><?php echo __('service.title_explain'); ?></em>
            </p>
            <p>
                <label for="label-icon"><?php echo __('service.icon'); ?>:</label>
                <?php echo Form::select('icon', $fontawesome, Input::previous('icon', $service->icon), ['class' => 'font-awesome']) ?>
                <em><?php echo __('service.icon_explain'); ?></em>
            </p>
            <p>
                <label for="label-description"><?php echo __('service.description'); ?>:</label>
                <?php echo Form::textarea('description', Input::previous('description', $service->description), ['id' => 'label-description']); ?>
                <em><?php echo __('service.description_explain'); ?></em>
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

            <?php echo Html::link('admin/services', __('global.cancel'), ['class' => 'btn cancel blue']); ?>

            <?php echo Html::link('admin/services/delete/' . $service->id, __('global.delete'), [
                'class' => 'btn delete red'
            ]); ?>
        </aside>
    </form>
</section>

<script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/slug.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/upload-fields.js'); ?>"></script>

<?php echo $footer; ?>
