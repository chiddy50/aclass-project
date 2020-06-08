<?php echo $header; ?>

<header class="wrap">
  <h1><?php echo __('metadata.metadata'); ?></h1>
</header>

<section class="wrap">
    <form method="post" action="<?php echo Uri::to('admin/extend/metadata'); ?>" novalidate>
        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="split">
            <legend>Site Settings</legend>
            <p>
                <label for="label-sitename"><?php echo __('metadata.sitename'); ?></label>
                <?php echo Form::text('sitename', Input::previous('sitename', $meta['sitename']),
                    ['id' => 'label-sitename']); ?>
                <em><?php echo __('metadata.sitename_explain'); ?></em>
            </p>
            <p>
                <label for="label-sitedescription"><?php echo __('metadata.sitedescription'); ?></label>
                <?php echo Form::textarea('description', Input::previous('description', $meta['description']), [
                    'id'          => 'label-sitedescription',
                    'placeholder' => __('metadata.sitedescription_explain')
                ]); ?>
            </p>
            <p>
                <label for="label-custom_keywords">Site keywords</label>
                <?php echo Form::textarea('custom_keywords', Input::previous('custom_keywords', $meta['custom_keywords']), [
                    'id'          => 'label-custom_keywords',
                    'placeholder' => 'Site Keywords'
                ]); ?>
            </p>
            <p>
                <label for="label-email">Site email</label>
                <?php echo Form::text('custom_email', Input::previous('custom_email', $meta['custom_email']),
                    ['id' => 'label-email']); ?>
                <em>Site Email</em>
            </p>
            <p>
                <label for="label-address">Site address</label>
                <?php echo Form::textarea('custom_address', Input::previous('custom_address', $meta['custom_address']), [
                    'id' => 'label-address',
                ]); ?>
            </p>

            <p>
                <label for="label-phone">Phone No</label>
                <?php echo Form::text('custom_phone', Input::previous('custom_phone', $meta['custom_phone']),
                    ['id' => 'label-phone']); ?>
                <em>seperate with commas</em>
            </p>
        </fieldset>

        <fieldset class="split">
            <legend>Event Settings</legend>
            <p>
                <label for="label-event_duration">Event Duration</label>
                <?php echo Form::number('custom_event_duration', Input::previous('custom_event_duration', $meta['custom_event_duration']),
                    ['id' => 'label-event_duration']); ?>
                <em>Duration in hours</em>
            </p>
        </fieldset>

        <fieldset class="split">
            <legend>Contact Settings</legend>
            <p>
                <label for="label-location_iframe"><?php echo __('metadata.location_iframe', 'Location IFrame'); ?></label>
                <?php echo Form::textarea('custom_location_iframe', Input::previous('custom_location_iframe', eq($meta['custom_location_iframe'])), [
                    'id' => 'label-location_iframe',
                    'rows' => 20,
                ]); ?>
                <em>Can be obtained from <a href="https://www.google.com/maps" target="_blank">Google Maps</a></em>
            </p>
        </fieldset>

        <fieldset class="split">
            <legend>Social Media</legend>
            <p>
                <label for="label-custom_facebook"><?php echo __('metadata.facebook', 'Facebook'); ?></label>
                <?php echo Form::text('custom_facebook', Input::previous('custom_facebook', $meta['custom_facebook']), [
                    'id' => 'label-custom_facebook',
                    'rows' => 20,
                ]); ?>
                <em>Facebook page link</em>
            </p>
            <p>
                <label for="label-custom_twitter"><?php echo __('metadata.twitter', 'Twitter'); ?></label>
                <?php echo Form::text('custom_twitter', Input::previous('custom_twitter', $meta['custom_twitter']), [
                    'id' => 'label-custom_twitter',
                    'rows' => 20,
                ]); ?>
                <em>Twitter account link</em>
            </p>
            <p>
                <label for="label-custom_instagram"><?php echo __('metadata.instagram', 'Instagram'); ?></label>
                <?php echo Form::text('custom_instagram', Input::previous('custom_instagram', $meta['custom_instagram']), [
                    'id' => 'label-custom_instagram',
                    'rows' => 20,
                ]); ?>
                <em>Instagram account link</em>
            </p>
        </fieldset>
        
        <aside class="buttons">
            <?php echo Form::button(__('global.save'), ['type' => 'submit', 'class' => 'btn']); ?>

            <?php echo Html::link('admin/extend', __('global.cancel'), ['class' => 'btn cancel blue']); ?>
        </aside>
    </form>
</section>

<?php echo $footer; ?>
