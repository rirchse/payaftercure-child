<?php

/** template Name: SRF Base File
*/

/**
 * SRF section has 2 base file connected 
 * 1. SRF_Base_File.php
 * 2. SRF_Prescription_Base_File.php
 *  
 * smart child.php file has included 
 * 
 * -> srf_functions.php,
 * -> srf_illnesses.php,
 * -> srf_questions_answers.php,
 * -> srf_answer_summery.php,
 * -> srf_disclaimer.php,
 * -> srf.css
 * -> srf.js
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

global $wpdb;

/** all functions for smart remedy finder included in srf_functions.php  */
include 'srf_functions.php';

/** ../css/srf.css file connected */
$srf_css = home_url('/').'wp-content/themes/veggie-lite-child/css/srf.css';
wp_enqueue_style('srf', $srf_css, array(), '2.0');

/** ../js/srf.js file connected */
$homeUrl = home_url('/').'wp-content/themes/veggie-lite-child/js/srf.js';
wp_enqueue_script( 'srf', $homeUrl, array(), '16.06');

/** ajax file connected from google service by 
 * upwork id: rafiquli34 */
wp_enqueue_script('datatables', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', false);

?>

<div class="smartfinderrem" style="text-align:center"><h2>smart remedy finder</h2></div>

<?php
/** checking user/member illness name selection */
  if( sanitize( !isset( $_POST['illness_id']) ) )
  {
    $_POST['illness_id'] = NULL;
  }

  $link_login = '<a href="' . wp_login_url($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) . '" title="' .  __( 'Login' ) .'"  class="menu-item menu-type-link">' . __( 'Login' ) . '</a>';
  $link_register = '<a href="' . wp_registration_url($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) . '" title="' .  __( 'Register' ) .'">' . __( 'Register' ) . '</a>';


  if( is_user_logged_in( ) )
  {
    $link = '<a href="' . wp_logout_url( $redirect ) . '" title="' .  __( 'Logout' ) .'">' . __( 'Logout' ) . '</a>';
    $items.= '<a id="log-in-out-link" class="menu-item menu-type-link">'. $link . '</a>';
  }

  $date_now = date("m/d/Y H:i:s");
  $registration_expiry_date = date("m/d/Y H:i:s", strtotime(get_userdata(get_current_user_id())->user_registered . apply_filters( 'free_trial_duration_days', '' )));

   /** get mysql query data for illnesses1 from srf_functions.php */
  $illnesses1 = illnesses1($wpdb);

  /** get mysql query data for illnesses2 from srf_functions.php */
  $illnesses2 = illnesses2($wpdb);

  echo '<pre><br></pre>';

  echo '
  <!-- progressbar -->
  <ul id="progressbar">';

  if( is_user_logged_in( ) )
  {
    echo '<li style="counter-increment: step" class="active">Login</li>';
  }
  else
  {
    echo '<li style="counter-increment: step">Login</li>';
  }
  echo '
  <li style="counter-increment: step">Answer questions</li>
  <li style="counter-increment: step">Summary of Your Answers</li>
  <li style="counter-increment: step">Disclaimer</li>
  <li style="counter-increment: step">Prescription</li>
  </ul>';


  if( !is_user_logged_in( ) )
  {
    /** get important notice text from smart_functions.php */
    echo importantText($link_register, $link_login);

  }

 /** ------------------------ 
  * srf ilnesses section included in srf_illnesses.php 
  * ------------------------- */

  include 'srf_illnesses.php';


  /** -----------------------
   *  Question Answer Section 
   * ------------------------ */

  /*code Added By Gaurang Date : 18-6-2018 */
  echo '<div id="illness_submit_notice" style="display:none;">Please Wait ...</div>';

  include 'srf_questions_answers.php'
?>

<script>
  // RAZAUL hide all DISEASE SPECIFIC QUESTIONS for all illness except Chronic Personality Analysis 24.10.2018
jQuery(document).ready(function()
{
  var checked_illnessid = jQuery('input:radio[name=illness_id]:checked').val();
  var questions = '1084,1085,1086,1087,1088,1089,1090,1091,1094';
  
  if(checked_illnessid != '18')
  {
      hideQuestions(questions);
  }
});
</script>
<?php
  if(!is_user_logged_in())
  {
  echo '<script>
  jQuery(document).ready(function(){
      jQuery("input[type=radio]").click(function(e){
          e.preventDefault();
          alert("Please Log In, if you are not Registered, please Register first. Refer to above Instructions.");
      });
  });  
  </script>';

  }

  get_footer();



// $smartJs = home_url('/').'wp-content/themes/veggie-lite-child/js/smartjs.js';
// wp_enqueue_script('smartjs', $smartJs, array(), '1.0');
?>

<script>

var family_member = document.getElementById('family_member');
var payaftercure_name1 = document.getElementById('payaftercure_name1');

function setMember(elm)
{
  var member = elm.options[elm.selectedIndex];
  if(member.value == 'new'){
    family_member.style.display = 'block';
    family_member.value = '';
    family_member.focus();
  }else{
    family_member.value = member.value;
    payaftercure_name1.value = member.value;
    family_member.style.display = 'none';
  }
  // console.log(member.value);
}

function keyUp(e)
{
  payaftercure_name1.value = e.value;
}
</script>