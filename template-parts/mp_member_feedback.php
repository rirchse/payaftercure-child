<?php

/**
 * MP Member Feedback
 * This file controls member feedback in % and smileys
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

if ( current_user_can('administrator') ) 
			{
				echo ' hide';
			}
			echo '">
			<td>Are you satisfied with the treatment so far:</td>
			<td>';

			if ($update_data->satisfaction == 'fa-smile-o')
			{
			echo '<input type="radio" name="satisfaction" value="Better" checked="checked"> <i class="fa fa-smile-o fa-2x" aria-hidden="true"></i>';
			}
			else
			{
			echo '<input type="radio" name="satisfaction" value="Better"> <i class="fa fa-smile-o fa-2x" aria-hidden="true"></i>';
			}

			if ($update_data->satisfaction == 'fa-meh-o')
			{
			echo '<input type="radio" name="satisfaction" value="Unchanged" checked="checked"> <i class="fa fa-meh-o fa-2x" aria-hidden="true"></i>';
			}
			else
			{
			echo '<input type="radio" name="satisfaction" value="Unchanged"> <i class="fa fa-meh-o fa-2x" aria-hidden="true"></i>';
			}

			if ($update_data->satisfaction == 'fa-frown-o')
			{
			echo '<input type="radio" name="satisfaction" value="Worse" checked="checked"> <i class="fa fa-frown-o fa-2x" aria-hidden="true"></i>';
			}
			else
			{
			echo '<input type="radio" name="satisfaction" value="Worse"> <i class="fa fa-frown-o fa-2x" aria-hidden="true"></i><br><br>';
			}

			echo '
			</td>
			</tr>
			<tr class="form_step_7 hide';

			if ( current_user_can('administrator') )
			{
				echo ' hide';
			}
			echo '">
			<td colspan="2">
			<h4>Since LAST update: </h4>
			</td>
			</tr>
			<tr class="form_step_7 hide';

			if ( current_user_can('administrator') )
			{
				echo ' hide';
			}
			echo '">
			<td>How is your Energy level:</td>
			<td>';

			if ($update_data->energy_level == 'Better')
			{
			echo '<input type="radio" name="energy_level" value="Better" checked="checked"> Better<br>';
			}
			else
			{
			echo '<input type="radio" name="energy_level" value="Better"> Better<br>';
			}

			if ($update_data->energy_level == 'Unchanged')
			{
			echo '<input type="radio" name="energy_level" value="Unchanged" checked="checked"> Unchanged<br>';
			}
			else
			{
			echo '<input type="radio" name="energy_level" value="Unchanged"> Unchanged<br>';
			}

			if ($update_data->energy_level == 'Worse')
			{
			echo '<input type="radio" name="energy_level" value="Worse" checked="checked"> Worse<br>';
			}
			else
			{
			echo '<input type="radio" name="energy_level" value="Worse"> Worse<br><br>';
			}

			echo '
			</td>
			</tr>
			<tr class="form_step_8 hide';

			if ( current_user_can('administrator') ) 
			{
				echo ' hide';
			}
			echo '">
			<td>How are you feeling Emotionally: </td>
			<td>';

			if ($update_data->feeling_emotionally == 'Better')
			{
			echo '<input type="radio" name="feeling_emotionally" value="Better" checked="checked"> Better<br>';
			}
			else
			{
			echo '<input type="radio" name="feeling_emotionally" value="Better"> Better<br>';
			}

			if ($update_data->feeling_emotionally == 'Unchanged')
			{
			echo '<input type="radio" name="feeling_emotionally" value="Unchanged" checked="checked"> Unchanged<br>';
			}
			else
			{
			echo '<input type="radio" name="feeling_emotionally" value="Unchanged"> Unchanged<br>';
			}

			if ($update_data->feeling_emotionally == 'Worse')
			{
				echo '<input type="radio" name="feeling_emotionally" value="Worse" checked="checked"> Worse<br>';
			}
			else
			{
				echo '<input type="radio" name="feeling_emotionally" value="Worse"> Worse<br><br>';
			}

			echo '
			</td>
			</tr>
			<tr class="form_step_9 hide';
			
			if ( current_user_can('administrator') ) 
			{
				echo ' hide';
			}
			echo '">
			<td>How is your Main Health Problem:</td>
			<td>';

			if ($update_data->main_problem == 'Better')
			{
				echo '<input type="radio" name="main_problem" value="Better" checked="checked"> Better<br>';
			}
			else
			{
				echo '<input type="radio" name="main_problem" value="Better"> Better<br>';
			}

			if ($update_data->main_problem == 'Unchanged')
			{
				echo '<input type="radio" name="main_problem" value="Unchanged" checked="checked"> Unchanged<br>';
			}
			else
			{
				echo '<input type="radio" name="main_problem" value="Unchanged"> Unchanged<br>';
			}

			if ($update_data->main_problem == 'Worse')
			{
				echo '<input type="radio" name="main_problem" value="Worse" checked="checked"> Worse<br>';
			}
			else
			{
				echo '<input type="radio" name="main_problem" value="Worse"> Worse<br><br>';
			}

			echo '
			</td>
			</tr>
			<tr class="form_step_10 hide';

			if ( current_user_can('administrator') ) 
			{
				echo ' hide';
			}
			echo '">
			<td>Has any new Discharge started e.g. loose stools, cough, runny nose: </td>
			<td>';

			if ($update_data->discharge == 'Yes')
			{
				echo '<input type="radio" name="discharge" value="Yes" checked="checked"> Yes<br>';
			}
			else
			{
				echo '<input type="radio" name="discharge" value="Yes"> Yes<br>';
			}

			if ($update_data->discharge == 'No')
			{
				echo '<input type="radio" name="discharge" value="No" checked="checked"> No<br>';
			}
			else
			{
				echo '<input type="radio" name="discharge" value="No"> No<br>';
			}
			echo '
			</td>
			</tr>
			<tr class="form_step_11">
			<td colspan="2">
			</td>
			</tr>';
?>