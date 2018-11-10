<div>
    <div id="dropzone" style="display:none;">
        <div id="panel">
            <p>Drag and Drop anywhere on this page</p>
        </div>
    </div>
    
    <div class="center">
        <div id="progress">
            <div class="bar" style="width: 0%;"></div>
        </div>
        <h1>Upload Image(s)</h1>
        <p>Drag and Drop <br><br> Paste(ctrl + v) <br><br> <label for="fileupload" class="btn">Browse</label>
        <input id="fileupload" type="file" name="files[]" data-url="/uploader" multiple></p>
        <div id="filelist"></div>
    </div>
</div>


<script src="js/jquery.ui.widget.js"></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/jquery.fileupload.js"></script>
<script src="js/jquery.getimagedata.min.js"></script>
<script>
$(function() {
    //toastr position
    toastr.options.positionClass = 'toast-bottom-right';
    
    //init fileupload
    $('#fileupload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                var html = '<div class="uploadinfo card-panel"> \
                    <img class="uploadthumb" src="' + file.url +'"/> \
                    <div class="uploadlinks"> \
                        <span>Link  </span><a class="btn"><i class="material-icons">content_copy</i></a> <input spellcheck="false" type="text" value="' +file.url+ '"> \
                    </div><div class="uploadlinks">\
                        <span>BBCode  </span><a class="btn"><i class="material-icons">content_copy</i></a><input spellcheck="false" type="text" value="[img]' +file.url+ '[/img]"> \
                    </div><div class="uploadlinks">\
                        <span>Markdown  </span><a class="btn"><i class="material-icons">content_copy</i></a><input spellcheck="false" type="text" value="[image](' +file.url+ ')"> \
                     </div>\
                </div>';
                
                var $ok = $('<div></div>').html(html);
                
                $("#filelist").append($ok);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        },
        fail: function(e,data){
            toastr.error('upload failed');
            console.log(data);
        },
        submit: function(e,data){
            if(!data.files[0].type.includes('image')){
                //exit out for non images
                if(data.files[0].name.toLowerCase() != 'thumbs.db'){
                    toastr.error('file is not an image');
                }
                console.log(data.files[0])
               // return false;
            }
        },
        dragover: function(e,data){
            return false;
        },
        stop: function(e,data){
            $('#progress .bar').css(
                'width',
                '0%'
            );
            toastr.success('done');
        },
        start: function(e,data){
            toastr.info('upload started');
        }
    });
    
    $('body').on('click', '.uploadlinks > a', function(e){
        e.preventDefault();
        var input = $(this).siblings('input');
        input.select();
       
        try{
           if(document.execCommand('copy')){
               toastr.info('copied');
           }
           else{
               throw "failed copy";
           }
       }catch(err){
           toastr.error(err);
       }
    });

    $(document).on('drop dragover paste', function (e) {
        e.preventDefault();
    });
    
    //drag and  drop overlay
    $(document).on('dragover', function(e) {

        var dropZone = $('#dropzone'),
            timeout = window.dropZoneTimeout;
        
        //check if we are already dragging    
        if (!timeout) {
            dropZone.css('zIndex',5000);
            dropZone.fadeTo(200,1);
            
        } else {
            //reset timer
            clearTimeout(timeout);
        }
        
        //set timer
        window.dropZoneTimeout = setTimeout(function () {
            dropZone.fadeTo(200,0);
            dropZone.css('zIndex',-1);
            window.dropZoneTimeout = null;
        }, 200); 
    
        return false;
    });
    
  $(window).on('drop', function(e) {
        //dropped url handling
        var text = e.originalEvent.dataTransfer.getData("text");
        if(text){
            checkstrings(text);
        }
        
        return false;
    });
    
    //something is pasted, process it
    $(document).on('paste', function(e) {
    console.log(e);
      var items = e.originalEvent.clipboardData.items;
      
      $.each(items,function(i,item){
        if (item.kind === 'file') {
            //if item  is file try to upload it
            var myfile = item.getAsFile();
            if(myfile.type.includes('image')){
                uploadsomething(myfile);
            }
        } else if(item.kind === 'string' && (item.type.match('^text/plain') || item.type.match('^text/uri-list')) ){
            item.getAsString(function(s){
              //if item is plain string then try to upload it as url
              checkstrings(s);
            });
        }else if(item === 0){
            toastr.error("invalid paste<br>you must drag & drop files");
        }
      });
      return false;
    });
    
    function checkstrings(pasted){
        var lines = pasted.split('\n'),
            count = lines.length,
            erstr = '';
        
        $.each(lines,function(i,line){
            if(isUrlValid(line)){
                testImage(line,function(url,status){
                    switch (status) {
                        case 'success':
                            getfilebyurlandupload(url);
                            break;
                        case 'timeout':
                            toastr.error("failed to load url");
                            break;
                        default:
                            toastr.error("invalid image url");
                    }
                });
            }
            else{
                erstr = "invalid url";
            }
            
            --count;
            if(count === 0 && erstr != ''){
                //if you're the last one to execute and all are errors, show error
                toastr.error(erstr);
            }
        });
    }
    
    function isUrlValid(url) {
        //check if string is a url
        return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    }

    function testImage(url, callback, timeout) {
        //check if a url is an image.
        timeout = timeout || 5000;
        var timedOut = false, timer;
        var img = new Image();
        img.onerror = img.onabort = function() {
            if (!timedOut) {
                clearTimeout(timer);
                callback(url, "error");
            }
        };
        img.onload = function() {
            if (!timedOut) {
                clearTimeout(timer);
                callback(url, "success");
            }
        };
        img.src = url;
        timer = setTimeout(function() {
            timedOut = true;
            // reset .src to invalid URL so it stops previous
            // loading, but doesn't trigger new load
            img.src = "//!!!!/test.jpg";
            callback(url, "timeout");
        }, timeout); 
    }
    
    function getfilebyurlandupload(url){
        try{
            toastr.info('getting remote image');
            $.get( "/upload/proxyget/" + btoa(url), function( data ) {
                
                var mime = data.substring(data.indexOf(':')+1,data.indexOf(';'));
                var ext = data.substring(data.indexOf('/')+1,data.indexOf(';'));
                var binary = atob(data.split(',')[1]);
                var array = [];
                for(var i = 0; i < binary.length; i++) {
                    array.push(binary.charCodeAt(i));
                }
                var blob = new Blob([new Uint8Array(array)], {type: mime});
                var filefromblob = new File([blob],"uploadme." + ext, {type: mime});
                filefromblob.type =  mime;
                console.log(filefromblob);
                
                uploadsomething(filefromblob);
            });
        } catch(err){
            toastr.err('error uploading file');
            console.log(err);
        }
    }
    
    function uploadsomething(something){
        //upload it to server
        var filesList = [something];
        
        $('#fileupload').fileupload('add', {files: filesList});
    }
});
</script>
