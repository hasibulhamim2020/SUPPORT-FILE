<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='WO Unhold Request Approval';


create_combobox('do_no');
do_calander('#max_delivery_date');


do_calander('#issue_date');

 $revise_do_no 		= $_REQUEST['do_no'];


if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

	
		
		$group_for = $_POST['group_for'];

		$issue_date=$_POST['issue_date'];
		
		$remarks=$_POST['remarks'];
		
		$max_delivery_date = $_POST['max_delivery_date'];

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		$do_no=$_POST['do_no'];

		
		//$chalan_no = next_transection_no('0',$issue_date,'sale_do_production_issue','chalan_no');
		
	
		//$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);

		
		$up_1='UPDATE sale_do_master SET max_delivery_date="'.$max_delivery_date.'" WHERE do_no = "'.$do_no.'" ';
		db_query($up_1);
		
		$up_2='UPDATE sale_do_details SET delivery_date="'.$max_delivery_date.'" WHERE do_no = "'.$do_no.'" ';
		db_query($up_2);
		
		$up_3='UPDATE sale_do_chalan SET delivery_date="'.$max_delivery_date.'" WHERE do_no = "'.$do_no.'" ';
		db_query($up_3);
		
		$up_4='UPDATE sale_do_production_issue SET delivery_date="'.$max_delivery_date.'" WHERE do_no = "'.$do_no.'" ';
		db_query($up_4);
		
		$up_5='UPDATE pi_details SET delivery_date="'.$max_delivery_date.'" WHERE do_no = "'.$do_no.'" ';
		db_query($up_5);
		
		$up_6='UPDATE sale_do_unhold_request SET new_delivery_date="'.$max_delivery_date.'", status="CHECKED", checked_by="'.$entry_by.'", checked_at="'.$entry_at.'" WHERE do_no = "'.$do_no.'"  and status="UNCHECKED"';
		db_query($up_6);
		
		



		

	

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

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



	function update_value(id)



	{


var id=id; // Rent

var issue_date=(document.getElementById('issue_date').value);
var revise_request=(document.getElementById('revise_request_'+id).value)*1; 

var wo_qty=(document.getElementById('wo_qty_'+id).value)*1; 
var pi_qty=(document.getElementById('pi_qty_'+id).value)*1;
var produced_qty=(document.getElementById('produced_qty_'+id).value)*1; 
var delivered_qty=(document.getElementById('delivered_qty_'+id).value)*1; 


var flag=(document.getElementById('flag_'+id).value); 

var strURL="master_data_revise_approval_ajax.php?id="+id+"&issue_date="+issue_date+"&revise_request="+revise_request+"&wo_qty="+wo_qty+"&pi_qty="+pi_qty
+"&produced_qty="+produced_qty+"&delivered_qty="+delivered_qty+"&flag="+flag;



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



<script>




function calculation(id){

var chalan=((document.getElementById('chalan_'+id).value)*1);


var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);



 if(chalan>pending_qty)
  {
alert('Can not issue more than pending quantity.');
document.getElementById('chalan_'+id).value='';

  } 




}

</script>

<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 215px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  

  <?

  if(isset($_POST['odate']))

  $odate = $_SESSION['odate'] = $_POST['odate'];

  elseif($_SESSION['odate']!='')

  $odate = $_SESSION['odate'];

  else

  $odate = date('Y-m-d');

  

  ?>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>JOB No:</strong></td>

    <td bgcolor="#FF9966">
	
	<select name="do_no" id="do_no" style="width:250px;">
		
	

        <?
		
		foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'do_no="'.$revise_do_no.'" order by job_no');

		?>
    </select>
	
	<input style="width:250px;"  name="issue_date" type="hidden" id="issue_date" required="required" value="<?=date('Y-m-d')?>"/>
	
	<? $wo_data = find_all_field('sale_do_master','','do_no='.$revise_do_no);?>		</td>

    <td rowspan="13" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="View Data" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>
    </tr>
  
	
		<?

if($revise_do_no>0){

?>
	
  <?php /*?><tr>
    <td align="right" bgcolor="#FF9966"><strong>Data  Date: </strong></td>
    <td bgcolor="#FF9966"><input style="width:250px;"  name="issue_date" type="hidden" id="issue_date" required="required" value="<?=date('Y-m-d')?>"/></td>
  </tr><?php */?>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
    <td bgcolor="#FF9966">
	<input name="" type="text" id="" readonly="" required style="width:250px; height:30px;" autocomplete="off"  value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$wo_data->dealer_code);?>" />	</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Buyer Name:</strong></td>
    <td bgcolor="#FF9966">
	<input name="" type="text" id="" readonly="" required style="width:250px; height:30px;" autocomplete="off"  value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$wo_data->buyer_code);?>" />	</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>New Delivery Date:</strong></td>
    <td bgcolor="#FF9966"><input name="max_delivery_date" type="text" id="max_delivery_date"  required style="width:250px; height:30px;" autocomplete="off" 
	 value="<?=$_POST['max_delivery_date'];?>" /></td>
  </tr>
  
    <? }?>
</table>

<br />

<?

if($revise_do_no>0){



	$sql = "select  order_no, sum(total_unit) as pi_qty from pi_details where 1 group by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pi_qty[$info->order_no]=$info->pi_qty;

		}

	$sql = "select  order_no, sum(total_unit) as produced_qty  from sale_do_production_issue where 1  group by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $produced_qty[$info->order_no]=$info->produced_qty;

		}


	$sql = "select  order_no, sum(total_unit) as challan_qty  from sale_do_chalan where 1  group by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $challan_qty[$info->order_no]=$info->challan_qty;

		}



   $sql='select a.id,  a.item_id,  a.unit_price, s.sub_category,  b.item_name,  b.unit_name, a.ply, a.paper_combination, a.L_cm, a.W_cm, a.H_cm, a.measurement_unit,  a.total_unit as qty ,
  a.delivery_place, a.delivery_date, a.style_no, a.po_no, a.referance, a.sku_no, a.color, a.size, b.pack_size, a.revise_request, a.revise_reason
   from sale_do_details a,item_info b, item_sub_group s where b.item_id=a.item_id 
  and b.sub_group_id=s.sub_group_id and  a.do_no="'.$revise_do_no.'" order by a.id';

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="1%">SL</th>

            <th width="15%">Item_Name </th>

            <th width="3%"><strong>Style No</strong></th>
            <th width="2%"><strong>PO No</strong></th>
            <th width="2%">Referance</th>
            <th bgcolor="#FFFFFF">UOM</th>

            <th bgcolor="#FFFFFF">Ply</th>
            <th bgcolor="#FFFFFF">Measurement</th>
            <th bgcolor="#FFFFFF">Delivery Date </th>
            <th bgcolor="#FFFFFF">Delivery Place </th>
            <th bgcolor="#FF99FF">WO_Qty </th>

            <th bgcolor="#FF99FF">PI_Qty</th>
            <th bgcolor="#009900">Produced</th>

            <th bgcolor="#FFFF00">Delivered </th>
            </tr>
          
          

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>

              <td>
			  
		<? 
		  if ($row->style_no!="") {
		  echo $row->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  <? 
		  if ($row->po_no!="") {
		  echo $row->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td><? 
		  if ($row->referance!="") {
		  echo $row->referance;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td width="2%" align="center"><?=$row->unit_name?>                </td>

              <td width="1%" align="center"><?=$row->ply?></td>
              <td width="6%" align="center">
			  
			  <? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?>			  </td>
              <td width="6%" align="center"><?php echo date('d-m-Y',strtotime($row->delivery_date));?></td>
              <td width="6%" align="center"><?= find_a_field('delivery_place_info','delivery_place','id="'.$row->delivery_place.'"');?></td>
              <td width="2%" align="center"><?=number_format($row->qty,2);?>
			  <input name="wo_qty_<?=$row->id?>" type="hidden" id="wo_qty_<?=$row->id?>" value="<?=$row->qty;?>"  style="width:80px; height:25px;"></td>

              <td width="2%" align="center"><?=number_format($pi_qty[$row->id],2);?>
		<input name="pi_qty_<?=$row->id?>" type="hidden" id="pi_qty_<?=$row->id?>" value="<?=$pi_qty[$row->id];?>"  style="width:80px; height:25px; "></td>
              <td width="4%" align="center"><?=number_format($produced_qty[$row->id],2);?>
		<input name="produced_qty_<?=$row->id?>" type="hidden" id="produced_qty_<?=$row->id?>" value="<?=$produced_qty[$row->id];?>"  style="width:80px; height:25px; "></td>

              <td width="4%" align="center"><?=number_format($challan_qty[$row->id],2);?>
			  
			<input name="delivered_qty_<?=$row->id?>" type="hidden" id="delivered_qty_<?=$row->id?>" value="<?=$challan_qty[$row->id];?>"  style="width:80px; height:25px; ">

                <input name="revise_request_<?=$row->id?>" type="hidden" id="revise_request_<?=$row->id?>" value="2"  style="width:80px; height:25px; float:none"></td>
              </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /> <br />
  

	
	<br />
  

<table width="100%" border="0">

<? 

 $uh_status = find_a_field('sale_do_unhold_request','count(status)','do_no="'.$revise_do_no.'" and status="UNCHECKED"');


if($uh_status==""){




?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong> WORK ORDER UNHOLD</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="CONFIRM ENTRY" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table>

<? }?>

<p>&nbsp;</p>

</form>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>