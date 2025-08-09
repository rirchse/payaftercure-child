jQuery(document).ready(function()
{
	// var portal_email = '';
	var family_member = '';  

		/** ---------
		 * MP Comment Submit
		 * btn_portal_submt action 
		 *  ---------- */
		jQuery(".btn-portal-submit").on( "click", function(event)
    {
			event.preventDefault();
			var count_selected = 0;
	
      jQuery('#frm-portal input[type=radio]').each(function(index)
      {
        var input = jQuery(this);
        if (input.is(':checked')) {count_selected += 1;}
      });
    
      jQuery('#frm-portal select option:selected').each(function(index)
      {  
        var input = jQuery(this);
        if (input.val().length > 0) {count_selected += 1;}
      });
    
      if (count_selected < 6 && admin === '0' && last_activity >3)
      {
        alert('All fields are required!');
      } 
      else 
      {
        if (typeof jQuery('#wfu_messageblock_header_1_label_1') !== "undefined" && jQuery('#wfu_messageblock_header_1_label_1').length > 0) 
        {
          var filename_start_string = 'File ';
          var filename_end_string = ' uploaded successfully';
          var filename = jQuery('#wfu_messageblock_header_1_label_1').html();
          filename = filename.replace(filename_start_string, "");
          filename = filename.replace(filename_end_string, "");
          jQuery('#portal_uploaded_file').val(filename);
        }

        jQuery('<input>').attr({
            type: 'hidden',
            name: jQuery(this).attr('name'),
            value: ''
        }).appendTo(jQuery('#frm-portal'));

        jQuery('<input>').attr({
            type: 'hidden',
            name: 'select_family_member',
            value: jQuery('[name="select_family_member"]').val()
        }).appendTo(jQuery('#frm-portal'));

        jQuery('<input>').attr({
            type: 'hidden',
            name: 'add_family_member',
            value: jQuery('[name="add_family_member"]').val()
        }).appendTo(jQuery('#frm-portal'));

        jQuery('<input>').attr({
            type: 'hidden',
            name: 'main_health_problem',
            value: jQuery('[name="main_health_problem"]').val()
        }).appendTo(jQuery('#frm-portal'));
          jQuery('#frm-portal').submit();
      }
    });
 


		/** ---------------- 
		 * MP btn_portal_submit by user 
		 * ------------------ */
		jQuery("#btn-portal-submit-user").on( "click", function(event) 
	{ 
		event.preventDefault();
		jQuery('<input>').attr({
				type: 'hidden',
				name: 'btn_portal_submit_user',
				value: ''
		}).appendTo(jQuery('#frm-family-member'));
		jQuery('<input>').attr({
				type: 'hidden',
				name: 'select_family_member',
				value: jQuery('[name="select_family_member"]').val()
		}).appendTo(jQuery('#frm-family-member'));
		jQuery('<input>').attr({
				type: 'hidden',
				name: 'add_family_member',
				value: jQuery('[name="add_family_member"]').val()
		}).appendTo(jQuery('#frm-family-member'));
			jQuery('#frm-family-member').submit();
		});
		
		/** 
		 * MP Prescription PDF Download
		 */
		jQuery(document).on( "click", ".portal_attachment", function(event) 
		{ 
			event.preventDefault();
			window.open('/wp-content/themes/veggie-lite-child/template-parts/mp_prescription_pdf_download_ajax.php?fn=' + jQuery(this).data('fn') + '&cid=' + jQuery('[name="client_id"]').val(), "_blank");
		});
 
	
		// RAZAUL: change page imit to 100 and search disable 24.10.2018

		/** --------------------------------
		 * MP Comments Admin and User
		 * get srf_case_update data send to Member Portal Progress  
		 * ---------------------------------*/
		var paglnth = 10;
		if ( typeof admin != 'undefined' && admin == '1')
		{ paglnth = 100; }

		var dataTable = jQuery('#case-update-grid').DataTable(
		{
			 "processing": true,
			 "serverSide": true,
			 "autoWidth": false,
			 "searching": false,
			 "pageLength": paglnth,
			 "order": [[ 0, 'desc' ]],
			 "ajax": {
				 url :"../wp-content/themes/veggie-lite-child/template-parts/mp_comments_ajax.php?email=" + portal_email + "&family_member=" +  family_member, // json datasource
		 	data: function(d) 
			{
			 if (typeof jQuery('[name="add_family_member"]') !== "undefined" && jQuery('[name="add_family_member"]').val().length > 0) {
				 d.family_member = jQuery('[name="add_family_member"]').val();
			 } else if (typeof jQuery('[name="select_family_member"]') !== "undefined" && jQuery('[name="select_family_member"]').val().length > 0) {
				 d.family_member = jQuery('[name="select_family_member"]').val();
			 } else if (typeof jQuery('[name="family_member"]') !== "undefined" && jQuery('[name="family_member"]').val().length > 0) {
				 d.family_member = jQuery('[name="family_member"]').val();
			 } else {
				 d.family_member = "";
			 }
			 },
				 type: "post",  // method  , by default get
				 error: function(){  // error handling
					 jQuery(".employee-grid-error").html("");
					 jQuery("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					 jQuery("#employee-grid_processing").css("display","none");
  
				 }
			 },

 
			"columns": [
			{ "data": "post_by", "width": "20%" },
			{ "data": "comments", "width": "60%" },
			{ "data": "dashboard_attachments", "width": "20%" },
			{ "data": "actions", "width": "20%" }
			],
		});

		  
	/** --------------------
	 * MP Comment update by selecting Family Member Name
	 */
 
		jQuery("#case-update-grid").on('xhr.dt', function(e, settings, json, xhr)
		{	
			/** ----------------
			 * MP comment hide if already submitted in current date 
			 * -----------------*/

			var dateArray = [];
			var hideComment1 = document.getElementById('hideComment1');
			var hideComment2 = document.getElementById('hideComment2');
			var adminComment = document.getElementById('adminComment');
			var curDate = hideComment2.getAttribute('date');

			for(var r = 0; r < json.data.length; r++) {
				if(json.data[r].post_by.substring(0, 10) == curDate)
				{
					dateArray.push(curDate);
				}
			}

			if(dateArray.includes(curDate))
			{
				hideComment1.classList.add('hide');
				hideComment2.classList.add('hide');
				adminComment.classList.remove('hide');
			}
			else if(hideComment2.getAttribute('auth') == 0)
			{
				adminComment.classList.add('hide');
				hideComment1.classList.remove('hide');
				hideComment2.classList.remove('hide');
			}
			/** End MP Select Family Member */


			jQuery('[name="main_health_problem"]').val(json.main_health_problem);
			jQuery('#main_health_problem_display').html(json.main_health_problem);
			jQuery('[name="last_payment_date"]').val(json.last_payment_date);
			jQuery('#last_payment_date_display').html(json.last_payment_date);
		});
		 
	 jQuery("#btn-portal-cancel").on( "click", function(event) { 
		 event.preventDefault();
		 location.reload(true); 
	 });
 
	 jQuery("#btn-enter-progress").on( "click", function(event) { 
		 event.preventDefault();
		 jQuery(".form_step_2").removeClass("hide"); 
	 });
	 
	 /** MP Improvement Case Change */
	 jQuery('[name="new_existing_case"]').on( "change", function(event) 
	 { 
		 event.preventDefault();
		 jQuery('#add_select_family_member_tr').addClass("hide"); 
		 jQuery('#add_family_member_tr').addClass("hide");
		 jQuery('#select_family_member_tr').addClass("hide");
		 jQuery('[name="self_family"]').prop("checked", false);
		 jQuery('[name="add_select_family_member"]').prop("checked", false);
		 jQuery('[name="select_family_member"] option:selected').prop("selected", false);
		 jQuery('[name="add_family_member"]').val('');
		 jQuery('.form_step_5').addClass("hide"); 
		 jQuery('.form_step_6').addClass("hide"); 
		 jQuery('.form_step_7').addClass("hide"); 
		 jQuery('.form_step_8').addClass("hide"); 
		 jQuery('.form_step_9').addClass("hide"); 
		 jQuery('.form_step_10').addClass("hide"); 
		 jQuery('.form_step_11').addClass("hide"); 
		 jQuery('#optional_section').addClass("hide");
		 jQuery('#short_term_section').addClass("hide");

		 if (jQuery('[name="new_existing_case"]:checked').val() === 'new_case')
		 {
				 jQuery('.form_step_3').removeClass("hide");
				 jQuery('.form_step_4').addClass("hide");
				 
		 } else {
				 jQuery('.form_step_3').addClass("hide"); 
				 jQuery('.form_step_4').removeClass("hide");
				 jQuery('.asfm1').addClass("hide");
				 jQuery('.asfm2').removeClass("hide");
		 }
	 	});


		/** MP short long term section */
	 jQuery('[name="short_long_term"]').on( "change", function(event) { 
		 event.preventDefault();
		 if (jQuery('[name="short_long_term"]:checked').val() === 'long_term' && (jQuery('[name="self_family"]:checked').val() === 'self' || jQuery('[name="select_family_member"]').val().length > 0 || jQuery('[name="add_family_member"]').val().length > 0 )){
				 jQuery('.form_step_4').removeClass("hide");
				 jQuery('#optional_section').removeClass("hide");
				 jQuery('#short_term_section').addClass("hide");
				 jQuery('.form_step_5').addClass("hide"); 
				 jQuery('.form_step_6').addClass("hide"); 
				 jQuery('.form_step_7').addClass("hide"); 
				 jQuery('.form_step_8').addClass("hide"); 
				 jQuery('.form_step_9').addClass("hide"); 
				 jQuery('.form_step_10').addClass("hide"); 
				 jQuery('.form_step_11').addClass("hide"); 
		 } else if (jQuery('[name="short_long_term"]:checked').val() === 'short_term' && (jQuery('[name="self_family"]:checked').val() === 'self' || jQuery('[name="select_family_member"]').val().length > 0 || jQuery('[name="add_family_member"]').val().length > 0 )){
				 jQuery('.form_step_4').removeClass("hide");
				 jQuery('#optional_section').addClass("hide");
				 jQuery('#short_term_section').removeClass("hide");
		 } else {
				 jQuery('.form_step_4').removeClass("hide");
		 }
	 });
	 
	 /** MP Select Family Member by Member */
	 jQuery('[name="self_family"]').on( "change", function(event) 
	 { 
		 event.preventDefault();
		 last_activity = 0
		 jQuery('[name="add_select_family_member"]').prop("checked", false);
		 jQuery('[name="select_family_member"] option:selected').prop("selected", false);
		 jQuery('[name="add_family_member"]').val('');
		 if (jQuery('[name="self_family"]:checked').val() === 'family_member'){
				 jQuery('#add_select_family_member_tr').removeClass("hide");
				 jQuery('.form_step_5').addClass("hide");
				 jQuery('#optional_section').addClass("hide");
				 jQuery('#short_term_section').addClass("hide");
		 } else if (jQuery('[name="self_family"]:checked').val() === 'self'){
				 jQuery('#add_select_family_member_tr').addClass("hide"); 
				 jQuery('#select_family_member_tr').addClass("hide");

				 if (admin === '0')
         {
					 if (jQuery('[name="new_existing_case"]:checked').val() === 'existing_case')
           {
						 checkLastUserActivity(portal_email);
						 if (last_activity > 3){
							jQuery('.form_step_5').removeClass("hide");
							jQuery('.form_step_11').addClass("hide");
						 } else {
							jQuery('.form_step_5').addClass("hide");
							jQuery('.form_step_11').removeClass("hide");
						 }	
						 jQuery('#optional_section').addClass("hide");
						 jQuery('#short_term_section').addClass("hide");
					 } else if (jQuery('[name="short_long_term"]:checked').val() === 'long_term')
           {
						 jQuery('#optional_section').removeClass("hide");
						 jQuery('#short_term_section').addClass("hide");
					 } else if (jQuery('[name="short_long_term"]:checked').val() === 'short_term')
           {
						 jQuery('#optional_section').addClass("hide");
						 jQuery('#short_term_section').removeClass("hide");
					 }
				 }
				 jQuery('[name="select_family_member"] option:selected').prop("selected", false);
				 jQuery('[name="add_family_member"]').val('');
				 dataTable.ajax.reload();
		 }
	 });
	 
	 /** 
		* MP Select family member for new 
	  */
	 jQuery('[name="add_select_family_member"]').on( "change", function(event) 
   { 
		 event.preventDefault();
		 if (jQuery('[name="add_select_family_member"]:checked').val() === 'add'){
			 jQuery('#add_family_member_tr').removeClass("hide"); 
			 jQuery('#select_family_member_tr').addClass("hide"); 
			 jQuery('#optional_section').addClass("hide");
			 jQuery('#short_term_section').addClass("hide");
		 } else {
			 jQuery('#select_family_member_tr').removeClass("hide"); 
			 jQuery('#add_family_member_tr').addClass("hide");
			 jQuery('#optional_section').addClass("hide");
			 jQuery('#short_term_section').addClass("hide");
		 }
	 });
	 
	 /** 
		* MP Add new family member by Admin
	  */
	 jQuery('[name="add_family_member"], [name="select_family_member"]').on( "keyup change", function(event) 
	 { 
		 event.preventDefault();
		 last_activity = 0
		 
		 if (jQuery(this).val().length > 0){
			 if (admin === '0'){
		 
				 if (jQuery('[name="new_existing_case"]:checked').val() === 'existing_case'){
					 jQuery('#optional_section').addClass("hide");
					 jQuery('#short_term_section').addClass("hide");
				 } else if (jQuery('[name="short_long_term"]:checked').val() === 'long_term'){
					 jQuery('#optional_section').removeClass("hide");
					 jQuery('#short_term_section').addClass("hide");
				 } else if (jQuery('[name="short_long_term"]:checked').val() === 'short_term'){
					 jQuery('#optional_section').addClass("hide");
					 jQuery('#short_term_section').removeClass("hide");
				 }
 
			 }
			 
			 if (jQuery(this).prop('name') === 'select_family_member'){
				 jQuery('#delete_member').removeClass("hide"); 
			 }
		 } else {
			 jQuery('#short_term_section').addClass("hide");
			 jQuery('.form_step_5').addClass("hide");
			 if (jQuery(this).prop('name') === 'select_family_member'){
				 jQuery('#delete_member').addClass("hide"); 
			 }
		 }
	 });
 

	 /** -----------------------
		* MP
		* ajax action for on select family member action 
		-------------------------- */
	 jQuery('[name="select_family_member"]').on( "change", function(event)
	 {
		 event.preventDefault();
		 last_activity = 0
		 dataTable.ajax.reload();
		 if (jQuery(this).val().length > 0){
			 if (admin === '0'){
		 
				 if (jQuery('[name="new_existing_case"]:checked').val() === 'existing_case'){
					  checkLastUserActivity(portal_email);
					  //alert(last_activity);
					  if (last_activity > 3){
						  jQuery('.form_step_5').removeClass("hide");
						  jQuery('.form_step_11').addClass("hide");
					  } else {
						  jQuery('.form_step_5').addClass("hide");
						  jQuery('.form_step_11').removeClass("hide");
					  }	
				 }
			 }
		 }
 		});
 
 
	 jQuery('tr[class^="form_step_"] input, tr[class^="form_step_"] select').on( "keyup change", function(event) { 
		 event.preventDefault();
				var class_name = jQuery(this).parent().parent().prop('class');
			 var class_name_arr = class_name.split('_');
 
		 if ( (class_name_arr[2] != 2 && class_name_arr[2] != 3 && class_name_arr[2] != 4) && admin === '0'){
			 if (jQuery(this).val().length > 0){
					 jQuery('.form_step_' + parseInt(parseInt(class_name_arr[2]) + parseInt(1))).removeClass("hide");
 
			 } else {
					 jQuery('.form_step_' + parseInt(parseInt(class_name_arr[2]) + parseInt(1))).addClass("hide");
			 }
		 }
	 });
	 
	 /** MP Delete Family Member */
	 jQuery('#delete_member').on( "click", function(event) 
	 { 
		 event.preventDefault();
		 if (confirm("You are about to delete all records for selected family member!\n Are you sure you want to do that?") == true) {
				var member_name = jQuery('[name="select_family_member"]').val();
			 if (member_name.length > 0){
				 jQuery.ajax({
				 method: "POST",
				 url: '../wp-content/themes/veggie-lite-child/template-parts/mp_delete_member_ajax.php?email=' + portal_email,
				 data: { 
					   "member_name": member_name,
				 },
				 success: function( data ) {
					 jQuery('[name="select_family_member"] option[value="' + member_name + '"]').remove();
					 jQuery('[name="select_family_member"]').val('');
					 jQuery('.form_step_5').addClass("hide");
					 dataTable.ajax.reload();
					 jQuery('#delete_member').addClass("hide"); 
					 alert('Family member deleted successfully!\nSelect another family member to continue!');
				 },
				 error: function(xhr, textStatus, error){
				 }
			 });
			 } else {
				 jQuery('.form_step_' + parseInt(parseInt(class_name_arr[2]) + parseInt(1))).addClass("hide");
			 }
		 }
	 	});
 
	/** MP Last payment date show */
	 jQuery('[name="last_payment_date"]').datepicker({'dateFormat': 'dd-mm-yy'});


	 	 
 function checkLastUserActivity(email='')
 { 
		 var family_member;
		 var json_response;
		 
		 if (typeof jQuery('[name="add_family_member"]') !== "undefined" && jQuery('[name="add_family_member"]').val().length > 0) {
			 family_member = jQuery('[name="add_family_member"]').val();
		 } else if (typeof jQuery('[name="select_family_member"]') !== "undefined" && jQuery('[name="select_family_member"]').val().length > 0) {
			 family_member = jQuery('[name="select_family_member"]').val();
		 } else if (typeof jQuery('[name="family_member"]') !== "undefined" && jQuery('[name="family_member"]').val().length > 0) {
			 family_member = jQuery('[name="family_member"]').val();
		 } else {
			 family_member = "";
		 }
	
			   var jqXHR = jQuery.ajax({
				 method: "POST",
				 async: false,
				 url: '../wp-content/plugins/smart-remedy-finder/portal-ajax-last-activity.php',
				 data: { 
					  "family_member": family_member,
					  "email": portal_email
				 },
				 success: function( data ) {
					 
				 },
				 error: function(xhr, textStatus, error){
				 }
			 });
		 var json = JSON.parse(jqXHR.responseText);
		 if ( jQuery.trim(json) ) {
		 last_activity = json.diff;
		 } else {
		 last_activity = 0;
		 }
 }
 
});