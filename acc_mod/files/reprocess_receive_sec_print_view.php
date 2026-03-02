<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$jv_no=$_REQUEST['jv_no'];

$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);



$jv_no=$_REQUEST['jv_no'];

if(prevent_multi_submit()){

if($_POST['check']=='CHECK')

{

	$time_now = date('Y-m-d H:s:i');

	$voucher_date = $_POST['voucher_date'];



	$jv=next_journal_voucher_id();

	
$ssql='update secondary_journal set jv_date="'.$voucher_date.'", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'", checked="YES" where jv_no="'.$jv_no.'"';

	db_query($ssql);

	

	sec_journal_journal($jv_no,$jv,'Reprocess Receive');

}

if($_POST['calculate']=='RE-CALCULATE')

{

$jv = find_all_field('secondary_journal','jv_date','jv_no='.$jv_no);

$ch = find_all_field('warehouse_other_issue','pr_no','oi_no='.$jv->tr_no);

$receive_date = $_POST['calculate_date'];

$ssql='update warehouse_other_issue set receive_date="'.$receive_date.'" where oi_no="'.$jv->tr_no.'"';

db_query($ssql);

$ssql='delete from secondary_journal where  tr_from="Reprocess Issue" and tr_no="'.$jv->tr_no.'" ';

db_query($ssql);

$ssql='delete from journal where  tr_from="Reprocess Issue" and tr_no="'.$jv->tr_no.'" ';

db_query($ssql);

auto_insert_sales_return_secoundary($jv->tr_no);

	$jv_no = find_a_field('secondary_journal','jv_no','tr_from="Reprocess Issue" and tr_no="'.$jv->tr_no.'" ');



}

}



$address=find_a_field('project_info','proj_address',"1");



$jv = find_all_field('secondary_journal','jv_date','jv_no='.$jv_no);

$ch = find_all_field('warehouse_other_issue','pr_no','oi_no='.$jv->tr_no);





?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Voucher :.</title>

<link href="../css/voucher_print.css" type="text/css" rel="stylesheet"/>



<link href="../../warehouse_mod/css/pagination.css" rel="stylesheet" type="text/css" />

<link href="../../warehouse_mod/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />

<link href="../../warehouse_mod/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="../../warehouse_mod/js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/jquery-ui-1.8.2.custom.min.js"></script>



<script type="text/javascript" src="../../warehouse_mod/js/jquery.autocomplete.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/jquery.validate.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/paging.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/ddaccordion.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/js.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/jquery.ui.datepicker.js"></script>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

function DoNav(theUrl)

{

	var URL = 'voucher_sec_view_popup.php?'+theUrl;

	popUp(URL);

}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<? do_calander('#voucher_date');?><? do_calander('#calculate_date');?>

<style type="text/css">

<!--

.style1 {

	color: #FFFFFF;

	font-weight: bold;

}

-->

</style>

</head>

<body>

<table width="820" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><div class="header">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="1%">

			<? $path='../logo/'.$_SESSION['proj_id'].'.jpg';

			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?>			</td>

            <td width="83%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td align="center" class="title">



				<?

if($_SESSION['user']['group']>1)

echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);

else

echo $_SESSION['proj_name'];

				?>                </td>

              </tr>

              <tr>

                <td align="center"><?=$address?></td>

              </tr>

              <tr>

                <td align="center"><table  class="debit_box" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td>&nbsp;</td>

                      <td width="325"><div align="center">JOURNAL VOUCHER</div></td>

                      <td>&nbsp;</td>

                    </tr>

                  </table></td>

              </tr>

            </table></td>

          </tr>



        </table></td>

	    </tr>

	  <tr>

	    <td>&nbsp;</td>

	  </tr>

    </table>

    </div></td>

  </tr>

  <tr>

    

	<td>	</td>

  </tr>

  

  <tr>



    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="2" class="tabledesign_text">



<div id="pr">

<? if($jv->checked!='YES'){?>

<div align="left">

<form action="" method="post">

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

  <tr>

    <td width="1" rowspan="2"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

    <td width="180" rowspan="2" align="right"><a target="_blank" href="#">PR-

        <?=$ch->oi_no?>

    </a></td>

    <td align="right">Voucher Date :</td>

    <td><input name="jv_no" type="hidden" value="<?=$jv_no?>" />

        <input name="voucher_date" type="text" id="voucher_date" value="<?=$jv->jv_date;?>" />

        <input name="oi_no" type="hidden" value="<?=$ch->oi_no?>" />    </td>

    <td><? if($jv->checked=='NO' || $jv->checked==''){?>

        <input name="check" type="submit" id="check" value="CHECK" style="font-size:12px; color:#990000" />

      <? }?>

        <input type="hidden" name="req_no" id="req_no" value="<?=$jv->jv_on?>" /></td>

  </tr>

  <tr>

    <td width="120" align="right">&nbsp;</td>


    <td>&nbsp;</td>

  </tr>

</table>

</form>

<a target="_blank" href="reprocess_issue_report.php?v_no=<?=$ch->oi_no?>"></a></div><? }else{?>

<div align="left">

<form action="" method="post">

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#339900">

  <tr>

    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

    <td width="200" align="right"><a target="_blank" href="reprocess_issue_report.php?v_no=<?=$ch->oi_no?>">PR-

        <?=$ch->oi_no?>

    </a></td>

    <td width="150" align="right">&nbsp;</td>

    <td width="0"><div align="center"><span class="style1">CHECKED</span></div></td>

    <td width="120">&nbsp;</td>

    <td width="1">&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

</table>

</form>

<a target="_blank" href="../../warehouse_mod/pages/pr/chalan_view2.php?v_no=<?=$ch->pr_no?>"></a></div><? }?>

</div></td>

        </tr>

      <tr>

        <td width="50%" class="tabledesign_text">Voucher Date :

          <?=$jv->jv_date;?></td>

        <td class="tabledesign_text">&nbsp;</td>

      </tr>

      <tr>

        <td class="tabledesign_text"> Voucher No  : <?=$jv_no?></td>

        <td class="tabledesign_text">Checked By :

          <? if($jv->checked=='YES') echo find_a_field('user_activity_management','username','user_id='.$jv->checked_by); else echo 'Not Checked';?></td>

      </tr>

    </table></td>

  </tr>

  

  <tr>

    <td class="tabledesign_text">SR : 

        <?=$ch->oi_no?></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td><? if($cccode>0){?>CC CODE/PROJECT NAME: <? echo find_a_field('cost_center','center_name',"id='$cccode'")?><? }?></td>

  </tr>

  <tr>

    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign" style="font-size:12px">

      <tr>

        <td align="center"><div align="center">SL</div></td>

        <td align="center">A/C Head </td>

        <td align="center">Particulars</td>

        <td>Debit</td>

        <td>Credit</td>

      </tr>

      

	  <?

$sql2="SELECT a.ledger_id,a.ledger_name,cr_amt,dr_amt,narration FROM accounts_ledger a, secondary_journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id";

$data2=db_query($sql2);

while($info=mysqli_fetch_object($data2)){		  

	  ?>

      <tr>

        <td align="left"><div align="center">

          <?=++$s;?>

        </div></td>

        <td align="left"><?=$info->ledger_id?> - 

          <?=$info->ledger_name?></td>

        <td align="left"><?=$info->narration?></td>

        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>

        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>

        </tr>

<?php }?>

      <tr>

        <td colspan="3" align="right">Total Taka: </td>

        <td align="right"><?=number_format($ttd,2)?></td>

        <td align="right"><?=number_format($ttc,2)?></td>

        </tr>

      

    </table></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>Amount in Word : 



	 (<? echo convertNumberMhafuz($ttc)?>)	 </td>

  </tr>

  <tr>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td class="tabledesign_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td align="center" valign="bottom">................................</td>

        <td align="center" valign="bottom">................................</td>

        <td align="center" valign="bottom">................................</td>

        <td align="center" valign="bottom">................................</td>

      </tr>

      <tr>

        <td width="33%"><div align="center">Received by </div></td>

        <td width="33%"><div align="center">Prepared by </div></td>

        <td width="33%"><div align="center">Head of Accounts </div></td>

        <td width="34%"><div align="center">Approved By </div></td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

  </tr>

</table>

</body>

</html>

