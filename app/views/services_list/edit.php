<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo "Editing ".$service->service; ?></h1>
</header>

<section class="wrap">
  <form method="post" action="<?php echo Uri::to('admin/services-list/edit/' . $service->id); ?>" novalidate>
    <input name="token" type="hidden" value="<?php echo $token; ?>">

    <fieldset class="split">
        <p>
            <label for="label-service"><?php echo 'Service'; ?>:</label>
            <?php echo Form::text('service', Input::previous('service', $service->service), ['id' => 'label-service']); ?>
            <em><?php echo 'For Service Name'; ?></em>
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

        <?php echo Html::link('admin/services-list', __('global.cancel'), ['class' => 'btn cancel blue']); ?>

        <?php echo Html::link('admin/services-list/delete/' . $service->id, __('global.delete'), [
            'class' => 'btn delete red'
        ]); ?>
    </aside>
  </form>
</section>

<script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/slug.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/upload-fields.js'); ?>"></script>

<?php echo $footer; ?>
