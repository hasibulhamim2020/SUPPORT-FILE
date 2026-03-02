<?php


session_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $str = $_POST['data'];


  $data=explode('##',$str);


  $data_id=$data[0];
  
  $ledger=explode('::',$data_id);
  
  $ledger_id=$ledger[0];




?>






<table width="100%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #C1DAD7;" cellpadding="2" cellspacing="2">
	<tr> 
		<td width="51%" class="p-0"><input type="text" class="form-control" id="ledger_name" name="ledger_name"  value="<?=find_a_field('accounts_ledger','ledger_name','ledger_id='.$ledger_id);?>" style="width:250px;" readonly/>
		<input type="hidden" class="input1" id="reference_id" name="reference_id"  value="" style="width:250px;" />
		
<?php /*?>			<select name="reference_id" id="reference_id"  style="width:120px;">
  <option></option>
  <? foreign_relation('acc_reference','id','reference_name',$reference_id,"ledger_id='".$ledger_id."'");?>
</select><?php */?>		</td>
	</tr>
</table>

