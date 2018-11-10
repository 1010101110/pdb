<div class="container">
    <?php if($this->user) { ?> <h2 style="display:inline"><?= $this->user->user_name; ?></h2> 
    <?php if($this->user->user_id == Session::get('user_id')){?> <a href="<?php echo Config::get('URL'); ?>user/editprofile">Edit</a><br><br><?php }?>
    <div class="box">
        <div>
            Join Date: <?= date('Y M d, H:i',strtotime($this->user->user_creation_timestamp)); ?><br>
            Last Login Date: <?= date('Y M d, H:i',strtotime($this->user->user_last_login_timestamp)); ?>
            <h3>avatar</h3>
            <?php if (isset($this->user->user_avatar_link)) { ?>
                <img src="<?= $this->user->user_avatar_link; ?>" />
            <?php } ?>
            <h3>About:</h3>
            <div id="description">
            </div>
        </div>
        <div>
            <h3>Reviews:</h3>
            <ul class="imggallery columns-4">
                <?php View::showUserReviews($this->user->user_id);
                ?>
            </ul>
        </div>
        <div>
            <h3>History:</h3>
            <table id="usertable">
                <thead>
                <tr>
                    <th>url</th>
                    <th>action</th>
                    <th>date</th>
                </tr>
                </thead>
            <?php $history = Session::getUserHistory($this->user->user_id);
                foreach ($history as $his) {
            ?>
                <tr>
                    <td><?= $his->url; ?></td>
                    <td><?= $his->action; ?></td>
                    <td><?= date('Y m d, H:i',strtotime($his->action_on)); ?></td>
                </tr>
            <?php } ?>
            </table>
        </div>
    </div>
    <?php }?>
</div>
<script>
    //page title
    document.title = "<?= $this->user->user_name; ?>";

    //when doucment is ready load content into editor
    $(function() {
        var mydescription = decodeURIComponent(escape(atob('<?php echo $this->user->user_bio;?>')));
        $("#description").html(mydescription);
    });
</script>   
<!-- now load dynatable -->
<script src="<?php echo Config::get('URL'); ?>js/dynatable.js" type="text/javascript"></script>