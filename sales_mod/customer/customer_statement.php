<?php

session_start();

ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


$title='Customer Statement';

$proj_id=$_SESSION['proj_id'];

$fromdate=$_POST['fdate'];
$todate=$_POST['tdate'];


?>



<form id="form1" name="form1" method="post" action="">
    
    <div class="container-fluid  shadowdiv round p-0"> 
		
            <div class="row p-3">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 p-2">
                    <div class="form-group row m-0 p-0">
                        <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From:</label>
                        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" required /> 
                        </div>
                    </div>

                </div>
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 p-2">
                    <div class="form-group row m-0 p-0">
                        <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To:</label>
                        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 p-0">
	                        <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" required/>
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-2">
                    <div class="form-group row m-0 p-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
			<?php
                             				 $sql33="SELECT dealer_code,dealer_name_e from  dealer_info";
                             
                            					$query23=db_query($sql33);
                            
                             		?>
                             				<select name="customer_name" id="customer_name" class="customer_name req1" value="<?=$_POST['customer_name'];?>"> </td>

                            				<option></option>
                             	 <?php 
                              
                             				 while($datarow=mysqli_fetch_object($query23)){
                              
                              
                             	 ?>
                            
                                          
                            		 		<option><?=$datarow->dealer_name_e?>--<?=$datarow->dealer_code?></option> 
                            			   
                             <?php }?>
							 </select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 p-2 d-flex justify-content-cente align-items-center">
                    
                    <input class="btn1 btn1-submit-input" name="show" type="submit" id="show" value="Show" />
                    
                </div>

            </div>
	</div>

    
            
        <div class="container-fluid shadowdiv  round mt-3 pt-3 pb-3">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report">
								        
								        <form id="form1" name="form1" method="post" action="">

									

								    </form></div></td>

						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td> <div id="reporting">
									<?php 
									
									
  if(isset($_POST['show']))

  {
 $tr_type="Search";
 $fdate=$_POST['fdate'];
 $tdate=$_POST['tdate'];

$customer_name=explode("--",$_POST["customer_name"]);
$customer_id=$customer_name[1];
$cus_ledger=find_a_field('dealer_info','dealer_code','dealer_code='.$customer_name);
$cc_code = (int) $_POST['cc_code'];

	if($_POST['customer_name']!==''){
	$con.= 'and dealer_code = "'.$customer_id.'"';
	}
	







									
									?>

							<table class="table1  table-striped table-bordered table-hover table-sm" id="grp">
                    <thead class="thead1">
                    <tr class="bgc-info">

								<th width="10%" height="20" align="center">S/N</th>

								<th width="30%" align="center">Customer Name</th>
								<th width="20%" height="20" align="center">Opening</th>

								<th width="20%" height="20" align="center">Debit</th>

								<th width="20%" align="center">Credit</th>

								<th width="20%" align="center">Balance</th>

							

							  </tr>
</thead>
<tbody class="tbody">
  <?php



$sql= "select dealer_code,dealer_name_e,account_code, sub_ledger_id from dealer_info where 1 ".$con." ";
	
$query=db_query($sql);
while($row=mysqli_fetch_object($query)){

$opening=find_a_field('journal','SUM(dr_amt-cr_amt)','sub_ledger="'.$row->sub_ledger_id.'"  and jv_date<"'.$fdate.'"');
 $total_debit=find_a_field('journal','SUM(dr_amt)','sub_ledger="'.$row->sub_ledger_id.'"  and jv_date between "'.$fdate.'" and "'.$tdate.'"');
  
   $test='select * from journal where sub_ledger="'.$row->sub_ledger_id.'"  and jv_date between "'.$fdate.'" and "'.$tdate.'"';
$total_credit=find_a_field('journal','SUM(cr_amt)','sub_ledger="'.$row->sub_ledger_id.'"  and jv_date between "'.$fdate.'" and "'.$tdate.'"');
	$balance=round(($opening+$total_debit)-$total_credit,2);

if($balance>0){
  $status1="Dr";
}
else{
 $status1="Cr";
}

  ?>
                <? if($balance!=0) { ?>
				<tr >

				<td align="center"><?= ++$i;?></td>

				<td align="center"><?=$row->dealer_name_e;?> </td>
				<td align="center"><?=$opening;?> </td>
                
				<td align="center"> <a href="customer_chalanview.php?sub_ledger=<?=$row->sub_ledger_id; ?>&fdate=<?=$fromdate ?>&tdate=<?=$todate?>&led_id=<?=$row->sub_ledger_id?>" target="blank"><?php echo $total_debit;?></a> </td>
                
                
               
				<td align="left"><a href="customer_chalanview2.php?sub_ledger=<?=$row->sub_ledger_id; ?>&fdate=<?=$fromdate ?>&tdate=<?=$todate?>&led_id=<?=$row->sub_ledger_id?>" target="blank"><?= $total_credit;?></a></td>
              
				<td align="center"><?= $balance."  (".$status1." )";?></td>
				</tr>
                <? } ?>
				<?php 
			  
$debit_sum= $debit_sum+$total_debit;
$credit_sum= $credit_sum+$total_credit;
$balance_sum=$balance_sum+$balance;

} ?>
				
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				</tr>
				
				
				<tr style="font-weight:bold;">

				<td align="center"></td>
				<td align="center"></td>

				<td align="center">Total </td>

				<td align="center"><?=$debit_sum;?></td>

				<td align="left"><?=$credit_sum;?></td>
<?php 
if($debit_sum>$credit_sum){
  $status="Dr";
}
else{
 $status="Cr";
}
?>
				<td align="center"><?=$balance_sum." ( ".$status.")";?></td>

				</tr>




</table><?php } ?> </div>

			<div id="pageNavPosition"></div>

			</td>

			</tr>
</tbody>
		</table>

        </div>

    
    
    
    

</form>



<?
selected_two("#customer_name");
require_once SERVER_CORE."routing/layout.bottom.php";
?>