<?php
/**
 * SRF Prescription Data Storing
 * This file storing prescription data to database
 */

/**
 * Developer Information:
 * [
 *  Name: Rafiqul Islam,
 *  Email: rirchse@gmail.com,
 *  Upwork Profile: https://upwork.com/freelancers/rafiquli34
 *  WhatsApp: +880 1825 322626
 *  Date: 2023-10-30
 * ]
 */

require('../../../../wp-load.php'); // Load Wordpress API
$data = ( isset( $_POST ) ) ? $_POST : null; // Get POST data, null on empty.

if ($data && isset($data['illness_name']) && isset($data['email'])){ // To Prevent Spam, bogus POSTs, etc.
    $wpdb->insert('srf_prescription', 
    array(
      'email'         => $data['email'],
      'illness_name'	=> $data['illness_name'],
      'manage_case'	  => $data['manage_case']
    ),
    array(
      '%s',
      '%s',
      '%s'
    ) 
  ); 

}