<?php
include 'main.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['uid']))
{
  function sanitize($data)
  {
    return htmlspecialchars($data);
  }

  $user_id = sanitize($_POST['uid']);
  $cronjob = sanitize($_POST['cronjob']);

  $user = Main::user($user_id);

  $user_login = Main::UserLogin($user_id);

  $result = '';
  if(isset($user_login))
  {
    $result = Main::updateUserLogin($user_id, $cronjob);
  }
  else
  {
    $data = [
      'user_id'    => $user_id,
      'user_mail'  => $user['user_email'],
      'last_login' => $user['user_registered'], 
      'cronjob'    => $cronjob
    ];
  
    $result = Main::insertUserLogins($data);

    $start = strtotime($user['user_registered']);
    $end = strtotime(date('Y-m-d'));
    $counter = ceil(abs($end - $start) / 86400);
  
    echo json_encode(['last_login' => $user['user_registered'], 'counter' => $counter]);
  }
  
}
?>