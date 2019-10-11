function image(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();  
        reader.onload = function (e) {
            $('#image_upload_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function () {

      $("#upload_image_orginal_image_path").change(function () {
    image(this);
});
});