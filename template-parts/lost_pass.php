
<?php

/** template Name: Lost Password
*/

get_header();?>
<?php 
wp_redirect( '../wp-login.php?action=lostpassword' ); 
exit; 
?>
<?php
get_footer();
?>