<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$unique_master='pi_no';
$pi_no 		= $_REQUEST['pi_no'];
//if(prevent_multi_submit()){
//if(isset($_POST['rec']))
//{
//		$pi_no=$req_no;
//		$_POST['status']='RECEIVED';
//		$_POST['received_by']=$_SESSION['user']['id'];
//		$_POST['received_at']=date('Y-m-d H:i:s');
//		
//db_query('update warehouse_transfer_master set status = "'.$_POST['status'].'", rec_sl_no = "'.$_POST['rec_sl_no'].'", receive_date = "'.$_POST['receive_date'].'", received_by = "'.$_POST['received_by'].'" where pi_no="'.$pi_no.'"');
//		
//
//$table_detail='warehouse_transfer_detail';
//$sql="select p.*,i.d_price from warehouse_transfer_detail p, item_info i where i.item_id=p.item_id and pi_no='$pi_no'";
//$data=db_query($sql);
//
//
//$master = $pi = find_all_field('warehouse_transfer_master','','pi_no='.$pi_no);
//$warehouse_to = $master->warehouse_to;
//$warehouse_from = $master->warehouse_from;
//
//$cc_code = find_a_field('warehouse','acc_code','warehouse_id='.$master->warehouse_to);
//
//$narration = 'PI No-'.$pi_no.'||Invoice -'.$pi->invoice_no.'|| RecDt:'.$pi->receive_date;
//
//while($all=mysqli_fetch_object($data)){
//$amount = $all->total_unit*$all->d_price;
//journal_item_control($all->item_id ,$warehouse_to,$_POST['receive_date'],$all->total_unit,'0','Transfered',$all->id,$all->d_price,$warehouse_from,$pi_no);
//db_query('update journal_item set tr_from="Transfered" where tr_no="'.$all->id.'" and tr_from="Transit"');
//$total_amount = $total_amount + $amount;
//}	
//}
//}


do_calander('#receive_date');

$sql="select * from warehouse_transfer_master where  pi_no='$pi_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);


$concern=find_all_field('user_group','','id='.$all->group_for);

$group_for = $all->group_for;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: FG Challan Copy :.</title>
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style14 {font-weight: bold}
.style12 {
	font-size: 12px;
	font-weight: normal;
}
.style18 {font-size: 12px}
.style20 {
	color: #FFFFFF;
	font-weight: bold;
}
.style21 {
	font-size: 14px;
	font-weight: bold;
}
.style22 {font-size: 14px}
-->
</style>
</head>
<body>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			
			
			
			<tr>

              <td width="20%"><p><strong>
			  
	
	<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$group_for?>.png" style="width:100px;" />
	
	
	
	
			  </strong></p></td>

               <td width="60%" align="center"><strong style="font-size:24px">
        <?=$concern->group_name?>
        <br />
        </strong><?=$concern->address?></td>
                <td width="20%">&nbsp;</td>
			</tr>
			
			

              <tr>

                <td colspan="3">

				<div class="header_title">
				  <div> Warehouse Transfer </div>
				</div></td>
              </tr>

            </table></td>
          </tr>



        </table></td>
	    </tr>
	  <?php /*?><tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td width="100%" valign="bottom">
			<? if($all->status=='SEND'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFCC99">
              <tr>
                <td><div align="center" class="style15">IN TRANSIT </div></td>
              </tr>
			                <tr>
                <td><form id="form1" name="form1" method="post" action="">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25%" bgcolor="#FFFFCC"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Receive Date : </strong></td>
                      <td width="25%" bgcolor="#FFFFCC"><label>
                        <select name="receive_date" id="receive_date" required />
						<? for($i=0;$i<62;$i++){?>
						<option><?=date('Y-m-d',time()-(24*60*60*$i));?></option>
						<? }?>
                        </select>
                      </label></td>
                      <td width="25%" bgcolor="#FFFFCC"><div align="right"><strong>Rec SL No : </strong></div></td>
                      <td width="25%" bgcolor="#FFFFCC"><label>
                        <input type="text" name="rec_sl_no" style="width:80px;" />
                      </label></td>
                      <td width="50%" bgcolor="#FFFFCC"><div align="center">
                        <input name="rec" type="submit" id="rec" value="Received" />
                      </div></td>
                    </tr>
                  </table>
                                </form>                </td>
              </tr>
            </table><? }?>
		    <? if($all->status=='RECEIVED'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCFFCC">
                <tr>
                  <td><div align="center"><strong>
	<span class="tabledesign style17" style=" text-transform: uppercase;">(<?='Received Date: '.$all->receive_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receive SL No: '.$all->rec_sl_no?>)&nbsp;</span></strong></div></td>
                </tr>
              </table><? }?>			</td>
		    </tr>
		</table>		</td>
	  </tr><?php */?>
    </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
	<td>	</td>
    <td></td>
  </tr>
  <tr>
    <td><div class="line"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div class="header2">
          <div class="header2_left" style="height:30px;">
        <p style="font-size:14px;">
		
		<strong>Transfer ID</strong>: <span class="style14">

          <?=$all->pi_no;?>

          </span><br />
		  
		  <strong>Invoice No</strong>: <?php echo $all->invoice_no;?><br />
		
		<strong>Send Date</strong>: <?=$all->pi_date;?><br />
		
		<strong>Warehouse From</strong> : <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_from);?><br />
		
		<strong>Warehouse To</strong>: <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?><br />

          
        </p>
      </div>
      
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
  </tr>
</table>
</form>
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="6%" rowspan="2" bgcolor="#004269"><span class="style20">SL</span></td>
        <td width="38%" rowspan="2" bgcolor="#004269"><span class="style20">Product Description </span></td>
        <td width="5%" rowspan="2" bgcolor="#004269"><span class="style20">Unit</span></td>
        <td width="9%" rowspan="2" bgcolor="#004269"><span class="style20">CTN Size </span></td>
        <td colspan="2" bgcolor="#004269"><span class="style20">No. of Unit </span></td>
        <td colspan="2" bgcolor="#004269"><span class="style20">Amount</span></td>
       </tr>
       <tr>
         <td width="6%" bgcolor="#004269"><span class="style20">CTN</span></td>
         <td width="8%" bgcolor="#004269"><span class="style20">PCS</span></td>
         <td width="11%" bgcolor="#004269"><span class="style20">CTN Rate</span></td>
         <td width="17%" bgcolor="#004269"><span class="style20">Amount</span></td>
       </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from warehouse_transfer_detail where  pi_no='$pi_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$pkt_size=$info->pkt_size;
$pkt_unit=$info->pkt_unit;
$grand_pkt_unit+=$pkt_unit;
$total_qty=$info->total_unit;
$grand_total_qty+=$total_qty;
$rate=$info->unit_price;
$crt_price=$info->crt_price;
$crt_amt=$info->crt_amt;
$total_crt_amt+=$crt_amt;
$total_amount=$info->total_amt;
$grand_total_amount+=$total_amount;

$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
if($item->item_id){
?>
      <tr>
        <td valign="top"><span class="style18">
          <?=$pi?>
        </span></td>
        <td align="left" valign="top"><span class="style12 style18">
          <?=$item->item_name?>
        </span></td>
        <td align="center" valign="top"><span class="style18">
          <?=$item->unit_name?>
        </span></td>
        <td align="center" valign="top"><span class="style18">
          <?=number_format($pkt_size,2);?>
        </span></td>
        <td valign="top"><div align="right" class="style18">
          <?=number_format($pkt_unit,2);?>
        </div></td>
        <td valign="top"><span class="style18">
          <?=number_format($total_qty,2);?>
        </span></td>
        <td valign="top"><div align="right" class="style18">
          <?=number_format($crt_price,2);?>
        </div></td>
        <td valign="top"><span class="style18">
          <?=number_format($crt_amt,2);?>
        </span></td>
      </tr>
      
<? }}?>
<tr>
        <td valign="top"><div align="right"></div></td>
        <td colspan="3" valign="top"><div align="right" class="style21">Total:</div></td>
        <td valign="top"><div align="right" class="style21">
          <?=number_format($grand_pkt_unit,2);?>
        </div></td>
        <td valign="top"><span class="style21">
          <?=number_format($grand_total_qty,2);?>
        </span></td>
        <td valign="top"><div align="right"><span class="style22"></span></div></td>
        <td valign="top"><span class="style21">
          <?=number_format($total_crt_amt,2);?>
        </span></td>
</tr>
    </table>
	
	<table>
		<tr>
			<td>
				<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
	 <tr>
	   <td >&nbsp;</td>
	   <td>&nbsp;</td>
	   </tr>
	 <tr>
    <td width="60%" >&nbsp;</td>
    <td width="40%">
		<table width="100%" border="1">
			<tr>
				<td width="50%"><div align="right"><strong>Sub Total: </strong></div></td>
				<td width="50%" align="center"><strong><?php echo number_format($total_crt_amt,2);?>
				</strong></td>
			</tr>
			<tr>
				<td width="50%"><div align="right"><strong>VAT(<?=$all->vat?> %): </strong> <? $vat_total=(($total_crt_amt*$all->vat)/100);?></div></td>
				<td width="50%" align="center"><strong>
				  <?  echo number_format($vat_total,2);?>
				</strong></td>
			</tr>
			
			<tr>
				<td width="50%"><div align="right"><strong>Total Payable : </strong></div></td>
				<td width="50%" align="center"><strong><? echo number_format(($total_crt_amt+$vat_total),2);?></strong></td>
			</tr>
	  </table>	</td>
  </tr>
	 </table>
			
			
			</td>
		
		</tr>
	</table>
	
	
	
	
	
	
	</td>
    <td>
	
	
	</td>
  </tr>
  <tr>
  
  
    <td align="center">
	<div class="footer1"><strong><br />
    </strong>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="30%"><div align="center">
            <p style="float:left; font-weight:bold; font-size:12px;">Prepared By: <br />
              <?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?>
            </p>
          </div></td>
          <td width="40%"><div align="center">
              <p>Received By<br />
                <strong>
                <?=find_a_field('user_activity_management','fname','user_id='.$all->received_by)?>
                </strong></p>
			  
          </div></td>
          <td width="30%"><div align="center">Store Incharge </div></td>
        </tr>
      </table>
      </div>
	<div class="footer1"></div></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
