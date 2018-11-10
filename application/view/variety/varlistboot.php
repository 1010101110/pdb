
    <h2 style="display:inline">Varieties </h2> <a role="button" class="btn mybutton" href="<?php echo Config::get('URL'); ?>variety/addVariety">add variety</a>
    
    <br><br>

    <table id="vardatatable">
    </table>

    <script type="text/javascript">

        document.title = "Pepper Varieties"

        var species = <?php echo json_encode($this->species); ?>;

        var varieties = <?php echo json_encode($this->varieties); ?>;

        $(document).ready(function(){

            $('#vardatatable').dataTable({
                "data":varieties,
                "columns":[
                    {
                        "data":"ID",
                        "render": (data,type,row,meta)=>{
                            return '<img style="max-width: 100%; max-height: 100px;" src="' + '<?php echo Config::get('URL') . 'images/variety/'; ?>' + data + '/' + data + '.jpg' + '"/>'
                        },
                        "width":"100px",
                    },
                    {
                        "title":"Variety",
                        "data":"name",
                        "render": (data,type,row,meta)=>{
                            return '<a href="<?= Config::get('URL').'variety/showVariety/'?>' + data.replace(/ /g, "-")  + ' "> ' + data + ' </a>'
                        }
                    },
                    {
                        "title":"Species",
                        "data":"species",
                        "render": (data,type,row,meta)=>{
                            var spec = species.find((el)=>{return el.ID === data})
                            return '<a href="<?= Config::get('URL'). 'species/showSpecies/'?>' + data + '">' + spec.name + '</a>'
                        }
                    },
                    {
                        "title":"Heat",
                        "data":"heat"                        
                    },
                ],
                "deferRender":true,
                "lengthMenu":[25,100,1000],                           
            });
        });            
    </script>