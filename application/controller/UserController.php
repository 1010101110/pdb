<?php

/**
 * PanelController
 * Controls panel
 */
class UserController extends Controller
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
     * Index, default action (shows the login form), when you do login/index
     */
    public function index()
    {
        $this->userlist();
    }
    
    //see if user is logged in..
    public function isloggedin()
    {
        return Session::userIsLoggedIn();
    }
    
    public function panel()
    {
        // if user is logged in redirect to main-page, if not show the view
        $data = array('redirect' => Request::get('redirect') ? Request::get('redirect') : NULL);
        
        if (Session::userIsLoggedIn()) {
            $this->View->render('user/myProfile');
        } else {
            $this->View->render('user/smalllogin', $data);
        }
    }
    
    //small Login
    public function smalllogin()
    {
        //check if csrf token is valid
        if (!Csrf::isTokenValid()) {
            //self::logout();
            $json = array('result' => false,'reason' => Session::get('csrf_token') . "token comp" . Request::post('csrf_token') );
        }
        else
        {
            // perform the login method, put result (true or false) into $login_successful
            $login_successful = LoginModel::login(
                Request::post('user_name'), Request::post('user_password'), Request::post('set_remember_me_cookie')
            );
            
            if($login_successful)
            {
                $json = array('result' => true,'reason' => 'login suceeded');
            }
            else
            {
                $json = array('result' => false,'reason' => 'login failed');
            }
        }
        
        header('Content-type: application/json');
        echo json_encode($json);
    }
    
    public function loginWithCookie()
    {
        // run the loginWithCookie() method in the login-model, put the result in $login_successful (true or false)
         $login_successful = LoginModel::loginWithCookie(Request::cookie('remember_me'));

        // if login successful, redirect to dashboard/index ...
        if ($login_successful) {
            //$uri = ltrim ($_SERVER['HTTP_REFERER'],'/');
            if(isset($_SERVER['HTTP_REFERER']))
            {
                echo $_SERVER['HTTP_REFERER'];
            }
            // if($uri != 'user/loginWithCookie'){
            //     //causes redirect loop if we keep redirecting to ourselves...
            //     Redirect::to($uri);
            // }
            // else{
            //     Redirect::to('index');
            // }
        } else {
            // if not, delete cookie (outdated? attack?) and route user to login form to prevent infinite login loops
            LoginModel::deleteCookie();
            //Redirect::to('index');
        }
    }
    
    //logout
    public function logout()
    {
        LoginModel::logout();
        //exit();
        //Redirect::home();
    }
    
    //get curerntly active user
    public function getUser()
    {
        //Auth::checkAuthentication();
        
        $json = array(
            'user_name' => Session::get('user_name'),
            'user_email' => Session::get('user_email'),
            'user_gravatar_image_url' => Session::get('user_gravatar_image_url'),
            'user_avatar_file' => Session::get('user_avatar_file'),
            'user_account_type' => Session::get('user_account_type')
        );
        
        header("Content-Type: application/json");
        echo json_encode($json);
    }
    
    public function csrf()
    {
        //generate and echo
        $token = Csrf::makeToken();
        $json = array('token' => $token);
        
        header('Content-type: application/json');
        echo json_encode($json);
    }
    
    public function userlist()
    {
        //load users and set dynatable to load it
        $users = array('users' => UserModel::getPublicProfilesOfAllUsers(),'dynatable'=>'userlist');
        $this->View->render('user/userlist',$users);
    }
    
    public function feedback()
    {
        // get the feedback (they are arrays, to make multiple positive/negative messages possible)
        $feedback_positive = Session::get('feedback_positive');
        $feedback_negative = Session::get('feedback_negative');
        Session::set('feedback_positive',null);        
        Session::set('feedback_negative',null);        
        
        //echo 'hi';
        // echo out positive messages
        if (isset($feedback_positive)) {
            foreach ($feedback_positive as $feedback) {
                echo '<div class="feedback success">'.$feedback.'</div>';
            }
        }
        
        // echo out negative messages
        if (isset($feedback_negative)) {
            foreach ($feedback_negative as $feedback) {
                echo '<div class="feedback error">'.$feedback.'</div>';
            }
        }
    }
    
    //lets user edit their profile
    public function editprofile()
    {
        //make sure user is logged in
        Auth::checkAuthentication();
        $data = array('ajaxform'=>'load');
        
        //loads user data from session, gives save button(post)
        $this->View->render('user/editProfile',$data);
    }
    
    public function editprofile_action()
    {
        //make sure user is logged in
        Auth::checkAuthentication();
        
        
        $postname = Request::post('user_name');
        $postemail = Request::post('user_email');
        $postbio = Request::post('user_bio');


        if(Session::get('user_name') != $postname && $postname != null)
        {
            UserModel::editUserName($postname);
        }
        
        if(Session::get('user_email') != $postemail && $postemail != null)
        {
            UserModel::editUserEmail($postemail);
        }
        
        //null is checked in this method
        AvatarModel::createAvatar();
        
        if(Session::get('user_bio') != $postbio && $postbio != null)
        {
            UserModel::editBio($postbio);
        }

        return true;
    }
    
    //shows current users profile!
    public function myProfile()
    {
        //make sure user is logged in
        Auth::checkAuthentication();
        
        //loads profile from session
        $this->View->render('user/myProfile');    
    }
    
    //shows public profile!
    public function showProfile($id)
    {
        if(isset($id))
        {
            //gets profile from database
            $data = array('user' => UserModel::getPublicProfileOfUser($id),'dynatable' => 'yes');
            $this->View->render('user/showProfile',$data);    
        }
        else
        {
            $this->userlist();
        }
    }
    
    //register page
    public function register()
    {
        if (LoginModel::isUserLoggedIn()) {
            Redirect::home();
        } else {
            $this->View->render('user/register');
        }
    }
    
    /**
     * Register POST-request after form submit
     */
    public function register_action()
    {
        $registration_successful = RegistrationModel::registerNewUser();

        if ($registration_successful) {
            Redirect::to('index');
        } else {
            Redirect::to('user/register');
        }
    }
    
    /**
     * Verify user after activation mail link opened
     * @param int $user_id user's id
     * @param string $user_activation_verification_code user's verification token
     */
    public function verify($user_id, $user_activation_verification_code)
    {
        if (isset($user_id) && isset($user_activation_verification_code)) {
            RegistrationModel::verifyNewUser($user_id, $user_activation_verification_code);
            $this->View->render('user/verify');
        } else {
            Redirect::to('index');
        }
    }

    /**
     * Show the request-password-reset page
     */
    public function requestPasswordReset()
    {
        $this->View->render('user/requestPasswordReset');
    }

    /**
     * The request-password-reset action
     * POST-request after form submit
     */
    public function requestPasswordReset_action()
    {
        PasswordResetModel::requestPasswordReset(Request::post('user_name_or_email'));
        Redirect::to('index');
    }

    /**
     * Verify the verification token of that user (to show the user the password editing view or not)
     * @param string $user_name username
     * @param string $verification_code password reset verification token
     */
    public function verifyPasswordReset($user_name, $verification_code)
    {
        // check if this the provided verification code fits the user's verification code
        if (PasswordResetModel::verifyPasswordReset($user_name, $verification_code)) {
            // pass URL-provided variable to view to display them
            $this->View->render('user/resetPassword', array(
                'user_name' => $user_name,
                'user_password_reset_hash' => $verification_code
            ));
        } else {
            Redirect::to('index');
        }
    }

    /**
     * Set the new password
     * Please note that this happens while the user is not logged in. The user identifies via the data provided by the
     * password reset link from the email, automatically filled into the <form> fields. See verifyPasswordReset()
     * for more. Then (regardless of result) route user to index page (user will get success/error via feedback message)
     * POST request !
     * TODO this is an _action
     */
    public function setNewPassword()
    {
        PasswordResetModel::setNewPassword(
            Request::post('user_name'), Request::post('user_password_reset_hash'),
            Request::post('user_password_new'), Request::post('user_password_repeat')
        );
        Redirect::to('index');
    }
    
    
    public function showCaptcha()
    {
        CaptchaModel::generateAndShowCaptcha();
    }
}
