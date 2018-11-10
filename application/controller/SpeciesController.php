<?php

class SpeciesController extends Controller
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
     * Index, default action shows species, or list if no param
     */
    public function index()
    {
        $this->specieslist();
    }

    /**
     * selects all species from database and puts them in dynatable
     */
    public function specieslist()
    {
        //load users and set dynatable to load it
        $data = array('species' => SpeciesModel::getAllSpecies(),'dynatable'=>'specieslist');
        $this->View->render('species/specieslist',$data);
    }

    public function show($id=null)
    {
        if(isset($id))
        {
            if(!is_numeric($id)){
                $id = SpeciesModel::getSpeciesID(str_replace('-',' ',$id));
            }
            //load users and set dynatable to load it
            if(is_numeric($id)){
                $data = array('species' => SpeciesModel::getSpecies($id),'varieties' => VarietyModel::getVarietiesBySpecies($id));
                $this->View->render('species/showSpecies',$data);
            }
            else{
                Redirect::to('species');
            }
        }
        else
        {
            Redirect::to('species');
        }
    }

    public function editSpecies($id=null)
    {
        if(isset($id))
        {
            if(Session::userIsLoggedIn())
            {
                $data = array('species' => SpeciesModel::getSpecies($id),'ajaxform' => 'editSpecies');
                $this->View->render('species/editSpecies',$data);
            }
            else
            {
                Session::add('feedback_negative', 'you must be logged in to edit a species page');
                Redirect::to('/species/showSpecies',$id);
            }
        }
        else
        {
            //no id provided, send to insert
            //we handle not logged in here, don't add it
            Redirect::to('species/add');
        }
    }

    //when user submits edit of species form
    public function editSpecies_action()
    {
        //make sure user is logged in
        Auth::checkAuthentication();

        $postid = Request::post('sid');
        $postname = Request::post('sname');
        $postattribute = Request::post('sattribute');
        $postdescription = Request::post('sdescription');
        $cover = $_FILES['cover'];

        SpeciesModel::updateSpecies($postid,$postname,$postattribute,$postdescription);

        Image::saveimage($cover,'species/',$postid);

        return true;
    }

    public function addSpecies()
    {
        if(Session::userIsLoggedIn())
        {
            $this->View->render('species/addSpecies');
        }
        else
        {
            Session::add('feedback_negative', 'you must be logged in to add a species page');
            Redirect::to('/species');
        }
    }

    //when user submits edit of species form
    public function addSpecies_action()
    {
        //make sure user is logged in
        Auth::checkAuthentication();

        $postname = Request::post('sname');
        $postattribute = Request::post('sattribute');
        $postdescription = Request::post('sdescription');
        $cover = $_FILES['cover'];

        //first add species (need to get ID)
        $id = SpeciesModel::addSpecies($postname,$postattribute,$postdescription);

        //now we can save image
        if($id != false)
        {
            Image::saveimage($cover,'species/',$id);
        }

        return true;
    }
}