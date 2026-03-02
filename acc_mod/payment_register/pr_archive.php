<?php

require_once "../../../assets/template/layout.top.php";

$title='Invoice Status';



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



?>

<script language="javascript">



function custom(theUrl)
{
	window.open('<?=$target_url?>?date='+theUrl);

}

</script>




<div class="form-container_large">
<p> <? include('PrintFormat.php');?> </p>
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                
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

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                   
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>





        <div class="container-fluid pt-5 p-0 ">

            <?

            if(isset($_POST['submitit'])){

            if($_POST['fdate']!=''&&$_POST['tdate']!='')

                $con .= 'and p.archive_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
				
				if($_POST['group_for']>0)
				 $con .=' and p.group_for="'.$_POST['group_for'].'"';

          	 $res='select p.archive_date,p.tr_no,p.tr_from,g.sub_ledger_name,a.ledger_name,p.payment_mode,p.amount,u.company_short_code from payment_register_archive p, general_sub_ledger g, accounts_ledger a, user_group u where u.id=p.group_for and p.sub_ledger_id=g.sub_ledger_id and p.cash_bank_ledger=a.ledger_id '.$con.'';

            $query = mysql_query($res);

            //echo link_report($res,'po_print_view.php');
            ?>


                <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SL</th>
						<th>Company</th>
						<th>Register Date</th>
						<th>Tr No.</th>
						<th>Type</th>
						<th>Payee</th>
                        <th>Ledger</th>
                        <th>Amount</th>
						<th>View </th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
                    while($row = mysql_fetch_object($query)){
                        ?>

                        <tr>
                            <td><?=++$sl;?></td>
							<td><?=$row->company_short_code?></td>
							<td><?=$row->archive_date?></td>
							<td><?=$row->tr_no?></td>
                            <td><?=$row->tr_from?></td>
                            <td><?=$row->sub_ledger_name?></td>
                            <td><?=$row->ledger_name?></td>
							<td><?=number_format($row->amount,2)?></td>
                            <td><a href="pr_archive_print_view.php?date=<?=$row->archive_date?>" target="_blank"><input type="button" name="submitit" id="submitit" value="VIEW" class="btn1 btn1-submit-input" /></a></td>

                        </tr>

                    <? } ?>

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