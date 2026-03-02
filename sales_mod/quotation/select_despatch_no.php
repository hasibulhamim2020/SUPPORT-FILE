<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Despatch Re Order Entry';

$table = 'requisition_fg_master';
$unique = 'req_no';
$status = 'CHECKED';
$target_url = '../fr/despatch_re_entry.php';

if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}

?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong><?=$title?> : </strong></td>
    <td bgcolor="#FF9966"><strong>
    
	  
	<?
	auto_complete_from_db('requisition_fg_master','req_no','req_no','warehouse_id='.$_SESSION['user']['depot'].' and status in ( "CHECKED")','req_no');
	?>
	
	<input name="<?=$unique?>" type="text" id="<?=$unique?>" style="width:180px;" required />
	
	 
	  
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>