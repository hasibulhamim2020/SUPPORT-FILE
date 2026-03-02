<?php



session_start();

$level=$_SESSION['user']['level'];

ob_start();



require "../../support/inc.all.php";


$sale_no 		= $_REQUEST['sale_no'];





$title='Monthly Sales Provision Calculation ';





do_calander('#fdate');

do_calander('#tdate');

if($_REQUEST['fdate']!=''||$_REQUEST['tdate']!='')

{

$provision_fdate = $_REQUEST['fdate'];

$year = date('Y',strtotime($provision_fdate));

$month = date('m',strtotime($provision_fdate));


 $found = find_a_field('item_sales_provision','sum(provision_amt)',' month="'.$month.'" and year="'.$year.'"  ');
 
 $provision_view = find_a_field('item_sales_provision','provision_no',' month="'.$month.'" and year="'.$year.'"  ');

}


if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


$provision_date = $_REQUEST['tdate'];


$year = date('Y',strtotime($provision_date));

$month = date('m',strtotime($provision_date));

$provision_no = (date('ymd',strtotime($provision_date))*1000)+$_SESSION['user']['depot'];

$entry_by = $_REQUEST['entry_by']=$_SESSION['user']['id'];

$entry_at = $_REQUEST['entry_at']=date('Y-m-d H:i:s');



//$sql = 'select * from item_info where 1 order by item_id';
//		$query = db_query($sql);	
//		while($data=mysqli_fetch_object($query))
//		{
//			if(($_POST['sales_qty_'.$data->item_id]>0)||($_POST['scheme_qty_'.$data->item_id]>0))
//			{
//				$provision_rate=$_POST['provision_rate_'.$data->item_id];
//				$sales_qty=$_POST['sales_qty_'.$data->item_id];
//				$scheme_qty=$_POST['scheme_qty_'.$data->item_id];
//				$total_qty=$_POST['total_qty_'.$data->item_id];
//				$provision_amt=$_POST['provision_amt_'.$data->item_id];
//	
//$provision = "INSERT INTO  item_sales_provision ( `provision_no`, `provision_date`, `month`, `year`, `item_id`, `provision_rate`, `sales_qty`, `scheme_qty`, `total_qty`, `provision_amt`, `status`, `entry_at`, `entry_by`)
// VALUES 
//('".$provision_no."', '".$provision_date."', '".$month."', '".$year."', '".$data->item_id."', '".$provision_rate."', '".$sales_qty."', '".$scheme_qty."', '".$total_qty."', '".$provision_amt."', 
//'CHECKED',  '".$entry_at."','".$entry_by."')";
//db_query($provision);
//
//			}
//		}



if($_POST['fdate']!=''&&$_POST['tdate']!='')
$sc_date .= ' and b.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

  $sql = "select b.item_id, a.sku_code, b.item_id, a.item_name, b.provision_rate, sum(b.total_unit) as total_unit,  sum(b.provision_amt) as provision_amt from item_info a, sale_do_chalan b where a.item_id=b.item_id 
 ".$sc_date."  group by b.item_id, b.provision_rate order by b.item_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$provision = "INSERT INTO  item_sales_provision ( `provision_no`, `provision_date`, `month`, `year`, `item_id`, `provision_rate`, `sales_qty`, `scheme_qty`, `total_qty`, `provision_amt`, `status`, `entry_at`, `entry_by`)
 VALUES 
('".$provision_no."', '".$provision_date."', '".$month."', '".$year."', '".$data->item_id."', '".$data->provision_rate."', '".$data->total_unit."', '0', '".$data->total_unit."',
 '".$data->provision_amt."', 'CHECKED',  '".$entry_at."','".$entry_by."')";
db_query($provision);


}



 $sql2 = "select b.item_id, a.sku_code, b.item_id, a.item_name, b.provision_rate, sum(b.total_unit) as total_unit,  sum(b.provision_amt) as provision_amt from item_info a, sale_other_chalan b where a.item_id=b.item_id and b.issue_type='SCHEME' ".$sc_date."  group by b.item_id, b.provision_rate order by b.item_id";
$query2 = db_query($sql2);
while($data2=mysqli_fetch_object($query2)){

$provision2 = "INSERT INTO  item_sales_provision ( `provision_no`, `provision_date`, `month`, `year`, `item_id`, `provision_rate`, `sales_qty`, `scheme_qty`, `total_qty`, `provision_amt`, `status`, `entry_at`, `entry_by`) VALUES 
('".$provision_no."', '".$provision_date."', '".$month."', '".$year."', '".$data2->item_id."', '".$data2->provision_rate."',  '0', '".$data2->total_unit."', '".$data2->total_unit."', 
'".$data2->provision_amt."', 'CHECKED',  '".$entry_at."','".$entry_by."')";
db_query($provision2);

}





if($_POST['fdate']!=''&&$_POST['tdate']!='')
$provision_date_con .= ' and provision_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


 $provision =  find_all_field_sql("SELECT sum(provision_amt) provision_amt, provision_no, provision_date, month, year FROM `item_sales_provision` WHERE 1 ".$provision_date_con." ");

$found_jv = find_all_field('secondary_journal','1','tr_from="PROVISION" and tr_no='.$provision->provision_no);

if($found_jv==0) {

$provision_date = $_REQUEST['tdate'];

$month_name = find_a_field('months','month_name','month_id='.$provision->month);


//$sql = "update item_sale_issue set status = 'COMPLETE' where `se_id`='".$se_id."' and `sale_date`='".$p_date."'";
//db_query($sql);



$jv_no = next_journal_sec_voucher_id();

$jv_date = strtotime($provision_date);

$narration = 'Provision '.$month_name.', '.$provision->year;

$cc_code = 0;

$sales_dr=3001000100000000;
$provision_cr=2003000100000000;


add_to_sec_journal('PHILIPS', $jv_no, $jv_date, $sales_dr, $narration, $provision->provision_amt, '0.00', 'PROVISION', $provision->provision_no,'','',$cc_code);

add_to_sec_journal('PHILIPS', $jv_no, $jv_date, $provision_cr,  $narration, '0.00', $provision->provision_amt, 'PROVISION', $provision->provision_no,'','',$cc_code);

}



}

}

if(isset($_REQUEST['delete']))

{



$p_date = $_REQUEST['p_date'];

$se_id = $_REQUEST['se_id'];

//$sale_no = $_REQUEST['sale_no'];

$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);

$se_sale =  find_all_field_sql("SELECT sum(today_sale_amt) total_sales,sale_no,status FROM `item_sale_issue` WHERE `se_id`='".$se_id."' and `sale_date`='".$p_date."' ");

$sql = "update item_sale_issue set status = 'MANUAL' where `se_id`='".$se_id."' and `sale_date`='".$p_date."'";

db_query($sql);


$sql_del_secondary = "DELETE FROM secondary_journal WHERE tr_no ='".$se_sale->sale_no."'";

db_query($sql_del_secondary);

$sql_del_journal = "DELETE FROM journal WHERE tr_no ='".$se_sale->sale_no."'";

db_query($sql_del_journal);


}






if($_GET['del']>0)
{

		$se_id = $_REQUEST['se_id'];
		
		$jv_no=$_GET['del'];
		
		// echo $del_sj = "DELETE FROM `secondary_journal`  where `jv_no`='".$jv_no."' and `tr_no`='".$se_id."' and tr_from='Collection' ";
	// db_query($del_sj);
	 
		
				
		
		$msg='Successfully Deleted.';
}






$se_info = find_all_field('warehouse','','warehouse_id='.$se_id);

$se_sale =  find_all_field_sql("SELECT sum(today_sale_amt) total_sales,status,sale_no FROM `item_sale_issue` WHERE `se_id`='".$se_id."' and `sale_date`='".$p_date."' ");



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







	function update_value(id)

	{

var item_id=id; // Rent 

var p_date=(document.getElementById('p_date').value);

var item_rate=(document.getElementById('item_rate_'+id).value);

var se_id=(document.getElementById('se_id').value);

var opening=(document.getElementById('opening_'+id).value)*1;

var issue=(document.getElementById('issue_'+id).value)*1;

var sale=(document.getElementById('sale_'+id).value)*1;

var sale_amt=(document.getElementById('sale_amt_'+id).value)*1;

var closing=(document.getElementById('closing_'+id).value)*1; 

var flag=(document.getElementById('flag_'+id).value); 

//alert(item_rate)

var strURL="sales_order_ajax.php?item_id="+item_id+"&opening="+opening+"&issue="+issue+"&sale="+sale+"&closing="+closing+"&item_rate="+item_rate+"&sale_amt="+sale_amt+"&se_id="+se_id+"&p_date="+p_date+"&flag="+flag;



//alert(strURL);



		var req = getXMLHTTP();







		if (req) {







			req.onreadystatechange = function() {



				if (req.readyState == 4) {



					// only if "OK"



					if (req.status == 200) {						



						document.getElementById('divi_'+id).style.display='inline';



						document.getElementById('divi_'+id).innerHTML=req.responseText;						



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

<script>

function calculation(id){

var opening=(document.getElementById('opening_'+id).value)*1; 

var issue=(document.getElementById('issue_'+id).value)*1; 

var sale=(document.getElementById('sale_'+id).value)*1; 

var item_rate=(document.getElementById('item_rate_'+id).value)*1; 

var floor_stock = ((document.getElementById('floor_stock_'+id).value)*1);

var closing = ((document.getElementById('closing_'+id).value=(opening+issue)-sale));

document.getElementById('sale_amt_'+id).value=(item_rate*sale);

//document.getElementById('closing_'+id).value=(opening+issue)-sale;

 if(issue>floor_stock)
  {
alert('Can not issue more than floor stock quantity.');
document.getElementById('issue_'+id).value='';
document.getElementById('closing_'+id).value='';
//document.getElementById('closing_'+id).focus();
  } 
  

   if(closing<0)
  {
  
alert('Can not sale more than closing stock quantity.');
document.getElementById('sale_'+id).value='';
document.getElementById('sale_amt_'+id).value='';
//document.getElementById('closing_'+id).value='$info->today_close';
document.getElementById('sale_'+id).focus();
document.getElementById('closing_'+id).value=(opening+issue);
  } 

 
}

</script>




<style type="text/css">

<!--

.style1 {

	color: #FFFFFF;

	font-weight: bold;

}
.style2 {font-weight: bold}

-->

</style>







<div class="form-container_large">



<form action="" method="post" name="codz" id="codz">



<table width="80%" border="0" align="center">



  <tr>



    <td colspan="6"  height="30" bgcolor="#FF0000"><div align="center" class="style1">Monthly Sales Provision Calculation </div></td>
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



    <td align="right" bgcolor="#FF9966"><strong> Date: </strong></td>



    <td bgcolor="#FF9966"><input name="fdate" type="text" id="fdate" style="width:120px;" value="<?=$_POST['fdate']?>" /></td>



    <td bgcolor="#FF9966"><strong>To</strong></td>
    <td bgcolor="#FF9966"><input name="tdate" type="text" id="tdate" style="width:120px;" value="<?=$_POST['tdate']?>" /> </td>
    <td rowspan="2" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Open Item" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

    <td rowspan="2" bgcolor="#FF9966"><a href="sales_provision_print_view.php?provision_no=<?=$provision_view?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>
  </tr>
</table>



<br />











<?



if(isset($_POST['submitit'])){



?>



<div class="tabledesign2" style="width:100%">



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">



  <tr style="font-size:12px;">
    <th>Item Code </th>



    <th>SKU Code </th>
    <th><div align="center">Product Name </div></th>



    <th>Type</th>
    <th>Provision Rate</th>

    <th bgcolor="#66CCFF">Challan Qty </th>

    <th bgcolor="#99FFCC">Provision Amt </th>
    </tr>



  <?
  
  
  

  

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$ch_date .= ' and chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

//1
 $sql = "select item_id, sum(total_unit) as ch_qty from sale_do_chalan where 1 ".$ch_date." group by item_id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$sales_qty[$data->item_id]=$data->ch_qty;

}


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$sc_date .= ' and b.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


 

  $sql = "select b.item_id, a.sku_code, b.item_id, a.item_name, b.provision_rate, sum(b.total_unit) as total_unit,  sum(b.provision_amt) as provision_amt from item_info a, sale_do_chalan b where a.item_id=b.item_id 
 ".$sc_date."  group by b.item_id, b.provision_rate order by b.item_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){$i++;


?>
<tr style=" font-size:12px;">
  <td><?=$data->item_id?></td>

  <td><?=$data->sku_code?></td>
  <td><?=$data->item_name?></td>

  <td>Sales</td>
  <td><?=$data->provision_rate?><input readonly name="provision_rate_<?=$data->item_id?>" id="provision_rate_<?=$data->item_id?>" type="hidden" value="<?=$data->provision_rate;?>" /></td>
<td bgcolor="#66CCFF"><input readonly name="sales_qty_<?=$data->item_id?>" id="sales_qty_<?=$data->item_id?>" type="text" size="10"  
value="<?=$data->total_unit; $tot_qty += $data->total_unit;?>" style="width:100px;"  /></td>
<td bgcolor="#99FFCC"><input readonly name="provision_amt_<?=$data->item_id?>" id="provision_amt_<?=$data->item_id?>" type="text" size="10"  
value="<?=$data->provision_amt; $tot_provision_amt +=$data->provision_amt;?>" style="width:120px;"  /></td>
</tr>
<? }?>

<?
  $sql2 = "select b.item_id, a.sku_code, b.item_id, a.item_name, b.provision_rate, sum(b.total_unit) as total_unit,  sum(b.provision_amt) as provision_amt from item_info a, sale_other_chalan b where a.item_id=b.item_id 
 and b.issue_type='SCHEME' ".$sc_date."  group by b.item_id, b.provision_rate order by b.item_id";
$query2 = db_query($sql2);
while($data2=mysqli_fetch_object($query2)){$i++;


?>


<tr style=" font-size:12px;">
  <td><?=$data2->item_id?></td>

  <td><?=$data2->sku_code?></td>
  <td><?=$data2->item_name?></td>

  <td>SCHEME</td>
  <td><?=$data2->provision_rate?><input readonly name="provision_rate_<?=$data->item_id?>" id="provision_rate_<?=$data->item_id?>" type="hidden" value="<?=$data2->provision_rate;?>" /></td>
<td bgcolor="#66CCFF"><input readonly name="sales_qty_<?=$data->item_id?>" id="sales_qty_<?=$data->item_id?>" type="text" size="10"  
value="<?=$data2->total_unit; $tot_qty2 += $data2->total_unit;?>" style="width:100px;"  /></td>
<td bgcolor="#99FFCC"><input readonly name="provision_amt_<?=$data->item_id?>" id="provision_amt_<?=$data->item_id?>" type="text" size="10"  
value="<?=$data2->provision_amt; $tot_provision_amt2 +=$data2->provision_amt;?>" style="width:120px;"  /></td>
</tr>

<? }?>

<tr style=" font-size:14px;">
  <td colspan="5"><div align="right"><strong>Total</strong>:</div></td>
  <td bgcolor="#66CCFF"><span class="style2">
    <?=number_format($tot_qty+$tot_qty2,2);?>
  </span></td>
  <td bgcolor="#99FFCC"><span class="style2">
    <?=number_format($tot_provision_amt+$tot_provision_amt2,2);?>
  </span></td>
</tr>
</table>



</div>





<? }?>

<br />

<p style="width:100%; float:right;">



   <? if($found<1){?>
   
	  	
		   
		   <input name="confirmit" type="submit" id="confirmit" class="btn1" value="CHECKED SALES PROVISION" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#000000; background:#215470; float:right;" autocomplete="off">       

 	   <? }?>  

	

	</p>
	
	
	
	



</form>



</div>







<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>