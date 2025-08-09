<?php
/**
 * MP prescription pdf download
 * This file helping to download the prescription pdf 
 * from member portal comments section
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

if (!empty($_GET) && !empty($_GET['fn'])) {

	$file_location = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/portal/' . $_GET['cid'] . '/' . $_GET['fn'];

	$content = file_get_contents($file_location);
	header('Content-Type: application/octet-stream');
	header('Content-Length: '.strlen( $content ));
	header('Content-disposition: attachment; filename="' . $_GET['fn'] . '"');
	header('Cache-Control: public, must-revalidate, max-age=0');
	header('Pragma: public');
	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');

	echo $content;

    exit();

} else {
	echo 'error';
}