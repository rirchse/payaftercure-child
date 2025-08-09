<?php
/**
 * SRF Prescription Generator
 * This file creates the final list of medicines based on user inputs
 * It uses the remedy grades and other conditions
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

    $mpdf=new mPDF();
    $mpdf->useGraphs = true;
    $mpdf->showImageErrors = true;
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($post_html, 2);
    
    // CODE EDIT BEGIN: Shubham, Upwork Profile Link: https://www.upwork.com/freelancers/~01be7c4b0821b12d99, Aug 20, 2022, Created new directory for every user presrciption so that presrciption does not get overwrite
    $upload_dir = wp_upload_dir()['basedir'] . '/prescriptions/' . get_current_user_id() . '/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
        $mpdf->Output('../../../../wp-content/uploads/prescriptions/'.get_current_user_id().'/Prescription.pdf','F');        
    }else{
        $mpdf->Output('../../../../wp-content/uploads/prescriptions/'.get_current_user_id().'/Prescription.pdf','F');
    }
    // CODE END