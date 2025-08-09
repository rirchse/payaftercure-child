<?php

/**
 * SRF Questions Answers
 * This file has included all of questions and answers field
 *
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

$questionFieldType = 0;

/** if illness selected then show question answer form */

if(sanitize(isset($_POST['illness_id'])))
{
  $category_id_last = $question_id_last = $group_rn = 0;

  $illness_id = ( sanitize($_POST['illness_id']) <= 6 || sanitize($_POST['illness_id']) == 22)?(1):(sanitize($_POST['illness_id']));

  //order by updated(choice_name, choice_order have been removed) jobayer 12-09-2018
  //added choice order 12-12-2019 james fiverr
  
  /** all questions getting using questions method from smart_function.php  */
  $questions = questions($wpdb, $illness_id);

  $count_questions = count($questions);
  echo ' <!-- <a onclick="javascript:uncheckChoicesAll(jQuery(this).attr(\'class\'));"  class="group' . $group_rn . '">Click HERE to uncheck all answers in the entire questionnaire</a> -->';
  /*code Added By Gaurang Date : 18-6-2018 */
  echo '<form id="frm_questions" class="hv-frm_questions" style="padding-top:80px;" action="' . get_permalink(2188) . '?family_member=' . $_GET['family_member'] . '" method="post">
  <h4 style="text-align:left">Following the questions select the answers:</h4>
  <table style="border-top:1px solid;"><tr><td style="width:40%;background:lightblue"><span >Select or Type Patient Name</span></td><td>'.getMembers($wpdb, $user_email).'</td></tr></table><table>'; 

  $cnt_answers = 0;
  $header = (!empty($questions[$count_questions - 1]->illness_header)) ? ($questions[$count_questions - 1]->illness_header) : ($questions[0]->illness_header);
  $footer = (!empty($questions[$count_questions - 1]->illness_footer)) ? ($questions[$count_questions - 1]->illness_footer) : ($questions[0]->illness_footer);
  echo '<tr><td colspan="2">' . $header . '</td></tr>';

  foreach($questions as $question)
  {
    $question_ids[] = $question->question_id;
  }

$cnt_answers_array = array_count_values($question_ids);

$isOption = false;
foreach($questions as $key => $question1)
{
  if($question1->question_field_type == 'select') {
      $isOption = true;
    }
}

$Key1 = $Key2 = $Key3 = $age = $count = 0;
$optionCheck = '';

/** all questions quering from database */
foreach($questions as $key => $question)
{
  $cnt_answers_total = $cnt_answers_array[$question->question_id];
  $checkbox_text = ($question->question_field_type  == 'checkbox') ? ('[]') : ('');
  $hidden_text = ($question->question_shown  == 0) ? (' style="display:none" class="tr' . $question->question_id . '"') : (' class="tr' . $question->question_id . '"');

  /*code Added By Razaul to hide CID 171 when IID 11, 120, 33, 85, 100, 110 is selected Date : Oct 03 2018 */

  if($question->question_id == 1122 || $question->question_id == 1123)
  {
    if($illness_id == 11 || $illness_id == 120 || $illness_id == 33 || $illness_id == 85 || $illness_id == 100 || $illness_id == 110)
    {
      $hidden_text .= ' style="display:none"';
    }
  }

  /*code Added By Razaul to Hide CID 152 when IID 110,65,71,141,60 is selected Date : Oct 03 2018 */

  if($question->question_id == 1031 || $question->question_id == 1032)
  {
    if($illness_id == 110 || $illness_id == 65 || $illness_id == 71 || $illness_id == 141 || $illness_id == 60 )
    {
      $hidden_text .= ' style="display:none"';
    }
  }

  // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Apr 25, 2022, hide question with id 1119
  if($question->question_id == 1119 )
  {
    $hidden_text .= ' style="display:none"';
  }

  // CODE EDIT END

  $javascript_disable_code = ($question->disable_question_id_list) ? ('disableQuestions(\'' . $question->disable_question_id_list . '\');') : ('');
  $javascript_enable_code = ($question->enable_question_id_list) ? ('enableQuestions(\'' . $question->enable_question_id_list . '\');') : ('');
  $javascript_hide_code = ($question->hide_question_id_list) ? ('hideQuestions(\'' . $question->hide_question_id_list . '\');') : ('');
  $javascript_show_code = ($question->show_question_id_list) ? ('showQuestions(\'' . $question->show_question_id_list . '\');') : ('');
  $javascript_code = 'onclick="' . $javascript_disable_code . $javascript_enable_code . $javascript_hide_code . $javascript_show_code . '"';

  if ($category_id_last != $question->category_id)
  {
    $cnt_answers = 0;
    $group_rn += 1;

    if($question->category_name != 'GENERAL')
    {
      echo '<tr><td style="border-top: 1px solid gray;border-bottom: 1px solid gray;background-color: lightblue; vertical-align: top;">' . strtoupper($question->category_name) . '</td><td style="border-top: 1px solid gray;border-bottom: 1px solid gray;cursor: pointer;">';
    }

    if( is_user_logged_in( ) )
    {
      echo '<a onclick="javascript:uncheckChoicesSection(jQuery(this).attr(\'class\'));"  class="group' . $group_rn . '">Click HERE to uncheck all answers in this section</a>';        
    }
  }



  $cnt_answers += 1;
  if ($question_id_last != $question->question_id)
  {
    /*code Added By Gaurang Date : 18-6-2018 */
    echo '</div></td></tr><tr ' . $hidden_text . '><td class="hv-FixWidth" style="border-top: 1px solid gray;border-bottom: 1px solid gray; vertical-align: top;" data-question-id='.$question->question_id.'><span class="question' . $question->question_field_type . $question->question_id . $checkbox_text . '" style="float: left;">' .($question->question_name != 'What is your name'? $question->question_name:'') . '</span></td><td class="hv-FixWidth-content" style="border-top: 1px solid gray;border-bottom: 1px solid gray;">';
    $cnt_answers = 0;
  }

  if( is_user_logged_in( ) )
  {
    $disabled = '';
  } else {
    $disabled = ' disabled';
  }

  /*code Added By Gaurang Date : 18-6-2018 */
  if ($cnt_answers == 0 && $cnt_answers_total <= 10)
  {
    echo '<div style="float:left; width: 100%;" class="checkbox_all_wrap">';
  } elseif ($cnt_answers == 0 && $cnt_answers_total <= 20)
  {
    echo '<div class="Hv-HalfWidth" style="float:left; width: 50%;">';
  } elseif ($cnt_answers == 0)
  {
    echo '<div class="Hv-HalfWidth" style="float:left; width: 33.33333%;">';
  }

  //added by jobayer 11-09-2018
  // && $question->question_id  == $question->question_id
  if($question->question_field_type == 'dropdown') 
  {    
    if($optionCheck == '')
    {
      $optionCheck = $question->question_id; 
    }
    elseif($optionCheck != $question->question_id)
    {
    $optionCheck = $question->question_id; 
    $count = 0;  
    }

    if($count == 0)
    {
      echo '<select id="choice1' . $question->question_id .'" class="timerOn choicesgroup' . $group_rn . '"type="' . $question1->question_field_type . '"   name="question' . $question1->question_field_type. $question->question_id . '" onclick> ';
      echo ' <option value=-1>Select</option>';          
    }
      
    echo '<option value='. $question->choice_id .'>'. $question->choice_name .'</option>';
      $count++;
      
    if($count == 0)
    {
      echo '</select>';
    }
    
  } //code added by jobayer  //code changed by Mohd and added text type
  elseif($question->question_field_type == 'textbox')
  {
    /*code changed By Gaurang Date : 18-6-2018 */
    echo '<div class="hv-wrap"><textarea placeholder="Describe yourself here..." name="question' . $question->question_field_type. $question->question_id . $checkbox_text .'" id="payaftercure_name1" class="choicesgroup' . $group_rn . '" style="float: left; margin-top: 7px; margin-bottom: 7px;" rows="3" cols="40"></textarea><label for="question' . $question->question_field_type. $question->choice_id . $checkbox_text . '" class="question' . $question->question_field_type . $question->question_id . $checkbox_text . '"  style="float: left;">' . $question->choice_name . '</label></div> <br>';

  }
  elseif($question->question_field_type == 'text')
  {
    // echo '<div class="hv-wrap"><input hidden id="payaftercure_name1" class="choicesgroup' . $group_rn . '" style="float: left; margin-top: 7px; margin-bottom: 7px;" type="text" name="question' . $question->question_field_type. $question->question_id . $checkbox_text .'" value="" placeholder="Type member name" /><label for="question' . $question->question_field_type. $question->choice_id . $checkbox_text . '" class="question' . $question->question_field_type . $question->question_id . $checkbox_text . '"  style="float: left;">' . $question->choice_name . '</label></div> <br>';
  }
  else 
  {
    /*code changed By Gaurang Date : 18-6-2018 */
    echo '<div class="checkbox_row_single"><input id="choice' . $question->choice_id . '" class="choicesgroup' . $group_rn . '" style="float: left; margin-top: 7px;" type="' . $question->question_field_type . '"  ' . $disabled . ' name="question' . $question->question_field_type. $question->question_id . $checkbox_text . '" value="' . $question->choice_id . '" ' . $javascript_code .  '/><label for="question' . $question->question_field_type. $question->choice_id . $checkbox_text . '" class="question' . $question->question_field_type . $question->question_id . $checkbox_text . '"  style="float: left;">' . $question->choice_name . '</label></div>';
  }


  if ($cnt_answers == 9 || $cnt_answers == 19)
  {
    if ($cnt_answers_total <= 10)
    {
        echo '';
    } else if ($cnt_answers_total <= 20){
      /*code Changed By Gaurang Date : 18-6-2018 */
        echo '</div><div class="Hv-HalfWidth" style="float:left; width: 50%;">';
    } else {
      /*code Added By Gaurang Date : 18-6-2018 */
        echo '</div><div class="Hv-HalfWidth" style="float:left; width: 33.33333%;">';
    } 
  }


  $category_id_last = $question->category_id;
  $question_id_last = $question->question_id;
}

echo '</td></tr>';
echo '<tr><td colspan="2">' . $footer . '</td></tr>';
echo '</table>';

if( is_user_logged_in( ) )
{
  if ($count_questions > 0) 
  {
   echo '<a style="cursor: pointer;"  onclick="javascript:uncheckChoicesAll(jQuery(this).attr(\'class\'));"  class="group' . $group_rn . '">Click HERE to uncheck all answers in the entire questionnaire</a><br><br>
    Time spent answering questions: <input type="text" name="time_spent" value="" readonly>
    <input type="hidden" name="illness_id" value="' . $illness_id . '">
    <input type="hidden" name="site_url" value="' . $home_url . '">
    <input type="hidden" id="group_count" value="' . get_home_url() . '">
    <input id="btn_question_submit"  class="button button-primary button-large btn btn-success" type="button" value="Next" style="max-width:33%;"><div id="page_submit_notice" style="float:left;display:none;">Please Wait ...</div>';
  }
  else
  {
    echo indicationText();
  }
}
echo '</form>';
}

?>