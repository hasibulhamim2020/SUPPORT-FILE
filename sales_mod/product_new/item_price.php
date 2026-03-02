<?php

session_start();

ob_start();

require "../../support/inc.all.php";





$title='Dealer Wise Price Setup';



do_calander('#odate');

auto_complete_from_db('dealer_info','concat(dealer_name_e,"-",address_e)','dealer_code','canceled="Yes"','dealer');


if($_POST['brand_name']!='') 	$brand_name=$_POST['brand_name'];

if(isset($brand_name)) 			{$brand_name_con=' and item_brand="'.$brand_name.'"';}

if($_POST['type_name']!='') 	$type_name=$_POST['type_name'];

if(isset($type_name)) 			{$type_name_con=' and t.type_name="'.$type_name.'"';}

if($_POST['BRANCH_NAME']!='') 	$region=$_POST['BRANCH_NAME'];

if(isset($region)) 			{$region_con=' and r.BRANCH_NAME="'.$region.'"';}

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



if(flag!==0) { 

//var set=(((document.getElementById('mrp_'+id).value)*1)-((((document.getElementById('mrp_'+id).value)*1)*discount)/100));    //modified date: 06-10-2020

var set=((document.getElementById('set_'+id).value)*1);

var set_price=set.toFixed(2);

}else{

var set_price=((document.getElementById('set_'+id).value)*1);

}

var strURL="item_price_ajax.php?item_id="+item_id+"&dealer_code="+dealer_code+"&discount="+discount+"&set_price="+set_price+"&flag="+flag;

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



<div class="row">

		<div class="col-md-12">

			<div class="panel panel-info" align="center">

				<div class="panel-heading">

					<h3 class="panel-title">Item Price</h3>

				</div>

				<div class="panel-body">



<form action=""  method="post" name="codz" id="codz">







 

 

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>
  </tr>



  

  <tr>
    <td align="center" bgcolor="#d9edf7"><strong>Dealer Type </strong></td>
    <td bgcolor="#d9edf7"><select name="type_name" class="form-control" id="type_name">
      <option></option>
      <?	$sql="select * from dealer_type order by type_name";

$query=db_query($sql);

while($datas=mysqli_fetch_object($query)){

?>
      <option <? if($datas->type_name==$type_name) echo 'Selected ';?> value="<?=$datas->type_name?>">
        <?=$datas->type_name?>
        </option>
      <? } ?>
    </select></td>
    <td align="center" bgcolor="#d9edf7"><strong>Region</strong></td>
    <td bgcolor="#d9edf7"><select name="region" class="form-control" id="region">
      <option></option>
      <?	$sql="select * from branch order by BRANCH_NAME";

$query=db_query($sql);

while($datas=mysqli_fetch_object($query)){

?>
      <option <? if($datas->BRANCH_NAME==$region) echo 'Selected ';?> value="<?=$datas->BRANCH_NAME;?>">
        <?=$datas->BRANCH_NAME;?>
        </option>
      <? } ?>
    </select></td>
    <td>&nbsp;</td>
    <td rowspan="2" ><strong>

      <input type="submit" name="submitit" class="form-control btn-danger" id="submitit" value="Set Price"/>

    </strong></td>
  </tr>
  <tr>

  

    <td align="center" bgcolor="#d9edf7"><strong>Select  Dealer: </strong></td>

    <td bgcolor="#d9edf7"><strong>

      <input name="dealer" class="orm-control form-control" type="text" id="dealer" value="<?=$_POST['dealer']?>" />

    </strong></td>

    <td align="center" bgcolor="#d9edf7">Item Brand </td>

    <td bgcolor="#d9edf7"><select name="brand_name" class="form-control" id="brand_name">

<option></option>

<?	$sql="select * from item_brand order by brand_name";

$query=db_query($sql);

while($datas=mysqli_fetch_object($query)){

?>

<option <? if($datas->brand_name==$brand_name) echo 'Selected ';?> value="<?=$datas->brand_name?>"><?=$datas->brand_name?></option>

<? } ?>

</select></td> <td>&nbsp;</td>
    </tr>
</table>







<br /><br />

<?

if($_POST['dealer']>0){

?>

<div class="tabledesign2" style="width:100%">



<table  align="center" class="table table-bordered table-hover" cellpadding="0" cellspacing="0">

  <tr>

    <td><strong>Dealer Name: </strong></td>

    <td><strong>

      <?=(find_a_field('dealer_info','concat(dealer_name_e,"-",address_e)','dealer_code='.$_POST['dealer']))?>

	  <input name="dealer_code" id="dealer_code" type="text" value="<? echo $_POST['dealer'];?>" /></strong></td>

  </tr>

</table>



<table width="100%" class="table-bordered table-hover" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">

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



$sql = 'select * from item_info i

where 

i.sub_group_id=10010000 

and i.finish_goods_code<1015 

'.$brand_name_con.'

order by i.finish_goods_code';



  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;



  echo $sql_price = 'select p.discount,p.set_price 
 
 from sales_corporate_price p,branch r,,dealer_info d
 
 where d.dealer_code=p.dealer_code and r.BRANCH_ID=d.region_code and d.dealer_code ="'.$_POST['dealer'].'" and p.item_id= "'.$data->item_id.' '.$region_con.$type_name_con.' "';

  $price_info = find_all_field_sql($sql_price);

  $set_distount = $price_info->discount;

  $set_price = $price_info->set_price;

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

	<input name="mrp_<?=$data->item_id?>" id="mrp_<?=$data->item_id?>" type="hidden" value=" " />

	<input name="dis_<?=$data->item_id?>" id="dis_<?=$data->item_id?>" type="text" size="5" maxlength="5" value="<?=$set_distount;?>" style="width:40px;" onchange="set_price(<?=$data->item_id?>)" /></td>

    <td><input name="set_<?=$data->item_id?>" id="set_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$set_price;?>" style="width:60px;" onblur="auto_blank(<?=$data->item_id?>)" />      </td>

    <td><span id="divi_<?=$data->item_id?>">

            <? 

			  if($set_price!='')

			  {?>

			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />

			  <input type="button" name="Button" value="Re-Set" class="btn-danger form-control"  onclick="update_value(<?=$data->item_id?>)" /><?

			  }

			  else

			  {

			  ?>

			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />

			  <input type="button" name="Button" value="Set" class="btn-success form-control" onclick="update_value(<?=$data->item_id?>)"/><? }?>

          </span>&nbsp;</td>

  </tr>

  <? }?>

</table>

</div>

<? }?>

<p>&nbsp;</p>

</form>



  </div>

		  </div>

  </div>

</div>







<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>