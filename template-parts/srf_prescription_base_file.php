<?php

/**
 * template Name: Srf Prescription Base File
 */

/**
 * SRF section has 2 base file connected 
 * 1. SRF_Base_File.php
 * 2. SRF_Prescription_Base_File.php
 *  
 * SRF_Prescription_Base_File.php file has included 
 * 
 * -> srf_functions.php,
 * -> srf_prescription.php,
 * -> srf_prescription_create_ajax.php connected by srf.js,
 * -----> srf_prescription_pdf_generator.php connected by srf.js,
 * -----> srf_send_email.php connected by srf.js,
 * -> srf_prescription_data.php connected by srf.js,
 * -> srf.js
 * -> prescription.css
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

get_header();

/** all functions included in prescription_functions.php for prescription child.php */
include 'srf_functions.php';

?>
<style type="text/css" media="print">
@media print {
    a[href]:after {
        content: none !important;
    }
}
</style>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    $redirect = get_permalink(336);
    if(is_user_logged_in() ) {
        $link = '<a href="' . wp_logout_url($redirect) . '" title="' .  __('Logout') .'">' . __('Logout') . '</a>';
    }
    $items.= '<a id="log-in-out-link" class="menu-item menu-type-link">'. $link . '</a>';
    echo $items;


    wp_enqueue_style('datatables-style', 'https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css', false); 
    wp_enqueue_script('datatables', 'https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js', false);

    /** ../js/srf.js file connected */
    $homeUrl = home_url('/').'wp-content/themes/veggie-lite-child/js/srf.js';
    wp_enqueue_script('srf', $homeUrl, array(), '15.01');

    /** if member select any question answer then do this action */
    if(sanitize(isset($_POST['time_spent'])))
    {
        global $wpdb;
        $current_user = wp_get_current_user();

        $in_clause = [];
        $in_clause_qst = [];
        $html = '';
        echo '<h3>Smart Remedy Finder</h3>
        <!-- progressbar -->
        <ul id="progressbar">';

        if(is_user_logged_in() )
        {
            echo '<li style="counter-increment: step" class="active">Login</li>';
        }
        else
        {
            echo '<li style="counter-increment: step">Login</li>';
        }
        echo '<li style="counter-increment: step" id="progressbar1" class="active">Answer questions</li><li style="counter-increment: step" id="progressbar2" class="active">Summary of Your Answers</li><li style="counter-increment: step" id="progressbar3">Disclaimer</li><li style="counter-increment: step" id="progressbar4">Prescription</li></ul>';

        $recommendation_details = '';

        /* razaul changed code here for save textbox questions 10-10-2018 */
        foreach ($_POST as $key => $value)
        {
            if (strpos($key, 'radio') !== false)
            {
                if($key != 'illness_id'){
                $in_clause[] .= $value;
                }
            }
            elseif(strpos($key, 'textbox') > 0)
            {
                $questiionidarr = explode("textbox",$key);
                if(isset($questiionidarr[1]))
                {
                $questid = $questiionidarr[1];
                $in_clause_qst[].=$questid;
                    $wpdb->insert(
                        'srf_prescription_choices_text', array(
                        'id' => '',
                        'email' => $current_user->user_email,
                        'question_id' => $questid,
                        'answer' => trim($value)
                        )
                    );
                }
            }
            elseif (strpos($key, 'comment') > 0) 
            {
                $questiionidarr = explode("comment",$key);
                if(isset($questiionidarr[1])){
                $questid = $questiionidarr[1];
                $in_clause_qst[].=$questid;
                    $wpdb->insert(
                        'srf_prescription_choices_text', array(
                        'id' => '',
                        'email' => $current_user->user_email,
                        'question_id' => $questid,
                        'answer' => trim($value)
                        )
                    );
                }
            }
            else
            {
                if($key != 'illness_id'){
                    if(is_array($value)){
                        foreach($value as $value2){
                            $in_clause[] .= $value2;
                        }
                    }elseif(is_numeric ($value) && $value > 0){
                        
                        $in_clause[] .= $value;
                    }
                }
            }
        } /** $_POST as $key => $value */

        $choice_ids = implode(',', $in_clause);
        
        /* razaul changed code here for save textbox questions 10-10-2018*/
        $text_qst_ids = implode(',', $in_clause_qst);
        $textqstsql = '';

        if($text_qst_ids != '')
        {
            $textqstsql = " OR question_id in ($text_qst_ids)";
        }

        /** SRF Answer Summery Section: srf_answer_summery page */

        include 'srf_answer_summary.php';
    
        /** SRF Disclaimer Section:
         * This logic of showing disclaimer from the disclaimer page */

        include 'srf_disclaimer.php';


        /** SRF Manage Case Section: srf_manage_case section */

        echo '<div id="manage_case_yes_div" style="display: none; float: left;">
        <p>
        <br>
        You have successfully submitted your case details. You will receive 2 emails from us within the next few minutes. One will be Welcome email and the other will be Prescription with PDF attachment. If you don’t receive the emails check your SPAM FOLDER, if mails are not there then contact us at support@payaftercure.com
        </p>
        <br>
        </div>';
        $html .= $disclaimer_text . '</div>';
    
        include 'srf_prescription.php';
    
    } /** sanitize(isset($_POST['time_spent'])) */

    ?>

</article>

<?php
/** ../css/prescription.css file connected */
$smartCss = home_url('/').'wp-content/themes/veggie-lite-child/css/prescription.css';
wp_enqueue_style('prescription', $smartCss, array(), '1.0');

// CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Apr 25, 2022,  Dynamic desclaimer text 
//
function disclaimer_text($post_id = 95){
    $content = get_post_field('post_content', $post_id);
    $content = isset($content) ? $content : 'N/A';
    return  $content;    
}
// CODE EDIT END
get_footer();
?>

<script>
    function printDiv(prescription_div)
    {
        document.getElementById('removePrint').remove();
        var printContents = document.getElementById(prescription_div).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>