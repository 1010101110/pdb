<?php
class ProxyController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class. The parent::__construct thing is necessary to
     * put checkAuthentication in here to make an entire controller only usable for logged-in users (for sure not
     * needed in the PanelController).
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(){
        $this->View->renderJSON("call get function not this"); 
    }
    
    public function get($url=null)
    {
        $url = base64_decode($url);
        
        $ret = new stdClass;
        $ret->url = $url;

        if($url){
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($response);

            echo 'data:' . $mime . ';base64,' . base64_encode($response);
            curl_close($ch);
            
            if($response){
                $ret->response = $response;
                $ret->err = "there is response";
            }
            else{
                $ret->err = "no response";
            }
        }
        else{
            $ret->err = "no url";
        }
        
        
        return true;
    }
}