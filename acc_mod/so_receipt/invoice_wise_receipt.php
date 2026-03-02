<?php



session_start();

ob_start();



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

 $issue_no = $_REQUEST['issue_no'];
 
 
 create_combobox('account_code');
 create_combobox('dr_ledger_id');
 create_combobox('do_no');
 
 
 ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
error_log( "Hello, errors!" );



$title='Sales Invoice Wise Receipt Voucher';


if($_POST['warehouse_id']>0) 

$warehouse_id = $_SESSION['warehouse_id']=$_POST['warehouse_id'];

elseif($_SESSION['warehouse_id']>0) 

$warehouse_id = $_POST['warehouse_id']=$_SESSION['warehouse_id'];


//auto_complete_from_db('vendor','vendor_name','concat(vendor_id,"#>",vendor_name)','1','vendor_id');




if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$receipt_date=$_POST['p_date'];
		
		$dr_ledger_id=$_POST['dr_ledger_id'];
		
		
 if($_POST['account_code']!='')
  $account_code_con=" and d.account_code=".$_POST['account_code'];
  
 if($_POST['do_no']!='')
  $do_no_con=" and j.tr_id=".$_POST['do_no'];
  


		$group_for= $_SESSION['user']['group'];

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		//$YR = date('Y',strtotime($ch_date));
//  		$yer = date('y',strtotime($ch_date));
//  		$month = date('m',strtotime($ch_date));
//
//  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
//   		$cy_id = sprintf("%07d", $ch_cy_id);
//   		$chalan_no=''.$yer.''.$month.''.$cy_id;


		
		$receipt_no = next_transection_no($group_for,$receipt_date,'receipt_from_customer','receipt_no');


		 $sql = "SELECT d.dealer_code, d.account_code, d.dealer_name_e, j.tr_no, j.jv_date, sum(j.dr_amt) as invoice_amt, j.tr_id FROM journal j, dealer_info d WHERE j.ledger_id=d.account_code and j.tr_from in ('Sales') ".$account_code_con.$do_no_con."  group by j.tr_no";

		$query = db_query($sql);

	


		while($data=mysqli_fetch_object($query))

		{
	

			if($_POST['receipt_amt_'.$data->tr_no]>0)

			{
			
	

				$receipt_amt=$_POST['receipt_amt_'.$data->tr_no];
				$account_code=$_POST['account_code_'.$data->tr_no];
				$tr_no=$_POST['tr_no_'.$data->tr_no];



   $so_invoice = 'INSERT INTO receipt_from_customer (receipt_no, receipt_date, do_no, chalan_no, dealer_code, ledger_id, dr_ledger_id, receipt_amt, status, entry_at, entry_by)
  
  VALUES("'.$receipt_no.'", "'.$receipt_date.'", "'.$data->tr_id.'", "'.$tr_no.'", "'.$data->dealer_code.'", "'.$account_code.'", "'.$dr_ledger_id.'", "'.$receipt_amt.'", "COMPLETE", "'.$entry_at.'", "'.$entry_by.'")';

db_query($so_invoice);


}

}


if($receipt_no>0)
{
auto_insert_sales_receipt_secoundary($receipt_no);

}

	

}

}













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

var invoice_no=(document.getElementById('invoice_no_'+po_no).value);

var payment_amt=(document.getElementById('payment_amt_'+po_no).value);


var flag=(document.getElementById('flag_'+po_no).value); 

//alert(item_rate)

var strURL="invoice_wise_payment_ajax.php?po_no="+po_no+"&p_date="+p_date+"&cr_ledger_id="+cr_ledger_id+"&vendor_id="+vendor_id
+"&po_date="+po_date+"&invoice_no="+invoice_no+"&payment_amt="+payment_amt+"&flag="+flag;


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

<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 250px;
    height: 37px;
    border-radius: 0px !important;
}



</style>







<div class="form-container_large">



<form action="" method="post" name="codz" id="codz">



<table width="80%" border="0" align="center">



  <tr>



    <td colspan="4" height="22" bgcolor="#FF0000"><div align="center" class="style1"><?=$title?></div></td>
    </tr>



  <?



  if(isset($_POST['p_date']))



  $p_date = $_SESSION['p_date'] = $_POST['p_date'];



  elseif($_SESSION['p_date']!='')



  $p_date = $_SESSION['p_date'];



  else



  $p_date = date('Y-m-d');



  



  ?>



  <tr>



    <td align="right" bgcolor="#FF9966"><strong> Date : </strong></td>



    <td bgcolor="#FF9966"><input name="p_date" type="text" id="p_date" style="width:120px;" value="<?=$p_date?>" /></td>



    <td rowspan="4" bgcolor="#FF9966"><strong>

      <input type="submit" name="submit" id="submit" value="Open Invoice" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

    <td rowspan="4" bgcolor="#FF9966"><a href="black_tea_transection_sheet.php?v_no=<?=$bt_issue->issue_no?>" target="_blank"><?php /*?><img src="../../../images/print.png" width="26" height="26" /><?php */?></a></td>
  </tr>



  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Customer Name : </strong></td>
    <td bgcolor="#FF9966"><select name="account_code" id="account_code" style="width:220px;">
	
	<option></option>

        <?

foreign_relation('dealer_info','account_code','dealer_name_e',$_POST['account_code'],'1');

?>

    </select></td>
  </tr>
  
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Job No : </strong></td>
    <td bgcolor="#FF9966">
	<select name="do_no" id="do_no" style="width:220px;">
	
	<option></option>

        <? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'status!="MANUAL"'); ?>

    </select></td>
  </tr>
  
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>DR  Ledger  : </strong></td>
    <td bgcolor="#FF9966"><select name="dr_ledger_id" id="dr_ledger_id" required="required" style="width:220px;">
      <option></option>
      <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['dr_ledger_id'],'ledger_group_id in (10201,10202)');?>
    </select></td>
    </tr>
	
	
	
</table>



<br />








<!--/Recept Sale Amount-->



<?



if(isset($_POST['submit'])){



?>



<div class="tabledesign2" style="width:100%">



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" >



  <tr style="font-size:14px;">
    <th width="3%">SL</th>
    <th width="7%">Invoice No </th>



    <th width="9%">Invoice Date </th>
    <th width="21%"><strong>Customer</strong>Name </th>
    <th width="13%" bgcolor="#99FFFF">Invoice Amt </th>
    <th width="11%" bgcolor="#FFFACD">Receipt Amt </th>
    <th width="11%" bgcolor="#CCCCCC">Due Amt </th>
    <th width="11%" bgcolor="#FFCCFF">Value</th>
    </tr>
  



  <?

  

 if($_POST['account_code']!='')
  $account_code_con=" and d.account_code=".$_POST['account_code'];
  
 if($_POST['do_no']!='')
  $do_no_con=" and j.tr_id=".$_POST['do_no'];
  




  
 $sql = "select sum(cr_amt) as receipt_amt, ledger_id, tr_id  from journal where tr_from='Receipt' group by tr_id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$receipt_amt[$data->ledger_id][$data->tr_id]=$data->receipt_amt;

}
  
  
  
 $sql = "select sum(cr_amt) as return_amt, ledger_id, tr_id  from journal where tr_from='Sales Return'  group by tr_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$return_amt[$data->ledger_id][$data->tr_id]=$data->return_amt;

}
 
  


   
    $sql = "SELECT d.account_code, d.dealer_name_e, j.tr_no, j.jv_date, sum(j.dr_amt) as invoice_amt FROM journal j, dealer_info d WHERE j.ledger_id=d.account_code and j.tr_from in ('Sales')  ".$account_code_con.$do_no_con."  group by j.tr_no";



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){





	//$stock_qty = $data->qty-$all_issue;

  ?>

<? if ($due_amt=$data->invoice_amt-$receipt_amt[$data->account_code][$data->tr_no]+$return_amt[$data->account_code][$data->tr_no]>0) {?>

  <tr  style="font-size:14px;">
    <td><?=++$i?></td>
    <td>     <a href="../../../warehouse_mod/pages/wo/sales_invoice_print_view.php?v_no=<?=$data->tr_no?>" target="_blank"><span class="style13" style="color:#000000; font-weight:700;"> <?=$data->tr_no?>  </span></a>  </td>

    <td>     <?php echo date('d-m-Y',strtotime($data->jv_date));?>  </td>
    <td>
	<?=$data->dealer_name_e;?>	  </td>
    <td bgcolor="#99FFFF"><strong>
 

    <?=number_format($data->invoice_amt,2);?>

  
</strong></td>
<td bgcolor="#FFFACD"><strong>
  <?=number_format($receipt_amt[$data->account_code][$data->tr_no]+$return_amt[$data->account_code][$data->tr_no],2);?>
</strong></td>
<td bgcolor="#CCCCCC"><strong>
  <? echo number_format($due_amt=$data->invoice_amt-$receipt_amt[$data->account_code][$data->tr_no]+$return_amt[$data->account_code][$data->tr_no],2);?>
</strong></td>
<td bgcolor="#FFCCFF"><strong>
 <input name="account_code_<?=$data->tr_no?>" id="account_code_<?=$data->tr_no?>" type="hidden" size="10"  value="<?=$data->account_code?>" style="width:80px;" />
 <input name="tr_no_<?=$data->tr_no?>" id="tr_no_<?=$data->tr_no?>" type="hidden" size="10"  value="<?=$data->tr_no?>" style="width:80px;" />
 <input name="receipt_amt_<?=$data->tr_no?>" id="receipt_amt_<?=$data->tr_no?>" type="text" size="10"  value="" style="width:120px;"  />
</strong></td>
</tr>
  



  <? } }?>
</table>


</div>

<br />



<? }?>



<p style="width:30%; float:right;">




 <input name="confirmit" type="submit" id="confirmit" value="CONFIRM ENTRY" style=" width:300px; height:35px; background-color:#FF3300 float:right; background:#3399CC; color: #000000; font-weight:700;" /> 	       

 	    

	

	</p>



</form>



</div>







<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>