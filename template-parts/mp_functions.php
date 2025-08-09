<?php

/**
 * MP Functions
 * This files has included all of functions for Member Portal
 * Functions are using query to database some calculation etc.
 * Controls all email sending from the member portal.
 
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


/** sanitize all request data removing html special characters */
function sanitize($value)
{
  return htmlspecialchars($value, ENT_QUOTES);
}


/** main emailing function from member portal */
function sendMail($email_to, $email_cc, $subject, $htmlmessage)
{
  $from_name = 'PayAfterCure';
  $from_mail = 'support@payaftercure.com';
  $replyto   = 'support@payaftercure.com';

  if (!empty($email_to))
    {
      $header  = "From: ".$from_name." <".$from_mail.">\r\n";
      $header .= "Cc: " . $email_cc . "\r\n";

      $header .= "Reply-To: ".$replyto."\r\n";
      $header .= "MIME-Version: 1.0\r\n";
      $header .= "Content-Type: text/html; charset=UTF-8\r\n";
      // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Aug 20, 2022, Added SMTP mail		
      $is_sent = wp_mail($email_to, $subject, $htmlmessage, $header);
      // echo $htmlmessage;
      // CODE EDIT END
    }
}



/** creating html email template */
function emailTemplate($message)
{
  // email template body with default style
  return '<!DOCTYPE=html><html><body style="background:#ddd;padding:25px"><table style="max-width:500px;min-height:400px;margin:0 auto; background:#fff;"><tr><td style="width:100%;color:blue;text-align:center;padding:25px"><h1 style="margin-bottom:0">Pay After Cure</h1><em>Online Homeopathic Consultation</em></td></tr><tr><td style="width:100%; padding:25px; vertical-align:top">'.$message.'</td></tr></table></body></html>';
}



/** email sending function by the admin */
function sendEmailAdmin($email_to, $comments, $family_member_name)
{
  $subject = 'Member Portal Message';
  $email_cc = 'support@payaftercure.com';
  $message .= '<h3>Admin PAC has posted this comment</h3> <br>"' . $comments . '" <br> for ' . $family_member_name . ' user.  <br>If it requires a reply, please login to the <a href="' . get_permalink() . '?email='.$email_to.'&family_member_name='. $family_member_name .'" style="padding:5px 15px;border:1px solid blue;background:blue;color:#fff;"> Member Portal</a> &nbsp; and reply.';
  
  sendMail($email_to, $email_cc, $subject, emailTemplate($message));
}



/** email sending function for member  */
function sendEmailUser($client_email, $comments, $family_member_name)
{
  $subject = 'Member Portal Message from ' . $client_email;
  $email_to = 'support@payaftercure.com';
  $email_cc = $client_email;
  $message .= '<h3>Member ' . $client_email . ' has posted this comment</h3> <br>"' . $comments . '" <br> for ' . $family_member_name . ' user.  <br>If it requires a reply, please login to the <a href="' . get_permalink() . '?email='.$client_email.'&family_member_name='. $family_member_name .'" style="padding:5px 15px;border:1px solid blue;background:blue;color:#fff;text-decoration:none"> Member Portal </a> &nbsp; and reply.';

  sendMail($email_to, $email_cc, $subject, emailTemplate($message));
}




/** get prescription data from database send to mp_member_portal_base_file.php */
function PrescriptionData($wpdb, $client_email)
{
  return $wpdb->get_row("SELECT * FROM srf_prescription WHERE email = '" . $client_email . "' AND manage_case = '1' ORDER BY `prescription_id` DESC LIMIT 1");
}



/** get illnesses quering databse send to mp_member_portal_base_file.php */
function Illnesses($wpdb)
{
  return 
  $wpdb->get_results("SELECT * FROM srf_illness WHERE illness_enabled = 1 ORDER BY `illness_name`");
}


/** get data from srf_case_update send to mp_member_portal_base_file.php */
function SrfCaseUpdate($wpdb, $client_email, $id)
{
  return $wpdb->get_row('select * from srf_case_update where client_email = "' . $client_email . '" and update_id = ' . $id);
}


/** delete srf_case_update data */
function SrfCaseDelete($wpdb, $client_email, $id)
{
  $document_root = $_SERVER['DOCUMENT_ROOT'];

  $case = $wpdb->get_row("SELECT * FROM srf_case_update WHERE update_id = $id LIMIT 1");

  if($case->case_photo && file_exists($document_root.$case->case_photo))
  {
    unlink($document_root.$case->case_photo);
  }
  // var_dump(file_exists($document_root.$case->case_photo));
  // exit();
  return $wpdb->delete( 'srf_case_update', array( 'client_email' => $client_email, 'update_id' => $id ) );
}


/** get paid user from database and send to mp_member_portal_base_file.php */
function GetDeletedPayUser($wpdb, $email)
{
  return $wpdb->get_row("SELECT * FROM pay_users WHERE user_email = '" . $email . "'");
}


/** delete from srf_case_update */
function CaseDeleteByEmail($wpdb, $email)
{
  return $wpdb->delete( 
    'srf_case_update', 
    array( 'client_email' => $email ) );
}


/** delete from srf_familty_member */
function FamilyMemberDelete($wpdb, array $memberData)
{
  return $wpdb->delete( 'srf_family_member', $memberData );
}


/** insert data to srf_family_member */
function FamilyMemberInsert($wpdb, array $memberData)
{
  return $wpdb->insert( 'srf_family_member', $memberData );
}


/** update srf_case_update table data  */
function Srf_Case_Update($wpdb, array $caseData, array $email)
{
  return $wpdb->update ( 'srf_case_update', $caseData, $email );
}


/** insert srf_case_update */
function SrfCaseInsert($wpdb, array $case_data)
{
  return $wpdb->insert('srf_case_update', $case_data);
}


/** get family member from database to mp_member_portal_base_file.php */
function getMemberFromCaseUpdate($wpdb, $client_email)
{
  // return $wpdb->get_results("SELECT DISTINCT family_member_name FROM srf_case_update WHERE client_email = '" . $client_email . "' ORDER BY family_member_name");
  return $wpdb->get_results("SELECT DISTINCT family_member_name FROM srf_family_member WHERE client_email = '" . $client_email . "' ORDER BY family_member_name");
}


/** get paypal user form databse and send it to mp_member_portal_base_file.php */
function SelectPayPalData($wpdb, $client_email)
{
  return $wpdb->get_row("SELECT po.*, pm2.meta_value as serialized_data 
      FROM `pay_posts` po
      JOIN `pay_postmeta` pm1 ON po.ID = pm1.post_id AND pm1.meta_key = 'payer_email'
      JOIN `pay_postmeta` pm2 ON po.ID = pm2.post_id AND pm2.meta_key = 'ipn data serialized'
      JOIN `pay_postmeta` pm3 ON po.ID = pm3.post_id AND pm3.meta_key = 'payment_status'
      JOIN `pay_postmeta` pm4 ON po.ID = pm4.post_id AND pm4.meta_key = 'item_number1'
      WHERE po.`post_type` = 'paypal_ipn'
      AND pm1.meta_value = '" . $client_email . "'
      AND pm3.meta_value = 'Completed'
      AND pm4.meta_value = 'member_portal'
      ORDER BY po.ID DESC LIMIT 1");
}



/** get pay_users data and send to mp_member_portal_base_file.php */
function PayUserData($wpdb, $client_email)
{
  return $wpdb->get_row("SELECT * FROM pay_users WHERE user_email = '" . $client_email . "'");
}


/** get result from pay_users */
function SelectEmailList($wpdb)
{
  return $wpdb->get_results("SELECT DISTINCT pr.email FROM srf_prescription pr JOIN pay_users us ON pr.email = us.user_email WHERE pr.manage_case = 1 ORDER BY pr.email ASC");
}


/** get existing case data from srf_case_update table */
function ExistingCaseData($wpdb, $client_email)
{
  return $wpdb->get_row('select * from srf_case_update where client_email = "' . $client_email . '" and improvement > 0 order by date_submitted desc limit 1');
}


/** select current time from sql query */
function CheckCurrentTime($wpdb)
{
  return $wpdb->get_row('SELECT NOW() as curtime');
}

/** exist prescription image upload */
function prescripUpload($rawfile, $target_dir)
{
  // return $rawfile;
  $base_dir = get_home_path();
  $data = [];
  $data['msg'] = NULL;
  $data['img_file'] = NULL;
  $data['status'] = NULL;
  $raw_image_size = $rawfile['size'];
  return $raw_image_size;
  if($rawfile["name"])
  {
    // $target_dir = $base_dir.$target_dir;
    $target_file = $target_dir . basename($rawfile["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $resizeFileName = time();
    $upload = 1;

    if($rawfile["size"] == 0 || $rawfile["size"] > 10000000)
    {
      $upload = 0;
      $data['msg'] = 'File size max 5MB';
      $data['status'] = 'error';
      return $data;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif")
    {
      $upload = 0;
      $data['msg'] = 'Image format does not match';
      $data['status'] = 'error';
      return $data;
    }

    if($upload == 1)
    {
      $raw_image = $rawfile['tmp_name'];
      $image_size = getimagesize($raw_image);
    
      $ratio = 0;
      $img_width = 1200;
      $img_height = 1200;
    
      if($image_size[0] > $image_size[1] && $image_size[0] > $img_width)
      {
        $ratio = $image_size[0] / $image_size[1];
        $img_height = round($img_width / $ratio);
      }
      elseif($image_size[1] > $image_size[0] && $image_size[1] > $img_height)
      {
        $ratio = $image_size[1] / $image_size[0];
        $img_width = round($img_height / $ratio);
      }
      else
      {
        $img_width = $image_size[0];
        $img_height = $image_size[1];
      }

      $resourceType = @imagecreatefromjpeg($raw_image);
      if($resourceType !== false)
      {    
        $imageLayer = imagecreatetruecolor($img_width, $img_height);imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $img_width, $img_height, $image_size[0], $image_size[1]);
        
        imagejpeg($imageLayer, $base_dir.$target_dir . $resizeFileName.'_' .$rawfile["name"]);
    
        // return $base_dir;
        $data['img_file'] = $target_dir . $resizeFileName.'_' .$rawfile["name"];
        return $data;
      }
    }
  }
}
?>