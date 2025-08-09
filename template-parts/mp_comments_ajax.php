<?php
/**
 * MP Comments
 * This file using for collecting comments data from database
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


 $protocol = isset($_SERVER['HTTPS'])?'https://':'http://';
 $host = $protocol.$_SERVER['HTTP_HOST'];

if (!empty($_POST) ) 
{
    require('../../../../wp-load.php'); // Load Wordpress API
    global $wpdb;

    $current_user = wp_get_current_user();

    if ( current_user_can('administrator') ) 
    {
        $client = $wpdb->get_row("SELECT client_email FROM srf_family_member WHERE family_member_name ='". $_POST['family_member']."' AND client_email = '".$_GET['email']."' LIMIT 1");

        $client_email = $client->client_email;
        
        // $client_email = ($_GET['email'])?($_GET['email']):($current_user->user_email);
    } 
    else 
    {
        $client_email = $current_user->user_email;
    }
    
    
    /** 
     * MP Comment for Admin
     */
    if ( current_user_can('administrator') ) {
        $actions = ', CONCAT(\'<a href="'.$host.'/member-portal/?email=' . $client_email . '&action=edit&id=\', cu.update_id, \'&case_id=\', cu.update_id, \'">Edit</a>\', 
        \'<br>\', 
        \'<a href="'.$host.'/member-portal/?email=' . $client_email . '&family_member_name='.$_POST["family_member"].'&action=delete&id=\', cu.update_id, \'" onclick="return confirm(\\\'Are you sure, You want to delete this comment?\\\')">Delete</a>\') AS actions';
    } else {
        $actions = ', \'\' AS actions';
    }
    
     if (isset($_GET["family_member"]) && strlen($_GET["family_member"]) > 0) 
     {
         $family_member = $_GET["family_member"];
     }
     elseif (isset($_POST["family_member"]) && strlen($_POST["family_member"]) > 0) 
     {
         $family_member = $_POST["family_member"];
     } 
     else 
     {
         $family_member = '4464564646464646464646434353535';
     }

    /* Useful $_POST Variables coming from the plugin */
    $draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
    $orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
    $orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
    $orderType = $_POST['order'][0]['dir']; // ASC or DESC
    $start  = $_POST["start"];//Paging first record indicator.
    $length = $_POST['length'];//Number of records that the table can display in the current draw
    /* END of POST variables */
    
    $select = 'CONCAT(cu.date_submitted, \'\<br\>\', cu.family_member_name, \'\<br\>\', us.display_name) AS post_by, CONCAT(cu.comments, \'\<br\>\', CASE WHEN CHAR_LENGTH(cu.case_photo) > 0 THEN CONCAT(\'<div><a style="color:#00f" download="" href="\',cu.case_photo,\'">Download Case Photo</a> <i class="fa fa-eye" onclick="view(this)" title="View"></i><img src="/" alt=""><br><a style="color:#a00" path="\',cu.case_photo,\'" onclick="delCasePhoto(this)">X Delete case photo</a></div>\') ELSE \'\' END) AS comments, 
    CASE WHEN cu.is_admin = 1 THEN
        CONCAT(cu.illness_name, \'\<br\>\', 
        CASE WHEN CHAR_LENGTH(cu.filename) > 0 THEN 
        CONCAT(\'<a href="javascript:void(0);" class="portal_attachment" data-fn="\', cu.filename , \'">Attachment</a>
        \') ELSE \'\' END )
    ELSE
        CONCAT(cu.illness_name, \'\<br\>\', 
        cu.improvement, \'%\, \', 
        \'<i class="fa \', CASE WHEN cu.satisfaction = \'Better\' THEN \'fa-smile-o\' WHEN cu.satisfaction = \'Unchanged\' THEN \'fa-meh-o\' WHEN cu.satisfaction = \'Worse\' THEN \'fa-frown-o\' ELSE \'\' END, \'" aria-hidden="true"></i>, 
        <span style="color:\', CASE WHEN cu.energy_level = \'Better\' THEN \'green\' WHEN cu.energy_level = \'Unchanged\' THEN \'gray\' WHEN cu.energy_level = \'Worse\' THEN \'red\' ELSE \'\' END, \'">Energy</span>, 
        <span style="color:\', CASE WHEN cu.feeling_emotionally = \'Better\' THEN \'green\' WHEN cu.feeling_emotionally = \'Unchanged\' THEN \'gray\' WHEN cu.feeling_emotionally = \'Worse\' THEN \'red\' ELSE \'\' END, \'">Emotions</span>, 
        <span style="color:\', CASE WHEN cu.main_problem = \'Better\' THEN \'green\' WHEN cu.main_problem = \'Unchanged\' THEN \'gray\' WHEN cu.main_problem = \'Worse\' THEN \'red\' ELSE \'\' END, \'">Main Problem</span>, 
        <span style="color:\', CASE WHEN cu.discharge = \'Yes\' THEN \'green\' WHEN cu.discharge = \'No\' THEN \'gray\' ELSE \'\' END, \'">Discharge</span>
        <br>\', CASE WHEN CHAR_LENGTH(cu.filename) > 0 THEN 
        CONCAT(\'<a href="javascript:void(0);" class="portal_attachment" data-fn="\', cu.filename , \'">Attachment</a>
        \') ELSE \'\' END)
    END AS dashboard_attachments' . $actions;
    $from = 'srf_case_update cu JOIN pay_users us ON cu.email = us.user_email ';

    $records_total = "SELECT * FROM srf_case_update WHERE client_email = '" . $client_email . "'";
	$records_total .= " AND family_member_name = '" . $family_member . "'";

    $recordsTotal = count($wpdb->get_results($records_total));

    /* SEARCH CASE : Filtered data */
    if(!empty($_POST['search']['value']))
    {
        /* WHERE Clause for searching */
        for($i=0 ; $i<count($_POST['columns']);$i++){
            $column = $_POST['columns'][$i]['data'];//we get the name of each column using its index from POST request
            $where[]="$column like '%".$_POST['search']['value']."%'";
        }

        $where = "WHERE ".implode(" OR " , $where);// id like '%searchValue%' or name like '%searchValue%' ....
	    $where .= " AND cu.client_email = '" . $client_email . "'";
	    $where .= " AND cu.family_member_name = '" . $family_member . "'";
        /* End WHERE */

        $sql = sprintf("SELECT * FROM %s %s", $from, $where);//Search query without limit clause (No pagination)
        $recordsFiltered = count($wpdb->get_results($sql));//Count of search result

        /* SQL Query for search with limit and orderBy clauses*/
        $sql = sprintf("SELECT * FROM %s %s ORDER BY %s %s limit %d , %d ", $from, $where, $orderBy, $orderType, $start, $length);

        $data = $wpdb->get_results($sql);
    }
    /* END SEARCH */
    else 
    {
       	$where = " WHERE cu.client_email = '" . $client_email . "'";
		$where .= " AND cu.family_member_name = '" . $family_member . "'";

	    $sql = sprintf("SELECT %s FROM %s %s ORDER BY %s %s limit %d , %d ", $select, $from, $where, $orderBy, $orderType, $start, $length);
        $data = $wpdb->get_results($sql);

        $recordsFiltered = $recordsTotal;
    }

	$family_member_sql = sprintf("SELECT * FROM srf_family_member WHERE client_email = '%s' AND family_member_name = '%s' ORDER BY created_at DESC", $client_email, $family_member);

    $family_member_data = $wpdb->get_row($family_member_sql);

    /* Response to client before JSON encoding */
    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $recordsFiltered,
        "data" => $data,
		"main_health_problem" => $family_member_data->main_health_problem,
		"last_payment_date" => $family_member_data->last_payment_date
    );

    echo json_encode($response);
} else {
    echo "NO POST Query from DataTable";
}
?>