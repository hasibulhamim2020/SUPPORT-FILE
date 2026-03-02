<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$c_id = $_SESSION['proj_id'];

$title='Advance Payment';

do_calander('#fdate');

do_calander('#tdate');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../vendor_payment/new_advance_payment.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}



?>

<script language="javascript">

function custom(theUrl)

{

	//window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
	
	window.open('<?=$target_url?>?<?=$unique?>='+encodeURIComponent(theUrl));

}

</script>




<div class="form-container_large"><span style="color:green; font-weight:bold;"><?=$_SESSION['success'];unset($_SESSION['success'])?></span>
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

            
            ?>


                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SL</th>
                        <th>PO NO.</th>
						<th>PO Date</th>
                        <th>Vendor</th>
                        
                        <th>Entry At</th>
						<th>Entry By</th>
						<th>Entry By</th>

                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?
			    if($_POST['fdate']!=''&&$_POST['tdate']!='')
				$con .= 'and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
				
				if($_POST['group_for']>0)
				 $con .=' and p.group_for="'.$_POST['group_for'].'"';
				
				$res='select p.po_no,p.po_date,p.entry_at,v.vendor_name,u.fname from purchase_master p, vendor v, user_activity_management u 
				where p.vendor_id=v.vendor_id and p.entry_by=u.user_id and p.status="CHECKED" '.$con.'';

            $query = db_query($res);
                    while($row = mysqli_fetch_object($query)){
                        ?>

                        <tr>
                            <td><?=++$i?></td>
							
                           <?php /*?> <td><a href="../../purchase_mod/po/po_print_view_store.php?po_no='<?=url_encode($row->po_no);?>'" target="_blank"><span class="style13" >
						 <?=$row->po_no?></span></a></td><?php */?>
						 
						 
						   <td><a href="../../purchase_mod/po/po_print_view_store.php?c='<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($row->po_no));?>'" target="_blank"><span class="style13" >
						 <?=$row->po_no?></span></a></td>
						 
						 
                            <td><?=$row->po_date?></td>
                            <td><?=$row->vendor_name?></td>
                            <td><?=$row->entry_at?></td>
							<td><?=$row->fname?></td>
                            <td><input type="submit" name="submitit" id="submitit" value="Advance Payment" class="btn1 btn1-submit-input" onclick="custom(<?=$row->po_no?>);" /></td>

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>