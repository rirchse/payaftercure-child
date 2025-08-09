<?php

$illness = $wpdb->get_results("SELECT * FROM srf_illness WHERE illness_enabled = 1 ORDER BY `illness_name`");

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  
  $username = $email = $member_name = $main_health_problem = $illness_name = '';

  if(isset($_POST['username']) && isset($_POST['email']))
  {
    $username = sanitize($_POST['username']);
    $email    = sanitize($_POST['email']);
    $illness_name    = sanitize($_POST['illness_name']);

    // find user exists
    $dbuser = $wpdb->get_row("SELECT * FROM pay_users WHERE user_email = '" . $email . "' OR user_login = '".$username."'");
    
    if($dbuser)
    {
      echo '<script>alert("The subscriber already exist.");</script>';
    }
    else
    {
      try{

        $wpdb->insert('pay_users', ['user_login' => $username, 'user_email' => $email]);

        $wpdb->insert('srf_prescription', ['email' => $email, 'illness_name' => $illness_name, 'manage_case' => 1 ]);

        echo '<script>alert("The Subscriber successfully created.");</script>';

      }catch(\E $e){
        echo '<script>alert("We are unable to insert to the database.");</script>';
      }
    }    
    
    // $text = 'subscriber form submited';
    // echo msg('subscriber form submited');
  }

  if(isset($_POST['email']) && isset($_POST['member_name']))
  {
    $member_name = sanitize($_POST['member_name']);
    $email    = sanitize($_POST['email']);
    $main_health_problem = sanitize($_POST['main_health_problem']);

    // find user exists
    $dbuser = $wpdb->get_row("SELECT * FROM pay_users WHERE user_email = '" . $email . "'");
    if($dbuser)
    {
      $db_member = $wpdb->get_row("SELECT * FROM srf_family_member WHERE client_email = '".$email."' AND member_name = '".$member_name."'");
      if($db_member)
      {
        echo '<script>alert("The member already exist.");</script>';
      }
      else
      {
        try{
          $result = $wpdb->insert('srf_family_member', [
            'client_email' => $email,
            'family_member_name' => $member_name,
            'main_health_problem' => $main_health_problem,
            'last_payment_date' => '0000-00-00'
          ]);

          $result = $wpdb->insert('srf_case_update', [
            'fid' => 0,
            'email' => $email,
            'client_email' => $email,
            'family_member_name' => $member_name,
            'illness_name' => $main_health_problem,
            'is_admin' => 0,
            'date_submitted' => date('Y-m-d H:i:s')
          ]);

          var_dump($result);
          // exit();

          echo '<script>alert("The member successfully added.");</script>';
        }
        catch(\E $e)
        {
          echo '<script>alert("Unable to create family member.");</script>';
        }
      }      
    }
    
  }  
}
?>
<style>
  .form-container{width:600px; position:fixed; top:15%; background:#fff; padding:25px; box-shadow: 0 0 1px; right:30%; display:none}
  input, select, button{padding: 0 15px}
  input, textarea{padding:5px 15px!important}
</style>

<!-- Subscriber Adding Form by Admin -->
<div class="form-container" id="subscriber_form">
  <span style="font-size:22px;float:right;margin-top:-20px;cursor:pointer" onclick="this.parentNode.style.display='none'">x</span>
  <h4>Add New Subscriber</h4>
  <form action="" method="POST">
    <div class="form-group">
      <div class="label">Username:</div>
      <input type="text" class="form-controll" name="username" required>
    </div>
    <div class="form-group">
      <div class="label">Email:</div>
      <input type="email" class="form-controll" name="email" required>
    </div>
    <div class="form-group">
      <div class="label">Main Health Problem:</div>
      <select class="form-controll" name="illness_name" required>
        <option value="">Select One</option>
        <?php
        foreach ($illness as $row)
				{
					echo '<option value="' . $row->illness_name . '" >' . $row->illness_name . '</option>';
				}
        ?>
      </select>
    </div>
    <button type="submit">Save</button>
  </form>
</div>

<!-- Member Adding Form by Admin -->
<div class="form-container" id="member_form">
  <span style="font-size:22px;float:right;margin-top:-20px;cursor:pointer" onclick="this.parentNode.style.display='none'">x</span>
  <h4>Add New Member</h4>
  <form action="" method="POST">
    <div class="form-group">
      <div class="label">Select Email:</div>
      <select class="form-controll" name="email" required>
        <option value="">Select One</option>
        <?php
        foreach ($email_list as $row)
				{
					$email_selected = (sanitize($_GET['email']) === $row->email)?('selected'):('');
					echo '<option value="' . $row->email . '" ' . $email_selected . '>' . $row->email . '</option>';
				}
        ?>
      </select>
    </div>
    <div class="form-group">
      <div class="label">Member Name:</div>
      <input type="text" class="form-controll" name="member_name" required>
    </div>
    <div class="form-group">
      <div class="label">Main Health Problem:</div>
      <select class="form-controll" name="main_health_problem" required>
        <option value="">Select One</option>
        <?php
        foreach ($illness as $row)
				{
					echo '<option value="' . $row->illness_name . '" >' . $row->illness_name . '</option>';
				}
        ?>
      </select>
    </div>
    <button type="submit">Save</button>
  </form>
</div>