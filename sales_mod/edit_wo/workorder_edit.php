<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Work Order Update';

do_calander('#wo_date');
do_calander('#chalan_date');

$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$do_no=$_POST['wo_id'];


	if(isset($_POST[$unique_master])&&!isset($_POST['confirm']))
	{
	$$unique_master=$_POST[$unique_master];
	$res='select a.id from sale_do_details a where a.do_no='.$do_no;
	$query=db_query($res);
		while($w=mysqli_fetch_object($query))
		{
			if(isset($_POST['edit#'.$w->id]))
			{
$_POST['id']=$w->id;
$_POST['unit_price'] = $_POST['unit_price#'.$w->id];
$_POST['pkt_unit'] = $_POST['pkt_unit#'.$w->id];
$_POST['dist_unit'] = $_POST['dist_unit#'.$w->id];
$_POST['pkt_size'] = $_POST['pkt_size#'.$w->id];
$_POST['total_amt'] = $_POST['total_amt#'.$w->id];
$_POST['total_unit'] = $_POST['total_unit#'.$w->id];

$crud   = new crud($table_detail);
$crud->update($unique_detail);
$type=1;
$msg='Successfully Edited.';
			}
		}
	}

if(isset($_POST['confirm']))

{
		unset($_POST);
		$_POST['id']=$wo_id;
		$_POST['status']='DONE';
		$crud   = new crud('lc_workorder');
		$crud->update('id');
		unset($wo_id);
		unset($_SESSION['wo_id']);
		$type=1;
		$msg='Successfully Send to Factory.';
}



if($$unique_master>0)

{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=@each($data))
		{ $$key=$value;}
		
		$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);
		auto_complete_start_from_db('item_info','concat(finish_goods_code,"#>",item_name)','finish_goods_code','product_nature="Salable" and sales_item_type like "%'.$dealer->product_group.'%"','item');
}



if(isset($_POST['add'])&&($_POST['wo_id']>0))

{
		$table		='lc_workorder_chalan';
		$crud      	=new crud($table);
		$crud->insert();
}

if(isset($_POST['dwo']))
{
$dsql='delete from '.$table_master.' where id='.$_GET['wo_id'];	
$disql='delete from lc_workorder_details where wo_id='.$_GET['wo_id'];	
db_query($dsql);
db_query($disql);
$type=2;
$msg='Work Order Successfully Deleted.';
}

?>
<script language="javascript">
function total_calculate(id)
{
var pkt_unit = ((document.getElementById('pkt_unit#'+id).value)*1);
var dist_unit = ((document.getElementById('dist_unit#'+id).value)*1);
var pkt_size = ((document.getElementById('pkt_size#'+id).value)*1);

var total_unit = (pkt_unit*pkt_size)+dist_unit;
var unit_price = ((document.getElementById('unit_price#'+id).value)*1);
var total_amt  = (total_unit*unit_price);
document.getElementById('total_unit#'+id).value=total_unit;
document.getElementById('total_amt#'+id).value	= total_amt .toFixed(2);
}
</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td><fieldset style="width:240px;">
        <div>
          <label style="width:75px;">Order No : </label>
          <input style="width:155px;"  name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:75px;">Dealer : </label>
          <select style="width:145px;" id="dealer_code" name="dealer_code" readonly="readonly">
            <option value="<?=$dealer->dealer_code;?>">
              <?=$dealer->dealer_name_e.'-'.$dealer->dealer_code;?>
              </option>
          </select>
          <input style="width:10px;"  name="group_for" type="text" id="group_for" value="<?=$dealer->product_group;?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:75px;">Area : </label>
          <input style="width:155px;"  name="wo_detail2" type="text" id="wo_detail2" value="<?=find_a_field('area','AREA_NAME','AREA_CODE='.$dealer->area_code)?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:75px;">Zone : </label>
          <input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=find_a_field_sql('select a.ZONE_NAME from zon a,area b where a.ZONE_CODE=b.ZONE_ID and b.AREA_CODE='.$dealer->area_code)?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:75px;">Region : </label>
          <input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=find_a_field_sql('select c.BRANCH_NAME from zon a,area b,branch c where a.REGION_ID=c.BRANCH_ID and a.ZONE_CODE=b.ZONE_ID and b.AREA_CODE='.$dealer->area_code)?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:75px;">Depot : </label>
          <select style="width:155px;" id="depot_id" name="depot_id" readonly="readonly">
            <option value="<?=$dealer->depot;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$dealer->depot)?>
              </option>
          </select>
        </div>
      </fieldset></td>
      <td><fieldset style="width:220px;">
        <div>
          <label style="width:105px;">Order Date : </label>
          <input style="width:105px;"  name="do_date" type="text" id="do_date" value="<?=date('Y-m-d')?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:105px;">Undel Amt : </label>
          <?
            
			?>
          <input style="width:105px;"  name="wo_subject" type="text" id="wo_subject" value="<? echo $av_amt=(find_a_field_sql('select sum(total_amt) from sale_do_details where  	dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"')-find_a_field_sql('select sum(total_amt) from sale_do_chalan where  	dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"'))?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:105px;">Credit Limit : </label>
          <input style="width:105px;"  name="wo_subject" type="text" id="wo_subject" value="<?=$dealer->credit_limit?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:105px;">Available Amt : </label>
          <input style="width:105px;"  name="thickness" type="text" id="thickness" value="<? echo $av_amt=find_a_field_sql('select sum(dr_amt)-sum(cr_amt) from journal where ledger_id='.$dealer->account_code)?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:105px;">Order Limit : </label>
          <input style="width:105px;"  name="thickness" type="text" id="thickness" value="<?=$thickness?>" readonly="readonly"/>
        </div>
        <div>
          <label style="width:105px;">Est Date: </label>
          <input style="width:105px;"  name="est_date" type="text" id="est_date" value="<?=date('Y-m-d')?>"/>
        </div>
      </fieldset></td>
      <td><fieldset style="width:240px;">
        <div>
          <label style="width:75px;">Address: </label>
          <textarea name="delivery_address" id="delivery_address" style="width:155px;"><? if($delivery_address!='') echo $delivery_address; else echo $dealer->address_e?>
  </textarea>
        </div>
        <div>
          <label style="width:75px;">Rcv Amt: </label>
          <input name="rcv_amt" type="text" id="rcv_amt" style="width:155px;" value="<?=$rcv_amt?>" tabindex="10" />
        </div>
        <div>
          <label style="width:75px;">Payment By: </label>
          <select style="width:155px;" id="payment_by" name="payment_by">
            <option value="Cash" <?=($payment_by=='Cash')?'selected':''?>>Cash</option>
            <option value="Bank" <?=($payment_by=='Bank')?'selected':''?>>Bank</option>
            <option value="Cheque" <?=($payment_by=='Cheque')?'selected':''?>>Cheque</option>
          </select>
        </div>
        <div>
          <label style="width:75px;">Bank: </label>
          <select style="width:155px;" id="bank" name="bank">
            <option></option>
            <? foreign_relation('tbl_bank','bank','bank',$bank);?>
          </select>
        </div>
        <div>
          <label style="width:75px;">Note: </label>
          <input name="remarks" type="text" id="remarks" style="width:155px;" value="<?=$remarks?>" tabindex="10" />
        </div>
      </fieldset></td>
    </tr>
    <tr>
      <td colspan="3"><div class="buttonrow" style="margin-left:240px;">
        <input name="wo_id" type="hidden" id="wo_id" value="<?=$$unique_master?>" />
        <? if($$unique_master>0) {?>
        <input name="flag" id="flag" type="hidden" value="1" />
        <? }else{?>
        <input name="flag" id="flag" type="hidden" value="0" />
        <? }?>
      </div></td>
    </tr>
  </table>
  <? if($$unique_master>0){?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>

      <td><div class="tabledesign2">

        <p>
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<tbody><tr>
<th>Item Code</th>
<th>Item Name</th>
<th>Dealer Price</th>
<th>Crt Qty</th>
<th>Pcs Qty</th>
<th>Total</th>
<th>Edit</th></tr>
<? 
$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price,a.pkt_unit,a.dist_unit,a.pkt_size,a.total_amt,a.total_unit,"X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master;
$query=db_query($res);
while($wo_item=mysqli_fetch_object($query)){
?>
<tr <? if($i%2) echo 'class="alt"';?>>
<td><?=$wo_item->code?></td>
<td><?=$wo_item->item_name?></td>
<td><input name="<?='unit_price#'.$wo_item->id?>" type="text" id="<?='unit_price#'.$wo_item->id?>" style="width:70px;" value="<?=$wo_item->unit_price?>" readonly="readonly" onchange="total_calculate(<?=$wo_item->id?>)" /></td>
<td>
<input type="text" name="<?='pkt_unit#'.$wo_item->id?>" id="<?='pkt_unit#'.$wo_item->id?>" value="<?=$wo_item->pkt_unit?>" style="width:70px;" onchange="total_calculate(<?=$wo_item->id?>)" /></td>
<td><input name="<?='dist_unit#'.$wo_item->id?>" type="text" id="<?='dist_unit#'.$wo_item->id?>" style="width:70px;" onchange="total_calculate(<?=$wo_item->id?>)" value="<?=$wo_item->dist_unit?>" />
  <input name="<?='pkt_size#'.$wo_item->id?>" type="hidden" class="input3" id="<?='pkt_size#'.$wo_item->id?>"  style="width:55px;"  value="<?=$wo_item->pkt_size?>" readonly="readonly" onchange="total_calculate(<?=$wo_item->id?>)"/></td>
<td><input name="<?='total_amt#'.$wo_item->id?>" type="text" id="<?='total_amt#'.$wo_item->id?>" style="width:100px;" value="<?=$wo_item->total_amt?>" readonly="readonly" onchange="total_calculate(<?=$wo_item->id?>)" />
  <input name="<?='total_unit#'.$wo_item->id?>" type="hidden" class="input3" id="<?='total_unit#'.$wo_item->id?>"  style="width:55px;" onchange="total_calculate(<?=$wo_item->id?>)" value="<?=$wo_item->total_unit?>" readonly="readonly"/></td>
<td align="center"><input name="<?='edit#'.$wo_item->id?>" type="submit" id="Edit" value="Edit" style="width:30px; height:20px;" onclick="total_calculate(<?=$wo_item->id?>)" /></td>
</tr>
<?
}
?>
</tbody></table>
        </p>

      </div></td>

    </tr>

	

    <tr>

     <td>



 </td>

    </tr>

  </table>

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                            <td colspan="6" align="center" bgcolor="#CCCCFF"><strong>CHALAN DELIVER</strong></td>

      </tr>

    </table>
					  <br /><br />
<? 
$res='select a.id,a.id,a.item_id,b.item_name, (select sum(pkt_unit) from sale_do_chalan where order_no=a.id) as del_pkt, (select sum(dist_unit) from sale_do_chalan where order_no=a.id) as del_pkt from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
echo link_report($res);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>

<table width="100%" border="0">

  <tr>

      <td align="center"><p>&nbsp;</p></td>

      

    </tr>

</table>

</form>

<? }?>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>