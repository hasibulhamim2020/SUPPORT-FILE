<?php


session_start();
ob_start();
$c_id = $_SESSION['proj_id'];
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
$title='Material Vendor Bill Provision';
do_calander('#receive_date');
$grn_no = $_REQUEST['grn_no'];
$table_master='purchase_master';
$table_details='purchase_receive';
$unique='po_no';
if($_SESSION[$unique]>0)
$$unique=$_SESSION[$unique];
if($_REQUEST[$unique]>0){
$$unique=$_REQUEST[$unique];
$_SESSION[$unique]=$$unique;}
else
$$unique = $_SESSION[$unique];
$sqql = 'select v.vendor_name,v.vendor_id,v.sub_ledger_id,pr.po_no,pr.pr_no,pm.vat,pm.tax,pm.rebateable,pm.deductible,pm.rebate_percentage,pm.group_for,v.ledger_id as accounts_payable,pr.entry_by,pr.entry_at from purchase_receive pr, purchase_master pm, vendor v where pm.po_no=pr.po_no and  v.vendor_id=pr.vendor_id and pr.pr_no="'.$_GET['grn_no'].'"';
$qry = db_query($sqql);
$info = mysqli_fetch_object($qry);

$config_ledger = find_all_field('config_group_class','',"group_for=".$info->group_for);


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

		

		$invoice_no=$_POST['invoice_no'];
		
		$invoice_date=$_POST['invoice_date'];
		
		$referance=$_POST['referance'];
		$receive_date=$_POST['receive_date'];
		
		$remarks=$_POST['remarks'];

		
		$tds = explode("#",$_POST['tds_code']);
		$tds_code = 0;//$tds[0];
		$tds_percent = (int)$_POST['tds_code'];//(int)$tds[1];
		$tds_amount = (int)$_POST['tds_amount'];
		
		$mushak=$_POST['mushak_no'];
		
		$group = $info->group_for;
		
		
	$folder ='accounts';
	$field = 'file_upload';
	$file_name = $field.'-'.$_POST['invoice_no'];
	if($_FILES['file_upload']['tmp_name']!=''){
	$random = random_int(10000,99999);
	$newFileName = 'accounts_'.$random;
	$ext = end(explode(".",$_FILES['file_upload']['name']));
	//$_POST['file_upload']=upload_file($folder,$field,$file_name);
	file_upload_aws('file_upload','accounts',$newFileName);
	$_POST['file_upload']= $newFileName.'.'.$ext;
	}
        
		 $master_insert = 'insert into vendor_invoice_master set invoice_no="'.$invoice_no.'",referance="'.$referance.'",invoice_date="'.$invoice_date.'",receive_date="'.$receive_date.'",vendor_id="'.$info->vendor_id.'",grn_no="'.$grn_no.'",po_no="'.$info->po_no.'",tds_code="'.$tds_code.'",tds_percent="'.$tds_percent.'",vds_percent="'.$_POST['mushak_no'].'",tds_amount="'.$tds_amount.'",deductible="'.$_POST['deductible'].'", entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$_SESSION['user']['id'].'", status="PENDING",group_for="'.$info->group_for.'", file_upload="'.$_POST['file_upload'].'"';
		$success = db_query($master_insert);
		
	   $system_invoice_no = db_insert_id();
	   
	   $cow=0;
	   $sl=0;

		$sql = 'select * from purchase_receive where pr_no = '.$grn_no;

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{	

			$sl++;

				$qty=$_POST['qty'.$data->id];

				$rate=$data->with_vat_rate;
				
				$vat_rate = $data->vat_rate;
				$tax_rate  =$data->tax_rate;

				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;

				$amount = ($qty*$rate);

				$total = $total + $amount;
				
				$vat_amt += ($qty*$vat_rate);
				
				$tax_amt +=($qty*$tax_rate);
				
				$qc_deduct_amount += $data->detection_amount;

				$qc_deduct_qty_amount += (float)$data->with_vat_rate * (float)$data->deduction_qty;
				
				
 $q = 'insert into vendor_invoice_details set system_invoice_no="'.$system_invoice_no.'",grn_no="'.$grn_no.'",pr_id="'.$data->id.'",po_no="'.$info->po_no.'",item_id="'.$data->item_id.'",qty="'.$qty.'",rate="'.$data->rate.'",amount="'.$amount.'",group_for="'.$info->group_for.'",entry_at="'.date('Y-m-d H:i:s').'", 
 entry_by="'.$_SESSION['user']['id'].'"';
db_query($q);


if($data->qty==$_POST['qty'.$data->id]){
	$cow++;
}

		}
		
$jv_date = $invoice_date;
$narration = 'Invoice No.'.$invoice_no;
$tr_from = 'vendor_invoice_receive';
$tr_no = $system_invoice_no;
$entry_by = $_SESSION['user']['id'];
$entry_at = date('Y-m-d H:i:s');
$jv_no=next_journal_sec_voucher_id('',$tr_from,$group);		
$proj_id = 'saas';

$total_payable = $total;

if($info->vat>0){
//$vat_amt = ($total*$info->vat)/100;
$rest_vat_amt = $vat_amt;

if($info->rebate_percentage>0){
$rebate_amt = ($vat_amt*$info->rebate_percentage)/100;

$rest_vat_amt = $vat_amt-$rebate_amt;

add_to_sec_journal($proj_id, $jv_no, $jv_date, $vat_current, $narration, $rebate_amt, 0, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vat_control, $narration, 0, $rebate_amt, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $vat_current, $narration, $rebate_amt, 0, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $vat_control, $narration, 0, $rebate_amt, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);

$total_payable = $total+$vat_amt;
}else{
$total_payable = $total;
}
}

if($tds_percent>0){
	//$tds_amount = ($total*$tds_percent)/100;
	$tds_amount = $tax_amt;
	$update_master = 'update vendor_invoice_master set tds_amount="'.$tds_amount.'" where system_invoice_no="'.$tr_no.'" and po_no="'.$info->po_no.'"';
	db_query($update_master);
	}


//$vat_amount = ($total*$info->vat)/100;
$vat_amount = $vat_amt; 

if($_POST['deductible']=='Yes'){
	$vds_amount = (int)$vat_amount;
	}else{
		$vds_amount = 0;
		}

if($tds_amount>0){ 
$narration = "Vendor TDS Payable";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $tds_payable, $narration, 0, $tds_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $tds_payable, $narration, 0, $tds_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}

if($vds_amount>0){
$narration = "Vendor VDS Payable";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vds_payable, $narration, 0, $vds_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $vds_payable, $narration, 0, $vds_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}


$narration = "Vendor Payable";
add_to_sec_journal($proj_id, $jv_no, $jv_date, $doc_vendor, $narration, $total_payable, 0, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date, $doc_vendor, $narration, $total_payable, 0, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);


if($qc_deduct_qty_amount>0){
$total_payable = ($total_payable-($tds_amount+$vds_amount+$qc_deduct_qty_amount));
add_to_sec_journal($proj_id, $jv_no, $jv_date, $info->accounts_payable, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->purchase_discount, $narration, 0, $qc_deduct_qty_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}

elseif($qc_deduct_amount>0){
$total_payable = ($total_payable-($tds_amount+$vds_amount+$qc_deduct_amount));
add_to_sec_journal($proj_id, $jv_no, $jv_date, $info->accounts_payable, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_sec_journal($proj_id, $jv_no, $jv_date,  $config_ledger->purchase_discount, $narration, 0, $qc_deduct_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}
else{
$total_payable = ($total_payable-($tds_amount+$vds_amount));
add_to_sec_journal($proj_id, $jv_no, $jv_date, $info->accounts_payable, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}




if($qc_deduct_qty_amount>0){
$total_payable = ($total_payable-($tds_amount+$vds_amount+$qc_deduct_qty_amount));
add_to_journal($proj_id, $jv_no, $jv_date, $info->accounts_payable, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date,  $config_ledger->purchase_discount, $narration, 0, $qc_deduct_qty_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);;
}

elseif($qc_deduct_amount>0){
$total_payable = ($total_payable-($tds_amount+$vds_amount+$qc_deduct_amount));
add_to_journal($proj_id, $jv_no, $jv_date, $info->accounts_payable, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_journal($proj_id, $jv_no, $jv_date,  $config_ledger->purchase_discount, $narration, 0, $qc_deduct_amount, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}
else{
$total_payable = ($total_payable-($tds_amount+$vds_amount));
add_to_journal($proj_id, $jv_no, $jv_date, $info->accounts_payable, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}


//add_to_journal($proj_id, $jv_no, $jv_date, $info->accounts_payable, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);

//sec_journal_journal($jv_no,$jv_no,$tr_from);

$_SESSION['inv_msg'] = '<span style="color:green;font-size:20px; font-weight:bold;">Transaction Successfull!</span>';
if($sl==$cow){
$update = 'update purchase_receive set status="Bill Created" where pr_no="'.$grn_no.'"';
db_query($update);
}
header('location:select_grn.php');
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

<form action="" method="post" name="codz" enctype="multipart/form-data" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="10" cellpadding="10" align="center">


  <tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$info->entry_by);?></td>

       <?php /*?> <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="../../../views/purchase_mod/po/po_print_view_store.php?po_no=<?=$po_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td><?php */?>
		
		 <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="../../../views/purchase_mod/po/po_print_view_store.php?c=<?=rawurlencode(url_encode($c_id))?>&v=<?=rawurlencode(url_encode($po_no))?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created On:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=$info->entry_at?></td>
      </tr>

    </table></td>
  </tr>

  <tr>

    <td colspan="5" valign="top">

<?php /*?>	<? if($ex<time()){?>

	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">

      <tr>

        <td align="right" bgcolor="#FF0000"><div align="center" style="text-decoration:blink"><strong>THIS PURCHASE ORDER IS EXPIRED</strong></div></td>

        </tr>

    </table>

    <? }?><?php */?>

<table width="96%" border="1" align="center" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
      <tr>
        <td width="21%" align="right" bgcolor="#66CCCC"><strong>Invoice Date:</strong></td>
        <td width="15%" bgcolor="#66CCCC">
          <input style="width:120px;" name="invoice_date" type="text" id="invoice_date" value="<?=date('Y-m-d')?>" required="required"/>
        </td>
        <td width="19%" align="right" bgcolor="#66CCCC"><strong>Vendor</strong></td>
        <td width="14%" bgcolor="#66CCCC">
          <input style="width:120px;" name="vendor" type="text" id="vendor" value="<?=$info->vendor_name?>" readonly />
          <input style="width:120px;" name="vendor_id" type="hidden" id="vendor_id" value="<?=$info->vendor_id?>" readonly />
        </td>
        <td width="14%" bgcolor="#66CCCC" align="right"><strong>Invoice No:</strong></td>
        <td width="17%" bgcolor="#66CCCC">
          <input style="width:120px;" name="invoice_no" type="text" id="invoice_no" value="" />
        </td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#66CCCC"><strong>PO No. :</strong></td>
        <td bgcolor="#66CCCC">
          <input style="width:120px;" name="po_no" type="text" id="po_no" value="<?=$info->po_no?>" readonly/>
        </td>
        <td align="right" bgcolor="#66CCCC"><strong>Receive Date:</strong></td>
        <td bgcolor="#66CCCC">
          <input style="width:120px;" name="receive_date" type="text" id="receive_date" value="<?=date('Y-m-d')?>" />
        </td>
        <td bgcolor="#66CCCC" align="right"><strong>Description:</strong></td>
        <td bgcolor="#66CCCC">
          <input style="width:120px;" name="remarks" type="text" id="remarks"/>
        </td>
      </tr>
        
      <tr>
        <td align="right" bgcolor="#66CCCC"><strong>TDS:</strong></td>
        <td bgcolor="#66CCCC">
          <input style="width:120px;" name="tds_code" type="text" id="tds_code" value="<?=$info->tax?>" placeholder="TDS Percent" readonly/>
          <input style="width:120px;" name="tds_amount" type="text" id="tds_amount" value="" placeholder="TDS Amount"/>
        </td>
        <td align="right" bgcolor="#66CCCC"><strong>Mushak:</strong></td>
        <td bgcolor="#66CCCC">
          <input style="width:120px;" name="mushak_no" type="text" id="mushak_no" value="<?=$info->mushak_no?>" />
        </td>
        <td bgcolor="#66CCCC" align="right"><strong>Referance:</strong></td>
        <td bgcolor="#66CCCC">
          <input style="width:120px;" name="referance" type="text" id="referance" value=""/>
        </td>
      </tr>
	  
	  <tr>
	  	<td align="right" bgcolor="#66CCCC"><strong>Deductible</strong></td>
		<td bgcolor="#66CCCC">
			<select style="width:120px" name="deductible" id="deductible" required>
				<option></option>
				<option value="Yes" <?=($info->deductible=='Yes') ? 'selected' : '' ?>>Yes</option>
				<option value="No" <?=($info->deductible=='No') ? 'selected' : '' ?>>No</option>
			</select>
		</td>
		<td align="right" bgcolor="#66CCCC"><strong>Rebateable</strong></td>
		<td bgcolor="#66CCCC">
          <input style="width:120px;" name="rebateable" type="text" id="rebateable" value="<?=$info->rebateable?>"/>
        </td>
		<td align="right" bgcolor="#66CCCC"><strong>Rebate % </strong></td>
		<td bgcolor="#66CCCC">
          <input style="width:120px;" name="rebate_percentage" type="text" id="rebate_percentage" value="<?=$info->rebate_percentage?>"/>
        </td>
	  </tr>
	  
	  <tr>
	    <td align="right" bgcolor="#66CCCC"><strong>Upload Bill</strong></td>
		<td colspan="5" bgcolor="#66CCCC">
          <input type="file" name="file_upload" id="file_upload" style="width:100%;" />
		</td>
	  </tr>
</table>

<? if($grn_no>0){

 $sql='select a.id,a.item_id,a.po_no,b.item_name,b.unit_name,a.qty,a.rate,a.order_no,a.deduction_qty,a.detection_amount from purchase_receive a,item_info b where b.item_id=a.item_id and a.pr_no='.$grn_no;
$res=db_query($sql);

?>

<table width="95%" border="0" align="center" cellpadding="15" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th>SL</th>

            <th>Item Code</th>

            <th width="20%">Item Name</th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th width="10%">PO Qty</th>
			<th width="10%">Qc Deduct Qty</th>
			<th width="10%">Qc Deduct Amount</th>
			<th width="10%">Rest Qty</th>
            <th width="10%">Bill Qty</th>
            <th width="10%">Rate </th>
            
            <th width="15%">Amount </th>

          </tr>

          

          <? while($row=mysqli_fetch_object($res)){
		  
		  $received_qty = find_a_field('vendor_invoice_details','sum(qty)','po_no="'.$row->po_no.'" and pr_id="'.$row->id.'" ');
		  $bg++;
		  
		  ?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_id?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

              <td>
			  
			  		<?=find_a_field('item_info','item_name','item_id='.$row->item_id);?>

                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" /></td>

              <td width="7%" align="center"><?=$row->unit_name?>
                
                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" />
				
				</td>
				<td><?=$row->qty?></td>
				
				<td><?=$row->deduction_qty?></td>
				
				<td><?=$row->detection_amount?></td>

  
  <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center"><input type="text" name="rest_qty<?=$row->id?>" id="rest_qty<?=$row->id?>" value="<?=$rest_qty=$row->qty-$received_qty?>" readonly /></td>
  <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center"><input type="text" name="qty<?=$row->id?>" id="qty<?=$row->id?>" value="<?=$rest_qty?>" onblur="count(<?=$row->id?>)" required /></td>
  <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center"><input type="text" name="rate<?=$row->id?>" id="rate<?=$row->id?>" value="<?=$row->rate?>" readonly /></td>
  <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center"><input type="text" name="amount<?=$row->id?>"
   id="amount<?=$row->id?>" value="<?=$totala=$row->qty*$row->rate?>" readonly /></td>  <? $G_total +=$totala;  ?>
                

              </tr>
			  
			

          <? }?>
		  
		  
		    <tr> 
			  
			  <td bgcolor="#6699FF" style="" colspan="10">Total Amount </td>
			  
			  
			  
			  <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center"><input type="text" name="j"
    value="<?=$G_total?>" readonly /></td> 
			  </tr>

      </tbody>

      </table>

      </div>

      </td>

    </tr>

  </table><br />

<table width="100%" border="0">


<tr>

<!--<td align="center">
<input name="return" type="submit" id="return" onclick="return_function()" class="btn btn-danger" value="Return To Purchase Department" style="width:270px; font-weight:bold; font-size:12px;" />
<input type="hidden" name="return_remarks" id="return_remarks">
</td>-->

<td align="center"><input name="confirms" type="submit" class="btn btn-primary" value="CONFIRM INVOICE" style="width:270px; font-weight:bold;" /></td>

</tr>


</table>

<? }?>

</form>

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
</script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>