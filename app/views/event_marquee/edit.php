<?php echo $header; ?>
<link rel="stylesheet" href="<?php echo asset('app/views/assets/css/sweetalert2.min.css'); ?>">

<header class="wrap">
    <h1><?php echo "Editing ".$event_marquee->title; ?></h1>
</header>

<section class="wrap">
    <h2>Marquee Images</h2>

    <form class="dropzone">
        <!--Fallback file input for no javascript support---->
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
        <!---end--->

        <input name="csrf" type="hidden" value="<?php echo $token; ?>">
        <input type="hidden" name="event_marquee" id="hidden_event_marquee" value="<?php echo $event_marquee->id; ?>">
    </form>
    <button class="button-margin btn-blue" id="startUpload">Upload</button>

    <hr>
    <h2>Marquee Features</h2>
    <form method="post" action="<?php echo Uri::to('admin/event-marquee/edit/' . $event_marquee->id); ?>" novalidate>

        <ul>
            <?php foreach ($features as $feature): ?>
                <fieldset class="split">
                    <p>
                        <label for="label-title"><?php echo $feature->name; ?>:</label>
                        <?php echo Form::checkbox('feature[]', Input::previous('feature[]', $feature->id), in_array($feature->id, $selected_features), ['class' =>'split']); ?>
                    </p>
                </fieldset>
            <?php endforeach; ?>
        </ul>
        <hr>
        <input name="token" type="hidden" id="csrf" value="<?php echo $token; ?>">
        <fieldset class="split">
            <p>
                <label for="label-title"><?php echo __('event_marquee.title'); ?>:</label>
                <?php echo Form::text('title', Input::previous('title', $event_marquee->title), ['id' => 'label-title']); ?>
                <em><?php echo __('event_marquee.title_explain'); ?></em>
            </p>
            <p>
                <label for="label-banquet_capacity"><?php echo __('event_marquee.banquet_capacity'); ?>:</label>
                <?php echo Form::number('banquet_capacity', Input::previous('banquet_capacity', $event_marquee->banquet_capacity), ['id' => 'label-banquet_capacity']); ?>
                <em><?php echo __('event_marquee.banquet_capacity_explain'); ?></em>
            </p>
            <p>
                <label for="label-theatre_capacity"><?php echo __('event_marquee.theatre_capacity'); ?>:</label>
                <?php echo Form::text('theatre_capacity', Input::previous('theatre_capacity', $event_marquee->theatre_capacity), ['id' => 'label-theatre_capacity']); ?>
                <em><?php echo __('event_marquee.theatre_capacity_explain'); ?></em>
            </p>
            <p>
                <label for="label-description"><?php echo __('event_marquee.description'); ?>:</label>
                <?php echo Form::textarea('description', Input::previous('description', $event_marquee->description), ['id' => 'label-description']); ?>
                <em><?php echo 'The description for your event marquee.'; ?></em>
            </p>
            <p>
                <label for="label-status"><?php echo "Status"; ?>:</label>
                <?php echo Form::select('status', [0 => 'Inactive', 1 => 'active'], Input::previous('status', $event_marquee->status), ['id' => 'label-status']); ?>
                <em><?php echo 'The status for your event marquee.'; ?></em>
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

            <?php echo Html::link('admin/event-marquee/delete/' . $event_marquee->id, __('global.delete'), [
                'class' => 'btn delete red'
            ]); ?>
        </aside>
    </form>


</section>
<?php echo $footer; ?>


<script src="<?php echo asset('app/views/assets/js/hide.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/slug.js'); ?>"></script>
<script src="<?php echo asset('app/views/assets/js/main-script.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script>
var marquee_image_id;

Dropzone.autoDiscover = false;

$(function() {
    var marquee = $('#hidden_event_marquee').val();

    //Dropzone class
    var myDropzone = new Dropzone(".dropzone", {
		url: 'http://aclass.test/admin/event-marquee/upload/'+marquee,
		paramName: "file",
		maxFilesize: 2,
		maxFiles: 10,
		acceptedFiles: "image/*",
        autoProcessQueue: false,
        // params:{

        // },
        //previewTemplates:
        init: function() {

            this.on('success', function(file, response){

                if(response.status){
                    // alert('Uploaded');
                    Swal.fire(
                        'Success',
                        'Successfully Uploaded image',
                        'success'
                    );
                    $('button.swal2-confirm').click(function(){
                        window.location.reload();
                    });
                    marquee_image_id = response.image.data.id
                }else{
                    Swal.fire(
                        'Error!',
                        'Could not Upload image',
                        'error'
                    )
                    myDropzone.removeFile(file);
                    var marquee_image = response.image.data.id;
                    var xhr = new XMLHttpRequest();
                    var param = 'id='+marquee_image;
                    xhr.open('post','http://aclass.test/admin/event-marquee/delete-image',true);
                    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (this.status == 200) {
                            let result = JSON.parse(this.responseText);
                            console.log(result);
                        }
                    }
                    xhr.send(param);
                }
            });

            this.on('complete', function(file) {

                var aside = document.createElement('div');
                aside.className = "buttons marquee-img-btns";
                aside.id = 'tpl';

                var btnBanner = document.createElement('button');
                btnBanner.className = 'btn blue send_banner';
                // btnBanner.innerText = 'Banner';
                // Create Icon tag
                var bannerIcon = document.createElement('i');
                bannerIcon.className = "fa fa-flag-o icon_send_banner";
                //append to banner button
                btnBanner.appendChild(bannerIcon);
                btnBanner.title = 'Mark image as banner';

                var btnDelete = document.createElement('button');
                btnDelete.className = 'btn red delete_img';
                // btnDelete.innerText = 'Delete'
                //create Icon tag
                var deleteBtnIcon = document.createElement('i');
                deleteBtnIcon.className = "fa fa-trash";
                //append to delete button
                btnDelete.appendChild(deleteBtnIcon);
                btnDelete.title = 'Delete image';

                aside.appendChild(btnBanner);
                aside.appendChild(btnDelete);
                file.previewTemplate.append(aside);

                // var send_banner = document.querySelector('button.send_banner');
                btnBanner.addEventListener('click', function(e){
                    e.preventDefault();

                    var class_name = e.target.classList[2];
                    var img_name = e.target.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.lastElementChild.innerText;

                    console.log(e);
                    if (confirm('Are you sure?')) {
                        var xhr = new XMLHttpRequest();
                        var param = 'name='+img_name;
                        xhr.open('post','http://aclass.test/admin/event-marquee/is-banner/',true);
                        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (this.status == 200) {
                                let result = JSON.parse(this.responseText);
                                console.log(result);
                                if (!result.state) {
                                    Swal.fire('Success', 'Banner removed', 'success');
                                }else{
                                    Swal.fire('Success', 'Image is now a banner', 'success');
                                }
                            }
                        }
                        xhr.send(param);
                    }
                });
                // myDropzone.removeFile(file);

                $('.icon_send_banner').click(function(e) {
                    e.preventDefault();
                    var class_name = e.target.classList[2];
                    var img_name = e.target.parentElement.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.lastElementChild.innerText;
                    var xhr = new XMLHttpRequest();
                    var param = 'name='+img_name;
                    xhr.open('post','http://aclass.test/admin/event-marquee/is-banner/',true);
                    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (this.status == 200) {
                            let result = JSON.parse(this.responseText);
                            if (!result.state) {
                                Swal.fire('Success', 'Banner removed', 'success');

                            }else{
                                Swal.fire('Success', 'Banner added', 'success');

                            }
                        }
                    }
                    xhr.send(param);
                });

                btnDelete.addEventListener('click', function(e){
                    e.preventDefault();
                    var image_element = e.target.parentElement.parentElement;
                    var class_name = e.target.classList[2];
                    var img_name = e.target.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.lastElementChild.innerText;

                    console.log(img_name);
                    if (confirm('Are you sure?')) {
                        var xhr = new XMLHttpRequest();
                        var param = 'name='+img_name;
                        xhr.open('post','http://aclass.test/admin/event-marquee/delete-image',true);
                        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (this.status == 200) {
                                let result = JSON.parse(this.responseText);
                                if (result.status) {
                                    Swal.fire('Success', 'Image Removed', 'success');
                                    image_element.remove();
                                    // myDropzone.removeFile(file);
                                }
                            }
                        }
                        xhr.send(param);
                    }
                });


            });



        }
	});

	$('#startUpload').click(function(){
		myDropzone.processQueue();
    });

    var marqueeImgs = <?php echo $marquee_images; ?>;

    $.each(marqueeImgs, function(index, elem) {

        var mockFile = Object.assign({}, elem);
        myDropzone.emit('addedfile', mockFile);
        myDropzone.emit('thumbnail', mockFile, mockFile.path);
        myDropzone.emit('complete', mockFile);

    });
    // console.log(myDropzone);


});
</script>
