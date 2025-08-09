<?php
include 'main.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']))
{
  function sanitize($data)
  {
    return htmlspecialchars($data);
  }

  $id = sanitize($_POST['id']);
  $name    = sanitize($_POST['name']);
  $status  = sanitize($_POST['status']);
  $date = date('Y-m-d H:i:s');

  $main->cronjobUpdate($id, $name, $status, $date);  
}
?>