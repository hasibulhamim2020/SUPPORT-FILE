<?php

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

session_start();



ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




$title='Vendor Invoice Receive';



//do_calander('#rec_date');

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


$sqql = 'select v.vendor_name,v.vendor_id,v.sub_ledger_id,pr.po_no,pr.pr_no as grn_no,pm.vat,pm.rebate_percentage from purchase_receive pr, purchase_master pm, vendor v where pm.po_no=pr.po_no and  v.vendor_id=pr.vendor_id and pr.pr_no="'.$_GET['grn_no'].'"';
$qry = db_query($sqql);
$info = mysqli_fetch_object($qry);




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
		
		echo $note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique.'","PR","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
		db_query($note_sql);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		header('location:select_upcoming_po.php');

}



//if(isset($_POST['delete']))
//
//{
//
//		unset($_POST);
//
//		$_POST[$unique]=$$unique;
//
//		$_POST['edit_by']=$_SESSION['user']['id'];
//
//		$_POST['edit_at']=date('Y-m-d h:s:i');
//
//		$_POST['status']='CANCELED';
//
//		$crud   = new crud($table_master);
//
//		$crud->update($unique);
//
//		
//
//
//
//		unset($$unique);
//
//		unset($_SESSION[$unique]);
//
//		$type=1;
//
//		$msg='Canceled Remainning All Purchase Order.';
//
//}



if(prevent_multi_submit()){



if(isset($_POST['confirms'])){

		

		$invoice_no=$_POST['invoice_no'];
		
		$invoice_date=$_POST['invoice_date'];
		
		$referance=$_POST['referance'];
		
		$receive_date=$_POST['receive_date'];
		
		$remarks=$_POST['remarks'];

		
		$tds = explode("#",$_POST['tds_code']);
		$tds_code = $tds[0];
		$tds_percent = (int)$tds[1];
		
		$mushak=$_POST['mushak_no'];
        
		 $master_insert = 'insert into vendor_invoice_master set invoice_no="'.$invoice_no.'",referance="'.$referance.'",invoice_date="'.$invoice_date.'",receive_date="'.$receive_date.'",vendor_id="'.$info->vendor_id.'",grn_no="'.$grn_no.'",po_no="'.$info->po_no.'",tds_code="'.$tds_code.'",tds_percent="'.$tds_percent.'",entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$_SESSION['user']['id'].'" ';
		$success = db_query($master_insert);
		
	   $system_invoice_no = mysqli_insert_id();

		$sql = 'select * from purchase_receive where pr_no = '.$grn_no;

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{

			

				$qty=$data->qty;

				$rate=$data->rate;

				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;

				$amount = ($qty*$rate);

				$total = $total + $amount;
				
$q = 'insert into vendor_invoice_details set system_invoice_no="'.$system_invoice_no.'",grn_no="'.$grn_no.'",po_no="'.$info->po_no.'",item_id="'.$data->item_id.'",qty="'.$data->qty.'",rate="'.$data->rate.'",amount="'.$amount.'",entry_at="'.date('Y-m-d H:i:s').'", entry_by="'.$_SESSION['user']['id'].'"';
db_query($q);


//$xid = mysqli_insert_id();


		}
		
$doc_vendor = 3021100143;
$noc_doc_vendor = 3021100144;
$vat_current = 1021900002;
$vat_control = 1021900003;
$jv_date = $invoice_date;
$narration = 'Invoice No.'.$invoice_no;
$tr_from = 'vendor_invoice_receive';
$tr_no = $system_invoice_no;
$entry_by = $_SESSION['user']['id'];
$entry_at = date('Y-m-d H:i:s');
$jv_no=next_journal_sec_voucher_id();		
$proj_id = 'MEP';



if($info->vat>0){

$vat_amt = ($total*$info->vat)/100;

if($info->rebate_percentage>0){

$rebate_amt = ($vat_amt*$info->rebate_percentage)/100;
$rest_vat_amt = $vat_amt-$rebate_amt;

add_to_sec_journal($proj_id, $jv_no, $jv_date, $vat_current, $narration, $rebate_amt, 0, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vat_control, $narration, 0, $rebate_amt, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//add_to_journal($proj_id, $jv_no, $jv_date, $vat_current, $narration, $rebate_amt, 0, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//add_to_journal($proj_id, $jv_no, $jv_date, $vat_control, $narration, 0, $rebate_amt, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
}
}

if($rest_vat_amt>0){
$total_payable = $total+$rest_vat_amt;
}else{
$total_payable = $total;
}


add_to_sec_journal($proj_id, $jv_no, $jv_date, $doc_vendor, $narration, $total_payable, 0, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $noc_doc_vendor, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//add_to_journal($proj_id, $jv_no, $jv_date, $doc_vendor, $narration, $total_payable, 0, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//add_to_journal($proj_id, $jv_no, $jv_date, $noc_doc_vendor, $narration, 0, $total_payable, $tr_from, $tr_no,$info->sub_ledger_id,$tr_id,$cc_code,$group,$entry_by,$entry_at);
//sec_journal_journal($jv_no,$jv_no,$tr_from);






sec_journal_journal2($jv_no,$jv_no,$tr_from);

$_SESSION['inv_msg'] = '<span style="color:green;font-size:20px; font-weight:bold;">Invoice Received Successfully!</span>';		
$update = 'update purchase_receive set status="Bill Created" where pr_no="'.$grn_no.'"';
db_query($update);

unset($_POST);
header('location:select_grn.php');

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

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

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="../../../purchase_mod/pages/po/po_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created On:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=$entry_at?></td>
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

	<table width="96%" border="1" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td width="21%" align="right" bgcolor="#66CCCC"><strong>Invoice Date:</strong></td>

        <td width="15%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;"  name="invoice_date" type="text" id="invoice_date" value="<?=date('Y-m-d')?>" required="required"/>

        </strong></td>

        <td width="19%" align="right" bgcolor="#66CCCC"><strong>Vendor</strong></td>

        <td width="14%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;" name="vendor" type="text" id="vendor" value="<?=$info->vendor_name?>" readonly />
          <input style="width:120px;" name="vendor_id" type="hidden" id="vendor_id" value="<?=$info->vendor_id?>" readonly />

        </strong></td>

        <td width="14%" bgcolor="#66CCCC"><div align="right"><strong>Invoice No:</strong></div></td>

        <td width="17%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;"  name="invoice_no" type="text" id="invoice_no" value="" />

        </strong></td>
        </tr>
      
      <tr>

        <td width="21%" align="right" bgcolor="#66CCCC"><strong>PO No. :</strong></td>

        <td width="15%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;"  name="po_no" type="text" id="po_no" value="<?=$info->po_no?>" readonly/>

        </strong></td>

        <td width="19%" align="right" bgcolor="#66CCCC"><strong>Receive Date:</strong></td>

        <td width="14%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;"  name="receive_date" type="text" id="receive_date" />

        </strong></td>

        <td width="14%" bgcolor="#66CCCC"><div align="right"><strong>Description:</strong></div></td>

        <td width="17%" bgcolor="#66CCCC"><strong>

          <input style="width:120px;"  name="remarks" type="text" id="remarks"/>

        </strong></td>
        </tr>
        
        <tr>
        <td align="right" bgcolor="#66CCCC"><strong>TDS:</strong></td>
        <td bgcolor="#66CCCC"><strong>
          <input style="width:120px;"  name="tds_code" type="text" id="tds_code" list="tds" value=""/>
          <datalist id="tds">
          <? foreign_relation('standard_tds','concat(id,"#",rate)','concat(service_code,"#",particulars)',$tds_code,'1');?>
          </datalist>
        </strong></td>
        <td align="right" bgcolor="#66CCCC"><strong>Mushak:</strong></td>
        <td bgcolor="#66CCCC"><input style="width:120px;"  name="mushak_no" type="text" id="mushak_no" value=""/></td>
        <td bgcolor="#66CCCC" align="right"><strong>Referance:</strong></td>
        <td bgcolor="#66CCCC"><input style="width:120px;"  name="referance" type="text" id="referance" value=""/></td>
      </tr>
      
    </table></td>
    </tr>
</table>

<? if($grn_no>0){

$sql='select a.id,a.item_id,b.item_name,b.unit_name,a.qty,a.rate from purchase_receive a,item_info b where b.item_id=a.item_id and a.pr_no='.$grn_no;

$res=db_query($sql);

?>

<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th>SL</th>

            <th>Item Code</th>

            <th width="45%">Item Name</th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th>Qty </th>
            
            <th>Rate </th>
            
            <th>Amount </th>

          </tr>

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_id?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

              <td><?=$row->item_name?>

                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" /></td>

              <td width="7%" align="center"><?=$row->unit_name?>
                
                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>

              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center"><?=$row->qty?></td>
              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center"><?=$row->rate?></td>
              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center"><?=number_format($row->rate*$row->qty,2)?></td>
                
                
              

              </tr>

          <? }?>

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


</script>
<?

$main_content=ob_get_contents();

ob_end_clean();


require_once SERVER_CORE."routing/layout.bottom.php";



?>