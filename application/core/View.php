<?php

/**
 * Class View
 * The part that handles all the output
 */
class View
{
    /**
     * simply includes (=shows) the view. this is done from the controller. In the controller, you usually say
     * $this->view->render('help/index'); to show (in this example) the view index.php in the folder help.
     * Usually the Class and the method are the same like the view, but sometimes you need to show different views.
     * @param string $filename Path of the to-be-rendered view, usually folder/file(.php)
     * @param array $data Data to be used in the view
     */
    public function render($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . '_templates/header.php';
        require Config::get('PATH_VIEW') . $filename . '.php';
        require Config::get('PATH_VIEW') . '_templates/footer.php';
    }

    /**
     * Similar to render, but accepts an array of separate views to render between the header and footer. Use like
     * the following: $this->view->renderMulti(array('help/index', 'help/banner'));
     * @param array $filenames Array of the paths of the to-be-rendered view, usually folder/file(.php) for each
     * @param array $data Data to be used in the view
     * @return bool
     */
    public function renderMulti($filenames, $data = null)
    {
        if (!is_array($filenames)) {
            self::render($filenames, $data); 
            return false;
        }

        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . '_templates/header.php';

        foreach($filenames as $filename) {
            require Config::get('PATH_VIEW') . $filename . '.php';
        }

        require Config::get('PATH_VIEW') . '_templates/footer.php';
    }

    /**
     * Same like render(), but does not include header and footer
     * @param string $filename Path of the to-be-rendered view, usually folder/file(.php)
     * @param mixed $data Data to be used in the view
     */
    public function renderWithoutHeaderAndFooter($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . $filename . '.php';
    }

    /**
     * Renders pure JSON to the browser, useful for API construction
     * @param $data
     */
    public function renderJSON($data)
    {
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    /**
     * Checks if the passed string is the currently active controller.
     * Useful for handling the navigation's active/non-active link.
     *
     * @param string $filename
     * @param string $navigation_controller
     *
     * @return bool Shows if the controller is used or not
     */
    public static function checkForActiveController($filename, $navigation_controller)
    {
        $split_filename = explode("/", $filename);
        $active_controller = $split_filename[0];

        if ($active_controller == $navigation_controller) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the passed string is the currently active controller-action (=method).
     * Useful for handling the navigation's active/non-active link.
     *
     * @param string $filename
     * @param string $navigation_action
     *
     * @return bool Shows if the action/method is used or not
     */
    public static function checkForActiveAction($filename, $navigation_action)
    {
        $split_filename = explode("/", $filename);
        $active_action = $split_filename[1];

        if ($active_action == $navigation_action) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the passed string is the currently active controller and controller-action.
     * Useful for handling the navigation's active/non-active link.
     *
     * @param string $filename
     * @param string $navigation_controller_and_action
     *
     * @return bool
     */
    public static function checkForActiveControllerAndAction($filename, $navigation_controller_and_action)
    {
        $split_filename = explode("/", $filename);
        $active_controller = $split_filename[0];
        $active_action = $split_filename[1];

        $split_filename = explode("/", $navigation_controller_and_action);
        $navigation_controller = $split_filename[0];
        $navigation_action = $split_filename[1];

        if ($active_controller == $navigation_controller AND $active_action == $navigation_action) {
            return true;
        }

        return false;
    }
    
    public static function getusergroup($accounttype)
    {
        $ret = "user not loaded";
        
        if(isset($accounttype))
        {
            $ret =  '<span>User</span>';
            if($accounttype == 7)    
            {
                $ret = '<span style="color:red">Admin</span>';
            }
            elseif($accounttype == 3)
            {
                $ret = '<span style="color:blue">Premium User</span>';
            }
        }
        return $ret;
    }

    public function showVarietyImages($id)
    {
        $path = Config::get('PATH_IMAGES') . '/variety/' . $id . '/';
        
        //if directory hasn't been created yet there are no images....
        if(is_dir($path))
        {
            $files = array_diff(scandir($path), array('..', '.'));
            
            foreach($files as $file)
            {
                $publicimgpath = Config::get('URL') . 'images/variety/'. $id . '/' . $file;
                echo '<li><a class="gallery" href="' . $publicimgpath . '"> <img src="' .  $publicimgpath . '"></a></li>';
            }
        }
    }
    
    public function showVarietyReviews($id)
    {
        if(isset($id))
        {
            $reviews = ReviewModel::getReviewsOfVariety($id);
            
            if(!$reviews){
                echo 'no reviews yet, be the first to add one!';
            }
            
            foreach($reviews as $rev)
            {
                echo '<li class="review row">';
                    echo '<span class="left">';
                    echo $rev->taste != 99 ? 'taste:'. str_repeat('★',$rev->taste) . '<br>' : '';
                    echo $rev->heat != 99 ? 'heat:'. str_repeat('★',$rev->heat) . '<br>' : '';
                    echo $rev->growth != 99 ? 'growth:'. str_repeat('★',$rev->growth) . '<br>' : '';

                    echo '</span><span class="right"> By ' . '<a href="'. Config::get('URL') . 'user/showProfile/' . $rev->created_by . '">' . UserModel::getUserNameByID($rev->created_by) . '</a>';
                    if( Session::get('user_id') == $rev->created_by || Session::get('user_account_type') == 7){
                        //only allow the user or admins to delete reviews
                        echo ' <br> <button id="reviewdelete" data="'. $rev->ID .'"><i class="material-icons">delete</i></button>';
                    }

                    echo '</span><div class="clear"></div><hr>';

                    echo '<p class="full">' . nl2br(View::links($rev->description)) . '</p>';
                echo '</li>';
            }   
        }
    }
    
    public function showUserReviews($id)
    {
        if(isset($id))
        {
            $reviews = ReviewModel::getReviewOfUser($id);
            
            foreach($reviews as $rev)
            {
                echo '<li>';
                    echo '<p><a href="' . Config::get('URL') . 'variety/showVariety/' . $rev->variety . '">' . VarietyModel::getVarietyName($rev->variety) . '</a> ';
                    if( Session::get('user_id') == $rev->created_by){
                        echo ' <button id="reviewdelete" data="'. $rev->ID .'"><i class="material-icons">delete</i></button>';
                    }                    
                    echo '</p>';
                    echo $rev->taste != 99 ? 'taste:'. str_repeat('★',$rev->taste) . '<br>' : '';
                    echo $rev->heat != 99 ? 'heat:'. str_repeat('★',$rev->heat) . '<br>' : '';
                    echo $rev->growth != 99 ? 'growth:'. str_repeat('★',$rev->growth) . '<br>' : '';
                    echo '<p>' . nl2br(View::links($rev->description)) . '</p>';
                echo '</li>';
            }   
        }
    }
    
    public function links($text){
      $exUrl = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
      preg_match_all($exUrl, $text, $url);
      foreach($url[0] as $k=>$v) $text = str_replace($url[0][$k], '<a href="'.$url[0][$k].'" target="_blank" rel="nofollow">'.$url[0][$k].'</a>', $text);
      return $text;
    }
    
}
