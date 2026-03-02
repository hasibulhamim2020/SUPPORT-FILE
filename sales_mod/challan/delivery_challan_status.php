<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Delivery Challan Status';


$tr_type="Show";
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique_master='do_no';

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

$target_url = 'delivery_challan_print_view.php';

$tr_from="Warehouse";
?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>


<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
	font-weight: bold;
	color: #000000;
	font-size: 14px;
}
.style3 {color: #FFFFFF}

-->








div.form-container_large input {
    width: 280px;
    height: 38px;
    border-radius: 0px !important;
}


</style>







<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">

        <div class="container-fluid bg-form-titel">
            <div class="row">

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Costomer Name </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="dealer_code" id="dealer_code"  >
		
									<option></option>
							
									<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');?>
								</select>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job No </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="do_no" id="do_no" >
		
								<option></option>
						
								<? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'1');?>
								</select>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Challan No </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="chalan_no" id="chalan_no" >
		
									<option></option>
							
									<? foreign_relation('sale_do_chalan','chalan_no','chalan_no',$_POST['chalan_no'],'1 group by chalan_no');?>
									</select>

                            </div>
                        </div>

                    </div>



                </div>


                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date :</label>
                          
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input type="text" name="fdate" id="fdate"  value="<?=$_POST['fdate']?>" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> To Date: </label>
                            
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" autocomplete="off"/>
                            </div>
                        </div>

                        

                    </div>



                </div>


            </div>

            <div class="n-form-btn-class">
                <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
            </div>
        </div>

        <!--return Table design start-->
        <div class="container-fluid pt-5 p-0 ">
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>Invoice No </th>
				  <th>Challan No </th>
				  <th>Gate Pass </th>
				  <th>Challan Date</th>
				  <th>Job No </th>
				  <th>Customer Name</th>
				  <th>Status</th>
				  
                </tr>
                </thead>

                <tbody class="tbody1">

                
				<? 
				
				if(isset($_POST['submitit'])){
				
				if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}
				
				
						
						
						if($_POST['dealer_code']!=''){
						$dealer_con=" and c.dealer_code='".$_POST['dealer_code']."'";
						}
						if($_POST['do_no']!=''){
						$job_no_con=" and c.do_no='".$_POST['do_no']."'";
						}
						if($_POST['chalan_no']!=''){
						$chalan_con=" and c.chalan_no='".$_POST['chalan_no']."'";
						}
				
					$res="select c.chalan_no, c.chalan_date,  m.do_no, m.job_no,  m.do_date, m.dealer_code,  d.dealer_name_e, c.entry_by, c.status from 
				sale_do_master m, sale_do_chalan c, dealer_info d, user_group u 
				where 
				
				 m.group_for=u.id  and m.dealer_code=d.dealer_code and m.do_no=c.do_no ".$group_for_con.$con.$dealer_con.$job_no_con.$chalan_con."  group by c.chalan_no order by  c.chalan_date DESC, m.do_no,c.chalan_no ";
				$query = db_query($res);
				
				$two_weeks = time() - 14*24*60*60;
				while($data = mysqli_fetch_object($query))
				{
				
				?>
				<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
				  <td><a title="Challan Preview" target="_blank" href="sales_invoice_print_view.php?v_no=<?=$data->chalan_no?>" style=" font-weight:700; color:#000000" >
					<?=$data->chalan_no;?>
				  </a></td>
				  <td><a title="Challan Preview" target="_blank" href="delivery_challan_print_view.php?v_no=<?=$data->chalan_no?>" style=" font-weight:700; color:#000000" ><?=$data->chalan_no;?></a></td>
				  <td><a title="Gate Pass Preview" target="_blank" href="gate_pass_print_view.php?v_no=<?=$data->chalan_no?>"  style=" font-weight:700; color:#000000" ><?=$data->chalan_no;?></a></td>
				  <td><?php echo date('d-m-Y',strtotime($data->chalan_date));?></td>
				  <td><?=$data->job_no;?></td>
				  <td>&nbsp;<?=$data->dealer_name_e;?></td>
				<td><?=$data->status;?></td>
				</tr>
				<?
				$total_send_amt = $total_send_amt + $data->SEND_AMT;
				$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
				}
				}
				?>

                </tbody>
            </table>

        </div>
    </form>

</div>


<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>