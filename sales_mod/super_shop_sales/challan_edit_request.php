<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Challan Edit Request';

$chalan_no 		= $_REQUEST['v_no'];

do_calander('#odate');

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

var edit_request=(document.getElementById('edit_request_'+id).value)*1; 

var flag=(document.getElementById('flag_'+id).value); 

var strURL="challan_edit_request_ajax.php?id="+id+"&edit_request="+edit_request+"&flag="+flag;



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

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2">&nbsp;</td>
  </tr>

  <?

  if(isset($_POST['odate']))

  $odate = $_SESSION['odate'] = $_POST['odate'];

  elseif($_SESSION['odate']!='')

  $odate = $_SESSION['odate'];

  else

  $odate = date('Y-m-d');

  

  ?>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Challan No:</strong></td>

    <td bgcolor="#FF9966"><input name="chalan_no" type="text" id="chalan_no" required readonly="" style="width:150px; height:35px;" autocomplete="off"  value="<?=$chalan_no?>" />
	<? $ch_data = find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);?></td>

    <td rowspan="8" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="View Challan" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>
    <td rowspan="8" bgcolor="#FF9966"><a target="_blank" href="delivery_challan_print_view.php?v_no=<?=$chalan_no?>"><img src="../../../images/print.png" alt="" width="30" height="30" /></a></td>
    </tr>
	
	<?

if($chalan_no>0){

?>
	
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Job No: </strong></td>
    <td bgcolor="#FF9966"><input name="" type="text" id="" readonly="" required style="width:250px; height:30px;" autocomplete="off"  value="<?=$ch_data->job_no;?>" /></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
    <td bgcolor="#FF9966">
	<input name="" type="text" id="" readonly="" required style="width:250px; height:30px;" autocomplete="off"  value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$ch_data->dealer_code);?>" />
	</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Buyer Name:</strong></td>
    <td bgcolor="#FF9966">
	<input name="" type="text" id="" readonly="" required style="width:250px; height:30px;" autocomplete="off"  value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$ch_data->buyer_code);?>" />
	</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Merchandiser Name:</strong></td>
    <td bgcolor="#FF9966">
	<input name="" type="text" id=""  readonly="" required style="width:250px; height:30px;" autocomplete="off"  value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$ch_data->merchandizer_code);?>" />
	</td>
  </tr>
  
  <? }?>
</table>

<br />

<?

if($chalan_no>0){

?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:10px">

  <tr>

    <th width="27%" rowspan="2"><div align="center">Item_Name </div></th>

    <th width="3%" rowspan="2">Style No</th>
    <th width="3%" rowspan="2">PO No</th>
    <th width="2%" rowspan="2">SKU</th>
    <th width="2%" rowspan="2">Color</th>
    <th width="1%" rowspan="2">Size</th>
    <th width="2%" rowspan="2">UOM</th>
    <th width="1%" rowspan="2">Ply</th>
    <th width="14%" rowspan="2">Measurement</th>
    <th width="5%" rowspan="2">Challan Date</th>
    <th width="3%" rowspan="2">Challan Qty </th>
    <th colspan="2">Challan 1</th>
    <th colspan="2">Challan 2 </th>
    <th colspan="2">Challan 3 </th>
    <th width="19%" rowspan="2"><div align="center">Action</div></th>
  </tr>
  <tr>
    <th width="3%">Pcs/Per Bundle</th>
    <th width="3%">Qty/ Bundle</th>
    <th width="3%">Pcs/Per Bundle</th>
    <th width="3%">Qty/ Bundle</th>
    <th width="3%">Pcs/Per Bundle</th>
    <th width="3%">Qty/ Bundle</th>
  </tr>

  <?

   $sql = "select c.*, i.item_name from item_info i, sale_do_chalan c where i.item_id=c.item_id and c.chalan_no=".$chalan_no;

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><?=$data->item_name?></td>

    <td><? 
		  if ($data->style_no!="") {
		  echo $data->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
    <td><? 
		  if ($data->po_no!="") {
		  echo $data->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
    <td><? 
		  if ($data->sku_no!="") {
		  echo $data->sku_no;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
    <td><? 
		  if ($data->color!="") {
		  echo $data->color;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
    <td><? 
		  if ($data->size!="") {
		  echo $data->size;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
    <td><?=$data->unit_name?></td>
    <td><?=$data->ply?></td>
    <td><? if($data->L_cm>0) {?><?=$data->L_cm?><? }?><? if($data->W_cm>0) {?>X<?=$data->W_cm?><? }?><? if($data->H_cm>0) {?>X<?=$data->H_cm?><? }?><?=$data->measurement_unit?>	</td>
    <td><?php echo date('d-m-Y',strtotime($data->chalan_date));?></td>
    <td><?=$data->total_unit?></td>
    <td><?=$data->pcs_1?></td>
    <td><?=$data->bundle_1?></td>
    <td><?=$data->pcs_2?></td>
    <td><?=$data->bundle_2?></td>
    <td><?=$data->pcs_3?></td>
    <td><?=$data->bundle_3?>
      <input name="edit_request_<?=$data->id?>" id="edit_request_<?=$data->id?>" type="hidden" size="10" maxlength="10" value="1" style="width:20px; height:20px;" /></td>
    <td><span id="divi_<?=$data->id?>">

            <?  if($data->edit_request==0)  { ?>

			  <input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="0" />

			  <input type="button" name="Button" value="Request"  onclick="update_value(<?=$data->id?>)" style="width:80px; font-size:12px; height:30px;background-color:#66CC66"/><? }?>
			  
			  
			<?  if($data->edit_request==1)  { ?>

			  <input type="button" name="Button" value="Pending"  style="width:80px; height:30px;  font-size:12px; background-color: #FF0000;"/><? }?>
			  
			  
			  <?  if($data->edit_request==2)  { ?>

			  <input type="button" name="Button" value="Accepted"  style="width:80px; height:30px;  font-size:12px; background-color: #0099CC;"/><? }?>

          </span>&nbsp;</td>
  </tr>

  <? }?>
</table>

</div>

<? }?>

<p>&nbsp;</p>

</form>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>