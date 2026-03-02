<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//require "../../../engine/tools/class.numbertoword.php";







$req_no 		= $_REQUEST['req_no'];



$sql="select * from requisition_fg_master where  req_no='$req_no'";

$data=db_query($sql);

$all=mysqli_fetch_object($data);



$sub_depot_id=$all->sub_depot;



$ware=find_all_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id);



$from_warehouse=$ware->warehouse_name;







$sub_ware=find_all_field('warehouse','warehouse_name','warehouse_id='.$all->sub_depot);



$sub_depot=$sub_ware->warehouse_name;



$address_depot=$sub_ware->address;



$delivery_spot=$sub_ware->delivery_spot;



$contect_p=$sub_ware->warehouse_company;

$contect_m=$sub_ware->contact_no;



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Despatch Order Copy</title>

<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>

<style type="text/css">

<!--

.style2 {font-weight: bold}

-->

</style>

</head>

<body>

<table width="701" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td colspan="3"><div class="header">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	

	<tr>



    <td align="center"><strong style="font-size:24px"><?



if($_SESSION['user']['group']>1)



echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);



else



echo $_SESSION['proj_name'];



				?><br /></strong>



    Head Office: Dargamohalla, Sylhet. Phone: +880-821-716552, 718815, Fax: +880-821-715200<br />



    <strong><font style="font-size:20px">Despatch Order Book </font></strong></td>



  </tr>

	

	  

	  

    </table>

    </div></td>

  </tr>

  <tr>

    

	<td colspan="3">	</td>

  </tr>

  <tr>

    <td colspan="3"><div class="line"></div></td>

  </tr>

  <tr>

    <td height="118" colspan="3"><div class="header2">

          <div class="header2_left">

        <p align="left">The Assistant Manager <br />

          M. Ahmed Tea & Lands Co. Ltd<br />

          Packaging Division<br />

		  Khan Tea Estate        </p>

      </div>

      <div class="header2_right">

        <p>

		  Req. No : <?php echo $all->req_no;?><br />

          Date : <?php echo date("d-m-Y",strtotime($all->req_date)); ?><br />

        </p>

      </div>

    </div></td>

  </tr>

  

  <tr>

    

	<td colspan="3">

		<div>

			<h4>Sub: Supply of Tea.</h4>

			

			<p style="font-size:15px; line-height:22px;">Dear Sir,<br />

			Please arrange to supply the following quantities of tea to <b>  <?php if($sub_depot_id>0){echo "$sub_depot";

			}else{echo "$from_warehouse";}?>

			</b> <?php echo $all->req_note; ?> will collect the teas from the  

			<b><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?></b> on 

			<?php echo date("d-m-Y",strtotime($all->need_by)); ?>.</p> 

		</div>	</td>

  </tr>

  

  

  

  <tr>

    <td colspan="3"><div id="pr">

<div align="left">

<form action="" method="get">



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

  </tr>

</table>

</form><br /><br />

</div>

</div>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">

       <tr>

        <td width="2%"><strong>S/L</strong></td>

        <td><strong>Code</strong></td>

        <td><strong>Description of the Goods </strong></td>

        <td><strong>Bag/Ctn</strong></td>

        <td><strong>Req Qty </strong></td>

        </tr>

	  <?php

$final_amt=(int)$data1[0];

$pi=0;

$total=0;

$sql2="select * from requisition_fg_order where  req_no='$req_no'";

$data2=db_query($sql2);

//echo $sql2;

while($info=mysqli_fetch_object($data2)){ 

$pi++;



$sl=$pi;

$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);



$ord_qty=$info->qty;

$ord_bag=$ord_qty/$item->pakg_ctn_size;



$tot_ord_qty +=$ord_qty;

$tot_ord_bag +=$ord_bag;





?>

      <tr>

        <td valign="top"><?=$sl?></td>

        <td align="center" valign="top"><?=$item->finish_goods_code?>

          &nbsp;</td>

        <td align="left" valign="top"><?=$item->item_name?></td>

        <td valign="top"><?=number_format($ord_bag,2);?></td>

        <td valign="top"><?=number_format($ord_qty,2);?></td>

      </tr>

	  

	  <? }?>

	  

      <tr>

        <td colspan="3" valign="top"><div align="right"><strong>Total</strong></div></td>

        <td valign="top"><span class="style2">

          <?=number_format($tot_ord_bag,2);?>

        </span></td>

        <td valign="top"><span class="style2">

          <?=number_format($tot_ord_qty,2);?>

        </span></td>

        </tr>

    </table></td>

  </tr>

  

  

  

  

  

  

  <tr>

    <td colspan="3">&nbsp;</td>

  </tr>

  <tr>

    <td colspan="3">&nbsp;</td>

  </tr>

  <tr>

    <td><strong><h4>Delivery Spot : </h4></strong></td>

  </tr>

  <tr>

    <td width="150"> <li>Depot Name </td>

    <td width="13">:</td>

    <td width="538"><b>

      <?php if($sub_depot_id>0){echo "$sub_depot";

			}else{echo "$from_warehouse";}?>

    </b></td>

  </tr>

  <tr>

    <td width="150"> <li>Address</td>

    <td width="13">:</td>

    <td width="538"> <?=$address_depot;?>

		

	

	</td>

  </tr>

  

  <? if($sub_depot_id==3) { ?>

  <tr>

    <td width="150"> <li>Delivery Spot</td>

    <td width="13">:</td>

    <td width="538"> <?=$delivery_spot;?></td>

  </tr>

  <? } ?>

  

  

  <tr>

    <td width="150"> <li>Contect Person</td>

    <td width="13">:</td>

    <td width="538"><?=$contect_p;?>, Mobile No : <?=$contect_m;?></td>

  </tr>

  <tr>

    <td width="150">&nbsp;</td>

    <td width="13">&nbsp;</td>

    <td width="538">&nbsp;</td>

  </tr>

  

  

  

  

  <tr>

    <td height="250" colspan="3" align="center">

	<div class="footer1">

	  <div style="float:left">

	  <p style="text-align:center">--------------------------<br />Authorized Person</p>

	  </div>

	</div>

	<div class="footer1">

      <p style="float:left; font-weight:bold;">Prepared By: <?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?></p>

	</div></td>

  </tr>

</table>

</body>

</html>

