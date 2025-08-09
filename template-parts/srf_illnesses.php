<?php

/**
 * SRF Illness Name selection section
 * First page of SRF Smart Remedy Finder
 * All illness name included to this file
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

echo '
  <form id="frm_illness" class="hv-frm_illness" action="' . get_permalink() . '?family_member=' . sanitize( isset($_GET['family_member']) ) . '#frm_questions" method="post" style="clear:both;">
  <label><b>List of illnesses:</b></label><br>';
  echo '<table style="width:100%;margin-left: auto; margin-right: auto;">  
  <tr>';


  $cnt = 1;
  foreach($illnesses1 as $illness)
  {
    /* isset(illness_id) [rafiquli34] */
    $selected = ( sanitize($_POST['illness_id']) == $illness->illness_id) ? (' checked') : ('');
    $available = ($illness->illness_available == 0) ? (' disabled') : ('');

    $new_row = ($cnt % 3 == 0) ? ('</tr><tr>') : ('');
    $available_display_text = ($illness->illness_available == 0) ? (' (temporarily unavailable)') : ('');

    /*code Added By Gaurang Date : 18-6-2018 */
    echo '<td class="Hv-HalfWidth" style="width: 33.33333%; float: left; padding-left: 0px;"><label><input id="illness' . $illness->illness_id . '" type="radio" name="illness_id" value="' . $illness->illness_id . '" ' . $available . $selected . '/>' . '<span class="hv-name">' . $illness->illness_name . ' </span> ' . $available_display_text . '</label></td>'.$new_row;
    $cnt += 1;
  }
  echo '</tr></table>';
  /*code Added By Gaurang Date : 18-6-2018 */
  echo '<label>If your <b>illness is not listed</b> above, please use one of the below options i.e. the Acute Personality Analysis for short term illnesses OR Chronic Personality Analysis for old and long term illnesses:</label><br>';
  echo '<table style="width:100%;margin-left: auto; margin-right: auto;"><tr>';

  $cnt = 1;
  foreach($illnesses2 as $illness)
  {
    $selected = ( sanitize($_POST['illness_id']) == $illness->illness_id) ? (' checked') : ('');
    $available = ($illness->illness_available == 0) ? (' disabled') : ('');

    $new_row = ($cnt % 3 == 0) ? ('</tr><tr>') : ('');
    $available_display_text = ($illness->illness_available == 0) ? (' (temporarily unavailable)') : ('');
    echo '<td class="Hv-HalfWidth" style="width: 33.33333%; float: left; padding-left: 0px;"><label><input id="illness' . $illness->illness_id . '" type="radio" name="illness_id" value="' . $illness->illness_id . '" ' . $available . $selected . '/>' . '<span class="hv-name">' . $illness->illness_name . ' </span>  ' . $available_display_text . '</label></td>'.$new_row;
    $cnt += 1;
  }
  echo '</tr></table>';

  echo '</form>';
  
  ?>