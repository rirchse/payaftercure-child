<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  require('../../../../wp-load.php'); // Load Wordpress API
  global $wpdb;

  $root = $_SERVER['DOCUMENT_ROOT'];
  $img_path = $_POST['img'];
  
  if(file_exists($root.$img_path))
  {
    unlink($root.$_POST['img']);
    echo 'Case photo successfully deleted.';
  }

  $result = $wpdb->get_row("SELECT case_photo FROM srf_case_update WHERE case_photo = '$img_path' LIMIT 1");

  if($result)
  {
    $wpdb->update('srf_case_update', ['case_photo' => NULL], ['case_photo' => $img_path]);
  }
}
?>