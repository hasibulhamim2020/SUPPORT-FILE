<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Demand Order Create';



if($_POST['do']>0) {
$do_no = $_POST['do'];}
else{
$do_no = $_POST['do_no'];}

$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';


if(prevent_multi_submit()){

if(isset($_POST['confirm'])){
		$driver_name=$_POST['driver_name'];
		$vehicle_no=$_POST['vehicle_no'];
		$delivery_man=$_POST['delivery_man'];
		$chalan_date=$_POST['chalan_date'];
		$now = date('Y-m-d H:i:s');
		
		$sql = 'select * from sale_do_details where do_no = '.$do_no;
		$query = db_query($sql);
		$chalan_no = find_a_field('sale_do_chalan','max(chalan_no)','1')+1;
		while($data=mysqli_fetch_object($query))
		{
			if(($_POST['chalan_'.$data->id]>0)||($_POST['chalan2_'.$data->id]>0))
			{
				$chalan_pkt=$_POST['chalan_'.$data->id];
				$chalan_dist=$_POST['chalan2_'.$data->id];
				$unit_qty=(($data->pkt_size*$chalan_pkt)+$chalan_dist);
				$total_amt = ($unit_qty*$data->unit_price);
				$total_amt_all = $total_amt_all + $total_amt;
				$dealer_code = $_POST['dealer_code'];
				$q = "INSERT INTO `sale_do_chalan` (`order_no`,chalan_no, `do_no`, `item_id`,`dealer_code`, `unit_price`, `pkt_size`, `pkt_unit`, `dist_unit`, `total_unit`, `total_amt`, `chalan_date`, `depot_id`, `driver_name`, `vehicle_no`,`delivery_man`, `entry_by`, `entry_at`) 
				VALUES 
				('".$data->id."', '".$chalan_no."', '".$do_no."', '".$data->item_id."', '".$dealer_code."', '".$data->unit_price."', '".$data->pkt_size."', '".$chalan_pkt."', '".$chalan_dist."', '".$unit_qty."', '".$total_amt."', '".$chalan_date."', '".$data->depot_id."', '".$driver_name."', '".$vehicle_no."', '".$delivery_man."', '".$_SESSION['user']['id']."', '".$now."')";
				db_query($q);
				$xid = db_insert_id();
				journal_item_control($data->item_id ,$data->depot_id,$_POST['chalan_date'],0,$unit_qty,'Sales',$xid);
			}
		}
		if($total_amt_all>0)
		{
			$dealer_ledger = find_a_field('config_group_class','sales_ledger',"1");;
			$sales_ledger= find_a_field('dealer_info','account_code',"dealer_code=".$_POST['dealer_code']);
			auto_insert_sale(strtotime($_POST['chalan_date']),$dealer_ledger,$sales_ledger,$do_no,$total_amt_all,$chalan_no);
		}
}
}
else
{
	$type=0;
	$msg='Data Re-Submit Warning!';
}
if($$unique_master>0)
{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','item');
?>
<script language="javascript">
function count()
{
var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
var dist_unit = ((document.getElementById('dist_unit').value)*1);
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var total_unit = (pkt_unit*pkt_size)+dist_unit;
var unit_price = ((document.getElementById('unit_price').value)*1);
var total_amt  = (total_unit*unit_price);
document.getElementById('total_unit').value=total_unit;
document.getElementById('total_amt').value	= total_amt .toFixed(2);
}
function cal(id) {
  var pkt_unit = ((document.getElementById('chalan_'+id).value)*1);
  var undelpkt = ((document.getElementById('undelpkt_'+id).value)*1);
  if(pkt_unit>undelpkt)
  {
alert('Can not Delivery More than Undelivered Pkt.');
document.getElementById('chalan_'+id).value='';
document.getElementById('chalan_'+id).focus();
  }
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td><fieldset style="width:320px;">
        <div>
          <label style="width:75px;">Order No : </label>
          <input style="width:235px;"  name="do_no2" type="text" id="do_no2" value="<? if($$unique_master>0) {echo $$unique_master;} else {echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);} ?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:75px;">Dealer : </label>
          <select style="width:235px;" id="dealer_code" name="dealer_code" readonly="readonly">
            <option value="<?=$dealer->dealer_code;?>">
              <?=$dealer->dealer_name_e.' ['.$dealer->dealer_code.']';?>
              </option>
          </select>
        </div>
        <div>
          <label style="width:75px;">Area : </label>
          <input style="width:235px;"  name="wo_detail2" type="text" id="wo_detail2" value="<?=find_a_field('area','AREA_NAME','AREA_CODE='.$dealer->area_code)?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:75px;">Zone : </label>
          <input style="width:235px;"  name="wo_detail" type="text" id="wo_detail" value="<?=find_a_field_sql('select a.ZONE_NAME from zon a,area b where a.ZONE_CODE=b.ZONE_ID and b.AREA_CODE='.$dealer->area_code)?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:75px;">Region : </label>
          <input style="width:235px;"  name="wo_detail" type="text" id="wo_detail" value="<?=find_a_field_sql('select c.BRANCH_NAME from zon a,area b,branch c where a.REGION_ID=c.BRANCH_ID and a.ZONE_CODE=b.ZONE_ID and b.AREA_CODE='.$dealer->area_code)?>" readonly="readonly"/>
        </div>
      </fieldset></td>
      <td></td>
      <td><fieldset style="width:300px;">
        <div>
          <label style="width:75px;">Chalan Dt: </label>
          <input name="chalan_date" type="text" id="chalan_date" style="width:215px;" value="<?=date('Y-m-d')?>" tabindex="10" readonly="readonly" />
        </div>
        <div>
          <label style="width:75px;">Address: </label>
          <textarea name="delivery_address" id="delivery_address" style="width:215px;"><? if($delivery_address!=''){ echo $delivery_address;} else {echo $dealer->address_e;} ?>
  </textarea>
        </div>
        <div>
          <label style="width:75px;">Note: </label>
          <input name="remarks" type="text" id="remarks" style="width:215px;" value="<?=$remarks?>" tabindex="10" />
        </div>
        <div>
          <label style="width:75px;">Depot : </label>
          <select style="width:215px;" id="depot_id2" name="depot_id2" readonly="readonly">
            <option value="<?=$dealer->depot;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$dealer->depot)?>
              </option>
          </select>
        </div>
      </fieldset></td>
      <td></td>
      <td valign="top">
      <table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">
        <tr>
          <td style="background-color: #9999CC; text-align: left;"><strong>Date</strong></td>
          <td style="background-color: #9999CC; text-align: left;"><strong>DC</strong></td>
        </tr>
<?
$sql='select distinct chalan_no,chalan_date from sale_do_chalan where do_no='.$do_no.' order by chalan_no desc';
$qqq=db_query($sql);
while($aaa=mysqli_fetch_object($qqq)){
?>
        <tr>
          <td style="background-color: #FFFF99;"><?=$aaa->chalan_date?></td>
		  
          <td style="background-color: #FFFF99; text-align: center;"><a href="chalan_view.php?v_no=<?=$aaa->chalan_no?>"><img src="../../images/print.png" width="15" height="15" /></a></td>
        </tr>
<?
}
?>

      </table></td>
    </tr>
    <tr>
      <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="right" style="background-color: #9999FF;"><strong>Chalan Date:</strong></td>
          <td style="background-color: #9999FF;"><strong>
            <input style="width:105px;"  name="chalan_date" type="text" id="chalan_date" readonly="readonly" value="<?=date('Y-m-d')?>"/>
          </strong></td>
          <td align="right" style="background-color: #9999FF;"><strong>Delivery Man:</strong></td>
          <td style="background-color: #9999FF;"><strong>
            <input style="width:105px;"  name="delivery_man" type="text" id="delivery_man" required/>
          </strong></td>
          <td align="right" style="background-color: #9999FF;"><strong>Driver Name:</strong></td>
          <td style="background-color: #9999FF;"><strong>
            <input style="width:105px;"  name="driver_name" type="text" id="driver_name" required/>
          </strong></td>
          <td align="right" style="background-color: #9999FF;"><strong>Truck No:</strong></td>
          <td style="background-color: #9999FF;"><strong>
            <input style="width:105px;"  name="vehicle_no" type="text" id="vehicle_no" required/>
          </strong></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <? if($$unique_master>0){?>

<? 
$sql='select a.id,a.item_id,b.item_name,a.pkt_unit,a.dist_unit,a.total_unit,a.pkt_size from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master;
$res=db_query($sql);
?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="tabledesign2">
      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">
      <tbody>
          <tr>
            <th width="50%" rowspan="2">Item Name</th>
            <th colspan="2" style="background-color: #FF99FF">Order Qty</th>
            <th colspan="2" style="background-color: #009900">Del Qty</th>
            <th colspan="2" style="background-color: #FFFF00">Undel Qty</th>
            <th colspan="2" style="background-color: #0099CC">Chalan Qty</th>
          </tr>
          <tr>
              <th width="7%">Crt</th>
              <th width="7%">Pcs</th>
              <th width="6%">Crt</th>
              <th width="6%">Pcs</th>
              <th width="7%">Crt</th>
              <th width="8%">Pcs</th>
              <th width="4%">Crt</th>
              <th width="5%">Pcs</th>
              </tr>
          <? while($row=mysqli_fetch_object($res)){$bg++?>
		  <tr style="background-color: <?= (($bg % 2) == 1) ? '#FFEAFF' : '#DDFFF9' ?>">

              <td><?=$row->item_name?></td>
              <td align="center"><?=$row->pkt_unit?></td>
              <td align="center"><?=$row->dist_unit?></td>
              <td align="center"><? $del_qty = find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"');
			  if($del_qty>0){ echo $del_pkt = (int)($del_qty/$row->pkt_size);} else {echo 0;} ?></td>
              <td align="center"><? if($del_qty>0) {echo $del_dist = (int)($del_qty%$row->pkt_size);} else {echo 0;} ?></td>
              <td align="center"><? $undel_qty=($row->total_unit-$del_qty); echo $undel_pkt = (int)($undel_qty/$row->pkt_size);?>
                <input type="hidden" name="undelpkt_<?=$row->id?>" id="undelpkt_<?=$row->id?>" value="<?=$undel_pkt?>" /></td>
              <td align="center"><? echo $undel_dist = (int)($undel_qty%$row->pkt_size);?>
                <input type="hidden" name="undeldist_<?=$row->id?>" id="undeldist_<?=$row->id?>" value="<?=$undel_dist?>" /></td>
              <td align="center" style="background-color: #66FF66; text-align:center">
                <? if($undel_pkt>0){?><input type="text" name="chalan_<?=$row->id?>" id="chalan_<?=$row->id?>" required style="width:40px; float:none" onchange="cal(<?=$row->id?>)" /><? } else {echo 'Done'; }?></td>
              <td align="center" style="background-color: #6699FF; text-align:center">
			  <? if($undel_qty>0){$cow++;?>
                <input name="chalan2_<?=$row->id?>" type="text" id="chalan2_<?=$row->id?>" style="width:40px; float:none" value="0" required="required" />
                <? } else { echo 'Done';} ?></td>
              </tr>
          <? }?>
      </tbody>
      </table>
      </div>
      </td>
    </tr>
  </table><br />
  <table width="100%" border="0">
    <? if($cow<1){
$vars['status']='COMPLETED';
db_update($table_chalan, $do_no, $vars, 'do_no');
db_update($table_details, $do_no, $vars, 'do_no');
db_update($table_master, $do_no, $vars, 'do_no');
?>
<tr>
<td colspan="2" align="center" style="background-color: #FF3333;"><strong>THIS DELIVERY ORDER IS COMPLETE</strong></td>
</tr>
<? }else{?>
<tr>
<td align="center"><input name="delete" type="submit" class="btn1" value="CANCEL DELIVERY ORDER" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />
<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/></td>
<td align="center"><input name="confirm" type="submit" class="btn1" value="COMPLETE DELIVERY ORDER" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>
</tr>
<? }?>
</table>
</form>
<? }?>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>