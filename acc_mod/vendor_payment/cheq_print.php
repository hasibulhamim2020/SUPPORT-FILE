<?php

require_once "../../../assets/template/layout.top.php";

$title='Cheque Print';


do_calander('#fdate');

do_calander('#tdate');

$table = 'purchase_master';

$unique = 'jv_no';

$status = 'CHECKED';

$target_url = '../files/general_voucher_print_view_from_journal.php';

if(isset($_POST['confirm_print'])){
 
$tr_no = $_POST['checked_tr_no'];
 
 foreach($tr_no as $tr){
   $update = 'update vendor_payment_info set status="PRINTED" where id="'.$tr.'"';
   //mysql_query($update);
   echo $tr;
 }
 
 if (is_array($tr_no)) {
        $queryString = http_build_query(['tr_no' => $tr_no]);
        header("Location: payment_cheque_print.php?" . $queryString);
		/*echo '<script>window.open("payment_register_view.php?'.$queryString.'&&cid='.$_POST['group_for'].'&&bank='.$bank_id.'", "_blank");</script>';*/
    }
	
 //header("Location: payment_cheque_print.php?tr_no='".$new_tr_no."'");
}


if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}



?>

<script language="javascript">



function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);

}

</script>




<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4">
                
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date Interval: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />

                        </div>
                    </div>
                </div>
                
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bank</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="bank" id="bank" required>
                            <option></option>
                            <? 
						$gr_all=find_all_field('config_group_class','*','group_for='.$_SESSION['user']['group']);
						foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$_POST['bank'],"ledger_id=".$gr_all->cashAtBank." order by sub_ledger_name");
						?>
                            </select>

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

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>





        <div class="container-fluid pt-5 p-0 ">

            <?

            if(isset($_POST['submitit'])){

            if($_POST['fdate']!=''&&$_POST['tdate']!='')

                $con .= 'and payment_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
				
				if($_POST['group_for']>0)
				 $con .=' and group_for="'.$_POST['group_for'].'"';
				 
				 if($_POST['bank']>0)
				 $con .=' and bank_sub_ledger="'.$_POST['bank'].'"';
            ?>


                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SL</th>
						<th>Vendor Name</th>
						<th>Payee Name</th>
						<th>Narration</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
						<th>EFT/Cheque No. </th>
						<th>Bank Name</th>
						<th>Payment Status</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
					$ch_sql = 'select * from general_sub_ledger where 1';
					$ch_qry = mysql_query($ch_sql);
					while($ch_data = mysql_fetch_object($ch_qry)){
					
					  $sub_ledger_name[$ch_data->sub_ledger_id] = $ch_data->sub_ledger_name;
					  
					  
					}
					
					$res='select * from vendor_payment_info where status="PENDING" '.$con.'';
                    $query = mysql_query($res);
                    while($row = mysql_fetch_object($query)){
                        ?>

                        <tr>
                            <td><input type="checkbox" name="checked_tr_no[]" id="checked_tr_no" value="<?=$row->id?>" style="width:50px; height:30px;" /></td>
							<td><?=$sub_ledger_name[$row->vendor_sub_ledger]?></td>
							<td><?=$sub_ledger_name[$row->vendor_sub_ledger]?></td>
                            <td><?=$row->remarks?></td>
                            <td><?=number_format($row->payment_amount,2)?></td>
                            <td><?=$row->payment_mode?></td>
							<td><?=$row->payment_referance?></td>
							<td><?=$sub_ledger_name[$row->bank_sub_ledger]?></td>
							<td><input type="button" class="btn btn-success" value="PAID" /></td>
							
                        </tr>

                    <? } ?>
                       <tr>
					    <td colspan="9" align="center">
					   <input type="submit" name="confirm_print" id="confirm_print" value="Confirm Print" class="btn btn-primary" />
					    </td>
					   </tr>
                    </tbody>
                </table>

                <? } ?>


        </div>
    </form>
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




<?

require_once "../../../assets/template/layout.bottom.php";

?>