<script src="<?php echo asset('app/views/assets/js/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/main-script.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/dropzone.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/sweetalert2.min.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/trumbowyg.min.js'); ?>"></script>

<?php if (Auth::user()): ?>
    <footer class="wrap bottom">
        <small><?php echo 'A-Class event management admin panel'; ?></small>
        <em><?php echo 'For Event Management Services.'; ?></em>
    </footer>

  <script>
    // Confirm any deletions
    $( '.delete' ).on( 'click', function () {
      return confirm( '<?php echo __('global.confirm_delete'); ?>' );
    } );
  </script>
  <script>
      $('textarea.trumbowyg').trumbowyg({
            // btns: [['strong', 'em',]],
            autogrow: true
        });
  </script>
<?php endif; ?>
</body>
</html>
