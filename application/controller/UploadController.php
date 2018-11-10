<?php


class UploadController extends Controller
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
    
    /**
     * Index, default action shows variety, or list if no param
     */
    public function index($id=null)
    {
        $this->View->render('upload/upload');
    }

    public function lol(){
        $this->View->render('upload/inferno');
    }
    
    public function proxyget($url=null)
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
?>