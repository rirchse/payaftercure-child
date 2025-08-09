<?php
/**
 * SRF Prescription
 * This file using for show prescription on the page
 * And prescription logic
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

    
        /** get remedies query data from prescription_functions.php */
        $remedies = Remedies($wpdb, $choice_ids);


        /* This logic of remedy slection is from row 204 till 356 */

        $show_remedies = 7;
        $new_remedies = array();
        $duplicate_chk_remedies_ids = array();
        // Most repeated remedy with Grade-9, sorted alphabetically. If there is no repeated remedy, move to the logic in the next row. 

        /** remedies grade data query from prescription_function.php */
        $remedies_grade_333 = RemediesGrade($wpdb, $choice_ids);
        
        $i = 1;
        foreach($remedies_grade_333 as $remedy_3)
        {
            // echo $i;
            if($i > $show_remedies) {  break; }
            
            if($remedy_3->rem_score > 9 && $i <= $show_remedies)
            {
                /** get selected remedies grade data from prescription functions.php  */
                $selected_remedies_grade_333 = SelectedRemediesGrade($wpdb, $remedy_3, $choice_ids);

                $selected_rem_score = '';
                foreach($selected_remedies_grade_333 as $selected_remedies_grade_3)
                {
                    $selected_rem_score = $selected_remedies_grade_3->rem_score;
                }

                $new_remedies[]= array('rem_id'=>$remedy_3->rem_id, 'rem_name'=>$remedy_3->rem_name, 'rem_abbr'=>$remedy_3->rem_abbr, 'rem_score'=>$selected_rem_score, 'illness_name'=>$remedy_3->illness_name );

                $duplicate_chk_remedies_ids[]=$remedy_3->rem_id;
                $i++;
            }
            
            
        }
        
        // Remedy with Grade-9, sorted aphabetically . If there is no remedy of Grade-9, move to the logic in the next row

        if($i <= $show_remedies)
        {    
            foreach($remedies_grade_333 as $remedy_33)
            {
                if($i > $show_remedies) break;
                
                if($remedy_3->rem_score < 10 && $i <= $show_remedies && !in_array($remedy_33->rem_id, $duplicate_chk_remedies_ids))
                {
                    /** get remedies grade 33 data from prescription function.php */
                    $selected_remedies_grade_33 = SelectedRemediesGrade_33($wpdb, $remedy_33, $choice_ids);
                    $selected_rem_score = '';

                    foreach($selected_remedies_grade_33 as $selected_remedie_grade_33)
                    {
                        $selected_rem_score = $selected_remedie_grade_33->rem_score;
                    }
            
                    $new_remedies[]= array('rem_id'=>$remedy_33->rem_id, 'rem_name'=>$remedy_33->rem_name, 'rem_abbr'=>$remedy_33->rem_abbr, 'rem_score'=>$selected_rem_score, 'illness_name'=>$remedy_33->illness_name );
                    
                    $duplicate_chk_remedies_ids[]=$remedy_33->rem_id;
                    $i++;
                }
            }
        }

        /** get data from prescription functions.php */
        $remedies_grade_3 = RemediesGrade_3($wpdb, $choice_ids);
            
        if($i <= $show_remedies)
        {
            foreach($remedies_grade_3 as $remedy_32)
            {
                if($i > $show_remedies) break;
                
                if($remedy_32->rem_score > 4 && $i <= $show_remedies && !in_array($remedy_32->rem_id, $duplicate_chk_remedies_ids))
                {
                    $new_remedies[]= array('rem_id'=>$remedy_32->rem_id, 'rem_name'=>$remedy_32->rem_name, 'rem_abbr'=>$remedy_32->rem_abbr, 'rem_score'=>$remedy_32->rem_score, 'illness_name'=>$remedy_32->illness_name );

                    $duplicate_chk_remedies_ids[]=$remedy_32->rem_id;
                    $i++;
                }
            }
        }

        // Most repeated remedy with Grade-3,2 & 1, sorted aphabetically. If there is no repeated remedy, move to the logic in the next row

        if($i <= $show_remedies)
        {
            foreach($remedies_grade_3 as $remedy_31)
            {
                if($i > $show_remedies) break;
                
                if($remedy_31->rem_score > 3 && $i <= $show_remedies && !in_array($remedy_31->rem_id, $duplicate_chk_remedies_ids))
                {
                    $new_remedies[]= array('rem_id'=>$remedy_31->rem_id, 'rem_name'=>$remedy_31->rem_name, 'rem_abbr'=>$remedy_31->rem_abbr, 'rem_score'=>$remedy_31->rem_score, 'illness_name'=>$remedy_31->illness_name );

                    $duplicate_chk_remedies_ids[]=$remedy_31->rem_id;
                    $i++;
                }
            }
        }

        // Most repeated remedy with Grade-2 and Grade-2&1, sorted aphabetically. If there is no repeated remedy, move to the logic in the next row

        if($i <= $show_remedies)
        {
            foreach($remedies_grade_3 as $remedy_2)
            {
                if($i > $show_remedies) break;
                
                if($remedy_2->rem_score > 2 && $i <= $show_remedies && !in_array($remedy_2->rem_id, $duplicate_chk_remedies_ids))
                {
                    $new_remedies[]= array('rem_id'=>$remedy_2->rem_id, 'rem_name'=>$remedy_2->rem_name, 'rem_abbr'=>$remedy_2->rem_abbr, 'rem_score'=>$remedy_2->rem_score, 'illness_name'=>$remedy_2->illness_name );
                    
                    $duplicate_chk_remedies_ids[]=$remedy_2->rem_id;
                    $i++;
                }
            }
        }
        // Most repeated remedy with Grade-1, sorted aphabetically. 


        if($i <= $show_remedies)
        {
            foreach($remedies_grade_3 as $remedy_1)
            {
                if($i > $show_remedies) break;
                
                if($remedy_1->rem_score >= 1 && $i <= $show_remedies && !in_array($remedy_1->rem_id, $duplicate_chk_remedies_ids))
                {
                    $new_remedies[]= array('rem_id'=>$remedy_1->rem_id, 'rem_name'=>$remedy_1->rem_name, 'rem_abbr'=>$remedy_1->rem_abbr, 'rem_score'=>$remedy_1->rem_score, 'illness_name'=>$remedy_1->illness_name );

                    $duplicate_chk_remedies_ids[]=$remedy_1->rem_id;
                    $i++;
                }
            }
        }

        /** get illness name from prescription functions.php */
        $illness_name = IllnessName($wpdb, sanitize($_POST['illness_id']));

        $prescription_text .= PrescriptionText_1();

        $rn = 1;
        foreach($new_remedies as $nremedy)
        {
            /** get remedies grade 2 data from prescription functions.php */
            $remediesgrades = RemediesGrades_2($wpdb, $choice_ids, $nremedy);
        
            $prescription_text .= '<tr><td style="width:30px;">' . $rn . '</td><td style="width:170px;">' . $nremedy['rem_name'] . '</td><td style="width:50px;">' 
            . $nremedy['rem_abbr'] . '</td><td style="width:50px;">' . $nremedy['rem_score'].' (';
            $grade_text ='';

            foreach($remediesgrades as $remediesgrade)
            {
                $grade_text .= $remediesgrade->rem_score .', ';
            }
            
            $grade_text = substr($grade_text, 0, -2);
            $prescription_text .=  $grade_text.')</td></tr>';
            if ($rn == 1) 
            {
                $remedy_name = $nremedy['rem_name'];

                $wpdb->insert(
                    'srf_prescription_remedies', array(
                    'email' => $current_user->user_email,
                    'remedy_id' => $nremedy['rem_id'],
                    'remedy_name' => $nremedy['rem_name']
                    )
                );

            }

            $rn += 1;
        }

        $prescription_text .= '</td></tr></table>';

        $dosage_instructions = str_replace('{{REMEDY_NAME}}', $remedy_name, $dosage_instructions);
        $dosage_instructions = str_replace('{{REMEDY_POTENCY}}', $remedy_potency, $dosage_instructions);

        /***** Health score calculator *******/
        $get_health_score = 0;
        $display_health_score = 0;
        $maximum_score = 88;

        if(in_array(17661,$in_clause))
        {
            /** get query data from prescription function.php */
            $sum_health_score = SumHealthScore($wpdb, $choice_ids, $textqstsql);

            foreach($sum_health_score as $sing_health_score)
            {
                $get_health_score = floatval($sing_health_score->healthscore);
            }

            if($get_health_score > 0)
            {
                // echo $get_health_score .'BBB'. $maximum_score;
                $display_health_score = $get_health_score / $maximum_score;
            } 
        }
        // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Apr 25, 2022, Make blocks for all important sections so that we know which div belongs to which section
        // 
        $prescription_text .= PrescriptionText_2($dosage_instructions, sanitize($_POST['time_spent']));
        
        
        if($get_health_score > 0)
        {        
            if(round(($get_health_score / $maximum_score) * 100, 2) >= 90){
                $bcolor= 'a9d08e';
            }else if(round(($get_health_score / $maximum_score) * 100, 2) >= 80 && round(($get_health_score / $maximum_score) * 100, 2) < 90){
                $bcolor= 'c6e0b4';
            }else if(round(($get_health_score / $maximum_score) * 100, 2) >= 70 && round(($get_health_score / $maximum_score) * 100, 2) < 80){
                $bcolor= 'e2efda';
            }else if(round(($get_health_score / $maximum_score) * 100, 2) >= 60 && round(($get_health_score / $maximum_score) * 100, 2) < 70){
                $bcolor= 'd9d9d9';
            }else if(round(($get_health_score / $maximum_score) * 100, 2) >= 50 && round(($get_health_score / $maximum_score) * 100, 2) < 60){
                $bcolor= 'fff2cc';
            }else if(round(($get_health_score / $maximum_score) * 100, 2) >= 40 && round(($get_health_score / $maximum_score) * 100, 2) < 50){
                $bcolor= 'ffd966';
            }else{
                $bcolor= 'ffc000';
            }
            
            /** get prescription data from prescription function.php */
            $prescription_text .= PrescriptionText_3($bcolor, $get_health_score, $maximum_score, $recommendation_details);
        }

        $html .= $prescription_text;
        echo $prescription_text;
        $member_name = (!empty(sanitize($_GET['family_member'])))?(sanitize($_GET['family_member'])):(sanitize($_POST["display_name"]));

        $prescription_text2 = '
        <br>
        <br>';

        $html .= $prescription_text2;
        
        echo '
        <input type="hidden" name="email" value="' . $current_user->user_email . '">
        <input type="hidden" name="family_member" value="' . $_POST['family_member'] .$member_name. '">
        <input type="hidden" name="illness_name" value="' . $illness_name->illness_name . '"> 
        <input type="hidden" name="html_text" value="' . htmlspecialchars($html) . '">
        ';
        // CODE EDIT END
?>