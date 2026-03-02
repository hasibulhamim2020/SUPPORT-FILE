<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="show";

$title='Unapprove Sales Order List';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$$unique_master=$_POST[$unique_master];



if(isset($_POST['return_remarks']) && $_POST['return_remarks']!=""){
        
		
		$remarks = $_POST['return_remarks'];
        unset($_POST);

		$_POST[$unique_master]=$$unique_master;
        $_POST['status']='MANUAL';
		$_POST['checked_at'] = date('Y-m-d H:i:s');
		$_POST['checked_by'] = $_SESSION['user']['id'];
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		
		approval_return_checking($$unique_master,'Sales', $entry_time);

		
		
		$note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique_master.'","DO","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
		db_query($note_sql);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;
        
        echo $msg='<span style="color:green;">Successfully Returned</span>';
}

if(isset($_POST['cancel']))
{


		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['status']='CANCELED';
		$_POST['checked_at'] = date('Y-m-d H:i:s');
		$_POST['checked_by'] = $_SESSION['user']['id'];
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		
		//insert into approval history
      $_POST['tr_no']=$$unique_master;
      $_POST['tr_from']='Sales';
      $_POST['approved_by']=$_SESSION['user']['id'];
      $_POST['approved_at']=date('Y-m-d h:s:i');
      $_POST['approval_level']=$all->current_approval_level;
      $_POST['remarks']="CANCELED";
      $_POST['notes']=$cancel_remarks;

        
  
        $crud_history  = new crud($table_history);
        $crud_history->insert();
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		echo $msg='<span style="color:red;">Successfully Canceled</span>';
		$tr_type="Remove";
}


if(isset($_POST['confirmm']))

{
  $entry_time=$_POST['entry_time'];
  $remarks=$_POST['remarks'];
  $$unique_master;

  $next_level_avaliable=approval_confirmation_checking($$unique_master,'Sales',$entry_time);
//  die();

 // unset($_POST);

    if($next_level_avaliable>0){
      $_POST[$unique_master]=$$unique_master;
      $crud   = new crud($table_master);
      $crud->update($unique);




    }else{
      $_POST[$unique_master]=$$unique_master;
      $_POST['checked_by']=$_SESSION['user']['id'];
      $_POST['checked_at']= $entry_time;
	  $_POST['remarks']= $remarks;
      $_POST['status']='CHECKED';
      $crud   = new crud($table_master);
      $crud->update($unique_master);


    }
    
		
		

		unset($_POST);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		echo $msg='<span style="color:green;">Successfully Instructed to Depot</span>';
		$tr_type="Complete";
}


$table='sale_do_master';
$show='dealer_code';
$id='do_no';
$text_field_id='old_do_no';

$target_url = '../cdo/do_check.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?do_no='+theUrl+'','_self');
}
</script>










<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">

        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate" class="from-control" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" autocomplete="off"/>
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  class="from-control" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" autocomplete="off"/>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
                </div>

            </div>
        </div>

    </form>




        <div class="container-fluid pt-5 p-0 ">
                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Do No</th>
                        <th>Do Date</th>
                        <th>Dealer Name</th>

                        <th>Warehouse</th>
                        <th>Created By</th>
                        <th>Created At</th>

                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <?

                    if($_POST['fdate']!=''&&$_POST['tdate']!=''){
                        $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
                        $tr_type="Search";
                        }


                    if($_POST['product_group']=='ABCDE'){ $con .= ' and d.product_group != "M"';}
                    elseif($_POST['product_group']!=''){ $con .= ' and d.product_group = "'.$_POST['product_group'].'"';}
					
					

                     $res="select m.do_no,m.do_date,concat(d.dealer_code,'-',d.dealer_name_e) as dealer_name,m.entry_at,u.fname,w.warehouse_name, 		   w.warehouse_id,u.user_id,wd.warehouse_id,wd.user_id
from sale_do_master m,dealer_info d, warehouse w, user_activity_management u, warehouse_define wd
where m.status in ('UNCHECKED')  and m.dealer_code=d.dealer_code ".$con."
and w.warehouse_id=m.depot_id and m.entry_by=u.user_id and w.warehouse_id=wd.warehouse_id and m.entry_by=wd.user_id and wd.status='Active' GROUP by m.do_no order by m.do_date desc,d.dealer_name_e "; 
                    $query = db_query($res);
                    while($data = mysqli_fetch_object($query))
                    {
					
					
												if(approval_validity_check($data->do_no,"Sales")>0){
                        ?>
                        <tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_date;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?> style="text-align:left">&nbsp;<?=$data->dealer_name;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?> style="text-align:left">&nbsp;<?=$data->warehouse_name;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->fname;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->entry_at;?></td>

                            <td onClick="custom(<?=$data->do_no;?>);">
                                <input type="button" class="btn1 btn1-bg-submit" value="Check DO">
                            </td>


                        </tr>
                        <?
                  } }
                     $res2="select m.do_no,m.do_date,concat(d.dealer_code,'-',d.dealer_name_e) as dealer_name,m.entry_at,m.order_from,w.warehouse_name
                    from sale_do_master m,dealer_info d, warehouse w
                    where m.status in ('PROCESSING','UNCHECKED')  and m.dealer_code=d.dealer_code ".$con."
                    and w.warehouse_id=m.depot_id and m.order_from='so' order by m.do_date desc,d.dealer_name_e ";
                    $query = db_query($res2);
                    while($data = mysqli_fetch_object($query))
                    {?>

                  <tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_date;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?> style="text-align:left">&nbsp;<?=$data->dealer_name;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?> style="text-align:left">&nbsp;<?=$data->warehouse_name;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->order_from;?></td>
                            <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->entry_at;?></td>

                            <td onClick="custom(<?=$data->do_no;?>);">
                                <input type="button" class="btn1 btn1-bg-submit" value="Check DO">
                            </td>


                        </tr>

                   <?}?>
                    </tbody>
                </table>





        </div>

</div>





<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>