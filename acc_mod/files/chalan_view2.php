<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$po_no 		= $_REQUEST['v_no'];


$datas=find_all_field('purchase_invoice','s','po_no='.$po_no);

$sql1="select b.* from purchase_invoice b where b.po_no = '".$po_no."'";
$data1=db_query($sql1);


$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;
$po_date=$info->po_date;
$rec_no=$info->rec_no;
$po_no=$info->po_no;
$order_no[]=$info->order_no;
$ch_no=$info->ch_no;
$qc_by=$info->qc_by;
$entry_at=$info->entry_at;

$item_id[] = $info->item_id;
$rate[] = $info->rate;
$amount[] = $info->amount;




$unit_qty[] = $info->qty;
$unit_name[] = $info->unit_name;
}
$ssql = 'select a.* from vendor a, purchase_master b where a.vendor_id=b.vendor_id and b.po_no='.$po_no;
$dealer = find_all_field_sql($ssql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cash Memo :.</title>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--

.style11 {
	font-size: 16px;
	font-weight: bold;
}
.style14 {font-weight: bold}
.style12 {
	font-size: 16px;
	font-weight: normal;
}
.style4 {	font-size: 18px;
	color: #000000;
}
.style6 {font-size: 10px}
.style15 {
	color: #FF0000;
	font-weight: bold;
}
.style16 {color: #336600}
-->
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
		  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><? if($_SESSION['user']['depot']!=5){?><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                  <tr>
                    <td style="background-color:#FFFFCC;" style="text-align:center; color:#000000; font-size:14px; font-weight:bold;"><span class="style4">M. Ahmed Tea &amp; Lands Co. Ltd<br />
                          <span class="style6">Head Office: Dargamohalla, Sylhet. Phone: +880-821-716552</span></span></td>
                  </tr>
                  
                </table><? }else{?><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                  <tr>
                    <td style="background-color:#FFFFCC;" style="text-align:center; color:#333333; font-size:14px; font-weight:bold;"><span class="style4">M. Ahmed Tea &amp; Lands Co. Ltd<br />
                          <span class="style6">Head Office: Dargamohalla, Sylhet. Phone: +880-821-716552</span></span></td>
                  </tr>
                  
                </table><? }?></td>
              </tr>
              
              <tr>
                <td height="19">&nbsp;</td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
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
        <td style="background-color:#666666;" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">GOODS RECEIVE NOTE </td>
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
		          <td width="40%" align="right" valign="middle">Vendor Company: </td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $dealer->vendor_name;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="top"> Address:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td height="60" valign="top"><?php echo $dealer->address;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        
		        <tr>
		          <td align="right" valign="middle">GR Posting Time  :</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $entry_at;?></td>
		              </tr>
		            </table></td>
		          </tr>
				  <tr>
		          <td align="right" valign="middle">GR Rec No :</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $rec_no;?></td>
		              </tr>
		            </table></td>
		          </tr>
		        </table>		      </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td align="right" valign="middle">PO No:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><strong><?php echo $po_no;?></strong>&nbsp;</td>
                    </tr>
                </table></td>
			    </tr>
			  <tr>
                <td align="right" valign="middle"> PO Date</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?=$po_date?>
                        &nbsp;</td>
                    </tr>
                </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle">PO No: </td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $po_no;?></td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
                <td align="right" valign="middle">QC By :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?php echo $qc_by;?>&nbsp;</td>
                    </tr>
                </table></td>
			    </tr>
			  <tr>
                <td align="right" valign="middle">Chalan No  :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><strong><?php echo $ch_no;?></strong></td>
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
        <td align="center" style="background-color:#CCCCCC;"><strong>SL</strong></td>
        <td align="center" style="background-color:#CCCCCC;"><strong>Code</strong></td>
        <td align="center" style="background-color:#CCCCCC;"><div align="center"><strong>Product Name</strong></div></td>

        <td align="center" style="background-color:#CCCCCC;"><strong>Unit</strong></td>
        <td align="center" style="background-color:#CCCCCC;"><strong>Rate</strong></td>
        <td align="center" style="background-color:#CCCCCC;"><strong>Rec Qty</strong></td>
        <td align="center" style="background-color:#CCCCCC;"><strong>Amount</strong></td>
        </tr>
       
<? for($i=0;$i<$pi;$i++){?>
      
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=$item_id[$i]?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="right" valign="top"><?=$unit_name[$i]?></td>
        <td align="right" valign="top"><?=$rate[$i]?></td>
        <td align="right" valign="top"><?=$unit_qty[$i]?></td>
        <td align="right" valign="top"><?=number_format($amount[$i],2); $t_amount = $t_amount + $amount[$i];?></td>
        </tr>
<? }?>
  <td colspan="6" align="center" valign="top"><div align="right"><strong>Total Amount: </strong></div></td>
        <td align="right" valign="top"><span class="style1">
          <?=number_format($t_amount,2);?>
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
