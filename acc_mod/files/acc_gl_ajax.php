<?php


session_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $str = $_POST['data'];


  $data=explode('##',$str);


  $data_id=$data[0];
  
  //$ledger=explode('::',$data_id);
  
  //$ledger_id=$ledger[0];




?>




				<select name="ledger_id" id="ledger_id"  style="width:320px;">
					
					<option></option>

                      <? foreign_relation('accounts_ledger','ledger_id','concat(ledger_id," - ",ledger_name)',$ledger_id,'ledger_group_id="'.$data_id.'" order by ledger_id');?>

                    </select>

