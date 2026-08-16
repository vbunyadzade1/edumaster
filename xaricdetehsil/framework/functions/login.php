<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Login Redirect
/*-----------------------------------------------------------------------------------*/
function kavkaz_add_login_check(){

    $login_page = kavkaz_get_option('login_page');
    $register_page = kavkaz_get_option('register_page');
    $password_page = kavkaz_get_option('password_page');

    if (is_user_logged_in() && $login_page != "" && $register_page != "" && $password_page != "" ) {
        if ( is_page($login_page) || is_page($register_page) || is_page($password_page) ){
            wp_redirect( esc_url( get_author_posts_url( get_current_user_id() ) ) );
            exit();
        }
    }

}

add_action('wp', 'kavkaz_add_login_check');

/*-----------------------------------------------------------------------------------*/
# Login Form
/*-----------------------------------------------------------------------------------*/
function kavkaz_login_form(){
    if (!is_user_logged_in()) {
        $output = kavkaz_login_form_fields();
    } else {
        $output = 'user info here';
    }
    return $output;
}

add_shortcode('login_form', 'kavkaz_login_form');

function kavkaz_login_form_fields(){
ob_start();
?>
<form id="kavkaz_login_form" class="sign-form widget-form" action="" method="post">
   <div class="form-group">
      <input type="text" class="form-control" placeholder="<?php _kavkaz('Username*'); ?>" name="username" id="username">
   </div>
   <div class="form-group">
      <input type="password" class="form-control" placeholder="<?php _kavkaz('Password*'); ?>" name="password" id="password">
   </div>
   <div class="sign-controls form-group">
      <div class="custom-control custom-checkbox">
         <input type="checkbox" class="custom-control-input" id="rememberMe">
         <label class="custom-control-label" for="rememberMe"><?php _kavkaz('Remember Me'); ?></label>
      </div>
      <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="btn-link  ml-auto">
      <?php _kavkaz('Forgot Password?'); ?></a>
   </div>
   <div class="form-group">
      <input type="hidden" name="kavkaz_login_nonce" value="<?php echo wp_create_nonce('kavkaz-login-nonce'); ?>">
      <button type="submit" class="btn-custom"><?php _kavkaz('Login'); ?></button>
      <?php wp_nonce_field( 'wp_nonce_field' ); ?> 
   </div>
   <?php if( $register_page = kavkaz_get_option('register_page') ): ?>
   <p class="form-group text-center">
    <?php _kavkaz('Don\'t have an account?'); ?> <a href="<?php echo esc_url( get_page_link( $register_page ) ); ?>" class="btn-link"><?php _kavkaz('Create One'); ?></a> 
   </p>
   <?php endif; ?>
</form>
<?php kavkaz_show_error_messages(); ?>
<?php 
return 
ob_get_clean();
} 

/*-----------------------------------------------------------------------------------*/
# Register Form
/*-----------------------------------------------------------------------------------*/
function kavkaz_registration_form(){
    if (!is_user_logged_in()) {
        $registration_enabled = get_option('users_can_register');
        if ($registration_enabled) {
            $output = kavkaz_registration_form_fields();
        } else {
            $output = __('Kullanıcı kaydı etkinleştirilmedi');
        }
        return $output;
    }
}

add_shortcode('register_form', 'kavkaz_registration_form');

function kavkaz_registration_form_fields(){
ob_start(); 
?>	
<form id="kavkaz_registration_form" class="sign-form widget-form contact_form" action="" method="post">
   <div class="form-group">
      <input type="text" class="form-control" placeholder="<?php _kavkaz('Username*'); ?>" name="username" id="username">
   </div>
   <div class="form-group">
      <input type="email" class="form-control" placeholder="<?php _kavkaz('Email Address*'); ?>" name="email" id="email">
   </div>
   <div class="form-group">
      <input type="text" class="form-control" placeholder="<?php _kavkaz('First Name*'); ?>" name="first_name" id="first_name">
   </div>
   <div class="form-group">
      <input type="text" class="form-control" placeholder="<?php _kavkaz('Last Name*'); ?>" name="email" id="email">
   </div>
   <div class="form-group">
      <input type="password" class="form-control" placeholder="<?php _kavkaz('Password*'); ?>" name="password" id="password">
   </div>
   <div class="form-group">
      <input type="password" class="form-control" placeholder="<?php _kavkaz('Password Again*'); ?>" name="password_confirm" id="password_again">
   </div>
   <div class="form-group">
      <input type="hidden" name="kavkaz_register_nonce" value="<?php echo wp_create_nonce('kavkaz-register-nonce'); ?>">
      <button type="submit" class="btn-custom"><?php _kavkaz('Sign up'); ?></button>
      <?php wp_nonce_field( 'wp_nonce_field' ); ?> 
   </div>
   <?php if( $login_page = kavkaz_get_option('login_page') ): ?>
   <p class="form-group text-center">
      <?php _kavkaz('Already have an account?'); ?> <a href="<?php echo esc_url( get_page_link( $login_page ) ); ?>" class="btn-link"><?php _kavkaz('Login'); ?></a> 
   </p>
   <?php endif; ?>
</form>
<?php kavkaz_show_error_messages(); ?>
<?php 
return 
ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
# Login Functions
/*-----------------------------------------------------------------------------------*/
function kavkaz_login_member(){

    if (isset($_POST['username']) && wp_verify_nonce($_POST['kavkaz_login_nonce'], 'kavkaz-login-nonce')) {

        $user = get_userdatabylogin($_POST['username']);

        if (!$user) {
            kavkaz_errors()->add('empty_username', __kavkaztext('Wrong username'));
        }

        if (!isset($_POST['password']) || $_POST['password'] == '') {
            kavkaz_errors()->add('empty_password', __kavkaztext('Please enter a password'));
        }
        
        if (!wp_check_password($_POST['password'], $user->user_pass, $user->ID)) {
            kavkaz_errors()->add('empty_password', __kavkaztext('Wrong password'));
        }
        
        $errors = kavkaz_errors()->get_error_messages();
        
        if (empty($errors)) {
            wp_setcookie($_POST['username'], $_POST['password'], true);
            wp_set_current_user($user->ID, $_POST['username']);
            do_action('wp_login', $_POST['username']);
            wp_redirect(home_url());
            exit();
        }
    }
}

add_action('init', 'kavkaz_login_member'); 

/*-----------------------------------------------------------------------------------*/
# Register Functions
/*-----------------------------------------------------------------------------------*/
function kavkaz_add_new_member(){

    if (isset($_POST["username"]) && wp_verify_nonce($_POST['kavkaz_register_nonce'], 'kavkaz-register-nonce')) {

        $user_login = $_POST["username"];
        $user_email = $_POST["email"];
        $user_first = $_POST["first_name"];
        $user_last = $_POST["last_name"];
        $user_pass = $_POST["password"];
        $pass_confirm = $_POST["password_confirm"];

        require_once ABSPATH . WPINC . '/registration.php';

        if (username_exists($user_login)) {
            kavkaz_errors()->add('username_unavailable', __kavkaztext('Username is already taken.'));
        }

        if (!validate_username($user_login)) {
            kavkaz_errors()->add('username_invalid', __kavkaztext('Invalid username'));
        }

        if ($user_login == '') {
            kavkaz_errors()->add('username_empty', __kavkaztext('Please enter a username'));
        }

        if (!is_email($user_email)) {
            kavkaz_errors()->add('email_invalid', __kavkaztext('Invalid email'));
        }

        if (email_exists($user_email)) {
            kavkaz_errors()->add('email_used', __kavkaztext('Email is already registered'));
        }

        if ($user_pass == '') {
            kavkaz_errors()->add('password_empty', __kavkaztext('Please enter a password'));
        }

        if ($user_pass != $pass_confirm) {
            kavkaz_errors()->add('password_mismatch', __kavkaztext('Passwords do not match'));
        }

        $errors = kavkaz_errors()->get_error_messages();

        if (empty($errors)) {

            $new_user_id = wp_insert_user([
                'user_login' => $user_login,
                'user_pass' => $user_pass,
                'user_email' => $user_email,
                'first_name' => $user_first,
                'last_name' => $user_last,
                'user_registered' => date('Y-m-d H:i:s'),
                'role' => 'subscriber',
            ]);

            if ($new_user_id) {

                wp_new_user_notification($new_user_id);
                wp_setcookie($user_login, $user_pass, true);
                wp_set_current_user($new_user_id, $user_login);
                do_action('wp_login', $user_login);

                $to = $user_email;
                $subject = __kavkaztext('Registration Successful');
                $sender = get_option('name');
                $logo_url = home_url();
                $logo_name = get_bloginfo('name');
                $message = "<div style='padding:15px;background:#eaeaea; color:#fff'><a href='$logo_url' title='$logo_name'>" . $logo_name . "</a></div><div style='padding: 15px;background:#f9f9f9;'><hr><strong style='text-align:center'>" . __kavkaztext('Your login details') . "</strong><hr><strong>" . __kavkaztext('Your Username:') . ":</strong>" . $user_login . "<hr><strong>" . __kavkaztext('Your Password:') . ":</strong>" . $user_pass . "<hr></div>";
                $headers[] = 'MIME-Version: 1.0' . "\r\n";
                $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers[] = "X-Mailer: PHP \r\n";
                $headers[] = 'From: ' . $sender . ' < ' . $user_email . '>' . "\r\n";

                wp_mail($to, $subject, $message, $headers);

                wp_redirect(home_url());
                exit();

            }
        }
    }
}

add_action('init', 'kavkaz_add_new_member');

/*-----------------------------------------------------------------------------------*/
# Errors Functions
/*-----------------------------------------------------------------------------------*/
function kavkaz_errors(){
    static $wp_error;
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

function kavkaz_show_error_messages(){
    if ($codes = kavkaz_errors()->get_error_codes()) {
        echo '<div class="form-errors-messages">';
        foreach ($codes as $code) {
            $message = kavkaz_errors()->get_error_message($code);
            echo '<span class="error"><strong>' . __kavkaztext('Error') . '</strong>: ' . $message . '</span><br/>';
        }
        echo '</div>';
    }
}

?>