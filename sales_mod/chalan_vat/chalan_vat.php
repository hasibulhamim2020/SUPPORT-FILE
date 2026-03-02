<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Chalan Vat Report';

do_calander('#fdate');
do_calander('#tdate');
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


var strURL="item_price_ajax.php?item_id="+id;



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
<table  style="width:80%; margin:0 auto; border:0; text-align:center;">
  <tr>
    <td width="32%">&nbsp;</td>
    <td width="40%" colspan="3">&nbsp;</td>
    <td width="28%">&nbsp;</td>
  </tr>
  <?
  if($_POST['fdate']!=''){
  $fdate= $_POST['fdate'];}
  else {
  $fdate = date('Y-m-01');}
  
  if($_POST['tdate']!=''){
  $tdate= $_POST['tdate'];}
  else{
  $tdate = date('Y-m-d');}
  
  ?>
  <tr>
    <td  style="background-color:#FF9966; text-align:right;"><strong> Date : </strong></td>
    <td style="background-color:#FF9966;"><input name="fdate" type="text" id="fdate" style="width:107px;" value="<?=$fdate?>" /></td>
    <td  style="background-color:#FF9966; text-align:center;">TO </td>
    <td  style="background-color:#FF9966; text-align:right;"><input name="tdate" type="text" id="tdate" style="width:107px;" value="<?=$tdate?>" /></td>
    <td style="background-color:#FF9966;">&nbsp;</td>
  </tr>
  <tr>
    <td  style="background-color:#FF9966; text-align:right;"><strong>Depot : </strong></td>
    <td colspan="3" style="background-color:#FF9966;">
	<select name="warehouse" id="warehouse">
	
<?
foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse'],'use_type="SD"');
?>
    </select>    </td>
    <td style="background-color:#FF9966;"><strong>
      <input type="submit" name="submitit" id="submitit" value="Open Balance" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>
<br /><br />
<?
if($_POST['tdate']!=""){
?>
<div class="tabledesign2" style="width:100%">
<table id="grp"  style="width:100%; border:0; border-collapse:collapse; padding:0; text-align:center;">
  <tr>
    <th style="width:2%; text-align:center;">S/L</th>
    <th style="width:10%; text-align:center;"><div align="center">Challan No </div></th>
    <th  style="width:5%; text-align:center;"><div align="center">Do No </div></th>
    <th  style="width:14%; text-align:center;"><div align="center">Chalan Date</div></th>
    <th style="width:31%;">Dealer Name</th>
    <th style="width:11%;">Area</th>
    <th style="width:14%; text-align:center;"><div align="center">Total Chalan Amt </div></th>
    <th  style="width:3%; text-align:center;"><div align="center">VAT</div></th>
    <th  style="width:10%; text-align:center;"><div align="center">Action</div></th>
  </tr>
  <?
  if($_POST['fdate']!="" && $_POST['tdate']!=""){
  $date_con=" and c.chalan_date between '".$_POST['fdate']."' and '".$_POST['tdate']."' ";
  }
  
  if($_POST['warehouse']!=""){
  $depot_con=" and c.depot_id=".$_POST['warehouse'];
  }
  
$sqls="select c.chalan_no,m.do_no,m.do_date,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot, sum(c.total_amt) as total_amt, a.AREA_NAME, c.vat_approval from 

sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w, area a

where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and d.area_code=a.AREA_CODE".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con.$area_con." group by chalan_no order by c.chalan_no";



$query = db_query($sqls);


while($data=mysqli_fetch_object($query)){



?>
  <tr style="background-color:<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=++$s?></td>
    <td><?=$data->chalan_no?></td>
    <td><?=$data->do_no?></td>
    <td><?=$data->do_date?></td>
    <td><?=$data->dealer_name?></td>
    <td><?=$data->AREA_NAME;?></td>
    <td><?=$data->total_amt;?></td>
    <td><input name="vat_approval_<?=$data->chalan_no?>" id="vat_approval_<?=$data->chalan_no?>" type="checkbox" value="YES" style="width:30px;" />      </td>
    <td><span id="divi_<?=$data->chalan_no?>">
            <? 
			  if($data->vat_approval=='YES')
			  {?>
			  <input name="flag_<?=$data->chalan_no?>" type="hidden" id="flag_<?=$data->chalan_no?>" value="1" />
			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->chalan_no?>)" style="width:40px; height:20px; background-color:#FF3366"/><?
			  }
			  elseif($data->vat_approval=='')
			  {
			  ?>
			  <input name="flag_<?=$data->chalan_no?>" type="hidden" id="flag_<?=$data->chalan_no?>" value="0" />
			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->chalan_no?>)" style="width:53px; height:32px;background-color:#66CC66"/><? }?>
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