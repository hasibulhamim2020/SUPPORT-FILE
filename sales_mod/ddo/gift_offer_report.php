<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Gift Offer';

do_calander('#od1');
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
        <label style="width:150px;">Gift Plan Number : </label>
        
        <input style="width:155px;"  name="gpn" type="text" id="gpn" value="<? if($_POST['gpn']!='') echo $_POST['gpn'];?>"/>
      </div>
      <div>
        <label style="width:150px;">Offer Date : </label>
        
        <input style="width:155px;"  name="od1" type="text" id="id1" value="<? if($_POST['od1']!='') echo $_POST['od1']; else echo date('Y-m-d');?>"/>
      </div>
      <div>
        <label style="width:150px;">Group For : </label>
        <select id="group_for" name="group_for">
        <option value="A" <?=($_POST['group_for']=='A')?'selected':''?>>A</option>
        <option value="B" <?=($_POST['group_for']=='B')?'selected':''?>>B</option>
        <option value="C" <?=($_POST['group_for']=='C')?'selected':''?>>C</option>
        </select>
      </div>
      </fieldset></td>
    </tr>
  <tr>
    <td><div class="buttonrow" style="margin-left:240px;">
    <? if($$unique_master>0) {?>
<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="1" />
<? }else{?>
<input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="0" />
<? }?>
    </div></td>
    </tr>
</table>

  <? 
if($_POST['od1']!='')
$con .= ' and a.start_date <= "'.$_POST['od1'].'" and a.end_date >= "'.$_POST['od1'].'" ';
if($_POST['group_for']!='')
$con .= ' and a.group_for="'.$_POST['group_for'].'"';

if($_POST['gpn']!='')
$con .= ' and a.offer_name="'.$_POST['gpn'].'"';

$res = 'select a.id,a.id,a.offer_name,a.group_for as Grp,b.finish_goods_code as i_code,b.item_name,a.item_qty,c.finish_goods_code as g_code,c.item_name as gift_name,a.gift_qty,a.start_date,a.end_date from sale_gift_offer a,item_info b,item_info c where b.item_id=a.item_id and c.item_id=a.gift_id and a.group_for!=""'.$con;
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>