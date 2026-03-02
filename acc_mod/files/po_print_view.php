<?php

session_start();

//====================== EOF ===================

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require "../../../engine/tools/class.numbertoword.php";





$po_no		= $_REQUEST['po_no'];



if(isset($_POST['cash_discount']))

{

	$po_no = $_POST['po_no'];

	$cash_discount = $_POST['cash_discount'];

	$ssql='update purchase_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';

	db_query($ssql);

}



$sql1="select * from purchase_master where po_no='$po_no'";

$data=mysqli_fetch_object(db_query($sql1));

$vendor=find_all_field('vendor','','vendor_id='.$data->vendor_id );

$whouse=find_all_field('warehouse','','warehouse_id='.$data->warehouse_id);









?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Purchase Order :.</title>

<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>

<style type="text/css">

<!--

.style4 {

	font-size: 12px;

	font-weight: bold;

}

-->

</style></head>

<body>

<form action="" method="post">

<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td align="center"><strong style="font-size:24px"><?=$whouse->company_name?><br /></strong>

    Head Office: Dargamohalla, Sylhet. Phone: +880-821-716552, Fax: +880-821-715200, Ctg:  +880-31-713632<br />

    <strong><font style="font-size:20px">Purchased</font></strong></td>

  </tr>

  <tr>

    

	<td>	<div align="center"><span class="style4">VAT REG NO: 7011028892 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br />

	  </div></td>

  </tr>

  <tr>

    <td><div class="line">

      <div align="center">

      </div>

    </div></td>

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

<?=$vendor->contact_person_name;?>

<br />

<?=$vendor->contact_person_designation;?>, Contact No:<?=$vendor->contact_no;?>, Fax No:<?=$vendor->fax_no;?>, Email:<?=$vendor->email;?><br />

          </span></td>

          <td valign="top"><span style="font-size:10px">&nbsp;&nbsp;&nbsp;P O No.#

              <?=$_GET['po_no']?>

              <br />

              &nbsp;&nbsp;&nbsp;PO Date:

              <?=$data->po_date?>

              <br />

&nbsp;&nbsp;&nbsp;Sale No:

<?=$data->sale_no?><br />

&nbsp;&nbsp;&nbsp;Sale Date:

<?=$data->sale_date?><br />

&nbsp;&nbsp;&nbsp;Prompt Date:

<?=$data->prompt_date?><br />


&nbsp;&nbsp;&nbsp;Contract No:

<?=$data->contract_no?><br />

&nbsp;&nbsp;&nbsp;Note:

<?=$data->po_details?>

          </span></td>

        </tr>

      </table>   <br />

      

</span>

        <span class="debit_box">

        </div>

    </span></td>

  </tr>

  <tr>

    <td><div id="pr">

      <div align="left">

        

          <table width="60%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

          <!--<td><span class="style3">Special Cash Discount: </span></td>

          <td><label>

            <input name="cash_discount" type="text" id="cash_discount" value="<?=$cash_discount?>" />

            </label>

            <input type="hidden" name="po_no" id="po_no" value="<?=$po_no?>" /></td>

          <td><label>

            <input type="submit" name="Update" value="Update" />

          </label></td>-->

        </tr>

      </table>

        

      </div>

    </div>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">

       <tr>

        <td width="4%"><strong>SL</strong></td>

        <td width="5%"><strong>Lot No</strong> </td>
        <td width="20%"><strong>Garden Name</strong></td>
        <td width="8%"><strong>Inv No </strong></td>
        <td width="9%"><div align="center"><strong>Item Grade</strong></div></td>

        <td width="9%"><strong>Shed</strong></td>
        <td width="9%"><strong>Liquor Marks</strong></td>
        <td width="7%"><strong>Pkgs</strong></td>
        <td width="7%"><strong>Sam Ple </strong></td>
        <td width="7%"><strong>Sam Qty</strong></td>
        <td width="10%"><strong>Total Kgs </strong></td>

        <td width="7%"><strong>Unit Price </strong></td>

        <td width="7%"><strong>Total Amount </strong></td>
      </tr>

	  <?php

$final_amt=0;

$pi=0;

$total=0;

$sql2="select * from purchase_invoice where po_no='$po_no'";

$data2=db_query($sql2);

//echo $sql2;

while($info=mysqli_fetch_object($data2)){ 

$pi++;

$amount=$info->qty*$info->rate;

$lot_no=$info->lot_no;

$invoice_no=$info->invoice_no;

$liquor_mark=$info->quality;

$pkgs=$info->pkgs;

$tpkgs+=$info->pkgs;

$sam_pay=$info->sam_pay;

$sam_qty=$info->sam_qty;

$total=$total+($info->qty*$info->rate);

$sl=$pi;

$item=find_a_field('item_info','concat(item_name)','item_id='.$info->item_id);

$garden=find_a_field('tea_garden','garden_name','garden_id='.$info->garden_id);

$shed=find_a_field('tea_warehouse','warehouse_nickname','warehouse_id='.$info->shed_id);


$qty=$info->qty;

$total_qty+=$info->qty;

$unit_name=$info->unit_name;

$rate=$info->rate;

$disc=$info->disc;



?>

<tr>

        <td valign="top"><?=$sl?></td>

        <td align="left" valign="top"><?=$lot_no?></td>
        <td align="left" valign="top"><?=$garden?></td>
        <td align="left" valign="top"><?=$invoice_no?></td>
        <td align="left" valign="top"><?=$item?></td>

        <td valign="top"><?=$shed?></td>
        <td valign="top"><?=$liquor_mark?></td>
        <td valign="top"><?=$pkgs?></td>
        <td valign="top"><?=$sam_pay?></td>
        <td valign="top"><?=number_format($sam_qty,2)?></td>
        <td valign="top"><?=$qty.' '.$unit_name?></td>

        <td align="right" valign="top"><?=number_format($rate,2)?></td>

        <td align="right" valign="top"><?=number_format($amount,2);?></td>
      </tr>

<? }?>

      <tr>

        <td colspan="7"><div align="right"><strong>Total:</strong></div></td>

        <td><?=$tpkgs?></td>
        <td colspan="2"></td>
        <td><?=number_format($total_qty,2)?></td>
        <td align="right">&nbsp;</td>

        <td align="right"><strong><?php echo number_format($total,2);?></strong></td>
      </tr>
    </table>

      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">

        <tr>

		<td>In Word: Taka <?
		$tax_total=(($total*$data->tax)/100);

$total_qtyy=($total_qty*0.1);

$totalai=($total*0.01);

$tot=($total+$total_qtyy+$totalai+$tax_total);
	 
$scs = $tot ;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}

	 echo ' Only';

		?></td>

          <td align="right">&nbsp;</td>

          <td align="right">&nbsp;</td>
        </tr>
		
		<? if($data->brokerage>0){?>

        <tr>

          <td align="right">&nbsp;</td>

          <td align="right">Brokerage: </td>

          <td align="right"><strong><?php  echo number_format(($total_qty*0.1),2)?></strong></td>
        </tr>

<? }?>
		
		
		<tr>

		<td align="right">&nbsp;</td>

          <td align="right">AIT(<?=$data->ait_tax?>%):</td>

          <td align="right"><strong><?php  echo number_format(($total*0.01),2);?></strong></td>
        </tr>
		
		

        <tr>

		<td align="right">&nbsp;</td>

          <td align="right">Vat(<?=$data->tax?>%):</td>

          <td align="right"><strong><?  echo number_format($tax_total,2);?></strong></td>
        </tr>

 



        <tr>

          <td align="right">&nbsp;</td>

          <td align="right">Grand Total:</td>

          <td align="right"><strong>

            <? echo number_format(($total+$total_qtyy+$totalai+$tax_total),2);?>

          </strong></td>
        </tr>

        <tr>

          <td colspan="3" align="left"><p><strong>Terms &amp; Conditions: </strong></p>

            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:9px">

              <tr>

                
              </tr>

              <tr>

                <td align="left" valign="top">

                  <li>Delivery Spot</li>                </td>

                <td align="right" valign="top">:</td>

                <td align="left" valign="top"> <strong><?=$whouse->address?></strong></td>
              </tr>

			  <? if($data->payment_terms!=''){?>

              <tr>

                <td align="left" valign="top">

                  <li>Payment</li>                </td>

                <td align="right" valign="top">:</td>

                <td align="left" valign="top"><?=$data->payment_terms?></td>
              </tr>

			  <? }?>
			  
			  
			  
			  <tr>

                <td align="left" valign="top">

                  <li>Tax and Vat</li>                </td>

                <td align="right" valign="top">:</td>

                <td align="left" valign="top">Tax and Vat impose as per Govt rules and regulation</td>
              </tr>
			  
			  
			  

              <tr>

                <td align="left" valign="top">

                  <li>Bill Submit</li>                </td>

                <td align="right" valign="top">:</td>

                <td align="left" valign="top">Head Office: Dargamohalla, Sylhet. Phone: +880-821-716552, 718815<strong>(Copy of Work/Purchase Order must be attached with original bill)</strong></td>
              </tr>

              

              <tr>

                <td align="left" valign="top"><li>Delievery  Instruction</li> </td>

                <td align="right" valign="top">:</td>

                <td align="left" valign="top">Our Store will be closed from 8:30AM to 4:30PM </td>
              </tr>

              <tr>

                <td align="left" valign="top">

                  <li>Contact Person</li>                </td>

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

                <td width="25%" valign="top"><p>Thanking You,<br />

                </p>

                  <p><br /> <br /> <br />

                      <br />

                    -----------------------<br />

                Executive Director&nbsp;</p></td>

                <td width="25%" valign="top"><p><br />

                </p>

                  <p><br /> <br /> <br />

                      <br />

                      -----------------------<br />

                DMD/Director &nbsp;</p></td>

                <td width="25%" valign="top"><p><br />

                </p>

                  <p><br /> <br /> <br />

                    <br />

                    -----------------------<br />

                  Sr.  Manager (Purchase) </p></td>
                </tr>
            </table></td>
        </tr>

        <tr>

          <td colspan="3" align="left" style="font-size:10px"><p>&nbsp;</p>

            <ul>
			<!--<li>Supplied goods will be same as approved sample, otherwise the goods must be replaced &amp; you will bare all expenses.</li>

            <li>The Copy of Work Order must be shown at the factory premises during the delivery.</li>

            <li>Company protects the right to reconsider or cancel the Work-Order every nowby any administrational dictation.</li>

            <li>Any inefficiency in maintanence must be informed(Officially) before the execution to avoid the compensation.

            Supplied goods will be same as approved sample, otherwise the goods must be replaced & you will bare all expenses.</li>-->

            <br /><br />-This Purchased prepared by <em>

              <b><?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></b>

            </em>
            </ul></td>
        </tr>

        <tr>

          <td colspan="3" align="left">&nbsp;</td>
        </tr>
      </table></td>

  </tr>



</table>

</form>

</body>

</html>

