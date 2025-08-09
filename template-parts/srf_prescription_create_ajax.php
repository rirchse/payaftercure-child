<?php

/**
 * SRF Prescription create by ajax
 * This file has basically 3 files
 * 
 * 1. srf_prescription_data.php,
 * 2. srf_prescription_pdf_generator.php,
 * 3. srf_send_email.php
 * 
 * This file storing prescription data to database
 * Creating prescription pdf
 * Sending prescription email to the member
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

if (isset($_POST))
{
    // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Aug 20, 2022, For Using Wordpress API
    require_once("../../../../wp-load.php");
    // CODE EDIT END
    include_once('srf_prescription_data_storing.php');

    // include_once('../../../../wp-includes/mpdf60/mpdf.php');
    // $stylesheet = file_get_contents('../../../../wp-content/themes/veggie-lite-child/css/pdf-style.css');


    // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, May 04, 2022, to remove slashes and space from HTML sting for showing correct PDF Links    
    $post_html = rmspace($_POST['html']);
    // CODE EDIT END

    $post_html = str_replace('display:none;', '', $post_html);
    $post_html = str_replace('<input id="disclaimer_check" type="checkbox" name="disclaimer_check" value="" />', '<input id="disclaimer_check" type="checkbox" name="disclaimer_check" checked="checked" />', $post_html);
    $post_html = str_replace('name="answers_check" value="Yes"', 'name="answers_check" value="Yes" checked="checked"', $post_html);


    // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Apr 25, 2022, exit the file if illness and user email is empty
    if (!(isset($_POST['illness_name']) && isset($_POST['email']))) {
        exit(); 
    }
    // CODE EDIT END



    /**-----------------------------------------------------
     * SRF prescription pdf creation 
     * ----------------------------------------------------*/
    // include 'srf_prescription_pdf_generator.php';

    // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Aug 20, 2022, Commented out old code

    $mailto = $_POST['email'];
    $from_name = 'PayAfterCure';
    $from_mail = 'support@payaftercure.com';
    $replyto = 'support@payaftercure.com';
    $uid = md5(uniqid(time()));
    

    /** 
     * MP Manage Case Table update for Paid Member
     */
   
    if (!empty($_POST['manage_case']) && (int)$_POST['manage_case'] === 1)
    {
	    require('../../../../wp-load.php'); // Load Wordpress API
	    $data = ( isset( $_POST ) ) ? $_POST : null; // Get POST data, null on empty.
        // $filename = 'prescription_' . date("Ymd_His") . '.pdf';

    	$case_data = array( 
			'email' => $_POST["email"],
			'client_email' => $_POST["email"], 
			'illness_name' => $_POST["illness_name"], 
			'comments' => 'prescription created by '.$_POST["email"].'<br><a style="color:red" href="javascript:void(0);" class="portal_attachment" data-fn="'.$filename.'">Download Prescription</a>',
			'is_admin' => '1',
			'family_member_name' => $_POST["family_member"],
			// 'filename' => $filename
    	);

        /** This query storing data to srf_case_update table */
     	$wpdb->insert( 
    	   	'srf_case_update', 
       		$case_data
	    );

        /** This query storing family member data to DB srf_family_member */
        $wpdb->insert('srf_family_member', [
			'client_email' => $_POST["email"],
			'family_member_name' => $_POST["family_member"], 
			'main_health_problem' => $_POST["illness_name"]
        ]);

        // $upload_dir = wp_upload_dir()['basedir'] . '/portal/' . $_POST['client_id'] . '/';
        // if (!file_exists($upload_dir)) {
        //     mkdir($upload_dir, 0755, true);
        // }

		// $mpdf->Output($upload_dir . $filename,'F');


        $subject = 'Welcome to PayAfterCure Member Portal';
        $message = '<pre>Dear Member, Thank you for using the SRF (Smart Remedy Finder) and choosing our Paid Consultation service. Please REPLY to this email and CONFIRM that you want us to start the treatment. We will not start unless you REPLY to this email. Once we receive your reply, we will manage your case FREE for 30 days and if you are fully satisfied with our service, you pay us at the end of those 30 days, if not, you go free and we  stop the treatment. You can use this link <a href="http://www.payaftercure.com/member-portal/">http://www.payaftercure.com/member-portal/</a> to access the MP (Member Portal). You can log in using the same username & password which you used for SRF (Smart Remedy Finder). In case of any confusion you can watch this video <a href="https://youtu.be/464haMjkPgA/">How to use the Member Portal/</a>
            You can use the Member Portal to:
        1. Update your case status & ask questions related to your case
        2. Upload any pictures & documents
        3. Update your health status dashboard
        4. Keep a track of your payments

        Wishing you health & happiness.
        Team Pay After Cure.
        </pre>';
    }
    else
    {
        $message = 'Thank you for using the free SRF (Smart Remedy Finder).<br>
            A copy of your free prescription is attached.<br>
                Please read the instructions & other details as they apply to all prescriptions.<br>
                Wishing you health & happiness.<br>
                Team Pay After Cure.';
        $subject = 'Your prescription for ' . $_POST['illness_name'];
    }
    
    // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Aug 20, 2022, Updated the code to wordpress function for using SMTP

    //make html prescription to the email body
    $message = $message.$post_html;

    /**----------------------------------------------------
     * SRF Send Email to Paid Member
     ------------------------------------------------------*/

    include 'srf_send_email.php';
    
    // CODE EDIT END
    exit;
}

// CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, May 04, 2022, to remove slashes and space from HTML sting for showing correct PDF Links

function rmspace($buffer)
{ 
    return stripslashes(preg_replace( "/\r|\n/", "", $buffer )); 
};
// CODE EDIT END

?>