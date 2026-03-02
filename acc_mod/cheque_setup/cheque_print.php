<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once "../../../controllers/core/class.numbertoword.php";


	 //$id = url_decode(str_replace(' ', '+', $_REQUEST['id']));
	 $id = $_GET['id'];
	 
	 $style_css = find_a_field('chq_setup_master','chq_id','id='.$id);
	$data = find_all_field('chq_setup_master','*','id='.$id);
	$master= find_all_field('chq_setup','*','id='.$data->chq_id);
	
	 $data2 = "SELECT m.*,d.id,d.bank_name,d.acct_name,d.acct_number,d.acct_payee FROM chq_setup_master m, chq_setup d WHERE m.id = '".$id."' and m.chq_id = d.id;";
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cheqe Design :.</title>
	<?php include("../../../../public/assets/css/theme_responsib_cheque.php");?>
	
	
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>    
    <div id="pr" style="padding-top: 36mm;">
		<button name="button" type="button" onclick="hide(); window.print();" value="Print" style=" width: 55px; cursor: pointer;">
			<img src="../../../../public/assets/images/print.png" width="40" height="40">
		</button>
		
    </div>

		<div class="chq-content rotate-print">
		<div class="account-payee"><?=date('d-m-Y');?></div>
		<div class="chq-date">
			<? $date= date("dmY",strtotime($data->chq_date));
				$array = str_split($date);
			?>
			<div class="latter1"><?=$array[0];?></div>
			<div class="latter2"><?=$array[1];?></div>
			<div class="latter3"><?=$array[2];?></div>
			<div class="latter4"><?=$array[3];?></div>
			<div class="latter5"><?=$array[4];?></div>
			<div class="latter6"><?=$array[5];?></div>
			<div class="latter7"><?=$array[6];?></div>
			<div class="latter8"><?=$array[7];?></div>
		</div>
		<div class="chq-pay-name"><?=$data->payee_name;?></div>
		<div class="bearer"><?=$data->payee_name;?></div>
		
		<div class="chq-inwords-n1"><? echo convertNumberMhafuz($data->amount);?></div>
		
		<div class="amount">**<?=number_format($data->amount);?>**</div>

		<div class="muri_amount"><?=number_format($data->amount);?> /-</div>
		</div>

</body>
</html>