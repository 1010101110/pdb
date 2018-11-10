<div class="container">
    <p><h2 style="display:inline">Varieties </h2> <button onclick="window.location.href='<?php echo Config::get('URL'); ?>variety/addVariety'">add variety</button></p>
    <div id="userlist">
        <table id="usertable">
            <thead>
            <tr>
                <th>Variety</th>
                <th>Species</th>
                <th>Heat</th>
            </tr>
            </thead>
            <?php foreach ($this->varieties as $variety) { ?>
                <tr>
                    <?php $coverpath = Config::get('PATH_IMAGES') . '/variety/' . $variety->ID . '/'. $variety->ID .   '.jpg';
                    $coverimage = Config::get('URL') . 'images/variety/' . $variety->ID . '/' . $variety->ID . '.jpg';?>
                    <td>
                        
                            <figure>
                            <?php if(file_exists($coverpath)){ ?>
                                <a href="<?= Config::get('URL').'variety/showVariety/'.str_replace(' ','-',$variety->name) ?>">
                                <img style="max-width: 100%; max-height: 100px;" src="<?= $coverimage;?>"/>
                                </a>
                            <?php } ?>
                            <figcaption><a href="<?= Config::get('URL').'variety/showVariety/'.str_replace(' ','-',$variety->name) ?>"><?php echo trim($variety->name); ?></a></figcaption>
                            </figure>
                        </a>
                    </td>

                    <td>
                    <?php
                        foreach($this->species as $spec){
                            if($spec->ID == $variety->species){
                                echo '<a href="species/showSpecies/' . $spec->ID . '">'.$spec->name .'</a>';
                            }
                        }?>
                    </td>
                    <td><?= $variety->heat; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<script>
    document.title = "Full Variety List";
</script>
