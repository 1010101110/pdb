<div class="container">
    <h2 style="display:inline">Users</h2>
    <div id="userlist">
        <table id="usertable">
            <thead>
            <tr>
                <th>Username</th>
                <th>Avatar</th>
                <th>Group</th>
            </tr>
            </thead>
            <?php foreach ($this->users as $user) { ?>
                <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                    <td><a href="<?= Config::get('URL') . 'user/showProfile/' . $user->user_id; ?>"><?= $user->user_name; ?></a></td>
                    <td class="avatar">
                        <?php if (isset($user->user_avatar_link)) { ?>
                            <img src="<?= $user->user_avatar_link; ?>" />
                        <?php } ?>
                    </td>
                    <td><?= View::getusergroup($user->user_account_type); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<!-- now load dynatable -->
<script src="<?php echo Config::get('URL'); ?>js/dynatable.js" type="text/javascript"></script>
<script>
        //page title
    document.title = "Users";
</script>