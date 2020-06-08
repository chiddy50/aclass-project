<?php echo $header; ?>
<link rel="stylesheet" href="<?php echo asset('app/views/assets/css/marquee_image.css'); ?>">

<header class="wrap">
  <h1><?php echo 'Images'; ?></h1>
</header>

<section class="wrap">
    <?php if ($images->count): ?>

        <?php foreach ($images->results as $image): ?>
            <div class="container">
                <img src="<?php echo asset('app/views/assets/uploads/'.$image->img_name); ?>" alt="Avatar" class="image">
                <div class="overlay" title="<?php echo $image->is_banner == 1 ? 'A Banner' : 'Not a Banner'; ?>">
                    <button class="button" id="<?php echo $image->id; ?>">Edit</button>

                    <button class="red-button delete_image" id="<?php echo $image->id; ?>">Delete</button>
                    <?php echo $image->is_banner == 1 ? 'Banner': ''; ?>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <p class="empty posts">
            <span class="icon"></span>
            <?php echo "No images yet"; ?><br>
        </p>

    <?php endif; ?>


</section>

<script>
$(document).ready(function(){

    // $.post('http://aclass.test/admin/event-marquee/images/delete/', {
    //     student_id: student_id
    //     },
    //     function(data, status){
    //     let validator = JSON.parse(data);
    //     console.log(validator);
    // });

    $(document).on('click', '.delete_image', function(e){
        var id = e.target.id;
        var element = e.target.parentElement.parentElement;

        $.post('http://aclass.test/admin/event-marquee/images/delete/', {
            id: id
        },function(data, status){
            console.log(data);

            if (data.status) {
                if(confirm('Are you sure')){
                    element.remove();
                }
            }
        });
    });

});
</script>
<?php echo $footer; ?>
