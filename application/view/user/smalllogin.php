<!doctype html>
<!-- cheating by using imggallery lol... -->

    <div class="container center">
        <div class="small-login-box limit50">
        <h3>Login</h3>
        <form id="small-login-form">
            <input type="text" id='user_name' name="user_name" placeholder="Username or email" required />
            <input type="password" id='user_password' name="user_password" placeholder="Password" required />
            <label for="set_remember_me_cookie" class="remember-me-label">
                <input type="checkbox" id="set_remember_me_cookie" name="set_remember_me_cookie" class="remember-me-checkbox" />
                Remember me 
            </label>
            <?php if (!empty($this->redirect)) { ?>
                <input type="hidden" name="redirect" value="<?php echo $this->redirect ?>" />
            <?php } ?>
			<input type="hidden" class="csrf_token" id="csrf_token" value="<?php echo Csrf::makeToken(); ?>" />
            <input type="submit" class="login-submit-button" value="Log in"/>
        </form>
        <div class="link-forgot-my-password">
            <a style="font-size:10px;" href="<?php echo Config::get('URL'); ?>user/requestPasswordReset">I forgot my password</a>
        </div>
        </div>

        <div class="small-register-box limit50">
        <h3>No account yet ?</h3>
        <a href="<?php echo Config::get('URL'); ?>user/register">Register</a>
        </div>
    </div>

<?php /*
<div class="small-login-page-box">
    <div class="table-wrapper">

        <!-- login box on left side -->
        <div class="small-login-box">
            <h3>Login here</h3>
            <form id="small-login-form">
                <input type="text" id='user_name' name="user_name" placeholder="Username or email" required />
                <input type="password" id='user_password' name="user_password" placeholder="Password" required />
                <label for="set_remember_me_cookie" class="remember-me-label">
                    <input type="checkbox" id="set_remember_me_cookie" name="set_remember_me_cookie" class="remember-me-checkbox" />
                    Remember me 
                </label>
                <?php if (!empty($this->redirect)) { ?>
                    <input type="hidden" name="redirect" value="<?php echo $this->redirect ?>" />
                <?php } ?>
				<input type="hidden" class="csrf_token" id="csrf_token" value="<?php echo Csrf::makeToken(); ?>" />
                <input type="submit" class="login-submit-button" value="Log in"/>
            </form>
            <div class="link-forgot-my-password">
                <a style="font-size:10px;" href="<?php echo Config::get('URL'); ?>user/requestPasswordReset">I forgot my password</a>
            </div>
        </div>

        <!-- register box on right side -->
        <div class="small-register-box">
            <h3>No account yet ?</h3>
            <a href="<?php echo Config::get('URL'); ?>user/register">Register</a>
        </div>

    </div>
</div>

*/ ?>