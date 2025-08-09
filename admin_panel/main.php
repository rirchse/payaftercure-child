<?php
include ABSPATH.'/wp-config.php';
// include '/wp-content/themes/veggie-lite-child/admin_panel/wp-config.php';

class Main {

  /** connect to the database */
  public function DB($sql)
  {
    $host        = constant('DB_HOST');
    $db_user     = constant('DB_USER');
    $db_password = constant('DB_PASSWORD');
    $db_name     = constant('DB_NAME');

    $connect = new mysqli($host, $db_user, $db_password, $db_name);

    if($connect->connect_error)
    {
      die("Connection failed:".$connect->connect_error);
    }

    $result = $connect->query($sql);
    return $result;

    $result->close();
  }


  public static function users()
  {
    $sql = "SELECT * FROM pay_users AS pu LEFT JOIN user_logins AS ul ON pu.ID = ul.user_id ORDER BY pu.ID DESC";
    $result = Main::DB($sql);
    return $result;
  }

  public static function updateUserLogin($uid, $reminder)
  {
    $sql = "UPDATE user_logins SET cronjob = $reminder WHERE user_id = $uid";
    $result = Main::DB($sql);
    return $result;
  }

  public static function insertUserLogins(array $data)
  {
    $id = $data['user_id'];
    $user_email = $data['user_mail'];
    $last_login = $data['last_login'];
    $cronjob = $data['cronjob'];

    $sql = "INSERT INTO user_logins (user_id, user_mail, last_login, cronjob) VALUES ($id, '$user_email', '$last_login', $cronjob)";
    $result = Main::DB($sql);
    return $result;
  }

  public static function UserLogin($id)
  {
    $sql = "SELECT * FROM user_logins WHERE user_id = $id LIMIT 1";
    $result = Main::DB($sql);
    return $result->fetch_assoc();
  }


  public static function user($id)
  {
    return Main::DB("SELECT * FROM pay_users WHERE ID = $id LIMIT 1")->fetch_assoc();
  }

  /** return cronjobs query results */
  public function cronjob()
  {
    $result = $this->DB("SELECT * FROM cronjobs ORDER BY id DESC");
    return $result;
  }

  /** update cronjob */
  public function cronjobUpdate($id, $name, $status, $date)
  {
    return $this->DB("UPDATE cronjobs SET name = '$name', status = $status, updated_at = '$date' WHERE id = $id");
  }
  
}

$main = new Main;

?>