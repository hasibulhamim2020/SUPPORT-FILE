<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Opening Balance';

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

var item_id=id; // Rent
var oqty=(document.getElementById('oqty_'+id).value)*1; 
var orate=(document.getElementById('orate_'+id).value)*1; 
var odate=(document.getElementById('odate').value); 
var flag=(document.getElementById('flag_'+id).value); 

var strURL="opening_balance_ajax.php?item_id="+item_id+"&oqty="+oqty+"&orate="+orate+"&odate="+odate+"&flag="+flag;

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
  <?
  if(isset($_POST['odate'])){
  $odate = $_SESSION['odate'] = $_POST['odate'];
  } elseif($_SESSION['odate']!=''){
  $odate = $_SESSION['odate'];
  } else{
  $odate = date('Y-m-d');
  }
  ?>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Opening Date: </strong></td>
    <td bgcolor="#FF9966"><input name="odate" type="text" id="odate" style="width:100px;" value="<?=$odate?>" /></td>
    <td bgcolor="#FF9966">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Select Product Sub Group: </strong></td>
    <td bgcolor="#FF9966">
	<select name="sub_group" id="sub_group">
	
<?
foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'sub_group_name!="Finished Goods"');
?>
    </select>    </td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Open Balance" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>
<br /><br />
<?
if($_POST['sub_group']>0){
?>
<div class="tabledesign2" style="width:100%">
<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">
  <tr>
    <th><div align="center">Item Code </div></th>
    <th><div align="center">Item Name </div></th>
    <th><div align="center">FC</div></th>
    <th>Unit</th>
    <th><div align="center">PQty</div></th>
    <th><div align="center">PRate</div></th>
    <th><div align="center">OQty</div></th>
    <th><div align="center">ORate</div></th>
    <th><div align="center">Action</div></th>
  </tr>
  <?
  $sql = "select * from item_info where sub_group_id=".$_POST['sub_group'];
  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$i++;
  $info = find_all_field('journal_item','','warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$data->item_id.'" order by id desc');
  if($info->tr_from=='Opening')
  $oqty=$info->final_stock;
  $orate=$info->final_price;
  $op = find_all_field('journal_item','','warehouse_id="'.$_SESSION['user']['depot'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$data->item_id?></td>
    <td><?=$data->item_name?></td>
    <td><?=($data->finish_goods_code>0)?$data->finish_goods_code:'';?></td>
    <td><?=$data->unit_name?></td>
    <td><?=$info->final_stock;?></td>
    <td><?=$info->final_price;?></td>
    <td><input name="oqty_<?=$data->item_id?>" id="oqty_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$op->final_stock;?>" style="width:60px;" /></td>
    <td><input name="orate_<?=$data->item_id?>" id="orate_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$data->f_price;?>" style="width:60px;" />      </td>
    <td><span id="divi_<?=$data->item_id?>">
            <? 
			  if(($op->id>0)&&($op->id==$info->id))
			  {?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:20px; background-color:#FF3366"/><?
			  }
			  elseif($info->id<1)
			  {
			  ?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:20px;background-color:#66CC66"/><? }?>
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