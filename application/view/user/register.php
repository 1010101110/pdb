<div class="container">

    <!-- login box on left side -->
    <div class="login-box" style="width: 50%; display: block;">
        <h2>Register a new account</h2>

        <!-- register form -->
        <form method="post" action="<?php echo Config::get('URL'); ?>user/register_action">
            <!-- the user name input field uses a HTML5 pattern check -->
            <input type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" placeholder="Username (letters/numbers, 2-64 chars)" required /><br>
            <input type="text" name="user_email" placeholder="email address (a real address)" required /><br>
            <input type="password" name="user_password_new" pattern=".{6,}" placeholder="Password (6+ characters)" required autocomplete="off" /><br>
            <input type="password" name="user_password_repeat" pattern=".{6,}" required placeholder="Repeat your password" autocomplete="off" /><br>

            <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
            <img id="captcha" src="<?php echo Config::get('URL'); ?>user/showCaptcha" />
            <input type="text" name="captcha" placeholder="Please enter above characters" required />

            <!-- quick & dirty captcha reloader -->
            <a href="#" style="display: block; font-size: 11px; margin: 5px 0 15px 0; text-align: center"
               onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL'); ?>user/showCaptcha?' + Math.random(); return false">Reload Captcha</a>

            <input type="submit" value="Register" />
        </form>
    </div>
</div>
<?php /*
<div class="container">
    <p style="display: block; font-size: 11px; color: #999;">
        Please note: This captcha will be generated when the img tag requests the captcha-generation
        (= a real image) from YOURURL/login/showcaptcha. As this is a client-side triggered request, a
        $_SESSION["captcha"] dump will not show the captcha characters. The captcha generation
        happens AFTER the request that generates THIS page has been finished.
    </p>
</div>*/
?>