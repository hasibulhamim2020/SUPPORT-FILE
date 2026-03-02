<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Gift Offer Report';

do_calander('#fdate');
do_calander('#tdate');

$table_master='sale_gift_offer';
$unique_master='id';
$page = $target_url = 'gift_offer.php';

?>


<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><fieldset style="width:700px;">
	      <div>
        <label style="width:150px;">Gift Plan Number : </label>
        
<input style="width:155px;"  name="gpn" type="text" id="gpn" 
value="<? if($_POST['gpn']!='') echo $_POST['gpn'];?>"/>
      </div>

<?php 
auto_complete_from_db('item_info','item_name','finish_goods_code','product_nature="Salable"','item_id');
?>	  
<div>
<label style="width:150px;">Item : </label>
<input style="width:355px;"  name="item_id" type="text" id="item_id" value="<? if($_POST['item_id']!='') echo $_POST['item_id'];?>"/>
</div>
      
	  
	  <div>
        <label style="width:150px;">Offer Date : </label>
		
<input style="width:155px;"  name="fdate" type="text" id="fdate" value="<? if($_POST['fdate']!=''){echo $_POST['fdate'];}else{echo date('Y-m-01');}?>"/> 
   
<input style="width:155px;"  name="tdate" type="text" id="tdate" value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d');?>"/>
</div>
      <div>
        <label style="width:150px;">Group For : </label>
        <select id="group_for" name="group_for">
		<option><?=$_POST['group_for'];?></option>
<? foreign_relation('product_group','group_name','group_name',$PBI_GROUP,'1 order by group_name');?>
        </select>
      </div>
      </fieldset></td>
    </tr>
  <tr>
    <td><div class="buttonrow" style="margin-left:240px;">
    <? if($$unique_master>0) {?>
<!--<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />-->
<input name="flag" id="flag" type="hidden" value="1" />
<? }else{?>
<input name="new" type="submit" class="btn1" value="Report" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="0" />
<? }?>
    </div></td>
    </tr>
</table>

<? 
if($_POST['fdate']!='')
$con .= ' and a.start_date >= "'.$_POST['fdate'].'" and a.end_date <= "'.$_POST['tdate'].'" ';

if($_POST['group_for']!='')
$con .= ' and a.group_for="'.$_POST['group_for'].'"';

if($_POST['item_id']!='')
$con .= ' and b.finish_goods_code="'.$_POST['item_id'].'"';

if($_POST['gpn']!='')
$con .= ' and a.offer_name="'.$_POST['gpn'].'"';

if($_POST['new']){
 $res='select a.id,a.id,concat(a.offer_name,"-",a.group_for) as offer,a.start_date as Start,a.end_date as End,
b.finish_goods_code as code,b.item_name,a.item_qty, a.min_qty,a.max_qty,
c.finish_goods_code as g_code,a.gift_qty
from sale_gift_offer a,item_info b,item_info c 
where b.item_id=a.item_id and c.item_id=a.gift_id 
'.$con.'
and a.group_for!="" 
order by id desc';
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
echo link_report($res,$page);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table></form>

</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>