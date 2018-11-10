<div class="container">
    <div class="box">
        <?php if ($this->variety) { ?>
        <p>
            <button onclick="window.location.href='<?= Config::get('URL') . 'variety' ?>'"><i class="material-icons">keyboard_backspace</i> Varieties</button>
        </p>
            <div class="showvar row">
                <?php 
                    $coverpath = Config::get('PATH_IMAGES') . '/variety/' . $this->variety->ID . '/' . $this->variety->ID . '.jpg';
                    $coverimage = Config::get('URL') . 'images/variety/' . $this->variety->ID . '/' . $this->variety->ID . '.jpg';
                ?>
                
                        <div class="left half aright">
                            <div class="covertitle">
                                <?php if ($this->variety) { ?> <h2 style="display:inline"><?= $this->variety->name; ?> </h2> 
                                <?php 
                                    if(Session::userIsLoggedIn()){
                                        echo '<button onclick="window.location.href=\''. Config::get('URL') . 'variety/editVariety/' . $this->variety->ID .'\'">edit</button>';
                                    }else{
                                        echo '<button class="youmustlogin">edit</button><br>';
                                    }
                                ?>
                                <?php }?>
                            </div>

                            <div class="vartitle">
                                <img alt="" src="<?=$coverimage;?>">
                            </div>
                        </div>                        
                        
                        <div class="left half aleft">
                            <div class="formrow">
                                <span class="formlabel">Species</span>
                                <span class="formvalue"><?= $this->variety->species;?></span>
                            </div>
                            <div class="formrow">
                                <span class="formlabel">Heat</span>
                                <span class="formvalue"><?= $this->variety->heat;?></span>
                            </div>
                            <div class="formrow">
                                <span class="formlabel">Pod Size(cm)</span>
                                <span class="formvalue"><?= $this->variety->podsize;?></span>
                            </div>
                            <div class="formrow">
                                <span class="formlabel">Pod Color</span>
                                <span class="formvalue"><?= $this->variety->podcolor;?></span>
                            </div>
                            <div class="formrow">
                                <span class="formlabel">Plant Color</span>
                                <span class="formvalue"><?= $this->variety->plantcolor;?></span>
                            </div>
                            <div class="formrow">
                                <span class="formlabel">Maturity</span>
                                <span class="formvalue"><?= $this->variety->maturity;?></span>
                            </div>
                            <div class="formrow">
                                <span class="formlabel">Origin</span>
                                <span class="formvalue"><?= $this->variety->origin;?></span>
                            </div>
                            <div class="formrow">
                                <span class="formlabel">Accessions</span>
                                <span class="formvalue"><?= $this->variety->accession;?></span>
                            </div>
                        </div>

                <div class="clear"></div>
                    
                <div class="full">                
                    <h3>Description:</h3>
                    <div id="description">
                        <?php 
                            echo html_entity_decode(urldecode(base64_decode($this->variety->description)));
                        ?>
                    </div>
                    <p> </p>
                </div>
                
                <div class="full">
                    <h3 id="Reviews" style="display:inline">Reviews </h3> 
                    <?php 
                    if(Session::userIsLoggedIn()){
                            echo '<button class="ImageAdd" data-featherlight="#f1">Add Review</button><br>';
                    }else{
                        echo '<button class="ImageAdd youmustlogin">Add Review</button><br>';
                    }
                    ?>
                    
                    <div>
                        <ul class="imggallery columns-4">
                            <?php View::showVarietyReviews($this->variety->ID);
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="full">                
                    <h3 style="display:inline">Images </h3> 
                    <?php 
                        if(Session::userIsLoggedIn()){
                            echo '<button class="ImageAdd" data-featherlight="#f0">Add Image</button><br>';
                        }else{
                            echo '<button class="ImageAdd youmustlogin">Add Image</button><br>';
                        }
                    ?>

                    <div>
                        <ul class="imggallery columns-4">
                            <?php View::showVarietyImages($this->variety->ID);?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</div>

<!-- featherlight review popup -->
<div class="lightbox" id="f1">
    <h3>Add Review for <?= $this->variety->name; ?></h3>
    <form action="<?php echo Config::get('URL'); ?>variety/addReview" class="formpopup" id="addReview" method="post" enctype="multipart/form-data">
        <input type="hidden" name="vid" value="<?= $this->variety->ID;?>">
        <div class="formrow">
            <span class="formlabel">Taste</span>
            <span class="formvalue">
                <select name="taste" id="taste" required>
                    <option value="">n/a</option>
                    <option value="1">★☆☆☆☆</option>
                    <option value="2">★★☆☆☆</option>
                    <option value="3">★★★☆☆</option>
                    <option value="4">★★★★☆</option>
                    <option value="5">★★★★★</option>
                </select>
            </span>
        </div>
        <div class="formrow">
            <span class="formlabel">Heat</span>
            <span class="formvalue">
                <select name="heat" id="heat">
                    <option value="99">n/a</option>
                    <option value="1">★☆☆☆☆</option>
                    <option value="2">★★☆☆☆</option>
                    <option value="3">★★★☆☆</option>
                    <option value="4">★★★★☆</option>
                    <option value="5">★★★★★</option>
                </select>
            </span>
        </div>
        <div class="formrow">
            <span class="formlabel">Growth</span>
            <span class="formvalue">
                <select name="growth" id="growth">
                    <option value="99">n/a</option>
                    <option value="1">★☆☆☆☆</option>
                    <option value="2">★★☆☆☆</option>
                    <option value="3">★★★☆☆</option>
                    <option value="4">★★★★☆</option>
                    <option value="5">★★★★★</option>
                </select>
            </span>
        </div>

		<h4>Description:</h4>
		<textarea class="popupdesc" name="revdesc" form="addReview"></textarea>

        <input type="submit" value="Save"> <input type="button" id="btnfcancel" value="Cancel">
    </form>
</div>

<!-- featherlight review edit popup -->
<div class="lightbox" id="f2">
    <h3>Edit Review for <?= $this->variety->name; ?></h3>
    <form action="<?php echo Config::get('URL'); ?>variety/addReview" class="formpopup" id="addReview" method="post" enctype="multipart/form-data">
        <input type="hidden" name="vid" value="<?= $this->variety->ID;?>">
        
        edit not supported yet <br> I can fix / delete manually send email to juanitospeppers@gmail.com
        
        <input type="button" id="btnfcancel" value="Cancel">
    </form>
</div>

<!-- featherlight upload popup -->
<div class="lightbox" id="f0">
    <h3>Add to the <?= $this->variety->name; ?> gallery</h3>
    <form action="<?php echo Config::get('URL'); ?>variety/addImage" class="formpopup" method="post" enctype="multipart/form-data">
        <input type="hidden" name="vid" value="<?= $this->variety->ID;?>">
        <img id="uploadPreview" style="max-width: 50%; max-height: 50%;" /><br> 
        <input type="file" class="uploadimage" name="galleryimage">
        <input type="hidden" name="MAX_FILE_SIZE" value="5000000"><br><br>
        <input type="submit" value="Upload"> <input type="button" id="btnfcancel" value="Cancel">
    </form>
</div>

<script>
    //page title
    $(function() {
        $('head').append('<link rel="canonical" href="<?= Config::get('URL').'variety/showVariety/'.str_replace(' ','-',$this->variety->name); ?>" >');
        $('title').html("<?= $this->variety->name; ?>");
        $('meta[name=description]').attr('content', "<?='Pepper Variety: '.$this->variety->name.', '.$this->variety->species; ?>");
    });
</script>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Thing",
  "name": "<?= $this->variety->name; ?>",
  "image": "<?=$coverimage;?>",
  "description": "<?=strip_tags(html_entity_decode(urldecode(base64_decode($this->variety->description))));?>"
}
</script>
