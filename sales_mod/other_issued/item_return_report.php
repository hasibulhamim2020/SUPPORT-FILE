<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$pr_no 		= $_REQUEST['v_no'];


$datas=find_all_field('purchase_return_details','s','pr_no='.$pr_no);
$vendor = find_all_field('vendor','s','vendor_id='.$datas->vendor_id);
$sql1="select b.* from purchase_return_master b where b.pr_no = '".$pr_no."'";
$data1=db_query($sql1);

//auto_insert_sales_return_secoundary('9027');

$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$rec_frm=$info->vendor_name;
$vendor_name=$info->vendor_name;
$vendor_id=$info->vendor_id;
$or_subject=$info->or_subject;
$pr_date=$info->pr_date;
$remarks=$info->remarks;
}

$sql1="select b.* from purchase_return_details b where b.pr_no = '".$pr_no."'";
$data1=db_query($sql1);

$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;

$order_no[]=$info->order_no;
$qc_by=$info->qc_by;

$item_id[] = $info->item_id;
$rate[] = $info->unit_price;
$amount[] = $info->total_amt;

$unit_qty[] = $info->total_unit;
$unit_name[] = $info->unit_name;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Purchase Return  Report :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">Purchase Return  Report </td>
      </tr>
    </table></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="top">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
		        <tr>
		          <td width="40%" align="right" valign="middle">Dealer Name : </td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $vendor->vendor_name;?> - &nbsp;<?php echo $vendor->vendor_id;?></td>
		              </tr>
		            </table></td>
		          </tr>
		        
		        
		        <tr>
                  <td align="right" valign="middle"> Address :</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                      <tr>
                        <td><?=$vendor->address.'<br>Mobile: '.$vendor->contact_no?>&nbsp;</td>
                      </tr>
                  </table></td>
		          </tr>
		          <td align="right" valign="middle"> Note :</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $remarks;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
                  
		        <tr>
		        </table>		      </td>
			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td width="38%" align="right" valign="middle">PR No :</td>
			    <td width="62%"><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><strong><?php echo $pr_no;?></strong>&nbsp;</td>
                    </tr>
                </table></td>
			    </tr>
			  <tr>
                <td align="right" valign="middle"> PR Date :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?=date("d M, Y",strtotime($pr_date))?>
                        &nbsp;</td>
                    </tr>
                </table></td>
			    </tr>
				<tr>
                  <td align="right" valign="middle"> Received By :</td>
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                      <tr>
                        <td><?php echo $datas->qc_by;?>&nbsp;</td>
                      </tr>
                  </table></td>
				  </tr>
				
				<tr>
                  <td align="right" valign="middle">Store PR No : </td>
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                      <tr>
                        <td><?php echo $datas->manual_or_no;?>&nbsp;</td>
                      </tr>
                  </table></td>
				  </tr>

			  </table></td>
		  </tr>
		</table>		</td>
	  </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  
  <tr>
    <td>
      <div id="pr">
  <div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
  </div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
       <tr>
        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>
        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Rec Qty</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Amount</strong></td>
        </tr>
       
<? for($i=0;$i<$pi;$i++){
$item = find_all_field('item_info','item_name','item_id='.$item_id[$i]);

?>
      
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=$item->finish_goods_code?></td>
        <td align="left" valign="top"><?=$item->item_name;?></td>
        <td align="right" valign="top"><?=$item->unit_name?></td>
        <td align="right" valign="top"><?=$rate[$i]?></td>
        <td align="right" valign="top"><?=$unit_qty[$i]?></td>
        <td align="right" valign="top"><?=$amount[$i]; $t_amount = $t_amount + $amount[$i];?></td>
        </tr>
<? }?>
  <td colspan="6" align="center" valign="top"><div align="right"><strong>Total Amount: </strong></div></td>
        <td align="right" valign="top"><span class="style1">
          <?=$t_amount?>
        </span></td>
    </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per Terms</em></td>
    </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong><br />
      </strong>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center">Received By </div></td>
          <td><div align="center">Quality Controller </div></td>
          <td><div align="center">Store Incharge </div></td>
          </tr>
      </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    </table>
    <div class="footer1"> </div>
    </td>
  </tr>
</table>
</body>
</html>
