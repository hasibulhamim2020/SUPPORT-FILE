<?

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

date_default_timezone_set('Asia/Dhaka');
$tdate=  strtotime($_REQUEST['t_date']);
$fdate=  strtotime($_REQUEST['f_date']);



$t_date=  $_REQUEST['t_date'];
$f_date=  $_REQUEST['f_date'];

if($_REQUEST['t_date']<1)
{$t_date=date('Y-m-d');$tdate=  time();
}

if($_REQUEST['f_date']<1)
{$fdate=  time()-2592000;$f_date=date('Y-m-d',$fdate);
}


$dealer_code = $_REQUEST['dealer_code'];
$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);
$ledger_id = $dealer->account_code;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
    <style type="text/css" media="print">
      div.page
      {
        page-break-after: always;
        page-break-inside: avoid;
      }
    </style>
  <?
  require_once "../../../controllers/core/inc.exporttable.php";
  ?>

</head>
<body>
<!--<div align="center" id="pr">-->
<!--<input type="button" value="Print" onclick="hide();window.print();"/>-->
<!--</div>-->
<div class="main">
<?
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($t_date)) 
		$str 	.= '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		if(isset($product_group)) 
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';
		$str 	.= '</div>';
		$str 	.= '<div class="left" style="width:100%">';

//		if(isset($allotment_no)) 
//		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
//		$str 	.= '</div><div class="right">';
//		if(isset($client_name)) 
//		$str 	.= '<p>Dealer Name: '.$dealer_name.'</p>';
//		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';


?>
<div style="text-align:center"><br />
<span style=" font-size:20px;">Current Account Statement of Dealer<br /><br /></span>
<span style="font-weight:bold; font-size:14px;">Dealer Name: <?=$dealer->dealer_name_e?> - <?=$dealer->dealer_code?> - <?=$dealer->product_group?><br />
Address: <?=$dealer->address_e?>
</span>

<br /><br />

<span style="font-weight:bold; font-size:14px;">Date Interval : <?=$f_date?> - <?=$t_date?>
</span>
<br /><br />

</div>
<table id="grp"  class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
  <tr>
    <th height="20" align="center">S/N</th>
    <th align="center">Voucher</th>
    <th height="20" align="center">Tr Date</th>
    <th align="center">Particulars</th>
    <th align="center">Source</th>
    <th height="20" align="center">Dr Amt </th>
    <th align="center">Cr Amt </th>
    <th align="center">Balance</th>
  </tr>
  <?php


		$total_sql = "select sum(a.dr_amt),sum(a.cr_amt) from journal a where a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '%$ledger_id%' and a.group_for=".$_SESSION['user']['group']."";
		$total=mysqli_fetch_row(db_query($total_sql));
		
		$c="select sum(a.dr_amt)-sum(a.cr_amt) from journal a where a.jv_date<'$fdate' and a.ledger_id like '%$ledger_id%' and a.group_for=".$_SESSION['user']['group']."";

		$p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_no,a.jv_no,a.cheq_no,a.cheq_date from journal a,accounts_ledger b where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '%$ledger_id%' and b.group_for=".$_SESSION['user']['group']." order by   FROM_UNIXTIME(a.jv_date, '%Y-%m-%d'),a.tr_from";
		  

	

	if($total[0]>$total[1])
	{
		$t_type="(Dr)";
		$t_total=$total[0]-$total[1];
	}
	else
	{
		$t_type="(Cr)";
		$t_total=$total[1]-$total[0];
	}
	/* ===== Opening Balance =======*/
	
	$psql=db_query($c);
	$pl = mysqli_fetch_row($psql);

	
	$blance=$pl[0];



  ?>
  <tr>
    <td align="center" bgcolor="#FFCCFF">#</td>
    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="center" bgcolor="#FFCCFF"><?php echo $_REQUEST["fdate"];?></td>
    <td align="left" bgcolor="#FFCCFF">Opening Balance </td>
    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF"><?php if($blance>0) echo '(Dr)'.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
  </tr>
  <?php
////////////////////////////////////
  //echo $p;
  $sql=db_query($p);
  while($data=mysqli_fetch_row($sql))
  {
  $pi++;
  ?>
  <tr <?php echo ($data[4]=='Collection')?'bgcolor="#CCFF99"':''?>>
    <td align="center"><?php echo $pi;?></td>
    <td align="center"><?php echo $data[6];?></td>
    <td align="center"><?php echo date("d.m.y",$data[0]);?></td>
    <td align="left"><?=$data[5];?><?=(($data[9]!='')?'-Cq#'.$data[9]:'');?><?=(($data[10]>943898400)?'-Cq-Date#'.date('d-m-Y',$data[10]):'');?></td>
    <td align="center"><?php echo $data[4];?></td>
    <td align="right"><?php echo number_format($data[2],2);?></td>
    <td align="right"><?php echo number_format($data[3],2);?></td>
    <td align="right"><?php $blance = $blance+($data[2]-$data[3]); if($blance>0) echo '(Dr)'.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <th colspan="4" align="center"><font color="#FF0000"> Balance : 
      <?php $blance = $blance+($data[2]-$data[3]); if($blance>0) echo '(Dr)'.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?>
</font></th>
    <th align="right"><strong>Total : </strong></th>
    <th align="right"><strong><?php echo number_format($total[0],2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total[1],2);?></strong></th>
    <th align="right">&nbsp;</th>
  </tr>
  <?php ?>
</table>
</div>
</body>
</html>