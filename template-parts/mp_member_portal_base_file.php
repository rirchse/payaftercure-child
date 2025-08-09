<?php
	/** template Name: Member Portal Base File
	*/

	/**
	 * MP Member Child
	 * mp_member_portal_base_file.php is base file of Member Portal section
	 * This files included
	 * mp_functions.php
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

	get_header();

	$host          = 'http://'.$_SERVER['HTTP_HOST'];
	$user_admin    = current_user_can('administrator');
	$user_loggedin = is_user_logged_in();

	$smartCss = home_url('/').'wp-content/themes/veggie-lite-child/css/member.css';
	wp_enqueue_style('member', $smartCss, array(), '1.0');

	/** all functions included in mp_functions.php for member_child.php */
	include 'mp_functions.php';
?>
<style>
	.btn{
		border:1px solid #ddd;padding: 2px 15px; background: blue;color:#fff!important;text-decoration:none;
	}
</style>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="member_por">
		<h2>member portal</h2>
	</div>

	<?php		
		
		$homeUrl = home_url('/').'wp-content/themes/veggie-lite-child/js/mp.js';
		wp_enqueue_script( 'mp', $homeUrl, array(), '02.0', true );

		wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', false );
		wp_enqueue_style( 'datatables-style', 'https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css', true );
		wp_enqueue_script( 'datatables', 'https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js', false );

		global $wpdb;
		$current_user = wp_get_current_user();
		$update_data  = array(
			'improvement'  => '-99',
			'illness_name' => '',
			'satisfaction' => '',
			'energy_level' => '',
			'feeling_emotionally' => '',
			'main_problem' => '',
			'discharge'    => '',
			'comments'     => ''
		);

		/* upwork id: rafiquli34 */
		if(!is_user_logged_in())
		{
			// echo '<script>window.location.href="'.$host.'/wp-login.php?redirect_to=http://dev.payaftercure.com/member-portal?'.sanitize(isset($_GET['email'])).'";</script>';
			// wp_safe_redirect( $host.'wp-login.php?redirect_to='.$host.'/member-portal/?email='.sanitize(isset($_GET['email'])) );
			// wp_redirect('http://dev.payaftercure');
			// exit();
		}

		/* logged in user role check and set client email
		Comment by: Rafiqul Islam, rirchse@gmail.com, Upwork id: rafiquli34
		*/
		if ( current_user_can('administrator') ) 
		{
			$client_email = (sanitize(isset($_GET['email']))) ? (sanitize($_GET['email'])) :($current_user->user_email);
			$form_fields_style = '';
		} 
		else 
		{
			$client_email = $current_user->user_email;
			$form_fields_style = 'style="display:none;"';
		}

		/** email exists check with url 
		*  Comment by: Rafiqul Islam, rirchse@gmail.com 
		*/
		$portal_link  = get_permalink();
		$portal_link .= sanitize(isset($_GET['email'])) ? ('?email=' . sanitize($_GET['email'])) :('?email=');

		/* get prescription data from database by client email 
		Comment by: Rafiqul Islam, rirchse@gmail.com
		*/
		/** get prescription data from mp function.php */
		$prescription_data = PrescriptionData($wpdb, $client_email);

		/* get illness data from srf_illness table
		Comment by: Rafiqul Islam, rirchse@gmail.com
		*/
		/** get illness data from member_function.php */
		$illnesses = Illnesses($wpdb);


		/* Check user is logged in or user is administrator
		Comment by: Rafiqul Islam, rirchse@gmail.com
		*/
		if( is_user_logged_in() && ($prescription_data > 0 || current_user_can('administrator') ) ) 
		{
			if (current_user_can('administrator') && $_SERVER['REQUEST_METHOD'] == 'GET' && sanitize(isset($_GET["action"])) && strlen(sanitize($_GET["action"])) > 0)
			{
				// if administrato edit or delete the comments
				if (sanitize($_GET["action"]) === 'edit')
				{
					/** update srf_case_update to mp_functions.php */
					$update_data = SrfCaseUpdate($wpdb, $client_email, sanitize($_GET["id"]));
				}
				elseif (sanitize($_GET["action"]) === 'delete')
				{
					/** case data delete to mp_functions.php */
					SrfCaseDelete($wpdb, $client_email, sanitize($_GET['id']));
				}

			}

			elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && sanitize(isset($_POST["btn_delete_user"])) && current_user_can('administrator'))
			{
				$family_member_name = sanitize($_POST["delete_user_email"]);

				/** get deleted user data from mp_functions.php */
				$user_data = GetDeletedPayUser($wpdb, sanitize($_POST["delete_user_email"]));

				require_once(ABSPATH.'wp-admin/includes/user.php' );
				wp_delete_user($user_data->ID);

				/** delete user by email from mp_functions.php */
				CaseDeleteByEmail($wpdb, sanitize($_POST["delete_user_email"]));
			}

			elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && sanitize(isset($_POST["btn_portal_submit_user"])))
			{
				$payment_date = explode('-', sanitize($_POST["last_payment_date"]));

				if (sanitize(isset($_POST["select_family_member"])) && strlen(sanitize($_POST["select_family_member"])) > 0)
				{
					$family_member_name = sanitize($_POST["select_family_member"]);
				}
				elseif (sanitize(isset($_POST["add_family_member"])) && strlen(sanitize($_POST["add_family_member"])) > 0)
				{
					$family_member_name = sanitize($_POST["add_family_member"]);
				}
				else
				{
					$family_member_name = $current_user->display_name;
				}


				$memberData = array( 
					'client_email' 			 => $client_email, 
					'family_member_name' => $family_member_name
				);
				
				/** delete srf_family_member from member_function.php */
				FamilyMemberDelete($wpdb, $memberData);

				
				$memberData = array(
					'client_email' 				=> $client_email,
					'family_member_name'  => $family_member_name,
					'main_health_problem' => sanitize($_POST["main_health_problem"]),
					'last_payment_date'   => $payment_date[2] . '-' . $payment_date[1] . '-' . $payment_date[0]
				);

				/** insert srf_family_member from member_function.php */
				FamilyMemberInsert($wpdb, $memberData);

			}

			elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$family_member_name = $current_user->display_name;
			}

			elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && (sanitize(isset($_POST["btn_portal_submit"])) || sanitize(isset($_POST["btn_portal_submit_exit"])) || sanitize(isset($_POST["btn_portal_submit_update"]))))
			{
				// var_dump($_POST);
				// CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Aug 20, 2022, Added Save Family member/update Functionlity on save & save & exit button as well
				
				if (sanitize(isset($_POST["select_family_member"])) && strlen(sanitize($_POST["select_family_member"])) > 0 && !isset($_POST["add_family_member"]) && strlen(sanitize($_POST["add_family_member"])) == 0 )
				{
					$family_member_name = sanitize($_POST["select_family_member"]);
				}
				elseif (sanitize(isset($_POST["add_family_member"])) && strlen(sanitize($_POST["add_family_member"])) > 0)
				{
					$family_member_name = sanitize($_POST["add_family_member"]);
					$add_member = true;
				}
				else
				{
					$family_member_name = $current_user->display_name;
				}

				if ((sanitize(isset($_POST["select_family_member"])) && strlen(sanitize($_POST["select_family_member"])) && sanitize(isset($client_email)) && sanitize(isset($_POST["last_payment_date"]))) || isset($add_member) ) 
				{
					//show alert if submit in same date two times
					$family_member_name = isset($add_member) ? $family_member_name : sanitize($_POST["select_family_member"]);

					$memberData = array (
						'client_email' => $client_email,
						'family_member_name' => $family_member_name
					);

					/** delete family member from mp_functions.php */
					FamilyMemberDelete($wpdb, $memberData);
					
					/** array created for srf_family_member insert */
					$memberData = array (
						'client_email'        => $client_email,
						'family_member_name'  => $family_member_name,
						'main_health_problem' => sanitize($_POST["main_health_problem"]),
						'last_payment_date'   => sanitize($_POST["last_payment_date"])
					);

					/** insert data to srf_family_member from mp_functions.php */
					FamilyMemberInsert($wpdb, $memberData);
				}


				// CODE EDIT END
				// CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Apr 25, 2022, Added by current datetime according to EST us timezone

				$current_datetime = new DateTime("now", new DateTimeZone('America/New_York') );

				/** upload existing prescription for future */
				// $case_photo = prescripUpload($_FILES["case_photo"], '/wp-content/uploads/prescription_image/');

				// var_dump($case_photo);
				// exit;

				$case_data = array ( 
					'email' => $current_user->user_email, 
					'client_email' => $client_email, 
					'illness_name' => sanitize($_POST["main_health_problem"]), 
					'family_member_name' => $family_member_name, 
					'improvement' => sanitize($_POST["improvement"]), 
					'satisfaction' => sanitize($_POST["satisfaction"]), 
					'energy_level' => sanitize($_POST["energy_level"]), 
					'feeling_emotionally' => sanitize($_POST["feeling_emotionally"]), 
					'main_problem' => sanitize($_POST["main_problem"]), 
					'discharge' => sanitize($_POST["discharge"]), 
					'filename' => sanitize($_POST["portal_uploaded_file"]),
					'case_photo' => $_POST['case_photo'],
					'comments' => stripslashes_deep(nl2br(sanitize($_POST["comments"]))),
					'is_admin' => (current_user_can('administrator'))?('1'):('0'),
					'date_submitted' => $current_datetime->format('Y-m-d H:i:s'),
				);
				//CODE EDIT END
				
				if (sanitize(isset($_POST["btn_portal_submit_update"])))
				{
					$caseData = [
						'improvement' => $case_data['improvement'],
						'comments'    => $case_data['comments']
					];
					//udpate case data [patient comments]
					$case_update_result = Srf_Case_Update($wpdb, $caseData, ['update_id' => sanitize( $_POST["case_id"]) ]);
					 
				}
				else
				{
					if(!empty(sanitize($_POST['postvaluebyme'])))
					{
						/** srf case update insert data from mp_functions.php */
						SrfCaseInsert($wpdb, $case_data);
					}
				}
				unset($case_data);

				/** 
				 * form controller end from above
				 */

				/** ----------- Email sending section ------------------- */

				/* create data for send email */
				if(!empty(sanitize($_POST['postvaluebyme'])))
				{
					if ( current_user_can('administrator') )
					{
						$email_to = $client_email;
						sendEmailAdmin($email_to, stripslashes_deep(nl2br(sanitize($_POST["comments"]))), $family_member_name);
					}
					else
					{
						sendEmailUser($client_email, stripslashes_deep(nl2br(sanitize($_POST["comments"]))), $family_member_name);
					}

					
				}
			
				// MEMBER PORTAL EMAIL
				/* Main email sending functionality
				Comment by: Rafiqul Islam, rirchse@gmail.com
				*/
				
				if (sanitize(isset($_POST["btn_portal_submit_exit"])))
				{
					echo '<script type="text/javascript"> document.location.href= "' . htmlspecialchars_decode( wp_logout_url( home_url() ) ) . '"; </script>';
				}
				unset($_POST['postvaluebyme']);
			}

			/** get family members from mp_functions.php */
			$family_members = getMemberFromCaseUpdate($wpdb, $client_email);


			/** get paypal data from mp_functions.php */
			$paypal = SelectPayPalData($wpdb, $client_email);
			

				$paypal_count = $paypal;

				if ($paypal_count > 0)
				{
					$paypal_data = unserialize($paypal->serialized_data);
				
					$payment_date = date_create($paypal_data['payment_date']);
					$last_payment = ($paypal_count > 0)?(date_format($payment_date, 'Y-m-d')):('-- -- --');
				
					$date1 = new DateTime(date_format($payment_date, 'Y-m-d'));
					$date2 = new DateTime("NOW");
					$date_diff = $date2->diff($date1)->d; 
				}

			/** get pay user data from mp_functions.php */
			$user_data = PayUserData($wpdb, $client_email);

			if( wp_is_mobile())
			{
				
				if (is_user_logged_in( )){
					//
				}
			}
		
			if ( current_user_can('administrator') )
			{
				/*code Added By Razaul 28-8-21 */
				$form1 = '
				<table class="helth_porob">
					<tr>
						<td>
							<p class="select_fam">Health Issue: </p>
						</td>
						<td><span id="main_health_problem_display">';

				if (!empty($user_data->main_health_problem))
				{
					$form1 .= $user_data->main_health_problem;
				}
				else
				{
					$form1 .= $prescription_data->illness_name;
				}

				$form1 .=  '</span>';
				$form1 .= '<input type="text" name="main_health_problem" class="improvement1" value="' . $user_data->main_health_problem . '"></td></tr>';
				$form1 .= '<br>
				<tr class="helth_porob">
				<td><p class="select_fam">Last Payment:</p></td>
				<td><span id="last_payment_date_display1">';
				// CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Aug 20, 2022, Added Calendar and removed previous date

				$form1 .= '</span>';
				$form1 .= '<input type="date" name="last_payment_date" value="' . $user_data->last_payment_date . '"></td></tr>';
				$form1 .= '</p>';
				// CODE EDIT END
				
				/*code Added By Razaul 28-8-21 */ 
			} 
			else
			{
				/*code Added By Razaul 28-8-21 */ 

				$form1 = '<tr class="helth_porob"><td>
				<p class="select_fam float-left">Health Issue:</p></td><td>
				<span id="main_health_problem_display">';
				if (!empty($user_data->main_health_problem))
				{
					$form1 .= $user_data->main_health_problem;
				}
				else
				{
					$form1 .= $prescription_data->illness_name;
				}

				$form1 .=  '</span> ';
				$form1 .= '<input type="text" readonly name="main_health_problem" class="health_prob float-left" value="' . $user_data->main_health_problem . '" placeholder=" Your health issue"></td></tr>';
				$form1 .= '<br>
				<tr class="helth_porob">
				<td><p class="select_fam w-50 float-left">Last Payment:</p></td><td> <span id="last_payment_date_display">';

				if (!empty($user_data->last_payment_date))
				{
					$form1 .= convert_date_format($user_data->last_payment_date);
				}
				else
				{
					$form1 .= convert_date_format($last_payment);
				}

				$form1 .= '</span>';
				$form1 .= '<input type="hidden" name="last_payment_date" class="health_prob" readonly value="' . convert_date_format($user_data->last_payment_date) . '"></td></tr>';
					/*code Added By Razaul 28-8-21 */ 
			} /*if current user is not administrator logic end 
			Comment by: Rafiqul Islam, rirchse@gmail.com
			*/

			/** select from existing family memebr or create new family member on admin section */
			// $form2 = '<tr id="add_select_family_member_tr" class="form_step_4">
			// <td>Please select the name of the patient:</td>
			// <td><label>
			// <input type="radio" name="add_select_family_member" value="select"> </label> Select From Existing Family Members<br>
			// <input type="radio" name="add_select_family_member" value="add"> Add A New Family Member//<br>
			// </td>
			// </tr>';

			$form2 = '';

			if ( current_user_can('administrator') ) 
			{
				$form2 .= '<tr id="add_family_member_tr" class="hide">
					<td></td>
					<td>
						<input type="text" name="add_family_member" placeholder=" Type patient name">
					</td>
				</tr>
				<tr id="select_family_member_tr " class="show reltv">
				<td><p class="existing_fam">Select Family Member:</p></td>
				<td><select name="select_family_member" class="improvement1 hvFullWidth" required>
				<option value="">--- Select Family Member ---</option>';

				foreach ($family_members as $row)
				{
					if(!empty($row->family_member_name))
					{
						$form2 .= '<option value="' . $row->family_member_name . '" '.(sanitize($_GET['family_member_name']) == $row->family_member_name? 'selected':'' ).'>' . $row->family_member_name . '</option>';
					}
				}

				$form2 .= '</select><a style="color:#00f;display:inline" onclick="document.getElementById(\'member_form\').style.display=\'block\'">Add New Member</a><button id="delete_member" class="hide">Delete</button>
				</td>
				</tr>';

				/* FORM 2 */
				/** get email list from srf_prescription table on mp_functions.php */
					$email_list = SelectEmailList($wpdb);

					/*code Added By Gaurang 20-6-2018*/  
					echo '
					<table class="hv-FixWidth-tb">
					<tr>
					<td class="hv" style="vertical-align: top">Select Email:</td>
					<td>
					<form id="frm-email" action="' . get_permalink() . '" method="get" style="clear:both;"><select name="email" class="" onchange="this.form.submit();" enctype="multipart/form-data">
					<option value="">--- Select Email Address ---</option>';

				foreach ($email_list as $row)
				{
					$email_selected = (sanitize($_GET['email']) === $row->email)?('selected'):('');
					echo '<option value="' . $row->email . '" ' . $email_selected . '>' . $row->email . '</option>';
				}
				echo '</select><a style="color:#00f;display:inline" onclick="document.getElementById(\'subscriber_form\').style.display=\'block\'">Add New Subscriber</a>
				</form>';

				if (!empty(sanitize($_GET['email'])))
				{
					echo '
					<form id="frm-delete-user" action="' . get_permalink() . '" method="post" style="clear:both;">
					<button name="btn_delete_user" onclick="return confirm(\'You are about to delete all records for selected main member email!\n Are you sure you want to do that?\')">Delete</button>
					<input type="hidden" name="delete_user_email" value="' . sanitize($_GET['email']) . '">
					</form>';
				}

				echo '
				</td>
				</tr>
				</table>';
			}	
			else
			{
				$form2 .= '
					<tr id="add_family_member_tr" class="hide">
					<td>
					<input type="hidden" name="add_family_member">
					</td>
					</tr>
					<tr id="select_family_member_tr " class="show reltv">
					<td><p class="select_fam float-left">Select Family Member:</p></td>
					<td><select name="select_family_member" class="float-left improvement">
					<option value="">--- Select Family Member ---</option>';

					foreach ($family_members as $row)
					{
						if(!empty($row->family_member_name))
						{
							$form2 .= '<option value="' . $row->family_member_name . '" '.(sanitize($_GET['family_member_name']) == $row->family_member_name? 'selected':'').'>' . $row->family_member_name . '</option>';
						}
					}

					$form2 .= '</select><button id="delete_member" class="hide">Delete</button>
					</td>
					</tr>';
			}

			if ( current_user_can('administrator') ) 
			{
				echo '
				<table id="admin_form_table" class="hv-admin_form_table">
				<tr>';
				echo $form2;
				echo '
				</tr>
				</table>';
			}
			
			/*code Added By Gaurang 20-6-2018*/  
			echo '
			<div id="frm-portal-div">
			<form id="frm-portal" class="hv-form-width" action="' . $portal_link . '" method="POST" style="clear:both;width:100%" enctype="multipart/form-data">
			<input type="hidden" name="family_member" value="' . $family_member_name . '">
			<input type="hidden" name="id" value="' . sanitize(isset($_GET['id'])) . '">';

				/*code Added By Razaul 28-8-21 */ 
			if ( !current_user_can('administrator') ) 
			{
				echo '<table class="/full-data">
				<tr class="left-data w-100"><td colspan=2><b>Welcome! </b>';
				echo $form2;
				echo '<input type="hidden" name="family_member_select" value=""></td></tr></table>';
			}
			else
			{
				echo $form1;
			}
			/*code end By Razaul 28-8-21 */ 
			echo '
			<table style="">';

			if ( !current_user_can('administrator') ) 
			{
				echo $form1;
			}
			
			echo '
			<tr class="form_step_5 hide">
			<td colspan="2"><br><br>
			</td>
			</tr>
			<tr id="hideComment2" auth="'.current_user_can('administrator').'" date="'.date('Y-m-d').'" class="form_step_5 rels'.(current_user_can('administrator')? ' hide':'').'">
			<td class="full_wid '.(current_user_can('administrator')? ' hide':'').'" colspan="2">
			<font color="FF0000"><i>The Comments Box will appear in the end once you answer all below questions.</i></font>
			<br><br><h4>Please let us know, since the last dose: </h4>
			</td>
			</tr>';

			// if(!current_user_can('administrator'))
			// {
				echo '<tr id="hideComment1" class="form_step_5 nowss '.(current_user_can('administrator')? ' hide':'').'">
				<td>How much improvement are you feeling:</td>
				<td>
				<select name="improvement" class="improvement">
				<option value="-99"> --- Select Your Improvement --- </option>';


				/** --------------- satifaction section -------------- */
				$improvement_steps = range(0, 100, 10);
				foreach ($improvement_steps as $step)
				{ 
					$selected = ($update_data->improvement == $step && strlen($update_data->improvement) > 0) ? ('selected="selected"'):('');
					echo '<option value="' . $step . '" ' . $selected . '>' . $step . '%</option>';
				}
				echo '</select>
				</td>
				</tr>';
			// }

			echo '<tr class="form_step_6 hide';
			/**
			 * MP member portal improvement section
			 */
			include 'mp_member_feedback.php';

			// Razaul 3hrs checking to enable comment box 25.10.2018
			/** get existing data from srf_case_update on mp_functions.php */
				$check_exist_case_data = ExistingCaseData($wpdb, $client_email);
				
				/** ger current time from mp_functions.php */
				$check_current_time = CheckCurrentTime($wpdb);

				$curdate = strtotime($check_current_time->curtime);  
				$srfdbdate = strtotime($check_exist_case_data->date_submitted);  
				
				$diff = abs($curdate - $srfdbdate);
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));

				$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));

				$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
				
				$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

				$show_comment_box = 0;

				if($days == 0 && $hours <= 3)
				{
					$show_comment_box = 1;
				}
				
				// if ( current_user_can('administrator')){ $show_comment_box = 1; }
				echo '<tr id="adminComment" class="form_step_11';
				if ( !current_user_can('administrator') && $show_comment_box == 0)
				{
					echo ' hide';
				}

				echo '">
				<td>Comments: </td>
				<td>
				<textarea style="width: 100%"  rows="7" class="cmt_name" name="comments" placeholder="Type your comments" required>';

				if (isset($update_data->comments))
				{
					echo strip_tags($update_data->comments);
				}
				else
				{
					echo '';
				}
				echo '</textarea>
				</td>
				</tr>
				<tr class="form_step_11';

				if( !current_user_can('administrator') ) 
				{
					echo ' show';
				}

				echo '">
				</tr>
				</table>
				<table class="form_step_11 pac-submit-btn';
				
				if( !current_user_can('administrator') )
				{
					echo ' show';
				}
				echo '">';

				if(!current_user_can('administrator'))
				{
					echo '<tr>
					<td><label>Attach case photos or reports here:</label></td>
					<td><input type="hidden" id="case_photo" name="case_photo"><input type="file" onchange="validImage(this)"><p style="color:#d00";">Upload Image Format: (JPG, JPEG, PNG) Only and Image size max: 5MB</p><div style="display:none" id="show_case_photo"><img id="" alt="" width="200"/><br><a style="color:red" onclick="removeCasePhoto(this)">Remove Photo</a></div><br/></td>
					</tr>';
				}

				echo '<tr>
				<td></td><td>';

				//You can attache your member\'s existing prescription file to get our doctors proper suggession or for future inquery that you can download when you need.



			/** ------MP member portal for Admin ------- */	

			if (current_user_can('administrator') && $_SERVER['REQUEST_METHOD'] == 'GET' && sanitize(isset($_GET["action"])) && strlen(sanitize($_GET["action"])) > 0 && sanitize($_GET["action"]) === 'edit')
			{
				echo '<input name="case_id" value="'.sanitize($_GET['case_id']).'" type="hidden">
				<input class="btn-portal-submit" type="submit" name="btn_portal_submit_update" value="Save Changes" style="margin-right:25px;" />';
			}
			else
			{
				echo '<div id="hide/Comment3">
				<input type="hidden" name="postvaluebyme" value="postdone"/>
				<input class="btn-portal-submit" type="submit" name="btn_portal_submit" value="Save" style="margin-right:25px;" />
				<input class="btn-portal-submit" type="submit" name="btn_portal_submit_exit" value="Save & Exit" style="margin-right:25px;" />
				<a id="btn-portal-cancel"><small>Exit Without Saving</small></a></div>';
			}

				echo '</td></tr></table><hr>
				</form>
				</div>'; 

				echo '
				<div id="short_term_section" class="hide">
				<form action="' . get_permalink(336) . '" method="post" style="clear:both;">
				<input type="submit" class="button button-primary button-large" style="float: left; clear: left;" value="Proceed to step 2" id="btn_short_term">
				</form>
				</div>';

				echo '';
				echo '</div>';
				
				/*if ($date_diff > 10){*/
				/* PAYPAL BUTTON START */
					

				echo '<input type="hidden" name="client_id" value="' . $user_data->ID . '">';
				echo '<input type="hidden" name="client_name" value="' . $user_data->display_name . '">';
				echo '<input type="hidden" name="client_email" value="' . $user_data->user_email . '">';
				echo '</div></div>';

				/*code Added By Gaurang : to display comment proper*/
				if (!current_user_can('administrator') )
				{
					?>
					
					<style>
					
					@media only screen and (max-width: 600px) {
						#case-update-grid_wrapper table#case-update-grid th.sorting_asc{
							width:30% !important;
						}
						#case-update-grid_wrapper table#case-update-grid th.sorting{
							width:30% !important;
						}
						#case-update-grid_wrapper table#case-update-grid th,#case-update-grid_wrapper table#case-update-grid td{
							width:30% !important;
						}
					}
						
					</style>
					<?php 
				}
				else
				{
					
					?>
					
					<style>
					
					@media only screen and (max-width: 600px) {
						#case-update-grid_wrapper table#case-update-grid th.sorting_asc{
							width:23% !important;
						}
						#case-update-grid_wrapper table#case-update-grid th.sorting{
							width:22% !important;
						}
						#case-update-grid_wrapper table#case-update-grid th,#case-update-grid_wrapper table#case-update-grid td{
							width:22% !important;
						}
					}
						
					</style>
					<?php
				}


				echo '
				<div class="site"><div id="case-update-grid-div" style="margin-left: 10px; margin-top: 40px; /*float: left;*/">
				<h3>Your Case Status</h3>
				<table id="case-update-grid" cellpadding="0" cellspacing="0" border="0" class="display comment_section_mv" width="100%">
					<thead>
						<tr>
							<th align="left">Date, Post By</th>
							<th align="left">Comments</th>
							<th align="left">Illness</th>';

				if ( current_user_can('administrator') )
				{
					echo '<th align="left">Actions</th>';
				}
				echo '</tr>
							</thead>
						</table>
					</div>
				</div>';
		} /* end of: if user logged in or user is administrator
		Comment by: Rafiqul Islam, rirchse@gmail.com
		*/
		else
		{
			/* if user not logged in or user is not administrator then show a message 
			Comment by: Rafiqul Islam, rirchse@gmail.com */

			echo '<div class="nologin-text" style="text-align:center;">';
				$link_login = '<a href="' . wp_login_url($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) . '" title="' .  __( 'Login' ) .'"  class="btn menu-item menu-type-link">' . __( 'Login' ) . '</a>';
				$link_register = '<a class="btn" href="' . wp_registration_url($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) . '" title="' .  __( 'Register' ) .'">' . __( 'Register' ) . '</a>';

			echo 'This page is reserved for members who want us to manage their case by using our Consultation service.<br>';

			echo 'Please <b><u> ' . $link_login . '</b></u> to use the consultation service, you have to ' . $link_register . ' before you can Login, registration is free.<br>';

			echo 'If you have already used the SRF (Smart Remedy Finder), you can use the same username & password to Login.<br>';

			echo 'In case of any queries please <a href="mailto:support@payaftercure.com?subject=Query_from_Member_Portal_page">Contact Us</a>.<br>';
			echo '</div>';
		} /* end else of: if user logged in 
		Comment by: Rafiqul Islam, rirchse@gmail.com */

	?>
	</div>
		<!-- case photo uploading preloader -->
		<div id="preloader" style="position:fixed;background:rgba(0,0,0,0.8);top:0;bottom:0;left:0;right:0;text-align:center;z-index:9999999999;padding-top:15%;display:none">
			<span style="color:#fff;font-size:25px;position:absolute; top:10px;right:25px" onclick="this.parentNode.style.display = 'none'"><i class="fa fa-times"></i></span>
			<img src="/preloader.webp" alt="">
			<div id="imgInfo" style="margin-top:-35px"></div>
		</div>
	</div>

	<?php include('mp_admin_add_subscriber.php'); ?>

	<script>
		var admin = '<?php if (current_user_can("administrator"))
		{echo "1";}
		else
		{echo "0";}  ?>';

		var portal_email = '<?php  echo $client_email; ?>';
		var last_activity = 0;
	</script>

	<script>
		jQuery(document).ready(function()
		{
			jQuery('#myTable').DataTable({
				"searching": false,
				"pageLength": 50
			});
		});


		var base_url = '<?php echo get_bloginfo('url');?>';
		var case_photo = document.getElementById('case_photo');
		var show_case_photo = document.getElementById('show_case_photo');
		var preloader = document.getElementById('preloader');
		var img_location = '';

		//ajax file upload
		function validImage(e)
		{
			/** remove if exist case photo */
			ajaxRemoveCasePhoto(img_location);

			//check file
			var file = e.files[0];
			var imgInfo = document.getElementById('imgInfo');
			imgInfo.innerHTML = 'Selected Image Size = '+ (file.size/1024).toFixed(0)+' KB';
			if(file == 0 || file.size > 5000000)
			{
				alert('Image size must be in 5MB');
				file = '';
				e.value = '';
			}
			else if(file.type != 'image/jpeg' && file.type != 'image/png' && file.type != 'image/gif')
			{
				alert('Please select valid image format');
				file = '';
				e.value = '';
			}
			else
			{
				preloader.style.display = 'block';
				var form_data = new FormData();
				form_data.append("file", file);
				jQuery.ajax({
					url: base_url+'/wp-content/themes/veggie-lite-child/template-parts/mp_upload_image.php',
					method: 'POST',
					data: form_data,
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						//
					},
					success: function(data) {
						// console.log(data);
						const obj = JSON.parse(data);
						if(obj.status == 'error')
						{
							file = '';
							e.value = '';
							case_photo.value = '';
							preloader.style.display = 'none';
							alert('Please select valid image');
						}
						else
						{
							img_location = obj.img_file;
							case_photo.value = obj.img_file;
							show_case_photo.firstChild.src = obj.img_file;
							show_case_photo.style.display = 'block';
							preloader.style.display = 'none';
						}
					},
					error: function(data){
						//
					}
				});
			}
		}

		/** remove case photo */
		function removeCasePhoto(e)
		{
			ajaxRemoveCasePhoto(img_location);

			e.parentNode.firstChild.src = '';
			case_photo.value = '';
			e.parentNode.style.display = 'none';
			case_photo.nextElementSibling.file = '';
			case_photo.nextElementSibling.value = '';
		}

		function delCasePhoto(e)
		{
			var result = confirm("Are you sure you want to delete this case photo?");

			if(result && e.getAttribute('path').length > 0)
			{
			console.log(e.getAttribute('path').length);
				ajaxRemoveCasePhoto(e.getAttribute('path'));
				e.parentNode.remove();
			}

		}

		function ajaxRemoveCasePhoto(img_path)
		{
			if(img_path)
			{
				jQuery.ajax({
					url: base_url+'/wp-content/themes/veggie-lite-child/template-parts/mp_remove_case_photo.php',
					method: 'POST',
					data: {
						img: img_path,
					},
					success:function(data)
					{
						//
					}
				});
			}
		}

		/** view case photo */
		function view(e)
		{
			var baseurl = '<?php echo home_url(); ?>/';
			if(e.nextElementSibling.src == baseurl)
			{
				e.nextElementSibling.src = e.previousElementSibling.href;
				e.classList.add("fa-eye-slash");
			}
			else
			{
				e.nextElementSibling.src = baseurl;
				e.classList.remove("fa-eye-slash");
			}
			
		}
	</script>
</article>

<?php
	get_footer();
?>