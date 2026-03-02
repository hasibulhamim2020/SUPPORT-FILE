<?php
session_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$order_id=$data[0];
$info = $data[1];
$in = explode('<@>',$info);

 $tr_no = find_a_field('secondary_journal','tr_no','id='.$order_id);

 $jv_val=find_a_field('journal','count(id)',"tr_no='".$tr_no."' and tr_from='Payment'");
 $sj_val=find_a_field('secondary_journal','count(id)',"tr_no='".$tr_no."' and tr_from='Payment' and cr_amt>0");
 
 
 if($jv_val>0){
 $del_jv = "delete from journal where tr_from='Payment' and tr_no = '".$tr_no."'";
 db_query($del_jv);
}

if($sj_val>0){
 $del_sj = "delete from secondary_journal where tr_from='Payment' and tr_no = '".$tr_no."' and cr_amt>0";
 db_query($del_sj);
}

 
 

$ledger_id = $in[0];
$reference_id = $in[1];
$cc_code = $in[2];
$narration = $in[3];
$dr_amt = $in[4];
$flag = $in[5];


$edit_by=$_SESSION['user']['id'];
$edit_at=date('Y-m-d H:i:s');

if ($dr_amt>0) {

			$new_sql="UPDATE secondary_journal SET 
			ledger_id = '".$ledger_id."',
			narration = '".$narration."',
			dr_amt = '".$dr_amt."',
			reference_id = '".$reference_id."',
			cc_code = '".$cc_code."', 
					
			edit_by = '".$edit_by."',	
			edit_at = '".$edit_at."'		
			WHERE id = '".$order_id."'";
			
			db_query($new_sql);
			
			
		
	
	
echo 'Success!';	

}else {

 $del_id = "delete from secondary_journal where tr_from='Payment' and tr_no = '".$tr_no."' and id = '".$order_id."' ";
 db_query($del_id);

echo 'Deleted!';	
}


?>

<!--<strong>Done</strong>-->