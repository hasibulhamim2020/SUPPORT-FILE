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
 
 $jv_val=find_a_field('journal','count(id)',"tr_no='".$tr_no."' and tr_from='Contra'");
 
  if($jv_val>0){
 $del_jv = "delete from journal where tr_from='Contra' and tr_no = '".$tr_no."'";
 db_query($del_jv);
}



 
 

$ledger_id = $in[0];
$reference_id = $in[1];
$cc_code = $in[2];
$narration = $in[3];
$dr_amt = $in[4];
$cr_amt = $in[5];
$flag = $in[6];


$edit_by=$_SESSION['user']['id'];
$edit_at=date('Y-m-d H:i:s');

if ($dr_amt==0 & $cr_amt==0) {

 $del_id = "delete from secondary_journal where tr_from='Contra' and tr_no = '".$tr_no."' and id = '".$order_id."' ";
 db_query($del_id);

echo 'Deleted!';

}else {

$new_sql="UPDATE secondary_journal SET 
			ledger_id = '".$ledger_id."',
			narration = '".$narration."',
			dr_amt = '".$dr_amt."',
			cr_amt = '".$cr_amt."',
			reference_id = '".$reference_id."',
			cc_code = '".$cc_code."', 
					
			edit_by = '".$edit_by."',	
			edit_at = '".$edit_at."'		
			WHERE id = '".$order_id."'";
			
			db_query($new_sql);

	
echo 'Success!';

	
}


?>

<!--<strong>Done</strong>-->