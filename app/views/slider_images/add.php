<?php echo $header; ?>

<section class="wrap">
    <h2>Add Slider Image</h2>

    <form class="dropzone">
        <!--Fallback file input for no javascript support---->
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
        <!---end--->
        <input name="csrf" type="hidden" value="<?php echo $token; ?>">
    </form>
    <button class="button-margin btn-blue" id="startUpload">Upload</button>


</section>
<?php echo $footer; ?>

<script>
    Dropzone.autoDiscover = false;
$(function(){
    var image_name = $('#label-name').val();
    var myDropzone = new Dropzone(".dropzone", {
		url: 'http://aclass.test/admin/slider-images/add',
		paramName: "file",
		maxFilesize: 2,
		maxFiles: 10,
		acceptedFiles: "image/*",
        autoProcessQueue: false,
        params:{
            image_name: image_name
        },
        init: function() {

            this.on('success', function(file, response){
                console.log(response);

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
                }else{
                    Swal.fire(
                        'Error!',
                        'Could not Upload image',
                        'error'
                    )

                }
            });

            this.on('complete', function(file){
                var aside = document.createElement('div');
                aside.className = "buttons marquee-img-btns";
                aside.id = 'tpl';


                var btnDelete = document.createElement('button');
                btnDelete.className = 'btn red delete_img';
                btnDelete.innerText = "Delete ";
                //create Icon tag
                // var deleteBtnIcon = document.createElement('i');
                // deleteBtnIcon.className = "fa fa-trash";
                //append to delete button
                // btnDelete.appendChild(deleteBtnIcon);
                btnDelete.title = 'Delete image';

                aside.appendChild(btnDelete);
                file.previewTemplate.append(aside);



                btnDelete.addEventListener('click', function(e){
                    e.preventDefault();
                    var image_element = e.target.parentElement.parentElement;
                    var class_name = e.target.classList[2];
                    var img_name = e.target.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.lastElementChild.innerText;

                    console.log(img_name);

                    if (confirm('Are you sure?')) {
                        var xhr = new XMLHttpRequest();
                        var param = 'name='+img_name;
                        xhr.open('post','http://aclass.test/admin/slider-images/delete', true);
                        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (this.status == 200) {
                                let result = JSON.parse(this.responseText);
                                console.log(result);
                                if (result.status) {
                                    Swal.fire(
                                        'Success',
                                        'Image Removed',
                                        'success'
                                    );
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

    var images = <?php echo $images; ?>;
    console.log(images);

    $.each(images, function(index, image) {

    var mockFile = Object.assign({}, image);

    myDropzone.emit('addedfile', mockFile);
    myDropzone.emit('thumbnail', mockFile, mockFile.path);
    myDropzone.emit('complete', mockFile);

    });


});
</script>

