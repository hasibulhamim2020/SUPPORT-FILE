<?php

require_once "../../../assets/template/layout.top.php";

$title='Payment Register';



do_calander('#fdate');

do_calander('#tdate');

$table = 'purchase_master';

$unique = 'jv_no';

$status = 'CHECKED';

$target_url = '../files/general_voucher_print_view_from_journal.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}


if(isset($_POST['confirm_print'])){
 
$tr_no = $_POST['checked_tr_no'];
 
if (is_array($tr_no)) {
        $queryString = http_build_query(['tr_no' => $tr_no]);
		echo '<script>window.open("payment_register_view.php?'.$queryString.'&&cid='.$_POST['group_for'].'&&bank='.$bank_id.'", "_blank");</script>';
    }
}


?>

<script language="javascript">



function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);

}

</script>




<div class="form-container_large">
<p> <? include('PrintFormat.php');?> </p>
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date Interval: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />

                        </div>
                    </div>
                </div>
				
				
                
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="group_for" id="group_for">
                            <option></option>
                            <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'1')?>
                            </select>

                        </div>
                    </div>
                </div>

               

            </div>
			</div>
			<div class="container-fluid bg-form-titel">
			<div class="row">
			   <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Select Vendor: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="vendor_id" id="vendor_id" value="<?=$_POST['vendor_id']?>" list="vendor" />
							<datalist id="vendor">
							  <? foreign_relation('general_sub_ledger','concat(sub_ledger_name,"#",sub_ledger_id)','""',$vendor_id,'1')?>
							</datalist>
                        </div>
                    </div>
					 </div>
					
					

               
				
				 <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                   
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>
			</div>
        </div>
 <?

            if(isset($_POST['submitit'])){
            
            if($_POST['fdate']!=''&&$_POST['tdate']!='')

                $con .= 'and p.tr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
				
				if($_POST['group_for']>0)
				 $con .=' and p.group_for="'.$_POST['group_for'].'"';
				 
				 if($_POST['vendor_id']!=''){
				    $vendor = explode("#",$_POST['vendor_id']);
				    $con .=' and p.payee_sub_ledger="'.$vendor[1].'"';
				 }
				 
				 
				 
            ?>

</form>


        <div class="container-fluid pt-5 p-0 ">
<form action="payment_register_view_post.php" method="post" name="codz" id="codz" target="_blank">
                <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SL</th>
						<th>Company</th>
						<th>Payee Name</th>
						<th>Type</th>
						<th>TR No.</th>
						<th>Payable</th>
                        <th>Pay</th>
                        <th>Payment Mode</th>
						<th>EFT/Cheque No. </th>
						<th>Bank Name</th>
						<th>Payment Status</th>
                    </tr>
                    </thead>
                    
                    <tbody class="tbody1">

                    <?
                    
					$bsql = 'select sub_ledger_name as cash_bank from general_sub_ledger where tr_from="custom" and type in("Cash at Bank","Cash In Hand")';
					$bqry = mysql_query($bsql);
					while($bdata=mysql_fetch_object($bqry)){
					 ++$b;
					 $cash_bank[$b] = $bdata->cash_bank;
					 
					}

					
					$ch_sql = 'select p.*,s.sub_ledger_name from vendor_payment_info p, general_sub_ledger s where p.bank_sub_ledger=s.sub_ledger_id';
					$ch_qry = mysql_query($ch_sql);
					while($ch_data = mysql_fetch_object($ch_qry)){
					if($old_tr_no!=$ch_data->tr_no){
					 $n=1;
					}
					  $payment_amt[$ch_data->tr_no] = $ch_data->payment_amount;
					  $cheq_no[$ch_data->tr_no][$n] = $ch_data->payment_referance;
					  $payment_mode[$ch_data->tr_no][$n] = $ch_data->payment_mode;
					  $bank_sub_ledger[$ch_data->tr_no][$n] = $ch_data->sub_ledger_name;
					  $old_tr_no = $ch_data->tr_no;
					  $n++;
					}
					
					//$res='select m.system_invoice_no,v.vendor_name,m.remarks,sum(d.amount) as amount,m.status,m.payment_mode,m.payment_referance,g.group_name from vendor v,vendor_invoice_details d, vendor_invoice_master m, user_group g where g.id=m.group_for and m.vendor_id=v.vendor_id and m.status in ("PENDING","PAID") and m.system_invoice_no=d.system_invoice_no '.$con.' group by d.system_invoice_no order by m.system_invoice_no';
					
					$res = 'select p.*,s.sub_ledger_name,g.company_short_code from payment_register p, general_sub_ledger s, user_group g where p.payee_sub_ledger=s.sub_ledger_id and p.group_for=g.id '.$con.'';

            $query = mysql_query($res);
                    while($row = mysql_fetch_object($query)){
					$paid_amt = $payment_amt[$row->tr_no];
					$rest_amt = $row->amount-$paid_amt;
					if($row->is_selected=='Yes'){
					 $checked = 'checked';
					}
                        ?>

                        <tr>
                            <td><input type="hidden" name="cid<?=$row->id?>" value="<?=$row->group_name?>" />
							<input type="checkbox" name="checked_tr_no[]" id="checked_tr_no" value="<?=$row->id?>" <?=$checked?> style="width:50px; height:30px;" /></td>
							<td><?=$row->company_short_code?></td>
							<td><?=$row->sub_ledger_name?></td>
                            <td>
							<? if($row->tr_from=='vendor_invoice_receive'){
							  $type = 'Vendor Invoice Payment';
							}elseif($row->tr_from=='Money Requisition'){
							 $type = 'Money Requisition';
							}else{
							 $type = $row->tr_from;
							}
							echo $type;
							?>							</td>
                            <td><?=$row->tr_no?></td>
                            <td><?=number_format($rest_amt,2)?></td>
							
                            <td width="30%"><input type="text" name="pay_<?=$row->id?>" id="pay_<?=$row->id?>" value="<?=$rest_amt?>" style="width:100%;" /></td>
                            <td><?
							 
							for($i=1; $i<=$n; $i++){ if($payment_mode[$row->tr_no][$i]!='') { echo $payment_mode[$row->tr_no][$i].', '; ++$tmode; } } 
							 if($tmode<1){
							 
							    echo $str = '<select id="payment_mode" name="payment_mode'.$row->id.'"><option></option><option>CHEQUE</option><option>BEFTIN</option><option>MOBILE BANKING</option></select>';
							   
							 }
							 
							 ?></td>
							
							<td><? for($i=1; $i<=$n; $i++){ if($cheq_no[$row->tr_no][$i]!='') { echo $cheq_no[$row->tr_no][$i].', '; } } ?></td>
							
							<td style="width:20%;"><? 
							
							for($i=1; $i<=$n; $i++){ if($bank_sub_ledger[$row->tr_no][$i]!=''){ echo $bank_sub_ledger[$row->tr_no][$i].', '; 
							++$tbank;} }
							
							if($tbank<1){
							 
							    $str = '<input type="text" name="cash_bank_info'.$row->id.'" list="CashBankList" />';
							    $str .= '<datalist id="CashBankList">';
							    foreach($cash_bank as $cashBank){
							      $str .= '<option>'.$cashBank.'</option>';
							    }
							   $str .= '</datalist>';
							   echo $str;
							 } 
							
							?></td>
							
							<? if($row->status=='PAID'){ ?>
							<td><span class="badge badge-success">Paid</span></td>
							<? }else{?>
							<td><span class="badge badge-dark">Pending</span>
							<div id="pr_ap<?=$row->id?>"><span type="button" class="badge badge-primary" onclick="save(<?=$row->id?>)">Approve</span></div>
							</td>
							<? } ?>
                        </tr>

                    <? } ?>
                    <tr>
					    <td colspan="11" align="center">
						
					   <input type="submit" name="confirm_print2" id="confirm_print2" value="Confirm Print" class="btn btn-primary" />					    </td>
					   </tr>
                    </tbody>
                </table>
		  </form>

                <? } ?>


        </div>
   
</div>







<?php /*?><div class="form-container_large">

  <form action="" method="post" name="codz" id="codz">

    <table width="80%" border="0" align="center">

      <tr>

        <td>&nbsp;</td>

        <td colspan="3">&nbsp;</td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />

        </strong></td>

        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />

        </strong></td>

        <td bgcolor="#FF9966"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>

        </strong></td>

      </tr>

    </table>

  </form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td>
<div class="tabledesign2">

<? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



  $res='select  a.po_no,a.po_no, DATE_FORMAT(a.po_date, "%d-%m-%Y") as po_date,   v.vendor_name as party_name,c.fname as entry_by, a.checked_at from purchase_master a,warehouse b,user_activity_management c, vendor v where  a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id and a.vendor_id=v.vendor_id  and a.status="CHECKED"  '.$con.' order by a.po_no DESC';

echo link_report($res,'po_print_view.php');



}

?>

</div>

</td>

</tr>

</table>

</div><?php */?>


<script>
 function save(id){
  var approve_amt = document.getElementById('pay_'+id).value*1;
  getData2('register_approve_ajax.php', 'pr_ap'+id, id, approve_amt);
 }
</script>

<?

require_once "../../../assets/template/layout.bottom.php";

?>