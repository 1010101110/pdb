<div class="container">
    <h2><?php if ($this->species) { echo $this->species->name;} else { echo "Add a Species"; } ?></h2>
    <div class="box">
        <?php if ($this->species) { ?>  
        <form action="<?php echo Config::get('URL'); ?>species/editSpecies_action" id="editspecies" method="post" enctype="multipart/form-data">
            <input type="hidden" name="sid" id="sid" value="<?= $this->species->ID; ?>"><br>
            
            <h4>Cover Photo</h4>
            <?php $coverpath = Config::get('PATH_IMAGES') . '/species/' . $this->species->ID . '.jpg';
            $coverimage = Config::get('URL') . 'images/species/' . $this->species->ID . '.jpg';?>
            <img id="uploadPreview" style="max-width: 30%; max-height: 30%;" src="<?php echo file_exists($coverpath) ? $coverimage : ''; ?>"/> 
            <input type="file" class="uploadimage" name="cover">
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000"><br><br>
            
            
            <h4>Name:</h4><input name="sname" id="sname" size="50" value="<?= $this->species->name; ?>" /><br><br>
            <h4>Unique Attribute / How to indentify:</h4><input name="sattribute" id="sattribute" size="100" value="<?= $this->species->attribute; ?>"/><br><br>
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
        var mydescription = base64decode('<?php echo $this->species->description;?>');
        $("#editor").html(mydescription);
    });
</script>