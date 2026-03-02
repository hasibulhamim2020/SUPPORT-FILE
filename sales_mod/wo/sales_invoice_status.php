<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$tr_type="Show";

$c_id = $_SESSION['proj_id'];
$title='Sales Order Status';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique_master='do_no';

 $master_id = find_a_field('user_activity_management','master_user','user_id='.$_SESSION['user']['id']);

//create_combobox('do_no');
//create_combobox('dealer_code');

$table_detail='sales_return_detail';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		$crud   = new crud($table_chalan);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirm']))
{
		$do_no=$_POST['do_no'];

		$_POST[$unique_master]=$$unique_master;
		$_POST['send_to_depot_at']=date('Y-m-d H:i:s');
		$_POST['do_date']=date('Y-m-d');
		$_POST['status']="CHECKED";
		
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
				unset($_POST);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='sale_do_master';
$show='dealer_code';
$id='do_no';
$text_field_id='do_no';

$target_url = 'sales_order_print_view.php';
?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl,c_id)
{
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
}


function custom2(theUrl)
{
	window.open('do.php?old_do_no='+theUrl);
}
</script>

<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 90%;
    height: 38px;
    border-radius: 0px !important;
}



</style>


<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">

        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> From Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                              <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
             <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<input list="dealer" type="text" name="dealer_code" id="dealer_code" /> 
                            <datalist id="dealer">
		
							<option></option>
					
							<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');?>
						</datalist>
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 pt-1 pb-1">
                    <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse Name :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
				 
				 <select name="warehouse_id" id="warehouse_id" >
				
			 <option></option>
                  <? foreign_relation('warehouse w, warehouse_define d','w.warehouse_id','w.warehouse_name',$_POST['warehouse_id'],'w.warehouse_id=d.warehouse_id and d.user_id="'.$_SESSION['user']['id'].'" and d.status="Active"');?>
				</select>
				 
				 

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>

		
		<div class="row pt-2 justify-content-center">
		<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
				<div class="form-group row m-0">
					
					<a href="do.php?new=2" class="btn btn-info btn-block">Create New Order</a>
					
				</div>
				</div>
			</div>
		

    </form>

        <div class="container-fluid pt-2 p-0 ">
                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SO No</th>
                        <th>SO Date</th>
                        <th>Customer Name</th>
                        <th>Warehouse Name</th>
                        <th>Entry By</th>
                        <th>Status</th>
						<th>Addi Status</th>
						<th>Approval Authorities</th>
                        <th colspan="2">Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                   <? 
					$last_two_months = date('Y-m-d', strtotime('-2 months'));
					$con = ' and m.do_date between "'.$last_two_months.'" and  "'.date('Y-m-d').'" ';
					
					if(isset($_POST['submitit'])){
						if($_POST['fdate']!=''&&$_POST['tdate']!='')  { 
							$con = ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
						}
						
						if($_POST['dealer_code']!='')
							$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
							
						if($_POST['warehouse_id']!='') 
							$con .= ' and m.depot_id in ('.$_POST['warehouse_id'].') ';
						$tr_type="Search";
					}
					
					$res="select m.do_no, m.do_no, m.do_date, m.dealer_code, m.job_no, m.sales_type, m.depot_id,  d.dealer_name_e, m.entry_by, m.status ,w.warehouse_id,w.warehouse_name,wd.user_id
						from  sale_do_master m,  dealer_info d, user_group u, warehouse w, warehouse_define wd
					where m.group_for=u.id  and m.dealer_code=d.dealer_code and m.depot_id=w.warehouse_id and wd.status='Active' and w.warehouse_id=wd.warehouse_id and m.entry_by=wd.user_id  ".$group_for_con.$con.$dealer_con." GROUP by m.do_no   order by m.do_no desc";
					$query = db_query($res);
					
					while($data = mysqli_fetch_object($query))
					{
					?>
                        <tr> 
									
							<td><?= $data->do_no?></td>
							<td><?= $data->do_date?></td>
							<td style="text-align:left"><?= $data->dealer_name_e?></td>
							<td style="text-align:left"><?= $data->warehouse_name?></td>
							<td><?= find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
							<td><?= $data->status?></td>
							<td>
							<?php
							$final_fg_qty=find_a_field('journal_item','sr_no','sr_no="'.$data->pr_no.'"');
							
							if($data->status=='PROCESSING'){
							echo "<span style='color:red;font-weight:bold;'>Acc Approval Pending</span>";
							}
							elseif($data->status=='UNCHECKED'){
							echo "<span style='color:blue;font-weight:bold;'>Sales Approval Pending</span>";
							}
							elseif($data->status=='MANUAL'){
							echo "<span style='color:black;font-weight:bold;'>Unfinished</span>";
							}
							else{
							echo "<span style='color:green;font-weight:bold;'>Approval Complete</span>";
							}
						?>
							</td>
							
							
							
							<?
                            if($data->status=='UNCHECKED'){
                            ?>
                            <td>
                            <?
                            $current_level = find_a_field('approval_matrix_history','MIN(approval_level)','tr_no="'.$data->do_no.'" and tr_from="Sales" and status="1"');
                            if( $current_level>0){
                              $res_approval_member = 'SELECT a.*,u.fname from approval_matrix_setup a JOIN user_activity_management u ON a.user_id=u.user_id where a.level<"'.$current_level.'" and a.status="ACTIVE" and a.tr_from="Sales" ORDER BY a.level DESC;
                                ';
                            }else{
                                $res_approval_member = 'SELECT a.*,u.fname from approval_matrix_setup a JOIN user_activity_management u ON a.user_id=u.user_id where a.tr_from="Sales" and a.status="ACTIVE" ORDER BY a.level DESC;'; 
                            }



                            $query_approval_member=db_query($res_approval_member);
                            
                            While($row2=mysqli_fetch_object($query_approval_member)){ 
                                // echo '<pre>';
                                // echo print_r($row2);
                                // echo '</pre>';

                            ?>
                             <span style="background-color: #898121; color: white; padding: 4px 8px; border-radius: 3px;"><?=$row2->fname?></span><br>


                            <? } ?>
                            </td>
                            <? }else{ ?>
                                <td></td>
                           
                            <? } ?>
							
							
							
							<td>
							<button type="button" onClick="custom('<?=url_encode($data->do_no);?>','<?=url_encode($c_id);?>');" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button>
							</td>
							<td>
								<? if($data->status=='MANUAL'){ ?>
								<button type="button" onClick="custom2(<?=$data->do_no;?>);" class="btn2 btn1-bg-submit"><i class="fa-solid fa-pen-to-square"></i></button>
								<? } ?>
							</td>


                        </tr>
                        <?
                    }
				?>
                    </tbody>
                </table>





        </div>

</div>








<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>