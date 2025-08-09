<?php

/**
 * SRF Answer Summary
 * This file show all of member answer summary
 * when submit questions answer form
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
    /** questions query resuts from srf_functions.php */
    $questions = prescriptionQuestions($wpdb, $choice_ids, $textqstsql);

    $category_id_last = 0;
    $question_id_last = 0;
    $remedy_potency = 0;
    $remedy_name = '';

    echo '<input type="hidden" name="client_id" value="' . $current_user->ID . '">';

    $answers_text = '<div id="answers_div" style="clear:both;text-align: left;"><div id="answers_only"><br>
    <h4 style="display: inline-table;margin-bottom: 0;margin-top: 40px;"><b>SUMMARY OF YOUR ANSWERS:</b></h4><br><table id="prescription_tbl1">';

    foreach($questions as $key => $question)
    {
        if($question->question_field_type != 'textbox'){
            $wpdb->insert(
                'srf_prescription_choices', array(
                'email' => $current_user->user_email,
                'choice_id' => $question->choice_id
                )
            );
            if($question->recommemdation != ''){
            $recommendation_details .='<li>'.$question->recommemdation.'</li>';
            }
        }
        $checkbox_text = ($question->question_field_type  == 'checkbox') ? ('[]') : ('');

        if ($category_id_last != $question->category_id) {
            $answers_text .= '<tr id="category_name1"><td style="background-color: lightblue;" >' . $question->category_name . '</td><td></td></tr>';
        }

        //row for showing name field(coded by Jobayer)
        if($key == 0) {
            $answers_text .= '<tr><td> Name</td><td><span id="first_row1">&nbsp;</span></td></tr>';
        }

        if ($question_id_last != $question->question_id) {
            $answers_text .= '<tr><td style="width:250px;">' . $question->question_name . '</td><td style="width:250px;">';
        }
        
        /* razaul changed code here for save textbox questions 10-10-2018 */
        if($question->question_field_type == 'textbox'){
            if(isset($_POST['questiontextbox'.$question->question_id] )){
                $answers_text .= $_POST['questiontextbox'.$question->question_id] . ' <br>';
            }
        }elseif($question->question_field_type == 'comment'){
            if(isset($_POST['questioncomment'.$question->question_id] )){
                $answers_text .= $_POST['questioncomment'.$question->question_id] . ' <br>';
            }
        }else{
            $answers_text .= $question->choice_name . ' <br>';
        }
        $category_id_last = $question->category_id;
        $question_id_last = $question->question_id;
        if ($question->potency > 0) {
            $remedy_potency = $question->potency;
        }
        $dosage_instructions = $question->illness_dosage_instructions;
    }


    $answers_text .= '</td></tr></table>
    <label for="answers_check">The above answers are correct:</label><br />
    <input id="answers_check" type="radio" name="answers_check" value="Yes" />Yes &nbsp;
    <input id="answers_check" type="radio" name="answers_check" value="No" />No
    <br /></div>';
    echo $answers_text;
    echo '<input type="submit" name="btn_summary_next" class="button button-primary button-large button-next" style="display:none; max-width:50%;" id="btn_summary_next" value="Next" />
    <div id="answers_not_correct" style="display:none;clear:both;"><br>
    <h4><b>Please click <a href="' . get_permalink(6130) . '" style="color: #0000EE;">here</a> to return to the Smart Remedy Finder and start again to get a new prescription.</b></h4><br>
    </div></div>';


    $html .= $answers_text . '</div>';
?>