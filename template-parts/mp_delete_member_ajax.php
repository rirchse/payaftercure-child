<?php
if (!empty($_POST) && !empty($_POST['member_name']) )
{
        require('../../../../wp-load.php'); // Load Wordpress API
        global $wpdb;
        $member_name = $_POST['member_name'];

        $current_user = wp_get_current_user();

        if ( current_user_can('administrator') )
        {
                $client_email = (!empty($_GET['email']))?($_GET['email']):($current_user->user_email);
        }
        else
        {
                $client_email = $current_user->user_email;
        }

        $wpdb->delete( 'srf_family_member', array( 'client_email' => $client_email, 'family_member_name' => $member_name ) );

}