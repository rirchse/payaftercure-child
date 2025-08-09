<?php

/** 
 * SRF Functions
 * All functions are connected to this file.
 * All database query controlled by this file.
 
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


/** return all questions from database to srf_base_file.php */
function questions($wpdb, $id) 
{
  // global $wpdb;
  $questions = $wpdb->get_results(
    "select * from (
    SELECT '1' data_group, qc.* FROM srf_illness ill JOIN questions_choices qc ON ill.illness_personality_illness_id = qc.illness_id WHERE ill.illness_id = " . $id . " and qc.`category_enabled` = 1 and qc.`question_enabled` = 1 and qc.`choice_enabled` = 1 and ill.illness_id not in (18,19)
    UNION ALL
    SELECT '2' data_group, qc.* FROM srf_illness ill JOIN questions_choices qc ON ill.parent_illness_id = qc.illness_id WHERE ill.illness_id = " . $id . " and qc.`category_enabled` = 1 and qc.`question_enabled` = 1 and qc.`choice_enabled` = 1 and ill.illness_show_parent_questions = 1
    UNION ALL
    SELECT '3' data_group, qc.* FROM srf_illness ill JOIN questions_choices qc ON ill.illness_id = qc.illness_id WHERE ill.illness_id = " . $id . " and `category_enabled` = 1 and `question_enabled` = 1 and `choice_enabled` = 1 and ill.illness_show_parent_questions = 0
    ) aaa
    order by data_group, illness_order, category_order, question_order, choice_order, choice_name                           
    ");
    return $questions;
}


/*------------------ get family members name ------------------*/
function getMembers($wpdb, $user_email)
{
  $family_members = $family_member_field = '';

  $family_members = '<option value="new">--- Type New Memeber Name ---</option>';
  $dbFamily_members = $wpdb->get_results("SELECT DISTINCT family_member_name FROM srf_case_update WHERE client_email = '".wp_get_current_user()->user_email."' ORDER BY family_member_name");

 foreach( $dbFamily_members as $member)
 {
  if(!empty($member->family_member_name))
   $family_members .= '<option value="'.$member->family_member_name.'">'.$member->family_member_name.'</option>';
 }

 $family_member_field = '<select name="select_member" id="select_member" onchange="setMember(this)" style="margin-bottom:0" >
  <option value=""> --- Select Member Name --- </option>'.$family_members.'</select><input onkeyup="keyUp(this)" type="text" name="family_member" value="" id="family_member" style="display:none; margin-bottom:0;margin-top:15px;padding-left:10px">
  <input type="hidden" name="" id="payaftercure_name1">';

  return $family_member_field;
}


/** return indication text to srf_base_file.php when it is needed */
function indicationText()
{
  return '<u>You can use homeopathy for Cosmetic purposes also:</u>
      - Complexion: Improve your complexion within 4-6 weeks.<br>
      - Ageing: Slow down ageing & it\'s effects. <br>
      - Stretch marks: Prevent pregnancy or growth spurt related stretch marks. <br>
      - If you want to try Cosmetic homeopathy, please <a href="mailto:support@payaftercure.com?subject=Mail for Cosmetic Homeopathy"><b>Contact Us</b></a>  <br>
      - All our consultation comes with PayAfterCure promise i.e. you follow our suggestions for a month, if you feel improvement you can pay us, otherwise you go free. No upfront payments. <br>
      <br><u>Limitations of Cosmetic Homeopathy</u>:<br>
      - Complexion change will not be dramatic, it will only improve by around 20-30% as we are not doing genetic engineering to turn black into white<br>
      - Anti-ageing will also not be dramatic, it will show signs of improvement in skin tone etc. by around 20% as we are trying to slow aging not reverse it<br>
      - We will need a picture of your face before & after the treatment under exact same conditions i.e.:<br>
      - Same time of the day<br>
      - Exact same location<br>
      - Exact same lighting conditions<br>
      - During the daytime<br>
      - Anything you share with us is covered by Patient Confidentiality Regulations and will never be shared with anyone.<br>
      - Formation of Stretch Marks can be eliminated or reduced if treatment is taken 2-3 months BEFORE the adolescent growth spurt or before end of 1st trimester in case of pregnancy.<br>
      ';
}


/** return important text as notice to srf_base_file.php */
function importantText($link_register, $link_login)
{
  return '<p class="instructions" style="clear:both;"><b>IMPORTANT INSTRUCTIONS - READ FIRST:</b><br/> 1.  To use the SRF (Smart Remedy Finder) please <b>' . $link_register . '</b> for free, if you are already registered then <b>' . $link_login . '</b><br>
  2.  Please try to answer all applicable questions. <font color="red">Don’t rush through it, think about your symptoms & then answer.</font> <br>
  3.  If you are unsure about an answer, leave it without replying. <br>     
  </p>';
}


/** return illnesses1 data from database to srf_base_file.php */
function illnesses1($wpdb)
{
  return $wpdb->get_results("SELECT * FROM srf_illness WHERE illness_enabled = 1 AND illness_show_in_table = 1 ORDER BY `illness_order`");
}


/** return illnesses2 data from database to srf_base_file.php */
function illnesses2($wpdb)
{
  return $wpdb->get_results("SELECT * FROM srf_illness WHERE illness_enabled = 1 AND illness_show_in_table = 2 ORDER BY `illness_order`");
}




/** 
 * ---------------- SRF Prescription Functions
 */



/** return questions choices data from databse to prescrition child.php */
function prescriptionQuestions($wpdb, $choice_ids, $textqstsql)
{
  return $wpdb->get_results("SELECT * FROM questions_choices WHERE `category_enabled` = 1 and `question_enabled` = 1 and `choice_enabled` = 1 and choice_id in ($choice_ids) ".$textqstsql);
}




/** return remedies data from database to prescription child.php */
function Remedies($wpdb, $choice_ids)
{
  return $wpdb->get_results(
    "SELECT qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id, SUM(sr.rem_grade) AS rem_score 
  FROM questions_choices qc INNER JOIN symptoms_remedies sr ON (qc.`sym_id_1` = sr.sym_id OR qc.`sym_id_2` = sr.sym_id 
  OR qc.`sym_id_3` = sr.sym_id)
  WHERE qc.choice_id IN ($choice_ids) 
  GROUP BY qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id
  ORDER BY SUM(sr.rem_grade) DESC, sr.rem_name ASC
  LIMIT 0, 7");
}


/** return remedies grade data from database to prescription child.php */
function RemediesGrade($wpdb, $choice_ids)
{
  return $wpdb->get_results(
    "SELECT qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id, SUM(sr.rem_grade) AS rem_score 
  FROM questions_choices qc INNER JOIN symptoms_remedies sr ON qc.`sym_id_1` = sr.sym_id
  WHERE sr.rem_grade = 9 and qc.choice_id IN ($choice_ids) 
  GROUP BY qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id
  ORDER BY SUM(sr.rem_grade) DESC, sr.rem_name ASC");
}



/** return selected remedies grade data  from database to prescription child.php */
function SelectedRemediesGrade($wpdb, $remedy_3, $choice_ids)
{
  return $wpdb->get_results(
    "SELECT qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id, SUM(sr.rem_grade) AS rem_score 
  FROM questions_choices qc INNER JOIN symptoms_remedies sr ON qc.`sym_id_1` = sr.sym_id
  WHERE sr.rem_id = $remedy_3->rem_id and qc.choice_id IN ($choice_ids) 
  GROUP BY qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id
  ORDER BY SUM(sr.rem_grade) DESC, sr.rem_name ASC");
}


/** return selected remedies grade 33 data from database to prescription child.php */
function SelectedRemediesGrade_33($wpdb, $remedy_33, $choice_ids)
{
  return $wpdb->get_results(
    "SELECT qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id, SUM(sr.rem_grade) AS rem_score 
  FROM questions_choices qc INNER JOIN symptoms_remedies sr ON qc.`sym_id_1` = sr.sym_id
  WHERE sr.rem_id = $remedy_33->rem_id and qc.choice_id IN ($choice_ids) 
  GROUP BY qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id
  ORDER BY SUM(sr.rem_grade) DESC, sr.rem_name ASC"

  );
}


/** get remedies grade 3 data from database to prescription child.php */
function RemediesGrade_3($wpdb, $choice_ids)
{
  return $wpdb->get_results(
    "SELECT qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id, SUM(sr.rem_grade) AS rem_score 
  FROM questions_choices qc INNER JOIN symptoms_remedies sr ON qc.`sym_id_1` = sr.sym_id
  WHERE qc.choice_id IN ($choice_ids) and sr.rem_grade > 0
  GROUP BY qc.illness_name, sr.rem_name, sr.rem_abbr, sr.rem_id
  ORDER BY SUM(sr.rem_grade) DESC, sr.rem_name ASC"
  );
}


/** get illness name from database to prescription child.php */
function IllnessName($wpdb, $id)
{
  return $wpdb->get_row (
    "SELECT illness_name FROM srf_illness WHERE illness_id = '" . $id . "'LIMIT 0, 1"
  );
}

/** remedies grades 2 data query from database to prescription child.php */
function RemediesGrades_2($wpdb, $choice_ids, $nremedy)
{
  return $wpdb->get_results(
    "SELECT SUM(sr.rem_grade) AS rem_score FROM questions_choices qc INNER JOIN symptoms_remedies sr ON (qc.`sym_id_1` = sr.sym_id ) WHERE qc.choice_id IN ($choice_ids) and sr.rem_id = ".$nremedy['rem_id']."    group by sr.rem_grade ORDER BY SUM(sr.rem_grade) DESC"
  );
}

/** get sum health score data from database to prescription child.php */
function SumHealthScore($wpdb, $choice_ids, $textqstsql)
{
  return 
  $wpdb->get_results("SELECT sum(score) as healthscore FROM questions_choices WHERE  score > 0 and `category_enabled` = 1 and `question_enabled` = 1 and `choice_enabled` = 1 and choice_id in ($choice_ids) ".$textqstsql);
}


/** send prescription text 1 to prescription child.php */
function PrescriptionText_1()
{
  return '<div id="prescription_div" style="display:none;clear:both;">
  <div style="color:blue;text-align:center">
  <img src="http://www.payaftercure.com/wp-content/uploads/2015/04/logo1.png" alt="logo">
  <h1 style="margin-bottom:0">Pay After Cure</h1>
  <p>Online Homeopathic Consultation</p></div><div id="prescription_only"><br>
  <h3 style="display: inline-table;margin-bottom: 0;margin-top: 10px; text-transform: uppercase; display: none; text-align:left; padding: 0px" id="preliminary_prescription_heading"><b>Here is your Preliminary Prescription:</b></h4>
  <h4 style="display: inline-table;margin-bottom: 10px;margin-top: 10px; padding: 0px"><b>YOUR POSSIBLE REMEDIES:</b></h4><table>
  <tr><th style="width:20px;">#</th><th style="width:150px;">Remedy Name</th><th style="width:40px;">Remedy Abbr.</th><th style="width:95px;">Score</th></tr>';
}

/** send prescription text 2 data to prescription child.php */
function PrescriptionText_2($dosage_instructions, $time)
{
  $prescription_tex = '</div><p class="prescription_text">
  IF YOU ARE DOING SELF HELP:<br>
  - Choose the remedy which seems to fit your symptoms the best.<br>
  - If you are unsure and want to avoid trial & error, please contact us.<br>
  - Never take more than one remedy at a time, mixing remedies will be counterproductive & may make symptoms worse.<br></p>';

  $prescription_tex .= '<div class="dosage_instructions"><br>'. $dosage_instructions . '
  <b><br>FREQUENTLY ASKED QUESTIONS<br></b>
  <p><i>WHAT IS A DOSE:<br>
  PILLS:<br>
  If the remedy is in the form of pills &num;40 e.g. Boiron: <br>
  - One dose is 1 pill. Dissolve the pill in your mouth. That\'s one dose. <br>
  If the remedy is in the form of smaller pills &num;25: <br>
  - One dose is 3 or 4 pills. Dissolve the pills in your mouth. That\'s one dose. <br>
  If the remedy is in the form of tiny pills &num;5 like sugar grains: <br>
  - One dose is 10 or 12 pills. Dissolve the pills in your mouth. That\'s one dose. <br>
  LIQUID: <br>
  - Put one drop of the remedy in half glass of water, stir and take one tea spoon from it. That\'s one
  dose. <br>
  IGNORE the directions given on the remedy bottles and follow the directions given above. <br>
  <br>FOR CHILDREN: <br>
  If the child can\'t safely suck on the pill/pellets then one dose is made by dissolving pill(s) of the
  remedy (or one drop, if you have liquid remedy) in half a glass of cooled, boiled water. Stir it and
  take one tea spoon from it. <br>
  <br>FOR ANIMALS: <br>
  One dose is made by dissolving pill(s) of the remedy (or one drop, if you have liquid remedy) in half
  a glass of water. Stir it and take one tea spoon from it. <br>
  <br>TIME OF DOSE: <br>
  - As soon as possible, giving a break of 10 minutes before or after eating anything so that there is no taste of food in your mouth. <br>
  - These remedies are safe and can be taken on empty stomach also. <br>
  <br>PRECAUTIONS: <br>
  - Don\'t take any more doses after the first dose till we tell you. <br>
  - Don\'t take any other homeopathic remedy during this treatment. <br>
  - During the treatment, don\'t eat anything which you have never had all your life. <br>
  - Repeating the dose when there is no need will worsen the symptoms, if this happens, stop the
  dosing and the worsening will subside within 24-48 hrs. <br>
  - In case of any confusion contact us or your local homeopath. <br>
  <br><b>IMPORTANT NOTE:</b><br>
  - No amount of treatment will give permanent cure you unless you adopt a healthy lifestyle. <br>
  - You can read our Blog on this link to learn <a href="https://www.payaftercure.com/healthy-living-guidelines/" rel="noopener" target="_blank"><u>How to Eat Right & Excercise to Stay Healthy</u></a><br>
  <br>HOW TO BUY REMEDIES: <br>
  - You can buy remedies from anywhere you like. Use internet search to find the best deals. <br>
  - We recommend that you read our Blog at this link <a href="https://www.payaftercure.com/recommended-homeopathic-remedies-to-stock/" rel="noopener" target="_blank"><u>Recommended Homeopathic Remedies to Keep</u></a> so that you have these
  available with you all the time. With these remedies, up to 90% of all your day to day ailments & emergencies can be handled. <br>
  - If your local health shop sells one single dose, you can take that also
  <br><br>SUPPORT:<br>
  In case of any questions, please email at support@payaftercure.com
  <br>
  <br>
  Time taken to complete the questionnaire: ' . $time . '<br><br><a style="color:red" onclick="printDiv(\'prescription_div\')" id="removePrint">Print/Save Prescription</a></div>
  </div>';
  return $prescription_tex;
}

/** send prescription text 3 to prescription child.php */
function PrescriptionText_3($bcolor, $get_health_score, $maximum_score, $recommendation_details)
{
  return ' <b>Your Health Score: <span style="background-color: #'.$bcolor.';">

  '.round(($get_health_score / $maximum_score) * 100, 2).' %</span></b><br>	(This % is a our proprietary calculated value based on your answers.)</b><br>
  <br>
  Excellent Health:<span style="background-color: #a9d08e;">	   Over 90%</span><br>
  Very Good Health:<span style="background-color: #c6e0b4;">	80-90%</span><br>
  Good Health:<span style="background-color: #e2efda;">        70-80%</span><br>
  Fair Health:<span style="background-color: #d9d9d9;">	        60-70%</span><br>
  Poor Health:<span style="background-color: #fff2cc;">	        50-60%</span><br>
  Very Poor Health:<span style="background-color: #ffd966;">    	40-50%</span><br>

  Significant Health Issues require immediate attention:<span style="background-color: #ffc000;">  	Below 40%</span> <br>
  <br>
  RECOMMENDATIONS:<br>
  Based on Your Health Rating, you should think about:<br>
  <ul>'.$recommendation_details.'</ul>';
}

?>