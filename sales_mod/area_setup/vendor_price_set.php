<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Opening Balance';


auto_complete_from_db('vendor','vendor_name','vendor_id','1','dealer');
if($_POST['brand_name']!=''){ 	$brand_name=$_POST['brand_name'];}
if(isset($brand_name)) 			{$brand_name_con=' and item_brand="'.$brand_name.'"';}
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

if(flag==0) {
var set=(((document.getElementById('mrp_'+id).value)*1)-((((document.getElementById('mrp_'+id).value)*1)*discount)/100));
var set_price=set.toFixed(2);
}else
{
var set_price=(document.getElementById('dis_'+id).value)*1;
}
var strURL="vendor_price_set_ajax.php?item_id="+item_id+"&dealer_code="+dealer_code+"&discount="+discount+"&set_price="+set_price+"&flag="+flag;

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
<table style="width:80%; margin:0 auto; border:0; text-align:center;">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  
  <tr>
  <td style="text-align:right; background-color:#FF9966;">
    <strong>Corporate Vendor:</strong>
  </td>

  <td style="background-color:#FF9966;">
    <strong>
      <input type="text" name="dealer" id="dealer" 
             value="<?= htmlspecialchars($_POST['dealer'] ?? '') ?>" 
             style="width:100%; height:28px;" />
    </strong>
  </td>

  <td style="background-color:#FF9966;">Item Brand</td>

  <td style="background-color:#FF9966;">
    <select name="brand_name" id="brand_name" style="width:100%; height:32px;">
      <option value=""></option>
      <?php
        $sql = "SELECT * FROM item_brand ORDER BY brand_name";
        $query = db_query($sql);
        while ($datas = mysqli_fetch_object($query)) {
            $selected = ($datas->brand_name == $brand_name) ? 'selected' : '';
            echo "<option value='{$datas->brand_name}' {$selected}>{$datas->brand_name}</option>";
        }
      ?>
    </select>
  </td>

  <td style="background-color:#FF9966; text-align:center;">
    <strong>
      <input type="submit" name="submitit" id="submitit" 
             value="Set Price" 
             style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090;" />
    </strong>
  </td>
</tr>

</table>
<br /><br />
<?
if($_POST['dealer']>0){
?>
<div class="tabledesign2" style="width:100%"><table style="width:70%; border:0; border-collapse:collapse; padding:0; text-align:center;">
  <tr>
    <td  style="background-color:#6699CC"><strong>Vendor Name: </strong></td>
    <td  style="background-color:#6699CC"><strong>
      <?=(find_a_field('dealer_info','concat(dealer_name_e,"-",dealer_code)','dealer_code='.$_POST['dealer']))?>
      &nbsp;
      <input name="dealer_code" id="dealer_code" type="text" size="10" maxlength="10" value="<? echo $_POST['dealer'];?>" style="width:60px;" />&nbsp;&nbsp;&nbsp;
    </strong></td>
  </tr>
</table>

<table  id="grp" style="width:70%; border:0; border-collapse:collapse; padding:0; text-align:center;">
  <tr>
    <th><div style="text-align:center;">Item Code </div></th>
    <th><div style="text-align:center;">Item Name </div></th>
    <th>Brand</th>
    <th>Group</th>
    <th>Unit</th>
    <th>TP</th>
    <th>MRP</th>
    <th>Set Rate</th>
   
    <th><div  style="text-align:center;">Action</div></th>
  </tr>

<?

 $sql = 'select * from item_info 
where  finish_goods_code<5000
'.$brand_name_con.'
order by finish_goods_code';

  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$i++;
  
  $sql_price = 'select d.discount,d.set_price from purchase_corporate_price d, dealer_info i where d.dealer_code="'.$_POST['dealer'].'" and i.dealer_code=d.dealer_code and  item_id= "'.$data->item_id.'"';
  $price_info = find_all_field_sql($sql_price);
  $set_distount = $price_info->discount;
  $set_price = $price_info->set_price;
  ?>

  <tr style="background-color:<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=($data->finish_goods_code>0)?$data->finish_goods_code:'';?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->item_brand?></td>
    <td><?=$data->sales_item_type?></td>
    <td><?=$data->unit_name?></td>
    <td><?=$data->t_price?></td>
    <td><?=$data->m_price?></td>
    <td>
	<input name="mrp_<?=$data->item_id?>" id="mrp_<?=$data->item_id?>" type="hidden" value="<?=$data->m_price?>" />
	<input name="dis_<?=$data->item_id?>" id="dis_<?=$data->item_id?>" type="text" size="5" maxlength="10" value="<?=$set_price;?>" style="width:80px;" onchange="set_price(<?=$data->item_id?>)" /></td>
  
    <td><span id="divi_<?=$data->item_id?>">
            <? 
			  if($set_price!='')
			  {?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
			  <input type="button" name="Button" value="Update"  onclick="update_value(<?=$data->item_id?>)" style="width:70px; height:30px; background-color:#FF3366"/><?
			  }
			  else
			  {
			  ?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
			  <input type="button" name="Button" value="Set"  onclick="update_value(<?=$data->item_id?>)" style="width:50px; height:30px;background-color:#66CC66"/><? }?>
          </span>&nbsp;</td>
  </tr>
  <? }?>
</table>
</div>
<? }?>
<p>&nbsp;</p>
</form>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>