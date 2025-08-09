<?php

/**
 * SRF Disclaimer
 * This file show the diclaimer information
 * After checking all of information
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

echo $disclaimer_text = '<div id="disclaimer_div" style="display:none;clear:both;"><div id="disclaimer_only">';
echo disclaimer_text(); // keep disclaimer text dynamic
echo '</div><label><input id="disclaimer_check" type="checkbox" name="disclaimer_check" value="" /> I have read, understood and accept the above disclaimer.</label><br>';
echo '<div id="manage_case_div" style="display: none;">

<br><label><input type="radio" name="manage_case" value="0" /> I want FREE prescription only.</label>
<br><label><input type="radio" name="manage_case" value="1" /> I want PAID consultation and full guidance ($25 all minor illnesses, $60 first time for old diseases, $30 monthly after that)</label>.
<br>
</div>';

echo '<input type="submit" name="btn_disclaimer_next" class="button button-primary button-large button-next" style="display:none;max-width:50%" width="100" id="btn_disclaimer_next" value="Next"></div>';

?>