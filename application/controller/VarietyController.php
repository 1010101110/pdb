<?php

class VarietyController extends Controller
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
        $this->varietyBOOT();
    }
    
    /**
     * selects all variety from database and puts them in dynatable
     */
    public function varietylist()
    {
        //load users and set dynatable to load it
        $data = array('varieties' => VarietyModel::getAllvarieties(),'dynatable'=>'varietylist','species' => SpeciesModel::getAllSpeciesNames());
        $this->View->render('variety/varietylist',$data);
    }

    public function varietyBOOT()
    {
        //load users and set dynatable to load it
        $this->View->renderWithoutHeaderAndFooter('_templates/headerboot');
        $data = array('varieties' => VarietyModel::getAllvarieties(),'dynatable'=>'varietylist','species' => SpeciesModel::getAllSpeciesNames());
        $this->View->renderWithoutHeaderAndFooter('variety/varlistboot',$data);
    }
    
    public function showVariety($id=null)
    {
        if(isset($id))
        {
            //load users and set dynatable to load it
            $data = array('variety' => VarietyModel::getVariety($id));
            $specs = SpeciesModel::getAllSpeciesNames();
            
            if(isset($data['variety']))
            {
                //this replaces the spec id with spec name
                foreach($specs as $spec){
                    if($spec->ID == $data['variety']->species){
                        $data['variety']->species = $spec->name;
                    }
                }
            }else {
                Session::add('feedback_negative', 'variety not found');
                Redirect::to('variety');
            }
            
            $this->View->render('variety/showVariety',$data);            
        }
        else
        {
            Redirect::to('variety');
        }
    }
    
    public function editVariety($id=null)
    {
        if(isset($id))
        {
            if(Session::userIsLoggedIn())
            {
                //have to send variety info and species for dropdown
                $data = array('variety' => VarietyModel::getVariety($id),'ajaxform' => 'editVariety','species' => SpeciesModel::getAllSpeciesNames());
                $this->View->render('variety/editVariety',$data);            
            }
            else
            {
                Session::add('feedback_negative', 'you must be logged in to edit a variety page');
                Redirect::to("/variety/showVariety/".$id);
            }
        }
        else
        {
            //no id provided, send to insert
            //we handle not logged in here, don't add it
            Redirect::to('variety/add');
        }
    }
    
    //when user submits edit of variety form
    public function editVariety_action()
    {
        //make sure user is logged in
        Auth::checkAuthentication();
        
        $postid = Request::post('vid');
        $postname = Request::post('vname');
        $postspecies = Request::post('vspecies');
        $postheat = Request::post('vheat');
        $postpods = Request::post('vpods');
        $postpodc = Request::post('vpodc');
        $postplantc = Request::post('vplantc');
        $postmaturity = Request::post('vmaturity');
        $postorigin = Request::post('vorigin');
        $postaccession = Request::post('vaccession');
        $postdescription = Request::post('sdescription');
        $cover = $_FILES['cover'];
        
        VarietyModel::updateVariety($postid,$postname,$postspecies,$postheat,$postpods,$postpodc,$postplantc,$postmaturity,$postorigin,$postaccession,$postdescription);
        
        Image::saveimage($cover,'variety/'.$postid.'/',$postid);
        
        return true;
    }
    
    public function addVariety()
    {
        if(Session::userIsLoggedIn())
        {
            //have to send species for dropdown
            $this->View->render('variety/addVariety',array('species' => SpeciesModel::getAllSpeciesNames()));            
        }
        else
        {
            Session::add('feedback_negative', 'you must be logged in to add a variety page');
            Redirect::to('variety');
        }
    }
    
    //when user submits edit of variety form
    public function addVariety_action()
    {
        //make sure user is logged in
        Auth::checkAuthentication();
        
        $postname = Request::post('vname');
        $postspecies = Request::post('vspecies');
        $postheat = Request::post('vheat');
        $postpods = Request::post('vpods');
        $postpodc = Request::post('vpodc');
        $postplantc = Request::post('vplantc');
        $postmaturity = Request::post('vmaturity');
        $postorigin = Request::post('vorigin');
        $postaccession = Request::post('vaccession');
        $postdescription = Request::post('sdescription');
        $cover = $_FILES['cover'];        
        
        //first add variety (need to get ID)
        $id = VarietyModel::addVariety($postname,$postspecies,$postheat,$postpods,$postpodc,$postplantc,$postmaturity,$postorigin,$postaccession,$postdescription);
        
        //now we can save image
        if($id != false)
        {
            Image::saveimage($cover,'variety/'.$id.'/',$id);
        }
        
        return true;
    }

    
   public function addImage()
    {
        //make sure user is logged in
        Auth::checkAuthentication();
        
        $postid = Request::post('vid');
        $galleryimg = $_FILES['galleryimage'];
        $filename = uniqid();
        
        //now we can save image
        if(isset($postid))
        {
            Image::saveimage($galleryimg,'variety/'.$postid.'/',$filename);
        }
        
        return true;
    }
    
    public function addReview()
    {
        //make sure user is logged in
        Auth::checkAuthentication();
        
        //data from post
        $postid     = Request::post('vid');
        $posttaste  = Request::post('taste');
        $postheat   = Request::post('heat');
        $postgrowth = Request::post('growth');
        $postdesc   = Request::post('revdesc');
        
	//create a composite review score for list display
        $composite = 0;
        $ratedcats = 0;
        
        if($posttaste != 99){
            $composite += $posttaste;
            $ratedcats++;
        }
        if($postgrowth != 99){
            $composite += $postgrowth;
            $ratedcats++;
        }

        
        if($ratedcats > 0){
            //make $composite
            $composite = $composite / $ratedcats;
            //save review
            if(isset($postid)){
                ReviewModel::createReview($postid,$posttaste,$postheat,$postgrowth,$postdesc,$composite);
            } else{
                Session::add('feedback_negative', "no variety id given");   
            }
        }else{
            Session::add('feedback_negative', "review not added: you didn't rate anything...");    
        }
    }
    
    public function deleteReview()
    {
        //make sure user is logged in
        Auth::checkAuthentication();
        
        //data from post
        $postid     = Request::post('rid');

        if(isset($postid))
        {
            //save review
            ReviewModel::deleteReview($postid);
        }
        else{
            Session::add('feedback_negative', "no review id given");
        }
    }

    public function search()
    {
    	$searchparam = Request::post('searchparam');
    	if(isset($searchparam)){
    	    $searchret = VarietyModel::search($searchparam);            
    		echo json_encode($searchret);
    	}
        return true;
    }
    
}
