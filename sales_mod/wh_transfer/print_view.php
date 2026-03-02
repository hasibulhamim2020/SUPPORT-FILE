<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require "../../support/inc.all.php";

require "../../../engine/tools/class.numbertoword.php";







$req_no 		= $_REQUEST['req_no'];



$sql="select * from warehouse_transfer_master where  pi_no='$req_no'";

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

.style11 {

	font-size: 16px;

	font-weight: bold;

}

.style14 {font-weight: bold}

.style12 {

	font-size: 12px;

	font-weight: normal;

}

.style4 {	font-size: 18px;

	color: #000000;

}

.style15 {

	color: #FF0000;

	font-weight: bold;

}

.style16 {color: #336600}
.style17 {font-size: 12px}
.style19 {font-size: 12px; font-weight: bold; }

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
	
	
	

	  

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

		  <tr>

		    <td width="14%" valign="bottom">&nbsp;</td>

		    <td width="32%" valign="bottom">&nbsp;</td>

		    <td width="9%" valign="bottom">&nbsp;</td>

		    <td width="45%">&nbsp;</td>
		    </tr>

		  <tr>

		    <td colspan="4" valign="bottom">

			<? if($all->status=='SEND'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFCC99">

			

              <tr>

                <td><div align="center" class="style15">IN TRANSIT </div></td>
              </tr>



            </table>

			<? }?>

		    <? if($all->status=='RECEIVED'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCFFCC">

                <tr>

                  <td><div align="center"><strong>

	<span class="style16" style=" text-transform: uppercase;">RECEIVED BY <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?></span></strong></div></td>
                </tr>

              </table><? }?>			</td>
		    </tr>

		</table>		</td>
	  </tr>
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
		  
		  <strong>Requisition No</strong>: <?php echo $all->req_no;?><br />
		
		<strong>Send Date</strong>: <?=$all->pi_date;?><br />
		
		<strong>Warehouse From</strong>: <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_from);?><br />
		
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

        <td width="5%"><strong>SL</strong></td>

        <td width="41%"><strong>Product Description </strong></td>

        <td width="9%"><strong>Unit</strong></td>

        <td width="11%"><strong>Rate</strong></td>
        <td width="11%"><strong> Qty</strong></td>
        <td width="19%"><strong>Total Amt</strong> </td>
       </tr>

	  <?php

$final_amt=(int)$data1[0];

$pi=0;

$total=0;

$sql2="select * from warehouse_transfer_detail where  pi_no='$req_no'";

$data2=db_query($sql2);

//echo $sql2;

while($info=mysqli_fetch_object($data2)){ 

$pi++;

$total_qty=$info->total_unit;
$grand_total_qty+=$total_qty;
$rate=$info->unit_price;
$total_amount=$info->total_amt;
$grand_total_amount+=$total_amount;



$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);

if($item->item_id){

?>

      <tr>

        <td valign="top"><span class="style17">
          <?=$pi?>
        </span></td>

        <td align="left" valign="top"><span class="style12">

          <?=$item->item_name?>

        </span></td>

        <td align="center" valign="top"><span class="style17">
          <?=$item->unit_name?>
        </span></td>

        <td align="center" valign="top"><span class="style17">
          <?=number_format($rate,2);?>
        </span></td>
        <td align="center" valign="top"><div align="right" class="style17">


          <?=number_format($total_qty,2);?>
           </div></td>
        <td align="center" valign="top"><div align="right"><span class="style17">
          <?=number_format($total_amount,2);?>
        </span></div></td>
      </tr>

      

<? } }?>

<tr>

        <td colspan="4" valign="top"><div align="right"><strong>Total:</strong></div></td>

        <td valign="top"><div align="right"><span class="style19">
          <?=number_format($grand_total_qty,2);?>
        </span></div></td>
        <td valign="top"><div align="right"><span class="style19">
          <?=number_format($grand_total_amount,2);?>
        </span></div></td>
</tr>
    </table></td>

    <td>&nbsp; </td>
  </tr>

  <tr>
    <td align="center"><div align="left"><h3><b>Note:</b> &nbsp;<?php echo $all->remarks;?></h3></div></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>

    <td align="center">

	<div class="footer1"><strong><br />

    </strong>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="30%"><div align="center">

            <p style="float:left; font-weight:bold;">Prepared By: <br />

              <?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?>
            </p>

          </div></td>

          <td width="40%"><div align="center">

              <p>Received By</p>

          </div></td>

          <td width="40%"><div align="center">Store Incharge </div></td>
        </tr>
      </table>

      </div>

	<div class="footer1"></div></td>

    <td align="center">&nbsp;</td>
  </tr>
</table>

</body>

</html>

