<div class="container">
    <h2>Add a Variety</h2>
    <div class="box">
        <form action="<?php echo Config::get('URL'); ?>variety/addVariety_action" id="addvariety" method="post" enctype="multipart/form-data">
            <input type="hidden" name="sid" id="sid"><br>
            
            <h5>Cover Photo</h5>
            <img id="uploadPreview" style="max-width: 30%; max-height: 30%;"/> 
            <input type="file" class="uploadimage" name="cover">
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000"><br><br>
            
            
            <div class="formrow">
                <span class="formlabel">Name</span>
                <span class="formvalue"><input name="vname" id="vname" size="50" required/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Species</span>
                <span class="formvalue">
                    <select name="vspecies" id="vspecies" required>
                    <?php foreach ($this->species as $speci) { ?>
                            <option value="<?= $speci->ID?>"><?= $speci->name?></option>
                        <?php } ?>
                    </select>
                </span>
            </div>
            <div class="formrow">
                <span class="formlabel">Heat</span>
                <span class="formvalue"><input list="heat" name="vheat" id="vheat" size="50" required/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Pod Size(cm x cm)</span>
                <span class="formvalue"><input name="vpods" id="vpods" size="50"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Pod Color</span>
                <span class="formvalue"><input name="vpodc" id="vpodc" size="50"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Plant Color</span>
                <span class="formvalue"><input name="vplantc" id="vplantc" size="50"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Maturity</span>
                <span class="formvalue"><input name="vmaturity" id="vmaturity" size="50"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Origin</span>
                <span class="formvalue"><input name="vorigin" id="vorigin" size="50"/></span>
            </div>
            <div class="formrow">
                <span class="formlabel">Accession #s</span>
                <span class="formvalue"><input name="vaccession" id="vaccession" size="50"/></span>
            </div>
            
            
    		<input type="hidden" name="csrf_token" id="csrf_token" class="csrf_token" value="<?= Session::get('csrf_token'); ?>" >
    		<input type="hidden" name="sdescription" id="sdescription" class="sdescription" >
    			
            <h4>Description:</h4><br> 
            <?php require Config::get('PATH_VIEW') . '_templates/editor.php'; ?>
            <br>
            
            <input type="submit" value="Save">   <input type="button" id="btncancel" value="Cancel">
        </form>
    </div>
</div>