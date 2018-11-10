<?php

/**
 * PanelController
 * Controls panel
 */
class HistoryController extends Controller
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
     * Index, default action
     */
    public function index()
    {
        $data = array('history' => HistoryModel::getAllHistory());
        $this->View->render('history/historylist',$data);
    }
}