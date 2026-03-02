<?php
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

$title='Cost of Goods Sold';

do_calander('#fdate');

do_calander('#tdate');

$fdate=$_REQUEST["fdate"];

$tdate=$_REQUEST['tdate'];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')

$report_detail.='<br>Reporting Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'].'';

?>





<style>

a:hover {

 

  color: #FF0000;

}
</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>



    <td><div class="left_report">



							<table width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>



								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">



									<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr>
    
    <td align="right" width="10%">From Date:</td>
    <td width="20%">
      <input name="fdate" type="text" id="fdate" maxlength="12" 
             value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off" style="width:120px;" required/>
    </td>

    
    <td align="right" width="10%">To Date:</td>
    <td width="20%">
      <input name="tdate" type="text" id="tdate" maxlength="12" 
             value="<?php echo $_REQUEST['tdate'];?>" autocomplete="off" style="width:120px;" required/>
    </td>

    
    <td align="right" width="10%">Company :</td>
    <td width="15%">
    <?php /*?> <? if($_POST['group_for']>0) { ?>
					<input type="hidden" name="group_for" id="group_for" value="<?=$_POST['group_for'];?>" readonly=""/>
	<input type="text" name="group_for_show" id="group_for_show" value="<?=find_a_field('user_group','group_name','id='.$_POST['group_for']);?>" readonly=""/>
							<? } else {?>
							<select  id="group_for" name="group_for" class="form-control" required>
										<? user_company_access($group_for); ?>
									</select>
									<? } ?><?php */?>
									
	<select  id="group_for" name="group_for" class="form-control" required>
	<option><?=find_a_field('user_group','group_name','id='.$_POST['group_for']);?></option>
										<? user_company_access($group_for); ?>
									</select>
    </td>
  </tr>

  
  <tr>
    <td colspan="6" align="center" style="padding-top:10px;">
      <input class="btn" name="show" type="submit" id="show" value="Show" style="padding:5px 15px;" />
    </td>
  </tr>
</table>




								    </form></div></td>



						      </tr>



								  <tr>



									<td align="right"><? include('PrintFormat.php');?></td>



								  </tr>



								  <tr>



									<td>



									<div id="reporting" style="overflow:hidden">

									
<?php
if(isset($_REQUEST['show']))
{
?>									<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>

										<tr>

											<th width="53%" bgcolor="#82D8CF">&nbsp; Particular</th>

											<th width="23%" bgcolor="#82D8CF">&nbsp; Amount</th>
										    <th width="24%" bgcolor="#82D8CF">Amount</th>
										</tr>
										</thead>

										

										
										
<?


$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as opening_rm 
from ledger_group l, accounts_ledger a, journal j 
where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.jv_date<'".$fdate."' and j.group_for='".$_POST['group_for']."' group by a.ledger_group_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$opening_rm[$data->ledger_group_id]=$data->opening_rm;
}


 $sql = "select a.ledger_group_id, sum(j.dr_amt) as dr_amt 
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.tr_from='Purchase' and j.group_for='".$_POST['group_for']."'
 and j.jv_date between '".$fdate."' and '".$tdate."' group by a.ledger_group_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$dr_amt[$data->ledger_group_id]=$data->dr_amt;
}


$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as closing_rm 
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and j.group_for='".$_POST['group_for']."'
 and  j.jv_date<='".$tdate."' group by a.ledger_group_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$closing_rm[$data->ledger_group_id]=$data->closing_rm;
}

 $sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as expense_amt
 from ledger_group l, accounts_ledger a, journal j 
 where l.group_id=a.ledger_group_id and a.ledger_id=j.ledger_id and a.ledger_id not in (140) and j.group_for='".$_POST['group_for']."'
 and j.jv_date between '".$fdate."' and '".$tdate."' group by a.ledger_group_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$expense_amt[$data->ledger_group_id]=$data->expense_amt;
}


	   
	   
	   ?>
									
	<tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>Add: Opening Inventory</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td bgcolor="#E0FFFF">&nbsp;</td>
	</tr>								  
									  

<?php


$sql="select l.group_id, l.group_name from cogs_configuration c, ledger_group l where c.group_id=l.group_id and c.type='RM' order by l.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>
								  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right">
<?=number_format($opening_rm[$data->group_id],2); $total_opening_rm+=$opening_rm[$data->group_id];?></td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	



		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Total </strong></td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_opening_rm,2); ?></strong></td>
				                      <td bgcolor="#E0FFFF" align="right">&nbsp;</td>
		</tr>		
				  
				  
				  
				  
				  <tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>Add: Purchase</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td bgcolor="#E0FFFF">&nbsp;</td>
				  </tr>								  
									  

<?php


 $sql="select l.group_id, l.group_name from cogs_configuration c, ledger_group l where c.group_id=l.group_id and c.type='RM' order by l.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right">
<?=number_format($dr_amt[$data->group_id],2); $total_purchase_rm+=$dr_amt[$data->group_id];?></td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	



		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Total </strong></td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_purchase_rm,2); ?></strong></td>
				                      <td bgcolor="#E0FFFF" align="right">&nbsp;</td>
		</tr>							
									  


 						
						
						 <tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>Less: Closing Inventory</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td bgcolor="#E0FFFF">&nbsp;</td>
				  </tr>								  
									  

<?php


 $sql="select l.group_id, l.group_name from cogs_configuration c, ledger_group l where c.group_id=l.group_id and c.type='RM' order by l.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right">
<?=number_format($closing_rm[$data->group_id],2); $total_closing_rm+=$closing_rm[$data->group_id];?></td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	



		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Total </strong></td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_closing_rm,2); ?></strong></td>
				                      <td bgcolor="#E0FFFF" align="right">&nbsp;</td>
		</tr>	
		
		
		
		
		<tr>
									  <td bgcolor="#E0FFFF" align="right"> <strong>Direct Material Cost  </strong></td>
									  <td bgcolor="#E0FFFF" align="right">&nbsp;</td>
				                      <td bgcolor="#E0FFFF" align="right"><strong><!--<a href="financial_transaction_group.php?show=show&fdate=<?=$fdate?>&tdate=<?=$tdate?>&acc_sub_sub_class=421">-->
				                        <?=number_format($material_cost=($total_opening_rm+$total_purchase_rm)-$total_closing_rm,2); ?>
				                     <!-- </a>--></strong></td>
		</tr>	
		
		
										  
									  

<?php


  $sql="select l.group_id, l.group_name 
  from ledger_group l
  where l.acc_sub_sub_class in (411,413,416) and l.group_id not in (411001) 
  order by l.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right">
<?=number_format($expense_amt[$data->group_id],2); $total_prime_cost+=$expense_amt[$data->group_id];?></td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	
		
		
		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Prime Cost</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td bgcolor="#E0FFFF" align="right"><strong>
				                        <?=number_format($material_cost_with_prime_cost=($total_prime_cost),2); ?>
				                      </strong></td>
				  </tr>
		
		
		
		<tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>Add: Factory Overhead</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td bgcolor="#E0FFFF">&nbsp;</td>
				  </tr>								  
									  

<?php


 $sql="select l.group_id, l.group_name from ledger_group l where l.acc_sub_sub_class=412 order by l.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right">
<?=number_format($expense_amt[$data->group_id],2); $total_factory_overhead+=$expense_amt[$data->group_id];?></td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	



		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Total </strong></td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_factory_overhead,2); ?></strong></td>
				                      <td bgcolor="#E0FFFF" align="right">&nbsp;</td>
		</tr>	
		
		
		<tr>
									  <td bgcolor="#fcf3cf" align="right">&nbsp;<strong>Cost of Production </strong></td>
									  <td bgcolor="#fcf3cf" align="right">&nbsp;</td>
				                      <td bgcolor="#fcf3cf" align="right"><strong>
				                        <?=number_format($total_cogm=($material_cost_with_prime_cost+$total_factory_overhead),2); ?>
				                      </strong></td>
		</tr>					
				
				
	<tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>Add: Opening Work In Process</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td bgcolor="#E0FFFF">&nbsp;</td>
	</tr>								  
									  

<?php


 $sql="select l.group_id, l.group_name from cogs_configuration c, ledger_group l where c.group_id=l.group_id and c.type='WIP' order by l.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right">
<?=number_format($opening_rm[$data->group_id],2); $total_wip_op+=$opening_rm[$data->group_id];?></td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	



		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Total </strong></td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_wip_op,2); ?></strong></td>
				                      <td bgcolor="#E0FFFF" align="right">&nbsp;</td>
		</tr>
		
		
		<tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>Less: Closing Work In Process</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td bgcolor="#E0FFFF">&nbsp;</td>
	</tr>								  
									  

<?php


 $sql="select l.group_id, l.group_name from cogs_configuration c, ledger_group l where c.group_id=l.group_id and c.type='WIP' order by l.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right">
<?=number_format($closing_rm[$data->group_id],2); $total_wip_cl+=$closing_rm[$data->group_id];?></td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	



		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Total </strong></td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_wip_cl,2); ?></strong></td>
				                      <td bgcolor="#E0FFFF" align="right">&nbsp;</td>
		</tr>
		
		
		<tr>
									  <td bgcolor="#fcf3cf" align="right">&nbsp;<strong>Cost of Goods Manufactured</strong></td>
									  <td bgcolor="#fcf3cf" align="right">&nbsp;</td>
				                      <td bgcolor="#fcf3cf" align="right"><strong>
				                        <?=number_format($total_cogm_manufactured=($total_cogm+$total_wip_op)-$total_wip_cl,2); ?>
				                      </strong></td>
		</tr>
		
		
		
		
		
		<tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>Add: Opening Finished Goods</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td bgcolor="#E0FFFF">&nbsp;</td>
	</tr>								  
									  

<?php


 $sql="select l.group_id, l.group_name from cogs_configuration c, ledger_group l where c.group_id=l.group_id and c.type='FG' order by l.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right">
<?=number_format($opening_rm[$data->group_id],2); $total_fg_op+=$opening_rm[$data->group_id];?></td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	



		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Total </strong></td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_fg_op,2); ?></strong></td>
				                      <td bgcolor="#E0FFFF" align="right">&nbsp;</td>
		</tr>
		
		
		<tr>
									  <td bgcolor="#fcf3cf" align="right">&nbsp;<strong>Cost of Goods Available for Sales </strong></td>
									  <td bgcolor="#fcf3cf" align="right">&nbsp;</td>
				                      <td bgcolor="#fcf3cf" align="right"><strong>
				                        <?=number_format($total_cogs_available_sales=($total_cogm_manufactured+$total_fg_op),2); ?>
				                      </strong></td>
		</tr>
		
		
		
		<tr>
									  <td bgcolor="#E0FFFF">&nbsp; <strong>Less: Closing Finished Goods</strong></td>
									  <td bgcolor="#E0FFFF">&nbsp;</td>
				                      <td bgcolor="#E0FFFF">&nbsp;</td>
	</tr>								  
									  

<?php


 $sql="select l.group_id, l.group_name from cogs_configuration c, ledger_group l where c.group_id=l.group_id and c.type='FG' order by l.group_id";

$query=db_query($sql);

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;
?>


									  
									  
									  <tr>

										  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->group_name;?></td>
<td align="right">
<?=number_format($closing_rm[$data->group_id],2); $total_fg_cl+=$closing_rm[$data->group_id];?></td>
									  <td align="right">&nbsp;</td>
									  </tr>
									  
									  
									  
<? }?>	



		<tr>
									  <td bgcolor="#E0FFFF" align="right">&nbsp; <strong>Total </strong></td>
									  <td bgcolor="#E0FFFF" align="right"><strong><?=number_format($total_fg_cl,2); ?></strong></td>
				                      <td bgcolor="#E0FFFF" align="right">&nbsp;</td>
		</tr>						

					
									
									
					
					
					
					<tr>
									  <td bgcolor="#fcf3cf" align="right">&nbsp;<strong>Cost of Goods Sold </strong></td>
									  <td bgcolor="#fcf3cf" align="right">&nbsp;</td>
				                      <td bgcolor="#fcf3cf" align="right"><strong>
				                        <?=number_format($total_cogs_amt=($total_cogs_available_sales-$total_fg_cl),2); ?>
				                      </strong></td>
		</tr>				
									
									</table>

									

									  
									  
									  



									</div>







									</td>



								</tr>



						</table>

<? }?>

		</div></td>    



  </tr>



</table>



<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>