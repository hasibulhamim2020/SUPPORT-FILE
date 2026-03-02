<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
session_start();

ob_start();


// require "../../support/inc.all.php";

 $issue_no = $_REQUEST['issue_no'];



$title='Purchase Invoice Wise Payment';


if($_POST['warehouse_id']>0){ 
$warehouse_id = $_SESSION['warehouse_id']=$_POST['warehouse_id'];
}

elseif($_SESSION['warehouse_id']>0){ 
$warehouse_id = $_POST['warehouse_id']=$_SESSION['warehouse_id'];
}


//auto_complete_from_db('vendor','vendor_name','concat(vendor_id,"#>",vendor_name)','1','vendor_id');


do_calander('#p_date');

if($_REQUEST['p_date']!='')

{

$p_date = $_REQUEST['p_date'];

$blend_type = $_REQUEST['blend_type'];



$p_found = find_a_field('black_tea_consumption','1',' 1 and blend_type = "'.$blend_type.'" and status="COMPLETE" and issue_date="'.$p_date.'"');

$m_found = find_a_field('black_tea_consumption','1',' 1 and blend_type = "'.$blend_type.'" and status="MANUAL" and issue_date<"'.$p_date.'"');

}

if(isset($_REQUEST['confirmit']))

{



$p_date = $_REQUEST['p_date'];

$blend_type = $_REQUEST['blend_type'];



$sql = "update black_tea_consumption set status = 'COMPLETE' where `blend_type`='".$blend_type."' and `issue_date`='".$p_date."'";

db_query($sql);






}







//$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);

$bt_issue =  find_all_field_sql("SELECT sum(amount) issue_amount, status, issue_no FROM `black_tea_consumption` WHERE `blend_type`='".$_POST['blend_type']."' and `issue_date`='".$p_date."' ");



?>



<script>







function getXMLHTTP() { //fuction to return the xml http object







		var xmlhttp=false;	







		try{







			xmlhttp=new XMLHttpRequest();







		}







		catch(e)	{		







			try{			







				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");



			}



			catch(e){







				try{







				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");







				}







				catch(e1){







					xmlhttp=false;







				}







			}







		}







		 	







		return xmlhttp;







    }







	function update_value(po_no)

	{

var po_no=po_no; // Rent 

var p_date=(document.getElementById('p_date').value);

var cr_ledger_id=(document.getElementById('cr_ledger_id').value);

var vendor_id=(document.getElementById('vendor_id_'+po_no).value);

var po_date=(document.getElementById('po_date_'+po_no).value);

var payment_amt=(document.getElementById('payment_amt_'+po_no).value);


var flag=(document.getElementById('flag_'+po_no).value); 

//alert(item_rate)

var strURL="invoice_wise_payment_ajax.php?po_no="+po_no+"&p_date="+p_date+"&cr_ledger_id="+cr_ledger_id+"&vendor_id="+vendor_id
+"&po_date="+po_date+"&payment_amt="+payment_amt+"&flag="+flag;


//alert(strURL);



		var req = getXMLHTTP();







		if (req) {







			req.onreadystatechange = function() {



				if (req.readyState == 4) {



					// only if "OK"



					if (req.status == 200) {						



						document.getElementById('divi_'+po_no).style.display='inline';



						document.getElementById('divi_'+po_no).innerHTML=req.responseText;						



					} else {



						alert("There was a problem while using XMLHTTP:\n" + req.statusText);



					}



				}				



			}



			req.open("GET", strURL, true);



			req.send(null);



		}	







}







</script>





</script>

<style type="text/css">

<!--

.style1 {

	color: #FFFFFF;

	font-weight: bold;

}

-->

</style>







<div class="form-container_large">



<form action="" method="post" name="codz" id="codz">



<table width="80%" border="0" align="center">



  <tr>



    <td colspan="4" height="22" bgcolor="#FF0000"><div align="center" class="style1"><?=$title?></div></td>
    </tr>



  <?



  if(isset($_POST['p_date'])){
  $p_date = $_SESSION['p_date'] = $_POST['p_date'];
}





  elseif($_SESSION['p_date']!=''){
  $p_date = $_SESSION['p_date'];
}





  else{
  $p_date = date('Y-m-d');
}





  



  ?>



  <tr>



    <td style="background-color:#FF9966; text-align:right;"><strong> Date : </strong></td>



    <td style="background-color:#FF9966;"><input name="p_date" type="text" id="p_date" style="width:120px;" value="<?=$p_date?>" /></td>



    <td rowspan="4" style="background-color:#FF9966;"><strong>

      <input type="submit" name="submit" id="submit" value="Open Invoice" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

    <td rowspan="4" style="background-color:#FF9966;"><a href="black_tea_transection_sheet.php?v_no=<?=$bt_issue->issue_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>
  </tr>



  <tr>
    <td  style="background-color:#FF9966; text-align:right;"><strong>Vendor Name : </strong></td>
    <td style="background-color:#FF9966;"><select name="vendor_id" id="vendor_id" style="width:220px;">

        <?

foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'1');

?>

    </select></td>
  </tr>
  
  <tr>
    <td  style="background-color:#FF9966; text-align:right;"><strong>CR  Ledger  : </strong></td>
    <td style="background-color:#FF9966;"><select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;">
      <option></option>
      <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id=1001 and parent=0 ');?>
    </select></td>
    </tr>
	
	
	
</table>



<br />








<!--/Recept Sale Amount-->



<?



if($_POST['vendor_id']>0){



?>



<div class="tabledesign2" style="width:100%">



<table  id="grp" style="width:100%; border:0; border-collapse:collapse; padding:0;">



  <tr style="font-size:14px;">
    <th width="4%"  style="width:4%;">SL</th>
    <th width="5%"  style="width:5%;">PO No </th>
    <th width="8%"  style="width:8%;">PO Date </th>
    <th width="26%" style="width:26%;"><strong>Vendor</strong>  Name </th>
    <th width="14%" style="width:14%;">Invoice No </th>
    <th width="15%" style="width:15%; background-color:#99FFFF;">Invoice Amt </th>
    <th width="13%" style="width:13%; background-color:#99FFFF;">Due Amt </th>
    <th width="13%" style="width:13%; background-color:#99FFFF;">Payment Amt </th>
    <th width="15%" style="width:15%;"><div style="text-align:center;">Action</div></th>
  </tr>
  



  <?

  

 if($_POST['vendor_id']!='')

  $vendor_con=" and m.vendor_id=".$_POST['vendor_id'];
  
  
 //$dealer_name_e = $_POST['dealer_code'];
 
 //$dealer=explode("#>",$dealer_name_e);

 //$dealer[0];

  
// if($_POST['dealer_code']!='')
//
//  $con=" and d.dealer_code=".$dealer[0];

  $sql = "select sum(amount) as bill_payment, po_no from purchase_bill_payment where 1 group by po_no ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$bill_payment[$data->po_no]=$data->bill_payment;

}
  
  
  $sql = "select sum(dr_amt-cr_amt) as opening_balance, ledger_id from journal where 1 group by ledger_id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$opening_balance[$data->ledger_id]=$data->opening_balance;

}
  

   
   echo $sql = "SELECT v.ledger_id, v.vendor_name, m.po_no, m.po_date, m.invoice_no, sum(p.amount) as amount FROM purchase_master m, purchase_invoice p, vendor v WHERE m.po_no=p.po_no and m.vendor_id=v.vendor_id and m.status in ('CHECKED','COMPLETED')  ".$vendor_con."  group by p.po_no";



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){





	//$stock_qty = $data->qty-$all_issue;

  ?>



  <tr  style="font-size:14px;">
    <td><?=++$i?></td>
    <td>      <?=$data->po_no?>    </td>

    <td>      <?=$data->po_date?>    </td>
    <td>
	<?=$data->vendor_name?>	  </td>
    <td>      <?=$data->invoice_no?></td>

<td bgcolor="#99FFFF"><strong>
 

  
  <?=number_format($data->amount,2);?>
  
</strong></td>
<td bgcolor="#CCCCCC"><strong>
  <? $bill_payment[$data->po_no];
  
  echo number_format($due_amt=$data->amount-$bill_payment[$data->po_no],2);?>
</strong></td>
<td bgcolor="#FFCCFF"><strong>
 <input name="vendor_id_<?=$data->po_no?>" id="vendor_id_<?=$data->po_no?>" type="hidden" size="10"  value="<?=$data->vendor_id?>" style="width:80px;" />
 <input name="po_no_<?=$data->po_no?>" id="po_no_<?=$data->po_no?>" type="hidden" size="10"  value="<?=$data->po_no?>" style="width:80px;" />
 <input name="po_date_<?=$data->po_no?>" id="po_date_<?=$data->po_no?>" type="hidden" size="10"  value="<?=$data->po_date?>" style="width:80px;" />
 <input name="payment_amt_<?=$data->po_no?>" id="payment_amt_<?=$data->po_no?>" type="text" size="10"  value="" style="width:100px;"  />
</strong></td>
<td><span id="divi_<?=$data->po_no?>">



   <?

if($m_found==0&&$p_found==0)

	{

	if($info->po_no<1)

	{

?>

    <input name="flag_<?=$data->po_no?>" type="hidden" id="flag_<?=$data->po_no?>" value="0" />

    <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->po_no?>)" style="width:60px; height:30px; font-size:12px; font-weight:700; background-color:#66CC66"/>

<? }



		 else



			{?>



				  <input name="flag_<?=$data->po_no?>" type="hidden" id="flag_<?=$data->po_no?>" value="1" />



				  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->po_no?>)" style="width:60px;font-size:12px;   height:30px;   font-weight:700; background-color:#FF3366"/>



		 <? }}



		 ?>



          </span>&nbsp;</td>
  </tr>



  <? }?>
</table>



</div>





<? }?>



<p style="width:60%; float:left;">


<?php /*?>
   <? if($se_sale->status=='MANUAL'){?>
   
    <? }?><?php */?>

	 	   <input name="confirmit" type="hidden" id="confirmit" value="TRANSECTION COMPLETE" style=" width:300px; height:25px; background-color:#FF3300 float:right; font-weight:700;" /> 	       

 	    

	

	</p>



</form>



</div>







<?



// $main_content=ob_get_contents();



// ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>