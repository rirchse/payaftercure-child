<?php

/** template Name: Login
*/

get_header();?>

<?php 
if ( is_user_logged_in() ) {
echo 'You have successfully registered and logged in.<br>
Please click <a href="' . get_permalink(336) . '">here</a> to open the Smart Remedy Finder page.<br><br><br>';
}
else
{
echo '
<div>
<p>To use the Smart Remedy Finder, the registered members have to Login with their email address &amp; password.</p>
<p>Please register your account if you don\'t have one.</p>
</div>
<div></div>
<a href="' . wp_login_url( get_permalink(336) ) . '" title="Login">Login</a><br>
<a href="'. wp_registration_url() . '">Register</a>
<br><br><br>';
}
?>

<?php

get_footer();
?>