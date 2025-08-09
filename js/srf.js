jQuery(document).ready(function()
{   
	//Initially hide Lbs,Ft, Inches, Kgs & Centimeters for health care section jobayer 14-09-2018
	jQuery(".questiondropdown1114").closest('tr').hide();
	jQuery(".questiondropdown1115").closest('tr').hide();
	jQuery(".questiondropdown1116").closest('tr').hide();
	jQuery(".questiondropdown1117").closest('tr').hide();
	jQuery(".questiondropdown1118").closest('tr').hide();
	
	//initial bmi value as 0 jobayer 14-09-2018
	jQuery("#choice18290").val("0");
	
	
	var startTime;
	var endTime;
	var name = localStorage.getItem('payaftercure_name');
	 
	 if(name){
		 jQuery("#first_row1").html( name);
		 
	 }
	
	/* ----------- SRF SECTION: On Select illness name ---- */
   jQuery("input[type=radio][name=illness_id]").on("change", function()
	 {
	 var checked_illness_radio = jQuery('input:radio[name=illness_id]:checked').val();
	 if(checked_illness_radio != undefined)
	 {
		jQuery('#illness_submit_notice').css({'display':'block', 'color': 'blue'});
		  jQuery('#frm_illness').submit();
	 }
   });
	



	/** ---------- 
	 * SRF Questioins Answers
	 *  on change question answer
	 *  ---------- */
 
	jQuery("input[name^='question']").on("change", function()
	{
	 if (!startTime)
	 {
	   startTime = new Date();
	   var counter = 0;
	   var myInterval = setInterval(function ()
		 {
			var currTime = new Date();
			var diff = Math.abs(currTime - startTime);
			var diffMin = Math.floor((diff/1000)/60); // minutes
			var diffSec = Math.floor(((diff/1000) - (diffMin * 60)));
			jQuery("input[name = 'time_spent']").val(diffMin + ' minutes ' + diffSec +  ' seconds');
			}, 1000);
 
	 // to stop the counter
	 //clearInterval(myInterval);
	 }
  });


	/** --------------- 
	 * SRF Questions Answers On select start timer
	 * on change the body actions 
	 * ----------------- */
	
	jQuery('body').on('change', '.timerOn', function ()
	{
	 if (!startTime)
	 {
	   startTime = new Date();
	   var counter = 0;
	   var myInterval = setInterval(function () {
		var currTime = new Date();
		var diff = Math.abs(currTime - startTime);
		var diffMin = Math.floor((diff/1000)/60); // minutes
		var diffSec = Math.floor(((diff/1000) - (diffMin * 60)));
		jQuery("input[name = 'time_spent']").val(diffMin + ' minutes ' + diffSec +  ' seconds');
		}, 1000);	
		}
   });
   



	/** --------------------------- 
	 * SRF Questions Answer Submit
	 * ------------------ ---------*/
	jQuery("#btn_question_submit").on("click", function(event)
	{
		var family_member = document.getElementById('family_member');
		var btn_question_submit = document.getElementById('btn_question_submit');
		var payaftercure_name1 = document.getElementById('payaftercure_name1');
	   event.preventDefault();
	   
	   //added by jobayer
	   localStorage.setItem("payaftercure_name", jQuery("#payaftercure_name1").val());
			 jQuery(this).prop("disabled", true);
			 jQuery('#page_submit_notice').css({'display': 'inline','float': 'none', 'margin-left': '15px', 'color': 'blue'});
			 endTime = new Date();
			 var diff = Math.abs(endTime - startTime);
			 var diffMin = Math.floor((diff/1000)/60); // minutes
			 var diffSec = Math.floor(((diff/1000) - (diffMin * 60)));
			 jQuery("input[name = 'time_spent']").val(diffMin + ' minutes ' + diffSec +  ' seconds');

			 if(payaftercure_name1.value.length == '')
			 {
				alert('Please write your name or select from the available options');
				btn_question_submit.removeAttribute('disabled');
				family_member.style.display = 'block';
				family_member.focus();
				exit();
			 }
			 
			 jQuery('#frm_questions').submit();
   });
  


	 /** ---------------------------------------- 
		* SRF Email send action onclick btn send  
		* ----------------------------------------- */
 
	jQuery("#btn_send_optional").on("click", function(event)
	{
	   event.preventDefault();
		 jQuery('#send_optional_spinner').removeClass("hide");
		 jQuery('#send_optional_notice_success').css({'display': 'none'});
		 jQuery('#send_optional_notice_wait').css({'display': 'inline','float': 'left', 'margin-left': '15px', 'color': 'blue'});
		 
		 var family_member;
		 
		 if (typeof jQuery('[name="add_family_member"]') !== "undefined" && jQuery('[name="add_family_member"]').val().length > 0) {
			 family_member = jQuery('[name="add_family_member"]').val();
		 } else if (typeof jQuery('[name="select_family_member"]') !== "undefined" && jQuery('[name="select_family_member"]').val().length > 0) {
			 family_member = jQuery('[name="select_family_member"]').val();
		 } else if (typeof jQuery('[name="family_member"]') !== "undefined" && jQuery('[name="family_member"]').val().length > 0) {
			 family_member = jQuery('[name="family_member"]').val();
		 } else {
			 family_member = "";
		 }
			 
			 
	   jQuery.ajax({
			method: "POST",
		 url: '../wp-content/plugins/smart-remedy-finder/srf-send-email-optional.php',
		 data: { "html": 'Patient\'s Name: ' + jQuery("textarea[name = 'optional1']").val() + '\r\n' + 'Where do you live (State/Province, Country): ' + jQuery("textarea[name = 'optional2']").val() + '\r\n' + 'Do you have any prominent physical feature e.g. stooped shoulders, eye squint, crooked nose etc.: ' + jQuery("textarea[name = 'optional4']").val() + '\r\n' + 'What is your main health problem that is bothering you the most, it has to be just one issue: ' + jQuery("textarea[name = 'optional5']").val() + '\r\n' + 'In your view, what is the cause of this issue (Emotional trauma, Physical trauma, Inherited etc.): ' + jQuery("textarea[name = 'optional6']").val() + '\r\n' + 'How long has this issue been there, years or months: ' + jQuery("textarea[name = 'optional7']").val() + '\r\n' + 'Is there a medical diagnosis & name for it, if yes, what is it: ' + jQuery("textarea[name = 'optional8']").val() + '\r\n' + 'For the main health issue, what are the symptoms you are experiencing: ' + jQuery("textarea[name = 'optional9']").val() + '\r\n' + 'What makes these symptoms better: ' + jQuery("textarea[name = 'optional10']").val() + '\r\n' + 'What makes these symptoms worse: ' + jQuery("textarea[name = 'optional11']").val() + '\r\n' + 'How do you feel emotionally during this problem: ' + jQuery("textarea[name = 'optional12']").val() + '\r\n' + 'Do you have any other health issues, if yes, what are those: ' + jQuery("textarea[name = 'optional15']").val() + '\r\n' + 'Give a timeline of of since when you have had these issues: ' + jQuery("textarea[name = 'optional16']").val() + '\r\n' + 'What illnesses are running in your mother\’s side of family: ' + jQuery("textarea[name = 'optional13']").val()  + '\r\n' + 'What illnesses are running in your father\’s side of family: ' + jQuery("textarea[name = 'optional14']").val() + '\r\n' + 'If there is something you\’d like to tell us which has not been asked above, please explain it here: ' + jQuery("textarea[name = 'optional17']").val(),
			 "email": jQuery('[name="client_email"]').val(),
			 "name": jQuery("textarea[name = 'optional1']").val(),
			 "client_name": jQuery("[name = 'client_name']").val(),
			 "country": jQuery("textarea[name = 'optional2']").val(),
			 "family_member": family_member
		 },
		 success: function( data ) {
			 jQuery('#send_optional_notice_wait').css({'display': 'none'});
			 jQuery('#send_optional_notice_success').css({'display': 'inline','float': 'left', 'margin-left': '15px', 'color': 'green'});
			 setTimeout(function () {
				window.location.href = "http://www.payaftercure.com/smart-remedy-finder?family_member=" + family_member; 
			 }, 8000); //will call the function after 8 secs.
			 
			 
		 },
		 error: function(xhr, textStatus, error){
			 jQuery('#send_optional_notice_error').css({'display': 'inline','float': 'left', 'margin-left': '15px', 'color': 'red'}); 
		 }
	 })
	 
  });   
	
	/**
	 * SRF Agree with the disclaimer check
	 */
	 jQuery('#disclaimer_check').change(function()
	 {
		 if(jQuery(this).prop("checked")) {
				 jQuery('#manage_case_div').show();
		 } else {
				 jQuery('#manage_case_div').hide();
		 }
		});
		 
		 
		 
		 
		 /** ------------------------------------------
			* SRF Prescription for Member Paid or Free 
			* manage case action 
			--------------------------------------------- */
	 jQuery("input[type=radio][name=manage_case]").on("change", function()
	 {
		 var checked_radio = jQuery('input:radio[name=manage_case]:checked').val();
		 if(checked_radio !== undefined){
			 if (checked_radio == 'Yes'){
				 jQuery('#btn_disclaimer_next').hide();
			 } else {
				 jQuery('#btn_disclaimer_next').show();
			 }	
		 }
   });
	 


	 /** ------------------------------------- 
		* SRF Summery Of Your Answers Page
		* answer check option 
		* -------------------------------------- */
	 jQuery("input[type=radio][name=answers_check]").on("change", function()
	 {
		 var checked_radio = jQuery('input:radio[name=answers_check]:checked').val();
		 if(checked_radio !== undefined){  
			 // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Apr 25, 2022, display/hide next and back buttons
			 if (checked_radio == 'Yes'){   // when next button is clicked
				  jQuery('#answers_not_correct').hide(); 
				  jQuery('#btn_summary_next').show();
			 } else {
				 jQuery('#answers_not_correct').show();
				 jQuery('#btn_summary_next').hide();
			 }	
			//  CODE EDIT END
		 }
   });
	  

	 /** ------------------------------------- 
		* SRF Summery Of Your Answers Form Submit
		* --------------------------------------  */
	  jQuery("#btn_summary_next").on("click", function(event) 
		{
		  jQuery('#progressbar2').addClass("active");
			event.preventDefault();
			jQuery('#answers_div').hide();
			jQuery('#disclaimer_div').show();
		});

	  
	 /** ------------------------------------- 
		* SRF Disclaimer Page Submit
		* Create Paid and Free User Prescription
		* Create Paid Prescription PDF
		* Sending Paid Member Email
		* -------------------------------------- */ 
	  jQuery("#btn_disclaimer_next").on("click", function(event) 
		{
		 var name_row1 = jQuery("input[name = 'html_text']").val();
		 
		 var name_new_row1 = name_row1.replace('<span id="first_row1">&nbsp;</span>', '<span id="first_row1">'+localStorage.getItem('payaftercure_name')+'</span>');
		 jQuery("input[name = 'html_text']").val(name_new_row1);
		   event.preventDefault();
			  jQuery('#progressbar3').addClass("active");
			  // amanuel updated
 
			 var manage_case = jQuery('input:radio[name=manage_case]:checked').val();
			 
			  jQuery('#disclaimer_div').hide();
			 jQuery('#prescription_div').show();
 
			// Logic for showing the code data on PRESCRIPTION tab
			// CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Apr 25, 2022, to show the data on PRESCRIPTION tab & update the PDF  HTML according to selected manage case
				
			 var pdfHtml = '';
			 /** Free user prescription action */
			 if (manage_case == 0) {
				 jQuery('.dosage_instructions').hide();
				 jQuery('#preliminary_prescription_heading').hide();
				 jQuery('.prescription_text').show();				 
				 pdfHtml = jQuery('#answers_only')[0].outerHTML+jQuery('#disclaimer_only')[0].outerHTML+jQuery('#prescription_only')[0].outerHTML+jQuery('.prescription_text')[0].outerHTML; 
			 }

			 /** Paid user prescription action */
			 if (manage_case == 1) {
				 jQuery('.dosage_instructions').show();
				 jQuery('#preliminary_prescription_heading').show();
				 jQuery('.prescription_text').hide();
				 pdfHtml = jQuery('#answers_only')[0].outerHTML+jQuery('#disclaimer_only')[0].outerHTML+jQuery('#prescription_only')[0].outerHTML+jQuery('.dosage_instructions')[0].outerHTML; 
			 }
			 // CODE EDIT END
	 
		 jQuery('#progressbar4').addClass("active");
		 
		 /* SEND EMAIL */
		 setTimeout(
		   function() 
		   {
			 //do something special
		   }, 5000);

		 jQuery('#send_email_notice_wait').css({'display': 'inline','float': 'none', 'margin-left': '15px', 'color': 'blue'});
			 jQuery.ajax({
			 method: "POST",
			 url: '../wp-content/themes/veggie-lite-child/template-parts/srf_prescription_create_ajax.php',
			 data: { 
			   "html": pdfHtml,
			   "email": jQuery("input[name = 'email']").val(),
			   "family_member": jQuery("input[name = 'family_member']").val(),
			   "illness_name": jQuery("input[name = 'illness_name']").val(),
			   "manage_case": jQuery("input[name = 'manage_case']:checked").val(),
			   "client_id": jQuery("input[name = 'client_id']").val()		
			 },
			 success: function( data )
			 {
				 jQuery('#send_email_notice_wait').css({'display': 'none'});
				 jQuery('#send_email_notice_success').css({'display': 'inline','float': 'none', 'margin-left': '15px', 'color': 'green'});
				 setTimeout(function() 
					 {
						 jQuery('#send_email_notice_success').css({'display': 'none'});
					 }, 5000);
				},
			 error: function(xhr, textStatus, error)
			 {
				 jQuery('#send_email_notice_error').css({'display': 'inline','float': 'none', 'margin-left': '15px', 'color': 'red'});
				 setTimeout(
					 function() 
					 {
						 jQuery('#send_email_notice_error').css({'display': 'none'});
					 }, 5000);
			 	}
	 		});
	 
	  }); /** #btn_disclaimer_next */
 


		/** ---------------------------------------------------
		 *  Member Portal Section From Here 
		 *  --------------------------------------------------- */
	 
}); /** document.ready */
  
	/** SRF Question Answer Show Hide  */
  function disableQuestions(question_id_list)
	{
	 var string = question_id_list + '';
	  var array = string.split(',');
		 jQuery.each( array, function( key, value ) {
			 
			 jQuery('input[name="questionradio' + value + '"]').closest('tr').addClass('hide');
			 jQuery('input[name="questioncheckbox' + value + '[]"]').closest('tr').addClass('hide');
		 });
	 }
	 
  function enableQuestions(question_id_list){
	 var string = question_id_list + '';
	  var array = string.split(',');
		 jQuery.each( array, function( key, value ) {
			 
			 jQuery('input[name="questionradio' + value + '"]').closest('tr').removeClass('hide');
			 jQuery('input[name="questioncheckbox' + value + '[]"]').closest('tr').removeClass('hide');
		 });
	 }
	 
  function hideQuestions(question_id_list){
	 var string = question_id_list + '';
	  var array = string.split(',');
		 jQuery.each( array, function( key, value ) {
			 jQuery('.tr' + value).css({'display':'none'});
		 });
	 }
	 
  function showQuestions(question_id_list){
	 var string = question_id_list + '';
	  var array = string.split(',');
		 jQuery.each( array, function( key, value ) {
			 jQuery('.tr' + value).css({'display':'table-row'});
		 });
	 }
	 
 function uncheckChoicesSection(classname){
	 jQuery(".choices" + classname).prop('checked', false);
	 console.log(classname);
	 }
	 
 function uncheckChoicesAll()
 {
	 jQuery("input[name^='question']").prop('checked', false);
	 }
 
 
 //check health care What is your weight & height question selection 14-09-2018 jobayer

 /** SRF Show Hide Questions Answers */
 jQuery("#choice5942").on("change", function() 
 {	 
	 jQuery(".questiondropdown1114").closest('tr').show();
	 jQuery(".questiondropdown1115").closest('tr').show();
	 jQuery(".questiondropdown1116").closest('tr').show();
	 
	 jQuery(".questiondropdown1117").closest('tr').hide();
	 jQuery(".questiondropdown1118").closest('tr').hide();
	 
	 calculate_bmi_step1();
 });
 
 jQuery("#choice17660").on("change", function() 
 {	 
	 jQuery(".questiondropdown1114").closest('tr').hide();
	 jQuery(".questiondropdown1115").closest('tr').hide();
	 jQuery(".questiondropdown1116").closest('tr').hide();
	 
	 jQuery(".questiondropdown1117").closest('tr').show();
	 jQuery(".questiondropdown1118").closest('tr').show();
	 
	 calculate_bmi_step2();
 });
 
 //check when lbs value changed 15-09-2018  jobayer 
 jQuery("#choice11114").on("change", function() 
 {
	 calculate_bmi_step1();
 });
 
 //check when ft value changed 15-09-2018  jobayer 
 jQuery("#choice11115").on("change", function() 
 {
	 calculate_bmi_step1();
 });
 
 //check when inches value changed 15-09-2018  jobayer 
 jQuery("#choice11116").on("change", function() 
 {
	 calculate_bmi_step1();
 });
 
 //check when kgs value changed 15-09-2018  jobayer 
 jQuery("#choice11117").on("change", function() 
 {
	 calculate_bmi_step2();
 });
 
 //check when centimeter value changed 15-09-2018  jobayer 
 jQuery("#choice11118").on("change", function() 
 {
	 calculate_bmi_step2();
 });
 
 function find_lbs_to_kg(lbs){
	 var kg = lbs/2.2;
	 return kg;
 }
 
 function ft_to_inches(ft){
	 var inches = ft*12;
	 return inches;
 }
 
 function inches_to_meter(inches){
	 var meter = (inches*2.54)/100;
	 return meter;
 }
 
 function centimeter_to_meter(centimeter){
	 var meter = centimeter/100;
	 return meter;
 }
 
 function calculate_bmi_step1()
 {
	 var lbs = jQuery("#choice11114 option:selected").text();
	 
	 if(isNaN(lbs)){
		 lbs = 0;
	 }
	 
	 var kg = find_lbs_to_kg(lbs);
	 //console.log("kg: "+kg);
	 var ft = parseFloat(jQuery("#choice11115 option:selected").text());
	 
	 if(isNaN(ft)){
		 ft = 0;
	 }
	 
	 //console.log("ft: " + ft);
	 var inches1 = ft_to_inches(ft);
	 
	 //console.log("inches1: " + inches1);
	 var inches2 = parseFloat(jQuery("#choice11116 option:selected").text());
	 
	 if(isNaN(inches2)){
		 inches2 = 0;
	 }
	 
	 //console.log("inches2: "+ inches2);
	 var total_inches = inches1 + inches2;
	 
	 var meter = inches_to_meter(total_inches);
	 //console.log("meter: "+ meter);
	 
	 var bmi = Math.round(calculate_bmi1(kg, meter));
	 //console.log("bmi: " +bmi );
	 
	 if(bmi != "Infinity"){
		 jQuery("#choice18290").val(bmi);
	 }
	 
 }
 
 function calculate_bmi_step2()
 {
	 var kg = jQuery("#choice11117 option:selected").text();
	 
	 if(isNaN(kg)){
		 kg = 0;
	 }
	 
	 //console.log("kg: "+kg);
	 
	 var centimeter = parseFloat(jQuery("#choice11118 option:selected").text());
	 
	 if(isNaN(centimeter)){
		 centimeter = 0;
	 }
	 
	 var meter = centimeter_to_meter(centimeter);
	 //console.log("meter: "+ meter);
	 
	 var bmi = Math.round(calculate_bmi1(kg, meter));
	 //console.log("bmi: " +bmi );
	 
	 if(bmi != "Infinity"){
		 jQuery("#choice18290").val(bmi);
	 }
	 
 }
 
 function calculate_bmi1(kg, meter)
 {
	 var bmi = kg/(meter*meter);
	 
	 if(isNaN(bmi)) bmi=0;
	 return bmi;
 }
 
 
 /* 21092018 Code edit by Razaul for hiding Warts in Skin question, for this to work the question shown option should first be disabled in mysql*/
 
 
 jQuery("#choice5950").click(function() 
 {
	 if (jQuery(this).is(':checked')) {
		 jQuery(".tr1033").show();
	 }else{
		 jQuery(".tr1033").hide();
	 }
	 
 });
 
  /* razaul change code 28-8-21 to fix the centimeter display problem, instead of drop down it was appearing in multiple columns and rows */
  
 jQuery("#choice17661").click(function() 
 {
	 if (jQuery(this).is(':checked')) 
	 {
		 jQuery(".tr1100").show();
		 jQuery(".tr1101").show();
		 jQuery(".tr1114").show();
		 jQuery(".tr1115").show();
		 jQuery(".tr1116").show();
		 jQuery(".tr1117").show();
		 jQuery(".tr1118").show();
		 jQuery(".tr1119").show();
		 jQuery(".tr880").show();
		 jQuery(".tr1035").show();
		 jQuery(".tr1121").show();        
		 jQuery(".tr1095").show();
		 jQuery(".tr1096").show();
		 jQuery(".tr1097").show();
		 jQuery(".tr1098").show();
		 jQuery(".tr1099").show();
		 jQuery(".tr1103").show();
		 jQuery(".tr1104").show();
		 jQuery(".tr1105").show();
		 jQuery(".tr1106").show();
		 jQuery(".tr1108").show();
		 jQuery(".tr1109").show();
		 jQuery(".tr1120").show();
		 jQuery(".tr1121").show();
		 
	 }else{
		 jQuery(".tr1100").hide();
		 jQuery(".tr1101").hide();
		 jQuery(".tr1114").hide();
		 jQuery(".tr1115").hide();
		 jQuery(".tr1116").hide();
		 jQuery(".tr1117").hide();
		 jQuery(".tr1118").hide();
		 jQuery(".tr1119").hide();
		 jQuery(".tr880").hide();
		 jQuery(".tr1035").hide();
		 jQuery(".tr1121").hide();
		 jQuery(".tr1095").hide();
		 jQuery(".tr1096").hide();
		 jQuery(".tr1097").hide();
		 jQuery(".tr1098").hide();
		 jQuery(".tr1099").hide();
		 jQuery(".tr1103").hide();
		 jQuery(".tr1104").hide();
		 jQuery(".tr1105").hide();
		 jQuery(".tr1106").hide();
		 jQuery(".tr1108").hide();
		 jQuery(".tr1109").hide();
		 jQuery(".tr1120").hide();
		 jQuery(".tr1121").hide();
	 }		 
	 
 }); 
