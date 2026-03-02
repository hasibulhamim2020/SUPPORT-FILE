<?php

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Bill Create For Vendor';
do_calander('#receive_date');
$grn_no = $_REQUEST['grn_no'];
$table_master='vendor_invoice_master';
$table_details='vendor_invoice_details';
$unique='system_invoice_no';
if($_SESSION[$unique]>0)
$$unique=$_SESSION[$unique];
if($_REQUEST[$unique]>0){
$$unique=$_REQUEST[$unique];
$_SESSION[$unique]=$$unique;}
else
$$unique = $_SESSION[$unique];

$config_ledger = find_all_field('config_group_class','',"group_for=".$_SESSION['user']['group']);


$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');

if(isset($_POST['master_insert'])){
$_POST['vendor_id'] = end(explode("->",$_POST['vendor_id']));
$_POST['group_for'] = $_SESSION['user']['gorup'];
$crud   = new crud($table_master);
$_POST[$unique]=$$unique=$_SESSION[$unique]=$crud->insert();
}

if(isset($_POST['master_update'])){
$_POST['vendor_id'] = end(explode("->",$_POST['vendor_id']));
$crud   = new crud($table_master);
$crud->update($unique);
}

if(isset($_POST['fgadd']) && $_SESSION['csrf_token']===$_POST['csrf_token']){
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
if($_SESSION[$unique]>0){

$crud   = new crud($table_details);
$_POST['item_id'] = end(explode("->",$_POST['item_id']));
$crud->insert();

}
}

if(isset($_POST['cancel']))

{

		$crud   = new crud($table_master);

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		$crud   = new crud($table_details);

		$condition=$unique."=".$$unique;		

		$crud->delete_all($condition);
		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Deleted.';
		$tr_type="Delete";

}

if(isset($_GET['fgdel']) && $_GET['fgdel']>0){

$crud   = new crud($table_details);
$condition="id=".$_GET['fgdel'];		
$crud->delete($condition);

}



if(isset($_POST['return']))

{
        $remarks = $_POST['return_remarks'];
		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$_POST['status']='MANUAL';

		$crud   = new crud($table_master);

		$crud->update($unique);
		
		 $note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique.'","PR","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
		db_query($note_sql);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		header('location:select_upcoming_po.php');

}


$doc_vendor =$config_ledger->doc_ledger;
$vat_current= $config_ledger->vat_current;
$vat_control =$config_ledger->purchase_vat;
$tds_payable = $config_ledger->tds_payable;
$vds_payable = $config_ledger->vds_payable;


if(prevent_multi_submit()){



if(isset($_POST['confirms'])){

$info = find_all_field('vendor_invoice_master','','system_invoice_no="'.$_SESSION[$unique].'"');
$bill_amt = find_a_field('vendor_invoice_details','sum(amount)','system_invoice_no="'.$_SESSION[$unique].'"');
$vendor_info = find_all_field('vendor','','vendor_id="'.$info->vendor_id.'"');
$jv_date = $info->invoice_date;
$narration = 'Invoice No.'.$info->invoice_date;
$tr_from = 'Bill';
$tr_no = $_SESSION[$unique];
$entry_by = $_SESSION['user']['id'];
$entry_at = date('Y-m-d H:i:s');
$jv_no=next_journal_sec_voucher_id('',$tr_from,$info->group);		
$proj_id = 'SAAS';



$ssql = 'select a.item_id,a.warehouse_id,a.amount as total_amt,a.rate,a.qty,s.item_ledger,i.item_name,i.sub_ledger_id from vendor_invoice_details a,item_info i, item_sub_group s where a.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  a.system_invoice_no="'.$tr_no.'"';
$qrry = db_query($ssql);
while($data=mysqli_fetch_object($qrry)){
$line_rebate_amt = 0;
$vds = ($data->total_amt*$info->vds_percent)/100;

if($info->rebateable=='Yes'){
$line_rebate_amt = ($vds*$info->rebate_percentage)/100;
$line_actual_vat_amt = $vds - $line_rebate_amt;
$total_line_item_cost = $data->total_amt+$line_actual_vat_amt;
$rate_with_vat = $total_line_item_cost/$data->qty;

}else{

$line_rebate_amt = 0;
$line_actual_vat_amt = $vds;
$total_line_item_cost = $data->total_amt+$line_actual_vat_amt;
$rate_with_vat = $total_line_item_cost/$data->qty;
}

$total_rebate +=$line_rebate_amt;
$vat_without_rebate +=$line_actual_vat_amt;
//$final_avg_price = find_a_field('journal_item','item_price','item_id="'.$data->item_id.'" and warehouse_id="'.$data->warehouse_id.'"');
journal_item_control($data->item_id, $data->warehouse_id, $jv_date, $data->qty, 0, $tr_from, $xid, $rate_with_vat, '', $tr_no, '', '',$info->group_for, $rate_with_vat, '' );

$narration = 'Item Name :"'.$data->item_name.'", Qty : "'.$data->qty.'", Rate : "'.$rate_with_vat.'"';
add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->item_ledger, $narration, $data->total_amt, 0, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$info->group_for,$entry_by,$entry_at);
//$bill_amt +=$data->total_amt;
//$total_bill +=$total_line_item_cost;
}


$total_payable = $bill_amt;

if($info->vds_percent>0){
$vds_percent = $info->vds_percent;
$vds_amount = ($total_payable*$info->vds_percent)/100;
}else{
$vds_percent = 0;
$vds_amount  = 0;
}


if($info->tds_percent>0){
$tds_percent = $info->tds_percent;
$tds_amount = ($total_payable*$info->tds_percent)/100;
}else{
$tds_percent = 0;
$tds_amount  = 0;
}





if($tds_amount>0){
	$update_master = 'update vendor_invoice_master set tds_amount="'.$tds_amount.'", tds_percent="'.$tds_percent.'" where system_invoice_no="'.$tr_no.'"';
	db_query($update_master);
	}
	
if($vds_amount>0){
$update_master = 'update vendor_invoice_master set vds_amount="'.$vds_amount.'", vds_percent="'.$vds_percent.'" where system_invoice_no="'.$tr_no.'"';
db_query($update_master);
}

if($info->deductible=='Yes'){
	$vds_amount = (int)$vds_amount;
	}else{
		$vds_amount = 0;
		}


	
if($tds_amount>0){ 
$narration = "Vendor TDS Payable";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $tds_payable, $narration, 0, $tds_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}

if($vds_amount>0){
$narration = "Vendor VDS Payable";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vds_payable, $narration, 0, $vds_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}


$narration = "Vendor Payable";
$total_payable = ($total_payable-($tds_amount+$vds_amount));

add_to_sec_journal($proj_id, $jv_no, $jv_date, $vendor_info->ledger_id, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);

sec_journal_journal($jv_no,$jv_no,$tr_from);

$_SESSION['inv_msg'] = '<span style="color:green;font-size:20px; font-weight:bold;">Transaction Successfull!</span>';

$update = 'update vendor_invoice_master set status=PENDING" where system_invoice_no="'.$tr_no.'"';
db_query($update);
unset($_SESSION[$unique]);
header('location:open_bill_create.php');
}

if(isset($_POST['confirms22'])){

$info = find_all_field('vendor_invoice_master','','system_invoice_no="'.$_SESSION[$unique].'"');
$bill_amt = find_a_field('vendor_invoice_details','sum(amount)','system_invoice_no="'.$_SESSION[$unique].'"');
$vendor_info = find_all_field('vendor','','vendor_id="'.$info->vendor_id.'"');
$jv_date = $info->invoice_date;
$narration = 'Invoice No.'.$info->invoice_date;
$tr_from = 'Bill';
$tr_no = $_SESSION[$unique];
$entry_by = $_SESSION['user']['id'];
$entry_at = date('Y-m-d H:i:s');
$jv_no=next_journal_sec_voucher_id('',$tr_from,$info->group);		
$proj_id = 'SAAS';



$ssql = 'select a.item_id,a.warehouse_id,a.amount as total_amt,a.rate,a.qty,s.item_ledger,i.item_name,i.sub_ledger_id from vendor_invoice_details a,item_info i, item_sub_group s where a.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  a.system_invoice_no="'.$tr_no.'"';
$qrry = db_query($ssql);
while($data=mysqli_fetch_object($qrry)){
$line_rebate_amt = 0;
$vds = ($data->total_amt*$info->vds_percent)/100;

if($info->rebateable=='Yes'){
$line_rebate_amt = ($vds*$info->rebate_percentage)/100;
$line_actual_vat_amt = $vds - $line_rebate_amt;
$total_line_item_cost = $data->total_amt+$line_actual_vat_amt;
$rate_with_vat = $total_line_item_cost/$data->qty;

}else{

$line_rebate_amt = 0;
$line_actual_vat_amt = $vds;
$total_line_item_cost = $data->total_amt+$line_actual_vat_amt;
$rate_with_vat = $total_line_item_cost/$data->qty;
}

$total_rebate +=$line_rebate_amt;
$vat_without_rebate +=$line_actual_vat_amt;
//$final_avg_price = find_a_field('journal_item','item_price','item_id="'.$data->item_id.'" and warehouse_id="'.$data->warehouse_id.'"');
journal_item_control($data->item_id, $data->warehouse_id, $jv_date, $data->qty, 0, $tr_from, $xid, $rate_with_vat, '', $tr_no, '', '',$info->group_for, $rate_with_vat, '' );

$narration = 'Item Name :"'.$data->item_name.'", Qty : "'.$data->qty.'", Rate : "'.$rate_with_vat.'"';
add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->item_ledger, $narration, $total_line_item_cost, 0, $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$info->group_for,$entry_by,$entry_at);
//$bill_amt +=$data->total_amt;
$total_bill +=$total_line_item_cost;
}

if($total_rebate>0){
$narration = 'Rebate amount = '.$total_rebate;
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vat_current, $narration, $total_rebate, 0, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
$total_payable = $bill_amt+$vat_without_rebate;
}


$total_payable = $total_bill;
if($info->vds_amount>0){
$vds_percent = ($total_bill/100)*$info->vds_amount;
$vds_amount = $info->vds_amount;
}elseif($info->vds_percent>0){
$vds_percent = $info->vds_percent;
$vds_amount = ($total_bill*$info->vds_percent)/100;
}else{
$vds_percent = 0;
$vds_amount  = 0;
}


if($info->tds_amount>0){
$tds_percent = ($total_bill/100)*$info->tds_amount;
$tds_amount = $info->tds_amount;
}elseif($info->tds_percent>0){
$tds_percent = $info->tds_percent;
$tds_amount = ($total_bill*$info->tds_percent)/100;
}else{
$tds_percent = 0;
$tds_amount  = 0;
}





if($tds_amount>0){
	$update_master = 'update vendor_invoice_master set tds_amount="'.$tds_amount.'", tds_percent="'.$tds_percent.'" where system_invoice_no="'.$tr_no.'"';
	db_query($update_master);
	}
	
if($vds_amount>0){
$update_master = 'update vendor_invoice_master set vds_amount="'.$vds_amount.'", vds_percent="'.$vds_percent.'" where system_invoice_no="'.$tr_no.'"';
db_query($update_master);
}

if($_POST['deductible']=='Yes'){
	$vds_amount = (int)$vds_amount;
	}else{
		$vds_amount = 0;
		}


	
if($tds_amount>0){ 
$narration = "Vendor TDS Payable";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $tds_payable, $narration, 0, $tds_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}

if($vds_amount>0){
$narration = "Vendor VDS Payable";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vds_payable, $narration, 0, $vds_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}


$narration = "Vendor Payable";
$total_payable = ($total_payable-($tds_amount+$vds_amount));

add_to_sec_journal($proj_id, $jv_no, $jv_date, $vendor_info->ledger_id, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);

sec_journal_journal($jv_no,$jv_no,$tr_from);

$_SESSION['inv_msg'] = '<span style="color:green;font-size:20px; font-weight:bold;">Transaction Successfull!</span>';

$update = 'update vendor_invoice_master set status=PENDING" where system_invoice_no="'.$tr_no.'"';
db_query($update);
unset($_SESSION[$unique]);
header('location:open_bill_create.php');
}
}
else
{

	$type=0;

	$msg='Data Re-Submit Warning!';

}



if($$unique>0){

		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
}


if($delivery_within>0)

{

	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);

}

?>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">


  
  <tr>

    <td colspan="5" valign="top">


	<table width="96%" border="1" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td width="21%" align="right" bgcolor="#66CCCC"><strong>Billing Date:</strong></td>

        <td width="15%" bgcolor="#66CCCC"><strong>
          <input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
          <input style="width:120px;"  name="invoice_date" type="text" id="invoice_date" value="<?=date('Y-m-d')?>" required="required"/>

        </strong></td>

        <td width="19%" align="right" bgcolor="#66CCCC"><strong>Vendor</strong></td>

        <td width="14%" bgcolor="#66CCCC"><strong>

          
          <input style="width:120px;" name="vendor_id" type="text" id="vendor_id" value="<?=find_a_field('vendor','concat(vendor_name,"->",vendor_id)','vendor_id='.$vendor_id)?>" list="vendorList" />
		  <datalist id="vendorList">
		   <? foreign_relation('vendor','concat(vendor_name,"->",vendor_id)','""',$vendor_id,'1');?>
		  </datalist>
		  

        </strong></td>

        <td width="14%" bgcolor="#66CCCC"><div align="right"><strong>Vendor Invoice No:</strong></div></td>

        <td width="17%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;"  name="invoice_no" type="text" id="invoice_no" value="<?=$invoice_no?>" />

        </strong></td>
        </tr>
      
      <tr>

        <td width="21%" align="right" bgcolor="#66CCCC"><strong>Inventory. :</strong></td>

        <td width="15%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;"  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>" readonly/>
		  <input style="width:120px;"  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$_SESSION['user']['depot'].'"')?>" readonly/>

        </strong></td>

        <td width="19%" align="right" bgcolor="#66CCCC"><strong>Receive Date:</strong></td>

        <td width="14%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;"  name="receive_date" type="text" id="receive_date" value="<?=date('Y-m-d')?>" />

        </strong></td>

        <td width="14%" bgcolor="#66CCCC"><div align="right"><strong>Description:</strong></div></td>

        <td width="17%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;"  name="remarks" type="text" id="remarks" value="<?=$remarks?>"/>

        </strong></td>
        </tr>
        
        <tr>
        <td align="right" bgcolor="#66CCCC"><strong>TDS:</strong></td>
        <td bgcolor="#66CCCC"><strong>
		  <!--<input style="width:120px;"  name="tds_amount" type="text" id="tds_amount" value="<?=($tds_amount>0)?$tds_amount:''?>" placeholder="TDS Amount"/>-->
		  <input style="width:120px;"  name="tds_percent" type="text" id="tds_percent" value="<?=($tds_percent>0)?$tds_percent:''?>" placeholder="TDS Percent"/>
         
        </strong></td>
		<td bgcolor="#66CCCC" align="right"><strong>VDS:</strong></td>
        <td bgcolor="#66CCCC"><!--<input style="width:120px;"  name="vds_amount" type="text" id="vds_amount" value="<?=($vds_amount>0)?$vds_amount:''?>" placeholder="VDS Amount"/>--><input style="width:120px;"  name="vds_percent" type="text" id="vds_percent" value="<?=($vds_percent>0)?$vds_percent:''?>" placeholder="VDS Amount"/></td>
        <td align="right" bgcolor="#66CCCC"><strong>Mushak:</strong></td>
        <td bgcolor="#66CCCC"><input style="width:120px;"  name="mushak_no" type="text" id="mushak_no" value="<?=$mushak_no?>"/></td>
        
      </tr>
	  <tr>
	  	<td align="right" bgcolor="#66CCCC"><strong>Deductible</strong></td>
		<td bgcolor="#66CCCC">
			<select style="width:120px"  name="deductible" type="text" id="deductible" required >
				<option></option>
				<option value="Yes" <?=($deductible=='Yes') ? 'selected' : '' ?>>Yes</option>
				<option value="No" <?=($deductible=='No') ? 'selected' : '' ?>>No</option>
			</select>
		</td>
		</tr>
		
	  <!--<tr>
	  	<td align="right" bgcolor="#66CCCC"><strong>Deductible</strong></td>
		<td bgcolor="#66CCCC">
			<select style="width:120px"  name="deductible" type="text" id="deductible" required >
				<option></option>
				<option value="Yes" <?=($deductible=='Yes') ? 'selected' : '' ?>>Yes</option>
				<option value="No" <?=($deductible=='No') ? 'selected' : '' ?>>No</option>
			</select>
		</td>
		<td align="right" bgcolor="#66CCCC"><strong>Rebatable</strong></td>
		<td bgcolor="#66CCCC">
		<select style="width:120px"  name="rebateable" type="text" id="rebateable" required >
				<option></option>
				<option value="Yes" <?=($rebateable=='Yes') ? 'selected' : '' ?>>Yes</option>
				<option value="No" <?=($rebateable=='No') ? 'selected' : '' ?>>No</option>
			</select>
		</td>
		<td align="right" bgcolor="#66CCCC"><strong>Rebate % </strong></td>
		<td bgcolor="#66CCCC"><input style="width:120px;"  name="rebate_percentage" type="text" id="rebate_percentage" value="<?=$rebate_percentage?>"/></td>
	  
	  </tr>-->
	  
      
    </table>
	</td>
    </tr>
	<tr>
	 <td colspan="5"><div align="center">
	 <?php if($_SESSION[$unique]>0){?>
	 <input name="master_update" type="submit" class="btn btn-primary" value="UPDATE" />
	 <? }else{ ?>
	 <input name="master_insert" type="submit" class="btn btn-primary" value="INITIATE" />
	 <? } ?>
	 
	 </div></td>
	</tr>
</table>
</form>
<?php
if($_SESSION[$unique]>0){
?>
<form action="" method="post" name="codz2" id="codz2">
<div class="container-fluid p-0 ">
      <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
		<tr>
		 <th colspan="8">Product Details</th>
		</tr>
          <tr class="bgc-info">
            <th>SL</th>
			<th>Item Group</th>
			<th>Item Name</th>
			<th>Unit Name</th>
            <th>Stock</th>
			<th>Bill Qty</th>
            <th>Rate</th>
            <th>Amount</th>
            <th>Action</th>
          </tr>
        </thead>
		<tbody class="tbody1">
          <?
                        
						$s=0;

						$res='select a.id,b.item_name as item_name,a.qty,a.rate,a.amount,b.unit_name,g.group_name,b.finish_goods_code,w.warehouse_name,"x" from vendor_invoice_details a,item_info b, item_sub_group s, item_group g, warehouse w where w.warehouse_id=a.warehouse_id and b.sub_group_id=s.sub_group_id and g.group_id=s.group_id and b.item_id=a.item_id and a.system_invoice_no='.$_SESSION[$unique];

                        $qry = db_query($res);

						while($data=mysqli_fetch_object($qry)){

						?>
          <tr>
            <td><?=++$s?></td>
			<td><?=$data->group_name?></td>
            <td style="text-align:left"><?=$data->finish_goods_code?>&nbsp;<?=$data->item_name?></td>
            <td><?=$data->unit_name?></td>
            <td></td>
			<td><?=$data->qty?></td>
			<td><?=$data->rate?></td>
			<td><?=number_format($data->amount,2)?></td>
            <td><a href="?fgdel=<?=$data->id?>">
              <button type="button" class="btn2 btn1-bg-cancel"><i class="fa-solid fa-trash"></i></button>
              </a></td>
          </tr>
          <? } ?>
        
          <tr>
		  <td>NEW</td>
		  <td>
		   <select name="group_id" id="group_id" onchange="getData2('get_item_list_ajax.php','item_list_fg',this.value,this.value)">
		   <option></option>
		   <? foreign_relation('item_group','group_id','group_name','1')?>
		  </select>
		  <input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
              <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
              <input  name="pr_date" type="hidden" id="pr_date" value="<?=$batch_date?>"/>
			  <input  name="pr_no" type="hidden" id="pr_no" value="<?=$_SESSION['pr_no']?>"/>
			  <input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>"/>
			  <input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
			  
		  </td>
            <td id="item_list_fg">
              <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>"/>
            </td>
            <td colspan="2"><div align="right"> <span id="bill">
                <table style="width:100%;" border="1">
                  <tr>
                    <td width="33%"><input name="qoh" type="text"  id="qoh" class="form-control"/></td>
                    <td width="23%"><input name="unit_name" type="text" id="unit_name"  maxlength="100" class="form-control"/></td>
                  </tr>
                </table>
                </span> </div></td>
            <td><input name="qty" type="text" class="input3" id="qty" onkeyup="calculation()" required /></td>
			<td><input name="rate" type="text" class="input3" id="rate" onkeyup="calculation()" required /></td>
			<td><input name="amount" type="text" class="input3" id="amount" required readonly="readonly" /></td>
            <td>
			<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
			<input name="fgadd" type="submit" id="fgadd" class="btn1 btn1-bg-submit" value="ADD" />
			</td>
          </tr>
        </tbody>
      </table>
    </div>
</form>


<form action="" method="post">
<table width="100%" border="0">
<tr>
<td align="center">
<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$_SESSION[$unique]?>" />
<input name="cancel" type="submit" class="btn btn-warning" value="CANCEL BILL" style="width:270px; font-weight:bold;" /></td>
<td align="center"><input name="confirms" type="submit" class="btn btn-primary" value="CONFIRM BILL" style="width:270px; font-weight:bold;" /></td>
</tr>
</table>
</form>
<? } ?>



</div>

<script>$("#codz").validate();$("#cloud").validate();</script>
<script>
function return_function() {
  var notes = prompt("Why Return This PO?","");
  if (notes!=null) {
    document.getElementById("return_remarks").value =notes;
	document.getElementById("codz").submit();
  }
  return false;
}


function count(id){
var qty = document.getElementById("qty"+id).value*1;
var rest_qty = document.getElementById("rest_qty"+id).value*1;
var rate = document.getElementById("rate"+id).value*1;
if(qty>rest_qty){
alert('Overflow!');
document.getElementById("qty"+id).value = rest_qty;
}else{
var amount = qty*rate;
document.getElementById("amount"+id).value = amount;
}
}

function calculation(){
 var qty = document.getElementById('qty').value*1;
 var rate = document.getElementById('rate').value*1;
 var stock = document.getElementById('stock').value*1;
 /*if(qty>stock){
  alert('stock Overflow!');
  document.getElementById('qty').value = '';
  document.getElementById('amount').value = '';
 }*/
 var amount = qty*rate;
 document.getElementById('amount').value = amount.toFixed(2);
}
</script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>