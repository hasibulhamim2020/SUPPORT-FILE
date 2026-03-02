<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Opening Balance';

do_calander('#odate');
auto_complete_from_db('dealer_info','dealer_name_e','dealer_code','dealer_type ="BulkBuyer" and group_for="'.$_SESSION['user']['group'].'" and canceled="Yes"','dealer');
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
	
	function update_value(id)
	{

var item_id=id;
var dealer_code=(document.getElementById('dealer_code').value)*1; 
var discount=(document.getElementById('dis_'+id).value)*1;
var flag =(document.getElementById('flag_'+id).value)*1;


var set_price=(document.getElementById('set_'+id).value)*1;

var strURL="item_price_ajax.php?item_id="+item_id+"&dealer_code="+dealer_code+"&discount="+discount+"&set_price="+set_price+"&flag="+flag;

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
    <td align="right" bgcolor="#FF9966"><strong>Corporate Dealer: </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input name="dealer" type="text" id="dealer" value="<?=$_POST['dealer']?>" />
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Set Price" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>
<br /><br />
<?
if($_POST['dealer']>0){
?>
<div class="tabledesign2" style="width:100%"><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#6699CC"><strong>Dealer Name: </strong></td>
    <td bgcolor="#6699CC"><strong>
      <?=(find_a_field('dealer_info','concat(dealer_name_e,"-",dealer_code)',' dealer_code='.$_POST['dealer']))?>
      &nbsp;
      <input name="dealer_code" id="dealer_code" type="text" size="10" maxlength="10" value="<? echo $_POST['dealer'];?>" style="width:60px;" />&nbsp;&nbsp;&nbsp;
    </strong></td>
  </tr>
</table>

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">
  <tr>
    <th><div align="center">Item Code </div></th>
    <th><div align="center">Item Name </div></th>
    <th>Brand</th>
    <th>Group</th>
    <th>Unit</th>
    <th>TP</th>
    <th>MRP</th>
    <th>%Dis</th>
    <th><div align="center">Set Rate</div></th>
    <th><div align="center">Action</div></th>
  </tr>

  <?
  $sql = "select * from item_info where sub_group_id=1096000100010000 order by finish_goods_code";
  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$i++;
  ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=($data->finish_goods_code>0)?$data->finish_goods_code:'';?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->item_brand?></td>
    <td><?=$data->sales_item_type?></td>
    <td><?=$data->unit_name?></td>
    <td><?=$data->t_price?></td>
    <td><?=$data->m_price?></td>
    <td>
	<input name="mrp_<?=$data->item_id?>" id="mrp_<?=$data->item_id?>" type="hidden" value="<?=$data->m_price?>" />
	<input name="dis_<?=$data->item_id?>" id="dis_<?=$data->item_id?>" type="text" size="5" maxlength="5" value="<? echo $set_price = find_a_field('sales_corporate_price','discount','dealer_code="'.$_POST['dealer'].'" and item_id= "'.$data->item_id.'"');?>" style="width:30px;" onchange="set_price(<?=$data->item_id?>)" /></td>
    <td><input name="set_<?=$data->item_id?>" id="set_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<? echo $set_price = find_a_field('sales_corporate_price','set_price','dealer_code="'.$_POST['dealer'].'" and item_id= "'.$data->item_id.'"');?>" style="width:50px;" onblur="auto_blank(<?=$data->item_id?>)" />      </td>
    <td><span id="divi_<?=$data->item_id?>">
            <? 
			  if($set_price!='')
			  {?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
			  <input type="button" name="Button" value="Re-Set"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:20px; background-color:#FF3366"/><?
			  }
			  else
			  {
			  ?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
			  <input type="button" name="Button" value="Set"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:20px;background-color:#66CC66"/><? }?>
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