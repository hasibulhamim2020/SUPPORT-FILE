<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Challan Cancel Order';

do_calander('#chalan_date','-6','+0');

if($_REQUEST['chalan_no']>0) 
$chalan_no = $_REQUEST['chalan_no'];
else
$chalan_no = $_POST['chalan_no'];

$ch_do=find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);

$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$master = find_all_field('sale_do_master','','do_no='.$ch_do);

if(prevent_multi_submit()){

if(isset($_POST['confirm'])){

		
		$cancel_date=$_POST['chalan_date'];
		$cancel_note=$_POST['cancel_note'];
		$entry_at = date('Y-m-d H:i:s');
		$entry_by =$_SESSION['user']['id'];			
		$cancel_no = next_transection_no('0',$cancel_date,'sale_do_chalan_cancel','cancel_no');
		$status = 'PENDING';
		//$do = find_all_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);
		//$do_no = $do->do_no;
		//$do_chalan_date = $do->chalan_date;
		//$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
		//$sales_ledger = find_a_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
		//$dealer= find_all_field('dealer_info','account_code',"dealer_code=".$_POST['dealer_code']);
		//$dealer_ledger= $dealer->account_code;
		//$master = find_all_field('sale_do_master','','do_no='.$do_no);
		$sql = 'select * from sale_do_chalan where chalan_no = '.$chalan_no.' ';
		$query = db_query($sql);	
		while($data=mysqli_fetch_object($query))
		{
			if(($_POST['chalan_'.$data->id]>0))
			{

				
			 $ch_cancel = "INSERT INTO `sale_do_chalan_cancel` (cancel_no, cancel_date, cancel_note, `chalan_no`, gate_pass,  `chalan_date`, `order_no`, item_name,  `do_no`, `do_date`, `job_no`,
 
 
  `delivery_date`, `cbm_no`, `group_for`, `dealer_code`, `buyer_code`, `merchandizer_code`, `destination`, `delivery_place`, `customer_po_no`, `unit_name`, `measurement_unit`,
  
  
   `ply`, `paper_combination_id`, `paper_combination`, `L_cm`, `W_cm`, `H_cm`, `WL`, `WW`, `item_id`, `formula_id`, `formula_cal`, `sqm_rate`, `sqm`, `additional_info`, 
   
   
   `additional_charge`, `final_price`, `unit_price`, pcs_1,bundle_1,pcs_2,bundle_2,pcs_3,bundle_3, `total_unit`, `total_amt`, `style_no`, `po_no`, `referance`, `sku_no`, `printing_info`, `color`, `pack_type`, `size`, `depot_id`, `status`, `entry_by`, `entry_at`, `remarks`, 
   vehicle_type,vehicle_id,vehicle_no,driver_name,driver_mobile,delivery_man,delivery_man_mobile,prepared_by,authorized_by)
  
  VALUES( '".$cancel_no."', '".$cancel_date."', '".$cancel_note."', '".$data->chalan_no."', '".$data->gate_pass."',  '".$data->chalan_date."', '".$data->id."',
   '".$data->item_name."',  '".$data->do_no."', '".$data->do_date."', '".$data->job_no."', 
 
   '".$data->delivery_date."', '".$data->cbm_no."', '".$data->group_for."' , '".$data->dealer_code."',  '".$data->buyer_code."',  '".$data->merchandizer_code."',
    '".$data->destination."', '".$data->delivery_place."', '".$data->customer_po_no."',  '".$data->unit_name."',
    '".$data->measurement_unit."',

	  '".$data->ply."', '".$data->paper_combination_id."', '".$data->paper_combination."', 
     
  '".$data->L_cm."','".$data->W_cm."','".$data->H_cm."','".$data->WL."',  '".$data->WW."', 
   '".$data->item_id."', '".$data->formula_id."', '".$data->formula_cal."', '".$data->sqm_rate."', '".$data->sqm."', '".$data->additional_info."', 
   
   
   '".$data->additional_charge."', 
   '".$data->final_price."', '".$data->rate."', '".$data->pcs_1."', '".$data->bundle_1."', '".$data->pcs_2."', '".$data->bundle_2."', '".$data->pcs_3."', '".$data->bundle_3."', '".$data->total_unit."', '".$data->total_amt."', 
   '".$data->style_no."', '".$data->po_no."', '".$data->referance."', '".$data->sku_no."', '".$data->printing_info."', '".$data->color."', '".$data->pack_type."', 
   '".$data->size."',  '".$data->depot_id."', '".$status."', '".$entry_by."', '".$entry_at."', '".$data->remarks."' ,
    '".$data->vehicle_type."', '".$data->vehicle_id."', '".$data->vehicle_no."', '".$data->driver_name."', '".$data->driver_mobile."', '".$data->delivery_man."',
	 '".$data->delivery_man_mobile."', '".$data->prepared_by."', '".$data->authorized_by."'  )";

db_query($ch_cancel);
			
	
			}
			
			
		}
		
		
		$sql3 = 'update sale_do_chalan set status="CANCELED" where chalan_no = '.$chalan_no;
		db_query($sql3);
		
	
		
}
}
else
{
	$type=0;
	$msg='Data Re-Submit Warning!';
}
if($_REQUEST['chalan_no']>0) 
$chalan_no = $_REQUEST['chalan_no'];
else
$chalan_no = $_POST['chalan_no'];
if($chalan_no>0)
{
		$condition="chalan_no=".$chalan_no;
		$data=db_fetch_object($table_chalan,$condition);
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
function cal2(id) {
  var pkt_unit = ((document.getElementById('chalan_'+id).value)*1);
  var undelpkt = ((document.getElementById('undelpkt_'+id).value)*1);
  var dist_unit = ((document.getElementById('chalan2_'+id).value)*1);
  var undeldist = ((document.getElementById('undeldist_'+id).value)*1);
  if(dist_unit>undeldist)
  {
	if(pkt_unit>(undelpkt-1))
	{
		alert('Can not Receive More than delivered Pcs.');
		document.getElementById('chalan2_'+id).value='';
		document.getElementById('chalan2_'+id).focus();
	}
  }
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
  Calc_totals();
}


function calculation(id){

var unreturn_qty=(document.getElementById('unreturn_qty_'+id).value)*1; 

var return_qty=(document.getElementById('chalan2_'+id).value)*1; 

var closing_qty=(document.getElementById('closing_qty_'+id).value=(unreturn_qty-return_qty));





   if(closing_qty<0)
  {
  
alert('Can not return more than invoice quantity.');
document.getElementById('chalan2_'+id).value='';


//document.getElementById('closing_'+id).value='$info->today_close';
document.getElementById('chalan2_'+id).focus();
//document.getElementById('closing_'+id).value=(opening+issue);
  } 



}



var active_ids = new Array();
function Calc_totals() {
    var answerValues = 0; 
	var answerValue = 0;
    for(i=0; i < active_ids.length; i++) 
    { 
        answerValue = Number(document.getElementById(active_ids[i]).value);
		answerValues += Number(answerValue);
    } 

	document.getElementById('crtdiv').innerHTML = '<span>'+answerValues+'</span>';
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td><fieldset style="width:450px;">
        <div>
          <label style="width:150px;">WO NO: </label>
          <input style="width:235px;"  name="do_no2" type="text" id="do_no2" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
          <input type="hidden" name="chalan_no" id="chalan_no" value="<?=$chalan_no?>" />
        </div>
		

        <div>
          <label style="width:150px;">Customer: </label>
          <input style="width:235px;"  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code?>" readonly="readonly"/>
		  
		   <input style="width:235px;"  name="wo_detail2" type="text" id="wo_detail2" value="<?=$dealer->dealer_name_e?>" readonly="readonly"/>
        </div>
        
         <div>
          <label style="width:150px;">Buyer: </label>
          <input style="width:235px;"  name="wo_detail" type="text" id="wo_detail" value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer_code);?>" readonly="readonly"/>
        </div>
		
        <div>
          <label style="width:150px;">Merchandiser: </label>
          <input style="width:235px;"  name="wo_detail" type="text" id="wo_detail" value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer_code);?>" readonly="readonly"/>
        </div>
		
		<div>
          <label style="width:150px;">Marketing Team: </label>
          <input style="width:235px;"  name="discount" type="text" id="discount" value="<?=find_a_field('marketing_team','team_name','team_code='.$master->marketing_team);?>" readonly="readonly"/>
        </div>
		
		<div>
          <label style="width:150px;">Marketing Person: </label>
          <input style="width:235px;"  name="discount" type="text" id="discount" value="<?=find_a_field('marketing_person','marketing_person_name','person_code='.$master->marketing_person);?>" readonly="readonly"/>
        </div>
		
		
      </fieldset></td>
      <td></td>
      <td><fieldset style="width:450px;">
	  
	  <div>
          <label style="width:150px;">Company: </label>
          
		  <input name="group_for" type="text" id="group_for" style="width:215px;" value="<?=find_a_field('user_group','group_name','id='.$group_for)?>" readonly="readonly" />
        </div>
	  
	  <div>
          <label style="width:150px;">Job NO: </label>
          <input name="remarksa" type="text" id="remarkas" style="width:215px;" value="<?=$job_no?>" readonly="readonly"/>
        </div>
		
		<div>
          <label style="width:150px;">WO Date: </label>
          <input name="remarksa" type="text" id="remarkas" style="width:215px;" value="<?=$do_date?>" readonly="readonly" tabindex="10" />
        </div>
	  
        <div>
          <label style="width:150px;">Challan NO: </label>
          <input name="remarksa" type="text" id="remarkas" style="width:215px;" value="<?=$chalan_no?>"  readonly="readonly" tabindex="10" />
        </div>
        <div>
          <label style="width:150px;">Challan Date: </label>
          <input name="do_date" type="text" id="do_date" style="width:215px;" value="<?=$chalan_date?>" tabindex="10" readonly="readonly" />
        </div>
		
		<div>
          <label style="width:150px;">Customer's PO: </label>
          
		  <input name="do_type" type="text" id="do_type" style="width:215px;" value="<?=$master->customer_po_no?>"  readonly="readonly" tabindex="10" />
        </div>
		
        

	
      </fieldset></td>
      <td></td>
      <td valign="top">
      <table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">
	          
        <tr>
          <td align="left" bgcolor="#9999CC"><strong>Return Note</strong></td>
          <td align="left" bgcolor="#9999CC"><strong>DC</strong></td>
        </tr>
<?
$sql='select distinct sr_no, sr_date from sale_return_master where chalan_no='.$chalan_no.' order by sr_no desc';
$qqq=db_query($sql);
while($aaa=mysqli_fetch_object($qqq)){
?>
        <tr>
          <td bgcolor="#FFFF99"><?=$aaa->sr_date?></td>
          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="../direct_sales/sales_return_print_view.php?v_no=<?=$aaa->sr_no?>"><img src="../../images/print.png" width="15" height="15" /></a></td>
        </tr>
<?
}
?>

      </table></td>
    </tr>
	
	
	<tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="4" align="center" bgcolor="#CCFF99"><strong> Entry Information</strong></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        

        <td rowspan="2" align="left" bgcolor="#CCFF99"><a title="WO Preview" target="_blank" href="delivery_challan_print_view.php?v_no=<?=$chalan_no?>" ><img src="../../../images/print.png" alt="" width="30" height="30" /></a></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created On:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=$entry_at?></td>
        </tr>

    </table></td>

  </tr>
	
	
    <tr>
      <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr style="height:40px;">
          <td align="right" width="20%" bgcolor="#00A59A"><strong>Cancel Date :</strong></td>
          <td align="left" width="20%"bgcolor="#00A59A"><strong>
            <input style="width:120px;"  name="chalan_date" type="text" id="chalan_date" required="required" value="<?=date('Y-m-d')?>"/>
          </strong></td>
          <td bgcolor="#00A59A" align="right" width="20%"><strong>Reasons:</strong></td>
          <td bgcolor="#00A59A" align="left" width="40%"><strong>
            <input style="width:300px;"  name="cancel_note" type="text" id="cancel_note" required="required"/>
          </strong></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <? if($$unique_master>0){?>

<? 
 $sql = "select c.*, i.item_name from item_info i, sale_do_chalan c where i.item_id=c.item_id and c.chalan_no=".$chalan_no;
$res=db_query($sql);
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="tabledesign2">
      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">
      <tbody>
          <tr>
            <th width="1%" rowspan="2">SL</th>
            <th width="35%" rowspan="2">Item_Name </th>
            <th width="36%" rowspan="2">Style No</th>
            <th width="71%" rowspan="2">PO No</th>
            <th width="71%" rowspan="2">SKU</th>
            <th width="71%" rowspan="2">Color</th>
            <th width="71%" rowspan="2">Size</th>
            <th width="71%" rowspan="2">UOM</th>
            <th width="71%" rowspan="2">Ply</th>
            <th width="71%" rowspan="2">Measurement</th>
            <th width="71%" rowspan="2">Challan Qty </th>
            <th width="71%" colspan="2">Challan 1</th>
            <th width="71%" colspan="2">Challan 2 </th>
            <th width="71%" colspan="2">Challan 3 </th>
            </tr>
          <tr>
            <th width="35%">Pcs/Per Bundle</th>
            <th width="36%">Qty/ Bundle</th>
            <th width="35%">Pcs/Per Bundle</th>
            <th width="36%">Qty/ Bundle</th>
            <th width="35%">Pcs/Per Bundle</th>
            <th width="36%">Qty/ Bundle</th>
            </tr>
          <? while($row=mysqli_fetch_object($res)){$bg++?>
          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">
            <td><?=++$ss;?></td>
            <td><?=$row->item_name?></td>
              <td><? 
		  if ($row->style_no!="") {
		  echo $row->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->po_no!="") {
		  echo $row->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->sku_no!="") {
		  echo $row->sku_no;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->color!="") {
		  echo $row->color;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->size!="") {
		  echo $row->size;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><?=$row->unit_name?></td>
              <td><?=$row->ply?></td>
              <td><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?></td>
              <td><?=$row->total_unit?></td>
              <td><?=$row->pcs_1?></td>
              <td><?=$row->bundle_1?></td>
              <td><?=$row->pcs_2?></td>
              <td><?=$row->bundle_2?></td>
              <td><?=$row->pcs_3?></td>
              <td><?=$row->bundle_3?>
			  <input name="chalan_<?=$row->id?>" type="hidden" id="chalan_<?=$row->id?>" style="width:80px; float:none" value="1" required="required" />			  </td>
              </tr>
          <? }?>
		    <tr>
            <td colspan="17">&nbsp;</td>
            </tr>
      </tbody>
      </table>
      </div>
      </td>
    </tr>
  </table><br />
  <table width="100%" border="0">


<? 

//if($cow<1)
//$vars['status']='CANCELED';
//db_update($table_chalan, $chalan_no, $vars, 'chalan_no');
//db_update($table_detail, $do_no, $vars, 'do_no');
//db_update($table_master, $do_no, $vars, 'do_no');

$cancel_count = find_a_field('sale_do_chalan','count(do_no)',' status="CANCELED" and chalan_no='.$chalan_no);


if($cancel_count==0){

?>
<tr>
<td align="center"><input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
<input name="confirm" type="submit" class="btn1" value="COMPLETE ENTRY" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>
</tr>


<? } else {?>
<tr>
<td align="center" bgcolor="#FF3333"><strong>THIS CHALLAN HAS BEEN CANCELLED  </strong></td>
</tr>
<? }?>

</table>
</form>
<? }?>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>