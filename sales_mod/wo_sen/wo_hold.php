<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Work Order Hold Request';



do_calander('#so_date');



$table_master='sale_do_master';

$table_details='sale_do_details';

 $unique='do_no';



if($_REQUEST['old_do_no']>0)

$$unique=$_REQUEST['old_do_no'];


//if($_SESSION[$unique]>0)
//
//$$unique=$_SESSION[$unique];
//
//
//
//if($_REQUEST[$unique]>0){
//
//$$unique=$_REQUEST[$unique];
//
//$_SESSION[$unique]=$$unique;}
//
//else
//
// $$unique = $_SESSION[$unique];
//






if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:i:s');

		$_POST['status']='PROCESSING';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';
		
		echo '<script>window.location.replace("select_unfinished_do.php")</script>';

}



if(isset($_POST['delete']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['status']='MANUAL';

		$crud   = new crud($table_master);

		$crud->update($unique);



		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Order Returned.';

}



if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

	
		
		$group_for = $_POST['group_for'];

		$entry_date=$_POST['so_date'];
		
		$remarks=$_POST['req_remarks'];

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		

		$do_no = $_POST['do_no'];
		
		//$bc_no = next_transection_no($group_for,$bc_date,'sale_do_bundle_card','bc_no');

		
		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);
		
 $sql = 'update sale_do_master set status="HOLD REQUEST", hold_req_date="'.$entry_date.'", hold_note="'.$remarks.'", hold_req_by="'.$entry_by.'", hold_req_at="'.$entry_at.'" where do_no = '.$do_no;
	db_query($sql);
	
	
	
	
//Text Sms

$sms_rec = find_all_field('sms_receiver','','id=1');

function sms($dest_addr,$sms_text){

$url = "https://vas.banglalink.net/sendSMS/sendSMS?userID=NASSA@123&passwd=LizAPI@019014&sender=NASSA_GROUP";


$fields = array(
    'userID'      => "NASSA@123",
    'passwd'      => "LizAPI@019014",
    'sender'      => "NASSA GROUP",
    'msisdn'      => $dest_addr,
    'message'     => $sms_text
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
$result = curl_exec($ch);
curl_close($ch);
}

$recipients =$sms_rec->receiver_1;
$recipients2 =$sms_rec->receiver_2;
$massage  = "Dear Sir,\r\nRequest for WO Hold Approval. \r\n";
$massage  .= "Job No : ".$ms_data->job_no." \r\n";
$massage  .= "Login : https://boxes.com.bd/NATIVE/lc_mod/pages/main/index.php?module_id=13 \r\n";
$sms_result=sms($recipients, $massage);
if($recipients2>0) {
$sms_result=sms($recipients2, $massage);
}
	
//Text Sms

		

}

?>

<!--<script language="javascript">
window.location.href = "wo_hold_request.php";
</script>-->

<?


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

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

//if($delivery_within>0)
//{
//	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);
//}







?>


<script>

function calculation(id){

var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);
var bc_qty=((document.getElementById('issue_'+id).value)*1);



 if(bc_qty>pending_qty)
  {
alert('Can not issue more than pending quantity.');
document.getElementById('issue_'+id).value='';
document.getElementById('chalan_'+id).value='';


  } 



//if (pp_bag >0) {
//	var pp_qty= document.getElementById('pp_qty_'+id).value= (bag_size*pp_bag);
//	var hdpe_bag= document.getElementById('hdpe_bag_'+id).value= (pp_bag/3);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (pp_bag+hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (pp_qty+hdpe_qty);
//} else if((pp_bag ==0)) {
//	var hdpe_bag=((document.getElementById('hdpe_bag_'+id).value)*1);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (hdpe_qty);
//}
//
//var wastage_starting=((document.getElementById('wastage_starting_'+id).value)*1);
//var wastage_on_process=((document.getElementById('wastage_on_process_'+id).value)*1);
//var total_wastage= document.getElementById('total_wastage_'+id).value= (wastage_starting+wastage_on_process);
//var net_total_qty= document.getElementById('net_total_qty_'+id).value= (total_qty-total_wastage);


}

</script>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td width="45%" valign="top"><fieldset style="width:100%;">

    <? $field='do_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">WO  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:250px;" />

      </div>

    <? $field='do_date';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">WO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required  style="width:250px;" />

      </div>
	  
	  
	  
	 
	  
	   <? $field='job_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">Job No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:250px;"  />

      </div>
	  
	  
	  
	  <div>

        <label style="width:140px;" for="<?=$field?>"> Customer:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" 
		style="width:250px;" required="required"/>

		<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>" required="required" style="width:250px;"/>

      </div>
	  
	  
	  <div>

        <label style="width:140px;" for="<?=$field?>"> Marketing Team:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('marketing_team','team_name','team_code='.$marketing_team);?>"
		style="width:250px;" required="required"/>

		<input  name="marketing_team" type="hidden" id="marketing_team" value="<?=$marketing_team?>" required="required" style="width:250px;"/>

      </div>
	  
	  	  <div>

        <label style="width:140px;" for="<?=$field?>"> Marketing Person:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('marketing_person','marketing_person_name','person_code='.$marketing_person);?>" 
		style="width:250px;" required="required"/>

		<input  name="marketing_person" type="hidden" id="marketing_person" value="<?=$marketing_person?>" required="required" style="width:250px;"/>

      </div>
	  
	  
	  <div>

        <label style="width:140px;" for="<?=$field?>"> Buyer:</label>

         <input  name="buyer_info2" type="text" id="buyer_info2" value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer_code);?>" required="required" 
		 style="width:250px;"/>

		<input  name="buyer_code" type="hidden" id="buyer_code" value="<?=$buyer_code?>" required="required"/>

      </div>
	  
	  
	  <div>

        <label style="width:140px;" for="<?=$field?>">Merchandiser:</label>

        <input  name="merchandizer_code2" type="text" id="merchandizer_code2" value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer_code);?>" required="required" style="width:250px;"/>

		<input  name="merchandizer_code" type="hidden" id="merchandizer_code" value="<?=$merchandizer_code?>" required="required"/>

      </div>
	 


    </fieldset></td>

    <td width="9%">			</td>

    <td width="45%"><fieldset style="width:100%;">
	
	
	
	<? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Company:</label>

        <input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" style="width:250px;" />

		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required="required"/>

      </div>
	  
	  
	   <? $field='customer_po_no';?>

      <div>

        <label style="width:120px;" for="<?=$field?>"><span style="width:140px;">Customer's PO</span>:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"   style="width:250px;"/>

      </div>
	  
	  
	   <? $field='customer_po_date';?>

      <div>

        <label style="width:120px;" for="<?=$field?>"><span style="width:140px;">PO Date</span>:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:250px;" />

      </div>
	
	
	


      <div>

        <label style="width:120px;" for="<?=$field?>"> Order Throw:</label>

   <input  name="buyer_info2" type="text" id="buyer_info2" value="<?=find_a_field('order_throw','order_throw','id='.$order_throw);?>" required="required" style="width:250px;"/>

		<input  name="order_throw" type="hidden" id="order_throw" value="<?=$order_throw?>" required="required"/>

      </div>

      <div></div>
 

      <div>

        <label style="width:120px;" for="<?=$field?>">Order Type:</label>

        <input  name="merchandizer_code2" type="text" id="merchandizer_code2" value="<?=find_a_field('order_type','order_type','id='.$order_type);?>" 
		style="width:250px;" required="required"  readonly="" />

		<input  name="order_type" type="hidden" id="order_type" value="<?=$order_type?>" required="required"/>

      </div>
	  
	  
	  <div>

        <label style="width:120px;" for="<?=$field?>">FSC Type:</label>

        <input  name="merchandizer_code2" type="text" id="merchandizer_code2" value="<?=find_a_field('fsc_claim_type','fsc_claim','id='.$fsc_claim);?>" 
		style="width:250px;" required="required"/>

		<input  name="fsc_claim" type="hidden" id="fsc_claim" value="<?=$fsc_claim?>" required="required"  readonly="" />

      </div>
	  
	  
	  	  <div>

        <label style="width:120px;" for="<?=$field?>">FSC Logo:</label>


		<input  name="fsc_logo" type="text" id="fsc_logo" value="<?=$fsc_logo?>"  readonly=""  style="width:250px;"/>

      </div>
	  
	  
	  <div>

        <label style="width:120px;" for="<?=$field?>">Remarks:</label>


		<input  name="remarks" type="text" id="remarks" value="<?=$remarks?>"  readonly="" style="width:250px;"/>

      </div>

              

      <div>


      

      </div>

		</fieldset></td>

    <td width="2%">&nbsp;</td>

    <?php /*?><td width="16%" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">

	          

        <tr>

          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>

          <td align="left" bgcolor="#9999CC"><strong>PR</strong></td>

        </tr>

<?

$sql='select distinct pr_no,rec_date from purchase_receive where po_no='.$po_no.' order by id desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99"><?=$aaa->rec_date?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="../pr_fg/chalan_view.php?v_no=<?=$aaa->pr_no?>"><img src="../../images/print.png" width="15" height="15" /></a></td>

        </tr>

<?

}

?>



      </table></td><?php */?>

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

        

        <td rowspan="2" align="left" bgcolor="#CCFF99">
		<a title="WO Preview" target="_blank" href="work_order_print_view.php?v_no=<?=$$unique?>"><img src="../../../images/print.png" alt="" width="30" height="30" /></a>
		</td>
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

	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td width="21%" align="right" bgcolor="#9999FF"><strong> Date:</strong></td>

        <td width="15%" bgcolor="#9999FF"><strong>

          <input style="width:120px; height:30px;"  name="so_date" type="text" id="so_date" value="<?=($so_date!='')?$so_date:date('Y-m-d')?>" 
		  autocomplete="off" required="required"/>

         
        </strong></td>

        <td width="17%" bgcolor="#9999FF"><div align="right"><strong>Remarks:</strong></div></td>
        <td width="47%" bgcolor="#9999FF">
			<input style="width:300px; height:30px;"  name="req_remarks" type="text" id="req_remarks" value="" required="required" autocomplete="off" />		</td>
      </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){

  $sql='select a.id,  a.item_id,  a.unit_price,  b.item_name,  b.unit_name, a.ply, a.paper_combination, a.L_cm, a.W_cm, a.H_cm, a.measurement_unit, a.total_unit as qty from sale_do_details a,item_info b where b.item_id=a.item_id and  a.do_no='.$$unique;

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th width="4%">SL</th>

            <th width="16%">Item Name </th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th bgcolor="#FFFFFF">Ply</th>
            <th bgcolor="#FFFFFF">Paper Combination</th>
            <th bgcolor="#FFFFFF">Measurement</th>
            <th bgcolor="#FF99FF">WO Qty </th>

            <th bgcolor="#009900">Bundle Qty  </th>

            <th bgcolor="#FFFF00">Challan Qty  </th>
            </tr>
          

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>

              <td width="2%" align="center"><?=$row->unit_name?>                </td>

              <td width="2%" align="center"><?=$row->ply?></td>
              <td width="20%" align="center"><?=$row->paper_combination?></td>
              <td width="17%" align="center">
			 
			  <? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?> <?=$row->measurement_unit?>			  </td>
              <td width="13%" align="center"><?=number_format($row->qty,2);?></td>

              <td width="13%" align="center">
			  <? echo number_format($bundle_qty = (find_a_field('sale_do_bundle_card','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>

              <td width="13%" align="center">
			  <? echo number_format($challan_qty = (find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?>            </td>
              </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /> <br />
  

  
  
  
  
	
	<br />
  

<table width="100%" border="0">

<? 

 $wo_status = find_a_field('sale_do_master','status','do_no='.$$unique);

if($wo_status=="CHECKED"){

?>



<tr>

<td align="center"><!--<input name="delete" type="submit" class="btn1" value="CANCEL WO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />-->

</td>

<td align="center">
<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/>
<input name="confirm" type="submit" class="btn1" value="WO HOLD REQUEST" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>




<? }else{?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  WORK ORDER  
  <?=$wo_status?></strong></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";


?>