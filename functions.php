<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(), '20240804' );
        
        /*
         * Code Added By Gaurang : I have putted this code for enqueue bootstrap css Date : 18-6-2018
         */
        if(is_home() || is_search()) {
        
            wp_enqueue_script( 'bootsrap_js', get_stylesheet_directory_uri().'/js/bootstrap.js', array(  ) );
            wp_enqueue_style( 'bootsrap_css', get_stylesheet_directory_uri().'/css/bootstrap.css' );
        
        }
        
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

// custom admin login logo
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url(../../wp-content/uploads/2015/04/logo1.png) !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');

add_action('template_redirect','remove_wpseo');

function remove_wpseo(){
    if (is_page('member-portal') || is_page('member-portal-test') || is_page('smart-remedy-finder')) {
        global $wpseo_front;
            if(defined($wpseo_front)){
                remove_action('wp_head',array($wpseo_front,'head'),1);
            }
            elseif(class_exists('WPSEO_Frontend')) {
              $wp_thing = WPSEO_Frontend::get_instance();
              remove_action('wp_head',array($wp_thing,'head'),1);
            }
    }
}

add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
	return 'http://www.payaftercure.com/';
}

function change_password_hint ( $text ) {
    if(basename($_SERVER["SCRIPT_NAME"])=='wp-login.php' && $text == 'Hint: The password should be at least twelve characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ &amp; ).'){
        $text = '';
    }
    return $text;
}
add_filter( 'gettext', 'change_password_hint' );



add_filter( 'wp_login_errors', 'wpse_161709', 10, 2 );

function wpse_161709( $errors, $redirect_to )
{
   if( isset( $errors->errors['registered'] ) )
   {
     // Use the magic __get method to retrieve the errors array:
     $tmp = $errors->errors;   

     // What text to modify:
     $old = 'Registration complete. Please check your email.';
     $new = 'Registration complete. Please check your email Inbox and your Spam/Junk folder for activating your account.';

     // Loop through the errors messages and modify the corresponding message:
     foreach( $tmp['registered'] as $index => $msg )
     {
       if( $msg === $old )
           $tmp['registered'][$index] = $new;        
     }
     // Use the magic __set method to override the errors property:
     $errors->errors = $tmp;

     // Cleanup:
     unset( $tmp );
   }  
   return $errors;
}

function my_delete_user( $user_id ) {
	global $wpdb;

        $user_obj = get_userdata( $user_id );
        $email = $user_obj->user_email;
       
 $delete= $wpdb->query(
              'DELETE  FROM srf_family_member  WHERE client_email = "'.$email.'"'
);
}
add_action( 'delete_user', 'my_delete_user' );

/* Code Added By Dhara: Add script for chnage text in Register page*/ 
function my_login_logo() { 
	
	// Add JS for custom register text
	wp_enqueue_script( 'custom-register', get_stylesheet_directory_uri() . '/js/custom-register.js', array('jquery'), '1.0', true  );
	}
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function convert_date_format($user_date){
   return date("m/d/Y H:i:s", strtotime($user_date));
}

 // Ghulam Abbas 
 // Edit date: 10 may 2020
 // to speed up home page load speed for Google Site kit these scripts will not be used on home page and blog posts
function remove_unuse_scripts() {
  wp_deregister_script('wp-embed');       
	if(is_front_page() || get_post_type()=='post')
  {
    wp_dequeue_style( 'wordpress-file-upload-style' );
    wp_dequeue_style( 'wordpress-file-upload-style-safe' );
    wp_dequeue_style( 'wordpress-file-upload-adminbar-style' );
    wp_dequeue_style( 'wordpress-file-upload-style' );  
    wp_deregister_script('wordpress_file_upload_script');  
	}    
     
 }     
 if (!is_admin()){   
	  $user = wp_get_current_user();
    if(!$user->exists()){ 
      add_action( 'wp_enqueue_scripts', 'remove_unuse_scripts', 100 ); 
    }
 } 
 
 
 /*
     CODE TO RESET REMINDERS WHEN USER LOGINS
     Author : ALI https://www.upwork.com/freelancers/~01db3ab5b50716ab88
 */
 function resetReminder( $login ) {
    global $wpdb;
    $user = get_user_by('login',$login);
    $user_ID = $user->ID;
    $update_user = "update pay_users set reminder = 0 where id =".$user_ID;
    $wpdb->query($update_user);
}
add_action('wp_login', 'resetReminder');


/** custom on click login */

function onclick_auth() 
{
  if( $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['auto_login']) == true && htmlspecialchars( isset($_GET['secure_token'])) )
  {
    global $wpdb;    
    $token = htmlspecialchars($_GET['secure_token']);
    $redirect_to = isset($_GET['redirect_to'])? htmlspecialchars($_GET['redirect_to']):'';

    $user = $wpdb->get_row("SELECT * FROM pay_users WHERE auth_token = $token limit 1");

    if(!is_null($user))
    {
      wp_set_current_user($user->ID);
      wp_set_auth_cookie($user->ID);
      // do_action('wp_login', $user->user_login = null);
    wp_redirect($redirect_to);
    }

    wp_redirect(home_url('/wp-admin'));
  }
  
}

add_action('init', 'onclick_auth');


/** custom menu on dashboard */
function custom_menu()
{
  add_menu_page(
    'Admin Panel', // Page title
    'PAC Admin Panel', // Menu title
    'manage-options', // Capability
    'pac_admin_panel', // Menu slug
    'admin_callback', // Callback function to display content
    'dashicons-screenoptions', // menu icon
    '1' // menu position
  );

  add_submenu_page(
    'pac_admin_panel', // Parent menu slug
    'View All Users', // Page title
    'View All Users', // Menu title
    'manage_options', // Capability
    'view_user', // Menu slug
    'view_user_callback' // Callback function to display content
  );

  add_submenu_page(
    'pac_admin_panel',
    'Cronjob Setting',
    'Cronjob Setting',
    'manage_options',
    'cron_job',
    'cronjob_callback'
  );
}

add_action('admin_menu', 'custom_menu', 1);

function admin_callback()
{
  // Include the template file
  $template_path =__DIR__ . '/admin_panel/admin_home.php';
  // var_dump($template_path);
    if (file_exists($template_path))
    {
      include $template_path;
    }
    else
    {
      echo '<p>Template file not found!</p>';
    }
}
function view_user_callback()
{
  // Include the template file
  $template_path =__DIR__ . '/admin_panel/view_users.php';
  // var_dump($template_path);
    if (file_exists($template_path))
    {
      include $template_path;
    }
    else
    {
      echo '<p>Template file not found!</p>';
    }
}

function cronjob_callback()
{
  // Include the template file
  $template_path =__DIR__ . '/admin_panel/cronjob.php';
  // var_dump($template_path);
    if (file_exists($template_path))
    {
      include $template_path;
    }
    else
    {
      echo '<p>Template file not found!</p>';
    }
}




/** 
 * insert data into user_login to find out user last login.
 * */

function user_last_login($user_login, $user) {
  // Get user information
  $user_id = $user->ID;
  $user_email = $user->user_email;
  $current_date = date('Y-m-d H:i:s');

  // Insert login information into your custom table
  global $wpdb;
  
  $dbuser = $wpdb->get_row("SELECT * FROM user_logins WHERE user_id = $user_id");

  $cronjob = 0;

  if($dbuser->cronjob == 1)
  {
    $cronjob = 1;
  }

  if(isset($dbuser))
  {
    $wpdb->update('user_logins', ['last_login' => $current_date, 'cronjob' => $cronjob ], ['user_id' => $user_id]);
  }
  else
  {
    $wpdb->insert(
        'user_logins',
        array(
            'user_id' => $user_id,
            'user_mail' => $user_email,
            'last_login' => $current_date
        )
    );
  }
}
add_action('wp_login', 'user_last_login', 10, 2);