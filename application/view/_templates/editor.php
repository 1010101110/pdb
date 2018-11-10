<style>
  small {
    display: block;
    margin-top: 40px;
    font-size: 9px;
  }
  
  small,
  small a {
    color: #666;
  }
  
  a {
    color: #000;
    text-decoration: underline;
    cursor: pointer;
  }
  
  #toolbar [data-wysihtml5-action] {
    float: right;
  }
  
  #toolbar,
  textarea {
    width: 920px;
    padding: 5px;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  
  textarea {
    height: 280px;
    border: 2px solid green;
    font-family: Verdana;
    font-size: 11px;
  }
  
  textarea:focus {
    color: black;
    border: 2px solid black;
  }
  
  .wysihtml5-command-active, .wysihtml5-action-active {
    font-weight: bold;
  }
  
  [data-wysihtml5-dialog] {
    margin: 5px 0 0;
    padding: 5px;
    border: 1px solid #666;
  }
  
  
  
  a[data-wysihtml5-command-value="red"] {
    color: red;
  }
  
  a[data-wysihtml5-command-value="green"] {
    color: green;
  }
  
  a[data-wysihtml5-command-value="blue"] {
    color: blue;
  }
  
  .wysihtml5-editor{
      min-height: 100px;
  }
  
  .wysihtml5-editor, .wysihtml5-editor table td {
    outline: 1px dotted #abc;
  }
  
  code {
    background: #ddd;
    padding: 10px;
    white-space: pre;
    display: block;
    margin: 1em 0;
  }
  
  .toolbar {
    display: block;
    border-radius: 3px;
    border: 1px solid #fff;
    margin-bottom: 9px;
    line-height: 1em;
  }
  .toolbar a {
    display: inline-block;
    height: 1.5em;
    border-radius: 3px;
    font-size: 9px;
    line-height: 1.5em;
    text-decoration: none;
    background: #e1e1e1;
    border: 1px solid #ddd;
    padding: 0 0.2em;
    margin: 1px 0;
  }
  .toolbar a.wysihtml5-command-active, .toolbar .wysihtml5-action-active {
    background: #222;
    color: white;
  }
  .toolbar .block { 
    padding: 1px 1px;
    display: inline-block;
    background: #eee;
    border-radius: 3px;
    margin: 0px 1px 1px 0;
  }
  
  div[data-wysihtml5-dialog="createTable"] {
    position: absolute;
    background: white;
  }
  
  div[data-wysihtml5-dialog="createTable"] td {
    width: 10px; height: 5px;
    border: 1px solid #666;
  }
  
  .wysihtml5-editor table td.wysiwyg-tmp-selected-cell {
    outline: 2px solid green;
  }
  
  .editor-container-tag {
    padding: 5px 10px;
    position: absolute;
    color: white;
    background: rgba(0,0,0,0.8);
    width: 100px;
    margin-left: -50px;
    -webkit-transition: 0.1s left, 0.1s top;
  }
  
  .wrap {
    max-width: 700px;
    margin: 40px;
  }
  
  .editable .wysihtml5-uneditable-container {
    outline: 1px dotted gray;
    position: relative;
  }
  .editable .wysihtml5-uneditable-container-right {
    float: right;
    width: 50%;
    margin-left: 2em;
    margin-bottom: 1em;
  }
  
  .editable .wysihtml5-uneditable-container-left {
    float: left;
    width: 50%;
    margin-right: 2em;
    margin-bottom: 1em;
  }

</style>


  <div class="ewrapper" contentEditable="false">
    <div class="toolbar" style="display: none;">
      <div class="block">
        <a data-wysihtml5-command="bold" title="CTRL+B"><b>b</b></a>
        <a data-wysihtml5-command="italic" title="CTRL+I"><i>i</i></a>
        <a data-wysihtml5-command="underline" title="CTRL+U"><u>u</u></a>
        <a data-wysihtml5-command="superscript" title="sup"><sup>s</sup></a>
        <a data-wysihtml5-command="subscript" title="sub"><sub>s</sub></a>
      </div>
      <div class="block">
        <a data-wysihtml5-command="createLink">add link</a>
        <a data-wysihtml5-command="removeLink"><s>remove link</s></a>
        <a data-wysihtml5-command="insertImage">image</a>
        <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1">h1</a>
        <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2">h2</a>
        <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h3">h3</a>
        <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="p">p</a>
        <!--<a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="pre">pre</a>-->
        <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-blank-value="true">plaintext</a>
        <a data-wysihtml5-command="insertBlockQuote">quote</a>
        <a data-wysihtml5-command="formatCode" data-wysihtml5-command-value="language-html">Code</a>
      </div>
      
      <!--
      <div class="block">
        <a data-wysihtml5-command="fontSizeStyle">Size</a>
        <div data-wysihtml5-dialog="fontSizeStyle" style="display: none;">
          Size:
          <input type="text" data-wysihtml5-dialog-field="size" style="width: 60px;" value="" />
          <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
        </div>
      </div>
      -->
      
      <div class="block">
        <a data-wysihtml5-command="insertUnorderedList">&bull; List</a>
        <a data-wysihtml5-command="insertOrderedList">1. List</a>
      </div>
      <!--
      <div class="block">
        <a data-wysihtml5-command="outdentList">&lt;-</a>
        <a data-wysihtml5-command="indentList">-&gt;</a>
      </div>-->
      <div class="block">
        <a data-wysihtml5-command="justifyLeft">justifyLeft</a>
        <a data-wysihtml5-command="justifyRight">justifyRight</a>
        <a data-wysihtml5-command="justifyFull">justifyFull</a>
      </div>
      <div class="block">
        <a data-wysihtml5-command="alignLeftStyle">alignLeft</a>
        <a data-wysihtml5-command="alignRightStyle">alignRight</a>
        <a data-wysihtml5-command="alignCenterStyle">alignCenter</a>
      </div>
      <div class="block">
        <a data-wysihtml5-command="foreColorStyle">Color</a>
        <div data-wysihtml5-dialog="foreColorStyle" style="display: none;">
          Color:
          <input type="text" data-wysihtml5-dialog-field="color" value="rgba(0,0,0,1)" />
          <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
        </div>
      </div>
      <div class="block">
        <a data-wysihtml5-command="bgColorStyle">BG Color</a>
        <div data-wysihtml5-dialog="bgColorStyle" style="display: none;">
          Color:
          <input type="text" data-wysihtml5-dialog-field="color" value="rgba(0,0,0,1)" />
          <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
        </div>
      </div>
      
      <div class="block">
        <a data-wysihtml5-command="undo" title="undo">undo</a>
        <a data-wysihtml5-command="redo" title="redo">redo</a>
      </div>
    
      <div class="block">
        <a data-wysihtml5-action="change_view">View Source</a>
      </div>
    
      <div data-wysihtml5-dialog="createLink" style="display: none;">
        <label>
          Link:
          <input data-wysihtml5-dialog-field="href" value="http://">
        </label>
        <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
      </div>
      <div data-wysihtml5-dialog="insertImage" style="display: none;">
        <label>
          Image:
          <input data-wysihtml5-dialog-field="src" value="http://">
        </label>
        <label>
          Align:
          <select data-wysihtml5-dialog-field="className">
            <option value="">default</option>
            <option value="wysiwyg-float-left">left</option>
            <option value="wysiwyg-float-right">right</option>
          </select>
        </label>
        <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
      </div>
    </div><!-- toolbar -->
  
    <div class="editable" id="editor" data-placeholder="Enter text ...">
    
    </div>
    
  </div>

  <!-- oldschool clearfix -->
  <div style="height: 1px; width: 100%; overflow: hidden; clear: both"></div>
</div><!-- //wrap -->


<script src="<?php echo Config::get('URL'); ?>wysihtml/dist/wysihtml-toolbar.min.js"></script>
<script src="<?php echo Config::get('URL'); ?>wysihtml/parser_rules/advanced_and_extended.js"></script>


<script>
var editors = [];

  $('.ewrapper').each(function(idx, wrapper) {
    var e = new wysihtml5.Editor($(wrapper).find('.editable').get(0), {
      toolbar:        $(wrapper).find('.toolbar').get(0),
      parserRules:    wysihtml5ParserRules,
      pasteParserRulesets: wysihtml5ParserPasteRulesets
      //showToolbarAfterInit: false
    });
    editors.push(e);
    
    e.on("showSource", function() {
      alert(e.getValue(true));
    });
    
  });
  
</script>
