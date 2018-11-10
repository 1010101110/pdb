<div class="container">
    <h2><?php if ($this->variety) { echo $this->variety->name;} else { echo "Add a Variety"; } ?></h2>
    <div class="box">
        <?php if ($this->variety) { ?>  
        <form action="<?php echo Config::get('URL'); ?>variety/editVariety_action" id="editvariety" method="post" enctype="multipart/form-data">
            <input type="hidden" name="vid" id="vid" value="<?= $this->variety->ID; ?>">
            <?php $coverpath = Config::get('PATH_IMAGES') . '/variety/' . $this->variety->ID. '/' . $this->variety->ID . '.jpg';
            $coverimage = Config::get('URL') . 'images/variety/'. $this->variety->ID . '/' . $this->variety->ID . '.jpg'; ?>
            <img id="uploadPreview" style="max-width: 30%; max-height: 30%;" src="<?php echo file_exists($coverpath) ? $coverimage : ''; ?>"/> 
            <input type="file" class="uploadimage" name="cover">
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000"><br><br>
            
            <div class="formrow">
                <span class="formlabel" title="Group, Variety Color">Name</span>
                <span class="formvalue"><input name="vname" id="vname" size="50" value="<?= $this->variety->name?>"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Species</span>
                <span class="formvalue">
                    <select name="vspecies" id="vspecies">
                    <?php foreach ($this->species as $speci) { ?>
                            <option value="<?= $speci->ID?>" <?php echo $speci->ID == $this->variety->species ? 'selected'  : null; ?>><?= $speci->name?></option>
                        <?php } ?>
                    </select>
                </span>
            </div>
            <div class="formrow">
                <span class="formlabel" title="only put exact heat if it has been tested by a lab">Heat</span>
                <span class="formvalue"><input list="heat" name="vheat" id="vheat" size="50" value="<?= $this->variety->heat;?>"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Pod Size(cm x cm)</span>
                <span class="formvalue"><input name="vpods" id="vpods" size="50" value="<?= $this->variety->podsize;?>"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel" title="the progression of color from new > ripe">Pod Color</span>
                <span class="formvalue"><input name="vpodc" id="vpodc" size="50" value="<?= $this->variety->podcolor;?>"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Plant Color</span>
                <span class="formvalue"><input name="vplantc" id="vplantc" size="50" value="<?= $this->variety->plantcolor;?>"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Maturity</span>
                <span class="formvalue"><input name="vmaturity" id="vmaturity" size="50" value="<?= $this->variety->maturity;?>"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Origin</span>
                <span class="formvalue"><input name="vorigin" id="vorigin" size="50" value="<?= $this->variety->origin;?>"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Accession #s</span>
                <span class="formvalue"><input name="vaccession" id="vaccession" size="50" value="<?= $this->variety->accession;?>"/></span>
            </div>
    		<input type="hidden" name="csrf_token" id="csrf_token" class="csrf_token" value="<?= Session::get('csrf_token'); ?>" >
    		<input type="hidden" name="sdescription" id="sdescription" class="sdescription" value="">
    			
            <h4>Description:</h4><br> 
            <?php require Config::get('PATH_VIEW') . '_templates/editor.php'; ?>
            <br>
            
            <input type="submit" value="Save">   <input type="button" id="btncancel" value="Cancel">
        </form>
        <?php }?>
    </div>
</div>

<script>
    //when doucment is ready load content into editor
    function base64encode(string) {
      return btoa(unescape(encodeURIComponent(string)));
    }
    
    function base64decode(string) {
      return decodeURIComponent(escape(atob(string)));
    }
            
    $(function() {
        var mydescription = base64decode('<?php echo $this->variety->description;?>');
        $("#editor").html(mydescription);
    });
</script>