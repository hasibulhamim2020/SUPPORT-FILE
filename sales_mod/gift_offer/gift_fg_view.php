<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Gift Offer';

do_calander('#do_date');
do_calander('#od2');

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
        <label style="width:150px;">FG Code  : </label>
        
<input style="width:155px;"  name="fg_code" type="text" id="fg_code" 
value="<? if($_POST['fg_code']!='') echo $_POST['fg_code'];?>"/>
      </div>
      <div>
        <label style="width:150px;">Offer Date : </label>
		
<input style="width:155px;"  name="do_date" type="text" id="do_date" 
value="<? if($_POST['do_date']){echo $_POST['do_date'];}else{echo date('Y-m-d');}?>"/>

      
<!--<input style="width:155px;"  name="od1" type="text" id="id1" value="<? if($_POST['od1']!='') echo $_POST['od1']; else echo date('Y-m-d');?>"/>-->


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
if($_POST['do_date']!='')
$con .= ' and a.start_date <= "'.$_POST['do_date'].'" and a.end_date >= "'.$_POST['do_date'].'" ';

if($_POST['group_for']!='')
$con .= ' and a.group_for="'.$_POST['group_for'].'"';

if($_POST['fg_code']!='')
$con .= ' and a.offer_name="'.$_POST['fg_code'].'"';

if($_POST['new']){

$item_id = find_a_field('item_info','item_id',' finish_goods_code="'.$_POST['fg_code'].'"');

$res = 'select d.do_no,d.do_no,d.dealer_code,i.item_name,d.entry_time,d.gift_on_item,d.gift_id
from sale_do_details d, item_info i
where d.item_id=i.item_id and d.do_date = "'.$_POST['do_date'].'" 
and (i.item_id="'.$item_id.'" or d.gift_on_item="'.$item_id.'")
order by id
';
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