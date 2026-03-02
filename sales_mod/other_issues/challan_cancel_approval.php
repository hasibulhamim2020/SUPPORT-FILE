<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Challan Cancel Order Approval';

//do_calander('#chalan_date','-6','+0');

if($_REQUEST['chalan_no']>0) 
$chalan_no = $_REQUEST['chalan_no'];
else
$chalan_no = $_POST['chalan_no'];

$ch_do=find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);
$cancel=find_all_field('sale_do_chalan_cancel','','chalan_no='.$chalan_no);

$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan_cancel';
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
		
		
		
		$sql3 = 'update sale_do_chalan_cancel set status="CANCELED" where chalan_no='.$chalan_no;
		db_query($sql3);
		
		
		
		$sql = 'delete from sale_do_chalan where status="CANCELED" and chalan_no="'.$chalan_no.'"';
		db_query($sql);
	
		
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
            <input style="width:120px;"  name="chalan_date" type="text" id="chalan_date" required="required" value="<?=$cancel->chalan_date?>" readonly=""/>
          </strong></td>
          <td bgcolor="#00A59A" align="right" width="20%"><strong>Reasons:</strong></td>
          <td bgcolor="#00A59A" align="left" width="40%"><strong>
            <input style="width:300px;"  name="cancel_note" type="text" id="cancel_note"  value="<?=$cancel->cancel_note?>" required="required" readonly=""/>
          </strong></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <? if($$unique_master>0){?>

<? 
 $sql = "select c.*, i.item_name from item_info i, sale_do_chalan_cancel c where i.item_id=c.item_id and c.chalan_no=".$chalan_no;
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
              <td><?=$row->bundle_3?></td>
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

$cancel_count = find_a_field('sale_do_chalan_cancel','count(cancel_no)',' status="PENDING" and chalan_no='.$chalan_no);


if($cancel_count>0){

?>
<tr>
<td align="center"><input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
<input name="confirm" type="submit" class="btn1" value="CONFIRM ENTRY" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>
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