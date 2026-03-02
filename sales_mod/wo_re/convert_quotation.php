<?php
session_start();
ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Requisition List ';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_requisition_master';
$unique='do_no';


$table_details='sale_requisition_details';
//$unique_chalan='id';

$$unique=$_POST[$unique];

//if(isset($_POST['delete']))
//{
//		$crud   = new crud($table_master);
//		$condition=$unique_master."=".$$unique_master;		
//		$crud->delete($condition);
//		$crud   = new crud($table_detail);
//		$crud->delete_all($condition);
//		$crud   = new crud($table_chalan);
//		$crud->delete_all($condition);
//		unset($$unique_master);
//		unset($_SESSION[$unique_master]);
//		$type=1;
//		$msg='Successfully Deleted.';
//}
//if(isset($_POST['confirm']))
//{
//		unset($_POST);
//		$_POST[$unique_master]=$$unique_master;
//		$_POST['entry_at']=date('Y-m-d h:s:i');
//		//$_POST['do_date']=date('Y-m-d');
//		//$_POST['status']='COMPLETED';
//		$crud   = new crud($table_master);
//		$crud->update($unique_master);
//		$crud   = new crud($table_detail);
//		$crud->update($unique_master);
//		$crud   = new crud($table_chalan);
//		$crud->update($unique_master);
//		
//		
//		
//		
//		
//		
//		
//		unset($$unique_master);
//		unset($_SESSION[$unique_master]);
//		$type=1;
//		$msg='Successfully Instructed to Depot.';
//}

if(prevent_multi_submit()){

if(isset($_POST['convert'])){
		
		
		 $do_no=$_POST['do_no'];
		 
		 
		 
		
		$so_no=find_a_field('sale_do_master', 'max(do_no)','1')+1;
		
		
		$entry_by =$_SESSION['user']['id'];
		
		
		 $ms_sql = 'select * from sale_requisition_master where do_no = '.$do_no;

		$ms_query = db_query($ms_sql);

		


		while($ms_data=mysqli_fetch_object($ms_query))

		{

			


 $so_ms = "INSERT INTO `sale_do_master` (`do_no`, `do_date`,`quo_no` ,`group_for`,`dealer_code`,`remarks`, `status`, `depot_id`,`vat_type` ,`vat_box`,`vat`, `ait_box` ,`ait`,`vat_ait_box`,`vat_ait`,`discount`, `cash_discount`,`ref_no`,`po_no`,`entry_at`, `entry_by`) 
 
 
 
 VALUES('".$so_no."', '".$ms_data->do_date."', '".$ms_data->do_no."','".$ms_data->group_for."','".$ms_data->dealer_code."','".$ms_data->remarks."', 'MANUAL',
 '".$ms_data->depot_id."', '".$ms_data->vat_type."','".$ms_data->vat_box."','".$ms_data->vat."','".$ms_data->ait_box."','".$ms_data->ait."' ,'".$ms_data->vat_ait_box."','".$ms_data->vat_ait."','".$ms_data->discount."','".$ms_data->cash_discount."','".$ms_data->ref_no."','".$_POST['po_no']."',
'".$entry_at."', '".$entry_by."' )";




db_query($so_ms);



}

		


		$sql = 'select * from sale_requisition_details where  do_no = '.$do_no;

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysqli_fetch_object($query))

		{

			
				$qty=$data->total_unit;

				$rate=$data->unit_price;

				$item_id =$data->item_id;

				
				$amount =$data->total_amt;


 $so_invoice = "INSERT INTO `sale_do_details` (`do_no`, `order_no`, `item_id`,`dealer_code`, `unit_name`,`unit_price`, `pkt_size`, `pkt_unit`, `dist_unit`, `total_unit`, `total_amt`, `depot_id`, `status`, `do_date`, entry_by, entry_at)
  VALUES('".$so_no."',  '".$data->id."',  '".$item_id."','".$data->dealer_code."','".$data->unit_name."','".$rate."',
 '".$data->pkt_size."', '".$qty."',  '".$qty."', '".$qty."','".$amount."', '".$data->depot_id."', 
   'MANUAL',  '".$data->do_date."',  '".$entry_by."', '".date('Y-m-d H:i:s')."' )";

db_query($so_invoice);

}
		
		
db_query('update sale_requisition_master set is_sales=1 where do_no="'.$do_no.'"');	
echo '<script>location.replace("../wo/do.php?old_do_no='.$so_no.'")</script>';
		
}
}
$table='sale_requisition_master';
$do_no='do_no';
$text_field_id='do_no';

//$target_url = '../sosp/so_create_from_requisition.php';

auto_complete_from_db('dealer_info','concat(dealer_name_e)','dealer_code','1','dealer');

?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?do_no='+theUrl);
}
</script>


<div class="form-container_large">
    
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Group</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input list="dealer_groups" name="dealer_group" type="text" id="dealer_group" />
    
                        </div>
                    </div>

                </div>
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date Active Customer</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input name="dealer" type="text" id="dealer" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quo NO:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            
								
		 
							<input  autocomplete="off" list="do_nos" name="do_nos" type="text" id="do_no" value="<?=$_POST['do_nos']?>" placeholder="Quotation No"/>
					 
						 <datalist  id="do_nos">
			
					   
			
						  <?  foreign_relation('sale_requisition_master','do_no','concat("Q-000",do_no)','','1 and status="CHECKED"');?>
						 
					  </datalist>	
					
									

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
					<input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
                    
                </div>

            </div>
        </div>






            
        <div class="container-fluid pt-5 p-0 ">

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Quotation No</th>
                        <th>Quotation Date</th>
                        <th>Dealer Name</th>

                        <th>Warehouse Name </th>
                        <th>Entry By</th>
                        <th>Entry At</th>
						<th>Status</th>

                        <th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
						<? 

							
							if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
							
							if($_POST['dealer_group']!='') 
							$con .= ' and de.dealer_type='.$_POST['dealer_group'].' ';
							
							if($_POST['dealer']!='') 
							$con .= ' and m.dealer_code='.$_POST['dealer'].' ';
							
							if($_POST['do_nos']!='') 
							$con .= ' and m.do_no='.$_POST['do_nos'].' ';
							
							$res="select m.do_no, m.do_no, m.dealer_code, m.do_date, m.depot_id,concat(w.warehouse_name) as warehouse_name,  m.status, u.fname, m.entry_at from sale_requisition_master m, sale_requisition_details d, warehouse w,dealer_info de ,user_activity_management u where m.dealer_code=de.dealer_code and m.do_no=d.do_no and m.depot_id=w.warehouse_id and m.entry_by=u.user_id and m.status='CHECKED' and m.is_sales=0 ".$con." group by m.do_no order by m.do_no desc";
							
							
							$query = db_query($res);
							while($data = mysqli_fetch_object($query))
							{
							?>
					
					  <tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
                            <td>Q-000<?=$data->do_no;?></td>
                            <td><?php echo date('d-m-Y',strtotime($data->do_date));?></td>
                            <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$data->dealer_code.'"');?></td>

                            <td><?=$data->warehouse_name;?></td>
                            <td><?=$data->fname;?></td>
                            <td><?=$data->entry_at;?></td>
							<td><?=$data->status;?></td>

                            
                            <td>
								<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
									<input type="hidden" name="do_no"  id="do_no" value="<?=$data->do_no?>"/>
									
									<input name="convert" type="submit"  id="convert" value="Convert Sale" class="btn1 btn1-submit-input" />
								</form>
							</td>

                        </tr>
							                      
                            <? } ?>
						 </tbody>
						 
						 <? 
						 	$total_send_amt = $total_send_amt + $data->SEND_AMT;
							$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
						 
						 ?>
						 
                </table>





        </div>
    </form>
</div>


<br /><br />



<!--<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>-->
      <?php /*?><tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="107" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td width="89" align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="158" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=$_POST['tdate']?>" />
        </strong></td>
        <td rowspan="3" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr><?php */?>
	  <?php /*?><tr>
	  	<td align="right" colspan="2" bgcolor="#FF9966">Customer Group</td>
		  
		 <td bgcolor="#FF9966">
		 
		 		<input list="dealer_groups" name="dealer_group" type="text" id="dealer_group" style="background-color:white;"/>
		 
		 	 <datalist  id="dealer_groups">

           

              <?  foreign_relation('dealer_type','id','dealer_type','','1');?>
             
          </datalist>	
		 </td>
	  	<td align="right" colspan="2" bgcolor="#FF9966">Active Customer List</td>
		<td  bgcolor="#FF9966">
		  <input name="dealer" type="text" id="dealer" style="background-color:white;"/></td>
		  
		 <td bgcolor="#FF9966">
		 
		 		<input list="do_nos" name="do_no" type="text" id="do_no" style="background-color:white;" placeholder="Quotation No"/>
		 
		 	 <datalist  id="do_nos">

           

              <?  foreign_relation('sale_requisition_master','do_no','concat("Q-000",do_no)','','1');?>
             
          </datalist>	
		 </td>
		 <td  bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
        </strong></td>
	  </tr><?php */?>
      <!--<tr>
        <td align="right" bgcolor="#FF9966"><strong>PO No  : </strong></td>
        <td colspan="3" bgcolor="#FF9966"><input type="text" name="po_no" id="po_no" style="width:107px;" value="<?=$_POST['po_no']?>" /></td>
      </tr>-->
    <?php /*?></table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th>Quotation No </th>
  <th>Quotation. Date </th>
  <th>Dealer</th>
  <th> Warehouse </th>
  <th>Status</th>
  <th>Entry By </th>
  <th>Entry At </th>
  <th>&nbsp;</th>
  </tr>


<? 


if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_group']!='') 
$con .= ' and de.dealer_type='.$_POST['dealer_group'].' ';

if($_POST['dealer']!='') 
$con .= ' and m.dealer_code='.$_POST['dealer'].' ';

if($_POST['do_no']!='') 
$con .= ' and m.do_no='.$_POST['do_no'].' ';

$res="select m.do_no, m.do_no, m.dealer_code, m.do_date, m.depot_id,concat(w.warehouse_name) as warehouse_name,  m.status, u.fname, m.entry_at from sale_requisition_master m, sale_requisition_details d, warehouse w,dealer_info de ,user_activity_management u where m.dealer_code=de.dealer_code and m.do_no=d.do_no and m.depot_id=w.warehouse_id and m.entry_by=u.user_id and m.status='CHECKED' and m.is_sales=0  ".$con." group by m.do_no order by m.do_no desc";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td>Q-000<?=$data->do_no;?></td>
<td><?php echo date('d-m-Y',strtotime($data->do_date));?></td>
<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$data->dealer_code.'"');?></td>
<td><?=$data->warehouse_name;?></td>
<td><?=$data->status;?></td>
<td><?=$data->fname;?></td>
<td><?=$data->entry_at;?></td>
<td>
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<input type="hidden" name="do_no"  id="do_no" value="<?=$data->do_no?>"/>

<input name="convert" type="submit"  id="convert" value="Convert Sale" class="btn1 btn1-submit-input" />
</form>
</td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;

}
?>


</tbody></table>
</div></td>
</tr>
</table>
</div><?php */?>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>