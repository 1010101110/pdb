<div class="container">
    <h2>Add a Species</h2>
    <div class="box">
        <form action="<?php echo Config::get('URL'); ?>species/addSpecies_action" id="addspecies" method="post" enctype="multipart/form-data">
            <input type="hidden" name="sid" id="sid"><br>
            
            <h5>Cover Photo</h5>
            <img id="uploadPreview" style="max-width: 30%; max-height: 30%;"/> 
            <input type="file" class="uploadimage" name="cover">
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000"><br><br>
            
            
            <h5>Name:</h5><input name="sname" id="sname" size="50"/><br><br>
            <h5>Unique Attribute / How to indentify:</h5><input name="sattribute" id="sattribute" size="100"/><br><br>
    		<input type="hidden" name="csrf_token" id="csrf_token" class="csrf_token" value="<?= Session::get('csrf_token'); ?>" >
    		<input type="hidden" name="sdescription" id="sdescription" class="sdescription" >
    			
            <h5>Description:</h5><br> 
            <?php require Config::get('PATH_VIEW') . '_templates/editor.php'; ?>
            <br>
            
            <input type="submit" value="Save">   <input type="button" id="btncancel" value="Cancel">
        </form>
    </div>
</div>