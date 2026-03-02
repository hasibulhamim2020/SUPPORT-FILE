<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
include "../common/check.php";
require "../common/db_connect.php";
require "../classes/db.php";
require_once ('../../common/class.numbertoword.php');
$proj_id	= $_SESSION['proj_id'];
$vtype		= $_REQUEST['v_type'];
$vdate		= $_REQUEST['vdate'];
$v_no 		= $_REQUEST['v_no'];
$no 		= $vtype."_no";
$in		= $_REQUEST['in'];

if($_GET['update']=='Update')
{
	$pur_status = $_GET['pur_status'];
	$ssql='update purchase_invoice set pur_status="'.$_GET['pur_status'].'" where p_inv_id="'.$v_no.'"';
	db_query($ssql);
}


$receiver='Vendor'; 
$i_no='p_inv_id';



$sql1="select * from purchase_invoice where p_inv_id='$v_no'";
$data=mysqli_fetch_object(db_query($sql1));
$vendor=find_all_field('vendor','','vendor_id='.$data->vendor );
$whouse=find_all_field('warehouse','','warehouse_id='.$data->warehouse_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cash Memo :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center"><strong style="font-size:24px">Purchase Order</strong></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  <tr>
    <td><div class="line"></div></td>
  </tr>
  <tr>
    <td><p><span style="font-size:10px">
    	</span></p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top"><span style="font-size:10px"><span style="font-size:20px; font-style:italic"><strong>
            <?=$vendor->vendor_name;?>
          </strong></span><br />

<?=$vendor->address;?>
<br />
Attn:
<?=$vendor->vendor_company;?>
<br />
<?=$vendor->contact_person_designation;?><br />
          </span></td>
          <td valign="top"><span style="font-size:10px">&nbsp;&nbsp;&nbsp;Ref#WO/ID/
              <?=$data->p_inv_id?>
              <br />
&nbsp;&nbsp;&nbsp;P. Requisition:
<?=$data->req_no?>
<br />
&nbsp;&nbsp;&nbsp;Date:
<?=$data->purchase_date?>
          </span></td>
        </tr>
      </table>   <br />
      <?=$vendor->vendor_company;?>, <br />
        In reference to your quotation ref no: <? if($data->quotation_no=='') echo 'NIL'; else echo $data->quotation_no;?> Dated at : <? if($data->quotation_date=='') echo 'NIL'; else echo $data->quotation_date;?>.<br />
</span>
        <span class="debit_box">
        </div>
    </span></td>
  </tr>
  <tr>
    <td><div id="pr">
      <div align="left">
        <form action="" method="get">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
              <td width="100" align="right">Present Status:</td>
              <td width="1"><select name="pur_status">
                <option>
                  <?=$data->pur_status;?>
                  </option>
                <option>PENDING</option>
                <option>STOPPED</option>
                <option>CANCELED</option>
                <option>COMPLETE</option>
              </select></td>
              <td><input name="update" type="submit" value="Update" />
                <input type="hidden" name="v_no" id="v_no" value="<?=$v_no?>" /></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="8%"><strong>SL/No</strong></td>
        <td width="54%"><div align="center"><strong>Description of the Goods </strong></div></td>
        <td width="9%"><strong>Qty.</strong></td>
        <td width="15%"><strong>Unit Price </strong></td>
        <td width="14%"><strong>Total Price </strong></td>
      </tr>
	  <?php
$final_amt=0;
$pi=0;
$total=0;
$sql2="select * from purchase_invoice where p_inv_id='$v_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$amount[]=$info->qty*$info->rate;
$total=$total+($info->qty*$info->rate);
$sl[]=$pi;
$item[]=find_a_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item);
$qty[]=$info->qty;
$rate[]=$info->rate;
$disc=$info->disc;
}?>
      <tr>
        <td height="200" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$sl[$i]?></p><? }?></td>
        <td align="left" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$item[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$qty[$i]?></p><? }?></td>
        <td align="right" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=number_format($rate[$i],2)?></p><? }?></td>
        <td align="right" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=number_format($amount[$i],2)?></p><? }?></td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td align="right">Total:</td>
        <td align="right"><strong><?php echo number_format($total,2);?></strong></td>
      </tr>
    </table>
      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
		<td>In Word: Taka <? $xamt = (int)($data->total_amt);echo convertNumberMhafuz(($xamt));?> Only</td>
          <td align="right">Discount:</td>
          <td align="right"><strong><? if($data->total_disc>0) echo number_format(((($data->total_disc)/100)*$total),2); else echo '0.00';?></strong></td>
        </tr>
        <tr>
		<td align="right">&nbsp;</td>
          <td align="right">Tax/Vat(15%):</td>
          <td align="right"><strong>0.00</strong></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right">Grand Total:</td>
          <td align="right"><strong>
            <?=number_format($data->total_amt,2);?>
          </strong></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><p><strong>Terms &amp; Conditions: </strong></p>
            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:9px">
              <tr>
                <td width="20%" align="left" valign="top">
                  <li>Delivery</li>
                </td>
                <td width="3%" align="right" valign="top">: </td>
                <td align="left" valign="top"> Within <? if($data->delivery_within>0) echo $data->delivery_within.' ('.CLASS_Numbertoword::convert(((int)$data->delivery_within),'en').') '; else echo ' 90 (Ninty)'?>  Days from the date of Work-Order<strong> (Delivery Period is strictly defined)</strong></td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  <li>Delivery Spot</li>
                </td>
                <td align="right" valign="top">:</td>
                <td align="left" valign="top"> <strong><?=$whouse->address?></strong></td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  <li>Payment</li>
                </td>
                <td align="right" valign="top">:</td>
                <td align="left" valign="top">After 30 (Thirty) Days from the date of receiving all goods at our factory.</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  <li>Bill Submit</li>
                </td>
                <td align="right" valign="top">:</td>
                <td align="left" valign="top">Shezan Point(5th Floor) 2, Indira Road Farmgate, Dhaka-1215.<strong>(Copy of Work-Order must be attached with original bill)</strong></td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  <li>Defined</li>
                </td>
                <td align="right" valign="top">:</td>
                <td align="left" valign="top">Supplied goods will be same as approved sample, otherwise the goods must be replaced &amp; you will bare all expenses.</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  <li>Contact Person</li>
                </td>
                <td align="right" valign="top">:</td>
                <td align="left" valign="top"><strong><?=$whouse->warehouse_company?>. Mobile No: <?=$whouse->contact_no?></strong></td>
              </tr>
            </table>
            <p><strong></strong></p></td>
        </tr>
        <tr>
          <td colspan="3" align="left" style="font-size:10px" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><p>Thanking You,<br />
                </p>
                  <p><br />
                    <br />--------------------<br />
                    Authorized Person&nbsp;</p></td>
                <td><em><strong>Prepared By </strong>: <?=$data->entry_by?></em></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="3" align="left" style="font-size:10px">
          <ul>
            <li>The Copy of Work Order must be shown at the factory premises during the delivery.</li>
            <li>Company protects the right to reconsider or cancel the Work-Order every nowby any administrational dictation.</li>
            <li>Any inefficiency in maintanence must be informed(Officially) before the execution to avoid the compensation.</li>
        </ul></td>
        </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
      </table></td>
  </tr>

</table>
</body>
</html>
