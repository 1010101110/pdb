<div class="container center">
    <h2 style="display:inline">Activity</h2>
    <div id="userlist">
    <ul>
    <?php foreach($this->history as $his){ ?>
        <li>
            <?=UserModel::getUserNameByID($his->action_by);?> 
            <a href="<?=$his->url;?>"><?=$his->action;?></a>
            <span><?= date("M d, Y",strtotime($his->action_on));?></span>
        </li>
    <?php } ?>
    </ul>
    </div>
</div>

<!-- now load dynatable -->
<script src="<?php echo Config::get('URL'); ?>js/dynatable.js" type="text/javascript"></script>
<script>
        //page title
    $('title').html("pdb - history");
</script>