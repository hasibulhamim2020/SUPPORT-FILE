<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$chalan_no 		= $_REQUEST['v_no'];



$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$v_no);



$sql1="select d.*,b.*, sum(b.total_unit) as total_unit, d.total_unit as ord_unit, sum(b.total_amt) as total_amt, j.item_ex as item_ex, m.depot_id as depot, m.remarks

from sale_do_chalan b,sale_do_details d, journal_item j, sale_do_master m 

where d.id=b.order_no and j.sr_no='".$chalan_no."' and  j.item_id=d.item_id and m.do_no=d.do_no and b.chalan_no = '".$chalan_no."' and (b.item_id!=1096000100010239 and b.item_id!=1096000100010312) group by b.order_no order by d.id";
//echo $sql1;
$data1=db_query($sql1);





$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;

$depot_id=$info->depot;

$remarks=$info->remarks;

$entry_time=$info->entry_time;

$chalan_date=$info->chalan_date;

$do_no=$info->do_no;

$item_ex[]=$info->item_ex;

$order_no[]=$info->order_no;

$store_sl=$info->driver_name; 

$driver_name=$info->driver_name_real;

$vehicle_no=$info->vehicle_no;

$delivery_man=$info->delivery_man;

$cash_discount=$info->cash_discount;

$del_ord[]=$info->ord_unit;

$undel_ord[]=$info->ord_unit - find_a_field('sale_do_chalan','sum(total_unit)','order_no='.$info->order_no);


$item_id[] = $info->item_id;

$unit_price[] = $info->unit_price;
$t_price[] = $info->t_price;
$pkt_size[] = $info->pkt_size;

$sps = find_a_field('item_info','sub_pack_size','item_id='.$info->item_id);

$sub_pkt_size[] = (($sps>1)?$sps:1);



$total_unit[] = $info->total_unit;

$pkt_unit[] = (int)($info->total_unit/$info->pkt_size);

$dist_unit[] = (int)($info->total_unit%$info->pkt_size);

$ord_unit[] = (int)($info->ord_unit);

$total_amt[] = $info->total_amt;



}



$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$ssql = 'select b.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$do = find_all_field_sql($ssql);

$ssqld = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dd = find_all_field_sql($ssqld);


$dept = 'select warehouse_name from warehouse where warehouse_id='.$_SESSION['user']['depot'];

$deptt = find_all_field_sql($dept);


//if(isset($_POST['cash_discount']))

//{

//

//	$c_no = $_POST['c_no'];

//	$cash_discount = $_POST['cash_discount'];

//	$ssql='update sale_do_chalan set cash_discount="'.$_POST['cash_discount'].'" where chalan_no="'.$c_no.'"';

//	db_query($ssql);

//

//}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Delivery Chalan Bill Report :.</title>

<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>

<style type="text/css">

<!--

.style1 {color: #000000}

.style3 {

	font-size: 11px;

	font-weight: bold;

}

-->

</style>

</head>

<body style="font-family:Tahoma, Geneva, sans-serif"><br /><br /><br />

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><div class="header">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          



        </table></td>

	    </tr>

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td width="15%">

                

                <td><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">

                  <tr>

                    <td bgcolor="#00CC33" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;"><span class="style4">M. Ahmed Tea &amp; Lands Co. Ltd<br />
                    </span></td>

                  </tr>

                  <tr>

                    <td><div align="center"><strong>Delivery BILL (<?php echo $deptt->warehouse_name;?>)</strong></div></td>

                  </tr>

                </table>                

                <td width="25%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

                  <tr>

                    <td align="right" valign="middle"> Chalan Date</td>

                    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                        <tr>

                          <td><?=$chalan_date?>

                            &nbsp;</td>

                        </tr>

                    </table></td>

                  </tr>

                  <tr>

                    <td align="right" valign="middle">Chalan No: </td>

                    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                        <tr>

                          <td><strong><?php echo $chalan_no;?></strong></td>

                        </tr>

                    </table></td>

                  </tr>



                </table>                

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

		          <td width="40%" align="right" valign="middle">Dealer Name: </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><span style="font-size:16px; font-weight:bold;" class="style8"><?php echo $dealer->dealer_name_b.'- '.$dealer->dealer_code.' ('.$dealer->team_name.')';?>&nbsp;</span></td>

		              </tr>

		            </table></td>

		          </tr>

		        <tr>

		          <td align="right" valign="top"> Address:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td height="60" valign="top"><?php echo $dealer->address_b.'&nbsp;'.' Mobile: '.$dealer->mobile_no;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>

		        

		        <tr>

                  <td align="right" valign="middle">Buyer Name:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                      <tr>

                        <td><?php echo $dealer->propritor_name_b;?>&nbsp;</td>

                      </tr>

                  </table></td>

		          </tr>

                  <tr>

		          <td width="40%" align="right" valign="middle">DO Date: </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?php echo date('Y-m-d',strtotime($entry_time));?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>

		        </table>		      </td>

			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			  <tr>

			    <td align="right" valign="middle">DO No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><?php echo $do_no;?>&nbsp;</td>
			        </tr>

			      </table></td>
			    </tr>


			  <tr>

			    <td align="right" valign="middle">Store Serial No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td style="font-size:16px; font-weight:bold"><?php echo $store_sl;?>&nbsp;</td>
			        </tr>

			      </table></td>
			    </tr>

			  <tr>

                <td align="right" valign="middle">Vehicle No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?=$vehicle_no?>

                        &nbsp;</td>
                    </tr>

                </table></td>
			    </tr>

			  <tr>

                <td align="right" valign="middle">Driver Name: </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?php echo $driver_name;?>&nbsp;</td>
                    </tr>

                </table></td>
			    </tr>

			  <tr>

			    <td align="right" valign="middle">Delivery Man:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                  <tr>

                    <td><?php echo $delivery_man;?>&nbsp;</td>
                  </tr>

                </table></td>
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

    <form id="form1" name="form1" method="post" action="">

      <table width="50%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

          </tr>

      </table>

        </form>

    </div>

</div>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:11px;">

       

       <tr>

         <td align="center" bgcolor="#FFFFFF"><strong>SL</strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Product Name</strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>TP </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>NET</strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Order Qty  </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Un Deliver Qty  </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Delivery Pcs </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Total Amt </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Bonus Amnt. </strong></td>

         <td align="center" bgcolor="#FFFFFF"><strong>Payable Amt </strong></td>
       </tr>


<? for($i=0;$i<$pi;$i++){ 

$gift_o = find_all_field('sale_do_details','','gift_on_order="'.$order_no[$i].'"  and (item_id=1096000100010239 || item_id=1096000100010312)');

$gift_order  = $gift_o->id;



if($gift_order>0){

$gifts = 'select sum(total_unit) total_unit, unit_price from sale_do_chalan where order_no="'.$gift_order.'" and chalan_no = "'.$chalan_no.'"';

$giftq = db_query($gifts);

$gift = mysqli_fetch_object($giftq);



$per_pcs =  (-1)*(@(($gift->unit_price)/@($total_unit[$i]/$gift->total_unit)));

}

else

{

$gift = 0;

$per_pcs = 0;

}



$g=0;

$items = find_all_field('item_info','item_name','item_id='.$item_id[$i]);

$set = find_all_field('sales_corporate_price','discount','dealer_code="'.$dealer->dealer_code.'" and item_id="'.$item_id[$i].'"');

$fit_size = ($items->sub_pack_size>0)?$items->sub_pack_size:1;

?>

      <tr>

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="left" valign="top"><? echo $items->item_name.'-'.$items->finish_goods_code; ?><?

		$gsql = 'select offer_name from sale_gift_offer g, sale_do_details d where g.id=d.gift_id and d.gift_on_order="'.$order_no[$i].'"';

		$gquery = db_query($gsql);

		while($qdata=mysqli_fetch_object($gquery)){if($g==0) echo '<b>  [Offer-'.$qdata->offer_name; else echo '/'.$qdata->offer_name; $g++; }

		if($g>0) echo ']</b>';?></td>

        <td align="right" valign="top"><?=($t_price[$i]==0&&$dealer->dealer_type=='SuperShop')?number_format($t_price[$i]*$fit_size,2):number_format($t_price[$i]*$fit_size,2);?></td>

        <td align="right" valign="top"><?=$unit_price[$i]*$fit_size?></td>

        <td align="right" valign="top"><?= $ord_unit[$i]?></td>

        <td align="right" valign="top"><?=$undel_ord[$i]?></td>


		<td align="right" valign="top"><? echo (int)$item_ex[$i];$tttttd = $tttttd + $item_ex[$i];?></td>

        <td align="right" valign="top"><? $tttt=($t_price[$i]==0&&$dealer->dealer_type=='SuperShop')?(($t_price[$i]*$fit_size)*$item_ex[$i]):(($t_price[$i]*$fit_size)*$item_ex[$i]);
echo  number_format($tttt,2); $ttttt = $ttttt + $tttt;
?></td>

        <td align="right" valign="top"><? $discount = ($t_price[$i]-$unit_price[$i])* $item_ex[$i]; echo  number_format($discount,2); $tdiscount = $tdiscount + $discount;?></td>

        <td align="right" valign="top"><? $ttt = $tttt-$discount; echo number_format($ttt,2); $tot = $tot + $ttt; ?></td>
        </tr>

<? }?>

      <tr style="border-bottom:#FFFFFF">

        <td colspan="6" align="center" valign="top"><div align="right"><strong>Total  </strong></div></td>

        <td align="center" valign="top"><div align="right"><strong>

          <?=$tttttd?>

        </strong></div></td>

        <td align="right" valign="top"><strong><? echo  number_format($ttttt,2);?></strong></td>

        <td align="right" valign="top"><strong><? echo  number_format($tdiscount,2);?></strong></td>

        <td align="right" valign="top"><strong>

          <?=number_format($tot,2)?>

        </strong></td>
      </tr>

	  <?

	  $sd = $tot*$do->sp_discount;

	  if($sd>0){

	  ?><div align="right"><strong>Special Discount <?=$do->sp_discount?> %: </strong></div>

      <tr>

        <td colspan="9" align="center" valign="top"><div align="right"><strong>Total Amount : </strong></div></td>

        <td align="right" valign="top"><strong>

          <?=number_format((($sd)/100),2)?>

        </strong></td>
      </tr>

	  <? }if($dd->commission>0){?>

      <tr>

        <td colspan="9" align="center" valign="top"><div align="right"><strong>Commission : <?= $dd->commission?> %  </strong></div></td>

        <td align="right" valign="top"><strong>

          <?php $dis=number_format((($tot*$dd->commission)/100),2); echo $dis;?>

        </strong></td>
      </tr>

	  <? }?>

      <tr>

        <td colspan="9" align="center" valign="top"><div align="right"><strong>Net Payable Amount : </strong></div></td>

        <td align="right" valign="top"><strong>

          <?=number_format((($tot-($tot*$dd->commission)/100)-$cash_discount),2)?>

        </strong></td>
      </tr>
    </table></td>

  </tr>

  <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2" style="font-size:12px"><em>N B : This is software generated bill, Signatiory is not required.&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;All goods are received in a good condition as per Terms</em> </td>

    </tr>

  <tr>

    <td width="50%"><?php if($remarks!=""){echo "<span style='font-size:18px'>NOTE: " .$remarks."</span>";}?></td>

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



    <td colspan="2" align="center"><div class="footer_left">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <br /><br />
        <tr>

        
		   
		   
		   
          <td width="25%"><div align="center">Received By </div></td>

          <td width="25%"><div align="center">Store In-Charge </div></td>
			
          

          <td width="25%"><div align="center">Store Officer </div></td>
		  
		  <td width="25%"><div align="center">Driver</div></td>

		   

        </tr>

      </table>

      </div>      <strong><br />

      </strong></td>

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

