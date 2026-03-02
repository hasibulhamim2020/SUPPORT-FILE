<?php



session_start();

ob_start();


require "../../support/inc.all.php";

 $issue_no = $_REQUEST['issue_no'];



$title='Create New Blend Sheet';


if($_POST['line_id']>0) 

$line_id = $_SESSION['line_id']=$_POST['line_id'];

elseif($_SESSION['line_id']>0) 

$line_id = $_POST['line_id']=$_SESSION['line_id'];


auto_complete_from_db('tea_garden','garden_name','concat(garden_id,"#>",garden_name)','1','garden_id');


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


//$jv_no = next_journal_sec_voucher_id();

//$jv_date = strtotime($p_date);

//$narration = 'Sale NO#'.$se_sale->sale_no.' SaleDate:'.$p_date;

//$cc_code = $se_info->acc_code;

//add_to_sec_journal('STA', $jv_no, $jv_date, $se_info->ledger_id, $narration, $se_sale->total_sales, '0.00', 'Sales', $se_sale->sale_no,'','',$cc_code);

//add_to_sec_journal('STA', $jv_no, $jv_date, '3001000100000000',  $narration, '0.00', $se_sale->total_sales, 'Sales', $se_sale->sale_no,'','',$cc_code);



}




if(isset($_REQUEST['recheck']))

{



$p_date = $_REQUEST['p_date'];

$blend_type = $_REQUEST['blend_type'];



$sql = "update black_tea_consumption set status = 'MANUAL' where `blend_type`='".$blend_type."' and `issue_date`='".$p_date."'";

db_query($sql);


//$jv_no = next_journal_sec_voucher_id();

//$jv_date = strtotime($p_date);

//$narration = 'Sale NO#'.$se_sale->sale_no.' SaleDate:'.$p_date;

//$cc_code = $se_info->acc_code;

//add_to_sec_journal('STA', $jv_no, $jv_date, $se_info->ledger_id, $narration, $se_sale->total_sales, '0.00', 'Sales', $se_sale->sale_no,'','',$cc_code);

//add_to_sec_journal('STA', $jv_no, $jv_date, '3001000100000000',  $narration, '0.00', $se_sale->total_sales, 'Sales', $se_sale->sale_no,'','',$cc_code);



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







	function update_value(id)

	{

var order_no=id; // Rent 

var p_date=(document.getElementById('p_date').value);

var blend_type=(document.getElementById('blend_type').value);

var po_no=(document.getElementById('po_no_'+id).value);

var pr_no=(document.getElementById('pr_no_'+id).value);

var sale_no=(document.getElementById('sale_no_'+id).value);

var item_id=(document.getElementById('item_id_'+id).value)*1;

var quality=(document.getElementById('quality_'+id).value);

var vendor_id=(document.getElementById('vendor_id_'+id).value)*1;

var lot_no=(document.getElementById('lot_no_'+id).value)*1;

var garden_id=(document.getElementById('garden_id_'+id).value)*1; 

var invoice_no=(document.getElementById('invoice_no_'+id).value)*1;

var blend_issue=(document.getElementById('blend_issue_'+id).value)*1;

var closing_qty=(document.getElementById('closing_qty_'+id).value)*1;

var pkgs=(document.getElementById('pkgs_'+id).value)*1;

var sam_qty=(document.getElementById('sam_qty_'+id).value)*1;

var qty=(document.getElementById('qty_'+id).value)*1; 

var rate=(document.getElementById('rate_'+id).value)*1;

var amount=(document.getElementById('amount_'+id).value)*1;

var flag=(document.getElementById('flag_'+id).value); 

//alert(item_rate)

var strURL="black_tea_recheck_ajax.php?order_no="+order_no+"&po_no="+po_no+"&pr_no="+pr_no+"&sale_no="+sale_no+"&item_id="+item_id
+"&quality="+quality+"&vendor_id="+vendor_id+"&lot_no="+lot_no+"&garden_id="+garden_id+"&invoice_no="+invoice_no+"&blend_issue="+blend_issue+"&closing_qty="+closing_qty+"&pkgs="+pkgs+"&sam_qty="+sam_qty+"&qty="+qty+"&rate="+rate+"&amount="+amount
+"&blend_type="+blend_type+"&p_date="+p_date+"&flag="+flag;



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

var rec_qty=(document.getElementById('rec_qty_'+id).value)*1;

var pkgs_size=(document.getElementById('pkgs_size_'+id).value)*1;  

var pkgs=(document.getElementById('pkgs_'+id).value)*1; 

var sam_qty=(document.getElementById('sam_qty_'+id).value)*1; 

var qty=(document.getElementById('qty_'+id).value=(pkgs*pkgs_size)-sam_qty);

var rate=(document.getElementById('rate_'+id).value)*1; 

document.getElementById('amount_'+id).value=(rate*qty);

var all_issue=(document.getElementById('all_issue_'+id).value)*1; 

var blend_issue=(document.getElementById('blend_issue_'+id).value=(all_issue+qty));

var closing_qty=(document.getElementById('closing_qty_'+id).value=(rec_qty-blend_issue));

//document.getElementById('closing_qty_'+id).value=(rec_qty-blend_issue);



   if(closing_qty<0)
  {
  
alert('Can not Issue more than closing stock quantity.');
document.getElementById('pkgs_'+id).value='';
document.getElementById('qty_'+id).value='';

//document.getElementById('closing_'+id).value='$info->today_close';
document.getElementById('pkgs_'+id).focus();
//document.getElementById('closing_'+id).value=(opening+issue);
  } 
  
  
  



}

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



    <td colspan="4" height="22" bgcolor="#FF0000"><div align="center" class="style1">Create New Blend Sheet</div></td>
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



    <td bgcolor="#FF9966"><input name="p_date" type="text" id="p_date" style="width:100px;" value="<?=$p_date?>" /></td>



    <td rowspan="4" bgcolor="#FF9966"><strong>

      <input type="submit" name="submit" id="submit" value="Open Item" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

    <td rowspan="4" bgcolor="#FF9966"><a href="black_tea_transection_sheet.php?v_no=<?=$bt_issue->issue_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>
  </tr>



  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Blend Name  : </strong></td>
    <td bgcolor="#FF9966"><select name="blend_type" id="blend_type" style="width:220px;">
	
	

        <?

foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['blend_type'],'warehouse_id="'.$line_id.'" ');

?>

    </select></td>
  </tr>
  <!--<tr>

    <td align="right" bgcolor="#FF9966"><strong>Garden Name  : </strong></td>

    <td bgcolor="#FF9966">
	
	<input name="garden_id" type="text" id="garden_id" value="<?=$_POST['garden_id']?>"  style="width:220px; height:18px;"  />
	
	
		</td>
    </tr>-->
  <!--<tr>
    <td align="right" bgcolor="#FF9966"><strong>Material Type : </strong></td>
    <td bgcolor="#FF9966"><select name="material_type" id="material_type" required="required" style="width:220px;">
      <option></option>
      <? foreign_relation('material_type','id','material',$_POST['material_type'],'1 ');?>
    </select></td>
    </tr>-->
	
	
	
</table>



<br />








<!--/Recept Sale Amount-->



<?



if($_POST['blend_type']>0){



?>



<div class="tabledesign2" style="width:100%">



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" >



  <tr style="font-size:7px;">
    <th width="4%" rowspan="2">SL</th>
    <th width="10%" rowspan="2">Sale No </th>



    <th width="15%" rowspan="2">Lot No </th>
    <th width="4%" rowspan="2">Garden</th>
    <th width="4%" rowspan="2">Inv. No </th>
    <th width="4%" rowspan="2"><div align="center"> Item Gread </div></th>

    <th width="1%" rowspan="2">Pkgs</th>

    <th width="3%" rowspan="2">Sam Qty </th>

    <th colspan="3">Black Tea Consumption</th>
    <th width="3%" rowspan="2" bgcolor="#99FFFF">Issue Pkgs </th>
    <th width="4%" rowspan="2" bgcolor="#FFCCFF">Sam. Qty </th>
    <th width="7%" rowspan="2" bgcolor="#9999FF">Total Qty </th>

    <th width="32%" rowspan="2"><div align="center">Action</div></th>
  </tr>
  <tr style="font-size:8px;">
    <th width="3%">Rec Qty </th>
    <th width="3%">Total Issue</th>
    <th width="3%">Stock</th>
  </tr>



  <?

  

 if($_POST['material_type']!='')

  $conm=" and r.material_type=".$_POST['material_type'];
  
  
 $tea_garden = $_POST['garden_id'];
 
 $garden=explode("#>",$tea_garden);

 $garden[0];

  
 if($_POST['garden_id']!='')

  $con=" and r.garden_id=".$garden[0];

  

    $sql = "select i.*, r.*, g.garden_name from item_info i, purchase_receive r, black_tea_consumption c,  tea_garden g where i.item_id=r.item_id and r.garden_id=g.garden_id
   and r.id=c.order_no and  c.issue_date='".$p_date."' and c.blend_type= '".$_POST['blend_type']."'  ".$con.$conm;



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){



  	$info = find_all_field('black_tea_consumption','','order_no = "'.$data->id.'" and issue_date = "'.$p_date.'" and item_id = "'.$data->item_id.'" and blend_type = "'.$_POST['blend_type'].'"');

  
    $all_issue = find_a_field('black_tea_consumption','sum(qty)','order_no="'.$data->id.'" and `issue_date`<"'.$p_date.'"');

	//$stock_qty = $data->qty-$all_issue;

  ?>



  <tr  style="font-size:8px;">
    <td><?=++$i?></td>
    <td><strong>
      <?=$data->sale_no?>
	  
	  <input readonly name="po_no_<?=$data->id?>" id="po_no_<?=$data->id?>" type="hidden" value="<?=$data->po_no;?>" />
	  
	  <input readonly name="pr_no_<?=$data->id?>" id="pr_no_<?=$data->id?>" type="hidden" value="<?=$data->pr_no;?>" />
	  
	  <input readonly name="sale_no_<?=$data->id?>" id="sale_no_<?=$data->id?>" type="hidden" value="<?=$data->sale_no;?>" />
	  
	  <input readonly name="item_id_<?=$data->id?>" id="item_id_<?=$data->id?>" type="hidden" value="<?=$data->item_id;?>" />
	  
	  <input readonly name="vendor_id_<?=$data->id?>" id="vendor_id_<?=$data->id?>" type="hidden" value="<?=$data->vendor_id;?>" />
	  
	  <input readonly name="quality_<?=$data->id?>" id="quality_<?=$data->id?>" type="hidden" style="width:60px;" value="<?=$data->quality;?>" />
	  
    </strong></td>

    <td><strong>
      <?=$data->lot_no?>
	  <input readonly name="lot_no_<?=$data->id?>" id="lot_no_<?=$data->id?>" type="hidden" value="<?=$data->lot_no;?>" />
    </strong></td>
    <td><strong>
      <?=$data->garden_name?>
	  <input readonly name="garden_id_<?=$data->id?>" id="garden_id_<?=$data->id?>" type="hidden" value="<?=$data->garden_id;?>" />
    </strong></td>
    <td><strong>
      <?=$data->invoice_no?>
	   <input readonly name="invoice_no_<?=$data->id?>" id="invoice_no_<?=$data->id?>" type="hidden" value="<?=$data->invoice_no;?>" />
    </strong></td>
    <td><strong><?=$data->item_name?></strong></td>

<td><strong>
  <?=$data->pkgs?>
  
</strong></td>

<td ><strong>
  <?=$data->sam_qty?>
</strong></td>

<td bgcolor="#99CCCC"><strong>
  
   <input name="rec_qty_<?=$data->id?>" id="rec_qty_<?=$data->id?>" type="text" size="10"  readonly="" value="<?=$data->qty;?>" style="width:40px;" onkeyup="calculation(<?=$data->id?>)" />
</strong></td>
<td bgcolor="#99CCCC"><strong>
  
  
<input name="all_issue_<?=$data->id?>"   id="all_issue_<?=$data->id?>" type="hidden" size="10"  readonly="" value="<?=$all_issue;?>" style="width:40px;" onkeyup="calculation(<?=$data->id?>)" />

  
    <input name="blend_issue_<?=$data->id?>" id="blend_issue_<?=$data->id?>" type="text" size="10"  readonly="" value="<?=$data->blend_issue;?>" style="width:40px;" onkeyup="calculation(<?=$data->id?>)" />
</strong></td>
<td bgcolor="#99CCCC">
<strong>
  
  <input name="closing_qty_<?=$data->id?>" id="closing_qty_<?=$data->id?>" type="text" size="10" readonly="" value="<?=$data->closing_qty;?>" style="width:40px;" onkeyup="calculation(<?=$data->id?>)" />
  
  <input name="pkgs_size_<?=$data->id?>" id="pkgs_size_<?=$data->id?>" type="hidden" size="10" readonly="" value="<?=$data->pkgs_size;?>" style="width:40px;" onkeyup="calculation(<?=$data->id?>)" />
</strong></td>
<td bgcolor="#99FFFF"><strong>
  <input name="pkgs_<?=$data->id?>" id="pkgs_<?=$data->id?>" type="text" size="10"  value="<?=$info->pkgs;?>" style="width:30px;" onkeyup="calculation(<?=$data->id?>)" />
</strong></td>
<td bgcolor="#FFCCFF"><strong>
  <input name="sam_qty_<?=$data->id?>" id="sam_qty_<?=$data->id?>" type="text" size="10"  value="<?=$info->sam_qty;?>" style="width:30px;" onKeyUp="calculation(<?=$data->id?>)" />
</strong></td>
<td bgcolor="#9999FF"><input readonly name="qty_<?=$data->id?>" id="qty_<?=$data->id?>" type="text" size="10"  value="<?=$info->qty;?>" style="width:40px;" />
<input readonly name="rate_<?=$data->id?>" id="rate_<?=$data->id?>" type="hidden" value="<?=$data->rate;?>" onKeyUp="calculation(<?=$data->id?>)" style="width:60px;"/>
<input readonly name="amount_<?=$data->id?>" id="amount_<?=$data->id?>" type="hidden" size="10"  value="<?=$info->amount;?>" style="width:60px;" /></td>

<td><span id="divi_<?=$data->id?>">



   <?

if($m_found==0&&$p_found==0)

	{

	if($info->id<1)

	{

?>

    <input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />

    <input type="button" name="Button" value="Save"  onclick="calculation(<?=$data->id?>);update_value(<?=$data->id?>)" style="width:45px; height:20px;background-color:#66CC66"/>

<? }



		 else



			{?>



				  <input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="1" />



				  <input type="button" name="Button" value="Edit"  onclick="calculation(<?=$data->id?>);update_value(<?=$data->id?>)" style="width:45px; height:20px; background-color:#FF3366"/>



		 <? }}



		 ?>



          </span>&nbsp;</td>
  </tr>



  <? }?>
</table>



</div>





<? }?>



<?php /*?><p style="width:60%; float:left;">



   <? if($se_sale->status=='MANUAL'){?>
   


	 	   <input name="confirmit" type="submit" id="confirmit" value="TODAY BLACK TEA TRANSECTION COMPLETE" style=" width:300px; height:25px; background-color:#FF3300 float:right; font-weight:700;" /> 	       

 	    

	    <? }?>

	</p><?php */?>
	
	
	<p style="width:60%; float:left;">



   <? if($_SESSION['user']['id']==10007){?>
   

 <input name="recheck" type="submit" id="recheck" value="TODAY BLACK TEA RE-CHECK" style=" width:300px; height:25px; background-color:#FF3300 float:right; font-weight:700;" /> 	       

 	    

	    <? }?>

	</p>



</form>



</div>







<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>