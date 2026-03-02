<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Warehouse Wise Price Setup';



do_calander('#odate');

auto_complete_from_db('warehouse','warehouse_name','warehouse_id','1 ','warehouse'); //dealer_type="Distributor"  change by kamrul at 23-10-2021

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

	function auto_blank(id)

	{

	(document.getElementById('dis_'+id).value)='';



	}

	

	function set_price(id)

	{

		var discount=(document.getElementById('dis_'+id).value)*1;

		

		if(discount>0) 

			{

			var set=(((document.getElementById('mrp_'+id).value)*1)-((((document.getElementById('mrp_'+id).value)*1)*discount)/100));

			var set_price=set.toFixed(2);

			}

		else

			{

			var set_price=(document.getElementById('set_'+id).value)*1;

			}

	document.getElementById('set_'+id).value=set_price;

	}

	
function update_value(id){
var item_id=id;

var warehouse_id=(document.getElementById('warehouse_id').value)*1; 

var pack_size=(document.getElementById('pack_size_'+id).value)*1;
var crt_price=(document.getElementById('crt_price_'+id).value)*1;
var unit_price=(document.getElementById('unit_price_'+id).value)*1;
var flag =(document.getElementById('flag_'+id).value)*1;





var strURL="item_price_ajax.php?item_id="+item_id+"&warehouse_id="+warehouse_id+"&pack_size="+pack_size+"&crt_price="+crt_price+"&unit_price="+unit_price+"&flag="+flag;



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

    <td>&nbsp;</td>

  </tr>



  

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Warehouse: </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input name="warehouse" type="text" id="warehouse" value="<?=$_POST['warehouse']?>" / class="form-control">

    </strong></td>

    <td bgcolor="#FF9966" style="text-align:center"><strong>

      <input type="submit" name="submitit" id="submitit" value="Set Price" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/ >

    </strong></td>

  </tr>

</table>

<br /><br />

<?

if($_POST['warehouse']>0){

?>

<div class="tabledesign2" style="width:100%"><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="26%" bgcolor="#6699CC"><strong>Warehouse Name: </strong></td>

    <td width="74%" bgcolor="#6699CC"><strong>

      <?=(find_a_field('warehouse','concat(warehouse_name,"-",warehouse_id)','warehouse_id='.$_POST['warehouse']))?>

      &nbsp;

      <input name="warehouse_id" id="warehouse_id" type="hidden" size="10" maxlength="10" value="<? echo $_POST['warehouse'];?>" style="width:60px;" />&nbsp;&nbsp;&nbsp;

    </strong></td>

  </tr>

</table>



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">

  <tr>
    <th width="17%">Item Category </th>

    <th width="7%"><div align="center">Item Code </div></th>

    <th width="30%"><div align="center">Item Name </div></th>

    <th width="18%">Description</th>

    <th width="4%">Unit</th>

    <th width="6%">CRT Size </th>

    <th width="6%">Crt Price </th>

    <th width="5%"><div align="center">Pcs  Price </div></th>

    <th width="7%"><div align="center">Action</div></th>
  </tr>



  <?

  $sql = "select i.*, s.sub_group_name from item_info i, item_sub_group s  where i.sub_group_id=s.sub_group_id and i.product_nature in ('Salable','Both') order by s.sub_group_id,i.item_id ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>



  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$data->sub_group_name?></td>

    <td><?=($data->item_id>0)?$data->item_id:'';?></td>

    <td style="text-align:left"><?=$data->item_name?></td>

    <td><?=$data->item_description?></td>

    <td><?=$data->unit_name?></td>

    <td><?=$data->pack_size?>
	<input name="pack_size_<?=$data->item_id?>" id="pack_size_<?=$data->item_id?>" type="hidden" size="5" maxlength="5" value="<?=$data->pack_size;?>" style="width:70px;" onchange="set_price(<?=$data->item_id?>)" />
	</td>

    <td>


	<input name="crt_price_<?=$data->item_id?>" id="crt_price_<?=$data->item_id?>" type="text" size="5" maxlength="5" value="<? echo $crt_price = find_a_field('sales_price_warehouse','crt_price','warehouse_id="'.$_POST['warehouse'].'" and item_id= "'.$data->item_id.'"');?>" style="width:70px;" onchange="set_price(<?=$data->item_id?>)" /></td>

    <td><input name="unit_price_<?=$data->item_id?>" id="unit_price_<?=$data->item_id?>" type="text" size="5" maxlength="5" value="<? echo $unit_price = find_a_field('sales_price_warehouse','unit_price','warehouse_id="'.$_POST['warehouse'].'" and item_id= "'.$data->item_id.'"');?>" style="width:70px;" onchange="set_price(<?=$data->item_id?>)" />  </td>

    <td><span id="divi_<?=$data->item_id?>">

            <? 

			  if($unit_price!='')

			  {?>

			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />

			  <input type="button" name="Button" value="Re-Set"  onclick="update_value(<?=$data->item_id?>)" style="width:60px; height:30px; background-color:#FF3366"/><?

			  }

			  else

			  {

			  ?>

			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />

			  <input type="button" name="Button" value="Set"  onclick="update_value(<?=$data->item_id?>)" style="width:60px; height:30px;background-color:#66CC66"/><? }?>

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>