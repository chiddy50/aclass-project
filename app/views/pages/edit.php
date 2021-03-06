<?php echo $header; ?>

<form method="post" action="<?php echo Uri::to('admin/pages/edit/' . $page->id); ?>" enctype="multipart/form-data" novalidate>
	<input name="token" type="hidden" value="<?php echo $token; ?>">

	<fieldset class="header">
		<div class="wrap page">

			<aside class="buttons">
				<?php echo Form::button(__('global.save'), [
					'type'  => 'submit',
					'class' => 'btn'
				]); ?>

				<?php echo Html::link('admin/pages', __('global.cancel'), [
					'class' => 'btn cancel blue'
				]);

				echo Html::link('admin/pages/delete/' . $page->id, __('global.delete'), [
					'class' => 'btn delete red'
				]);
				?>
			</aside>

			<?php echo Form::text('title', Input::previous('title', $page->title), [
				'placeholder'  => __('pages.title'),
				'autocomplete' => 'off',
				'autofocus'    => 'true'
            ]);
            ?>

		</div>
	</fieldset>

	<fieldset class="main">
		<div class="wrap">
			<?php echo Form::textarea('markdown', Input::previous('markdown', $page->markdown), [
				'placeholder' => __('pages.content_explain'),
				'class' => 'trumbowyg'
			]); ?>
		</div>
	</fieldset>

	<fieldset class="meta split">
		<div class="wrap">
			<p>
				<label for="label-name"><?php echo __('pages.name'); ?>:</label>
				<?php echo Form::text('name', Input::previous('name', $page->name), ['id' => 'label-name']); ?>
				<em><?php echo __('pages.name_explain'); ?></em>
			</p>
			<p>
                <label for="label-icon"><?php echo __('marquee_feature.icon'); ?>:</label>

                <?php echo Form::select('icon', $fontawesome, Input::previous('icon', $page->icon), ['class' => 'font-awesome']) ?>
                <em><?php echo __('marquee_feature.icon_explain'); ?></em>
            </p>
			<p>
				<label for="label-slug"><?php echo __('pages.slug'); ?>:</label>
				<?php echo Form::text('slug', Input::previous('slug', $page->slug), ['id' => 'label-slug']); ?>
				<em><?php echo __('pages.slug_explain'); ?></em>
			</p>
			<p>
				<label for="label-status"><?php echo __('pages.status'); ?>:</label>
				<?php echo Form::select(
					'status',
					$statuses,
					Input::previous('status', $page->status),
					['id' => 'label-status']
				); ?>
				<em><?php echo __('pages.status_explain'); ?></em>
			</p>

			<p>
				<label for="label-image"><?php echo __('pages.image'); ?>:</label>
				<?php echo Form::file('image', ['id' => 'label-image', 'value' => Input::previous('image', $page->image)]); ?>
				<em><?php echo __('pages.image_explain'); ?></em>
			</p>
			<p>
			<?php if($page->image): ?>
			<label for="label-image"><?php echo __('pages.image_preview'); ?>:</label>
				<img class="thumbnail" src='<?php echo '/uploads/' . $page->image; ?>' />
			</p>
			<?php endif; ?>
		</div>
	</fieldset>
</form>

<script src="<?php echo asset('app/views/assets/js/upload-fields.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/text-resize.js'); ?>"></script>

<?php echo $footer; ?>
