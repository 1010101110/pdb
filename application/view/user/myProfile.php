<!doctype html>
<div class="container center">
        <div class="small-login-box limit50">
            <h3><?= Session::get('user_name'); ?></h3>
            <p><img src="<?= Session::get('user_avatar_file');?>" /><br>
            <?= Session::get('user_email'); ?><br>
            Group: <?= Session::getusergroup(); ?></p>
        </div>
        <div class="small-register-box limit50">
            <br>
            <a href="<?php echo Config::get('URL'); ?>user/editprofile">Edit Profile</a><br><br><br>
            <a id="logout" href="#">Logout</a>
        </div>
</div>