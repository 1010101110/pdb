<!doctype html>
<div class="container">
    <h2>Edit your profile</h2>

    <div class="box">
        <form action="<?php echo Config::get('URL'); ?>user/editprofile_action" id="editprofile" method="post" enctype="multipart/form-data">
            <label for="avatar_file">Avatar: upload an image</label><br>
            <img id="uploadPreview" style="max-width: 100px; max-height: 100px;" src="<?= Session::get('user_avatar_file');?>"> 
            <input type="file" id="avatar_file" class="uploadimage" name="avatar_file">
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000"><br><br>
            
            Username: <input name="user_name" id="user_name" class="user_name" value="<?= Session::get('user_name'); ?>"><br><br>
            Email: <input name="user_email" id="user_email" class="user_email" value="<?= Session::get('user_email'); ?>"><br><br>
            
			<input type="hidden" name="csrf_token" id="csrf_token" class="csrf_token" value="<?= Session::get('csrf_token'); ?>">
			<input type="hidden" name="user_bio" id="user_bio" class="user_bio" value="">

            Bio:<br>
            <?php require Config::get('PATH_VIEW') . '_templates/editor.php'; ?>
            <br>
            
            <input type="submit" value="Save">
        </form>
        
        <script>
            //when doucment is ready load content into editor
            function base64encode(string) {
              return btoa(unescape(encodeURIComponent(string)));
            }
            
            function base64decode(string) {
              return decodeURIComponent(escape(atob(string)));
            }

            $(function() {
                var mybio = base64decode('<?php echo Session::get('user_bio');?>');
                $("#editor").html(mybio);
            });
        </script>
    </div>
</div>