<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$c_id = $_SESSION['proj_id'];

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

function custom(theUrl,c_id)
{
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
}

</script>




<div class="form-container_large">
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
                $con .= 'and j.jv_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
				if($_POST['group_for']>0)
				 $con .=' and j.group_for="'.$_POST['group_for'].'"';

          	 $res='select j.jv_no,j.jv_date,j.tr_from,j.narration,sum(j.dr_amt) as dr_amt,g.sub_ledger_name from journal j,general_sub_ledger g  where j.tr_from in ("Vendor_payment","Vendor_advance_payment") and g.sub_ledger_id=j.sub_ledger  '.$con.'  group by jv_no order by jv_no asc';
            $query = db_query($res);
            //echo link_report($res,'po_print_view.php');
            ?>

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Jv No</th>
						<th>Jv Date</th>
						<th>Tr From</th>
						<th>Narration</th>
                        <th>Amount</th>
                        <th>Vendor</th>
						<th>View </th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
                    while($row = mysqli_fetch_object($query)){
                        ?>

                        <tr>
                            <td><?=$row->jv_no?></td>
							<td><?=$row->jv_date?></td>
							<td><?=$row->tr_from?></td>
                            <td><?=$row->narration?></td>
                            <td><?=$row->dr_amt?></td>
                            <td><?=$row->sub_ledger_name?></td>
                            <td><input type="submit" name="submitit" id="submitit" value="VIEW" class="btn1 btn1-submit-input" onclick="custom('<?=url_encode($row->jv_no);?>','<?=url_encode($c_id);?>');" /></td>

                        </tr>

                    <? } ?>

                    </tbody>
                </table>

                <? } ?>


        </div>
    </form>
</div>






<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>