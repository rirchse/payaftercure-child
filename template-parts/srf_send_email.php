<?php
/**
 * SRF Send Email
 * This file emails final prescription after the user selects Free or Paid Option
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

    $header2 = "From: ".$from_name." <".$from_mail.">\r\n";
    $header2 .= "Cc: payaftercure@gmail.com\r\n";
    $header2 .= "Reply-To: ".$replyto."\r\n";
    $header2 .= "Return-Path: $from_mail\r\n";
    $header2 .= "Content-Type: text/html; charset=UTF-8\r\n";

    // $attachment_path  = ABSPATH . 'wp-content/uploads/prescriptions/'.get_current_user_id().'/Prescription.pdf';
    // $attachments = array($attachment_path);

    $is_sent = wp_mail($mailto, $subject, $message, $header2);
    // echo $message;
    // $is_sent = wp_mail($mailto, $subject, $message, $header2, $attachments);

    /*
    if (file_exists($attachment_path)) 
    {  
        // delete the attachement from the server after sending in email to save memory
        unlink($attachment_path);
    }
    */

?>