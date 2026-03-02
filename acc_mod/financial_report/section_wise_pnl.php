<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Section Wise GP Report';


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



									<table width="100%" border="0" cellspacing="2" cellpadding="0">



                                      <tr>



                                        <td width="22%" align="right">



		    From Date :                                       </td>



                                        <td width="23%" align="left"> <div align="right">

                                          <input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off"/>

                                        </div></td>



                                        <td width="8%" align="left"> <div align="center">To Date: </div></td>

                                        <td width="50%" align="left"><input name="tdate" type="text" id="tdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['tdate'];?>" autocomplete="off"/></td>

                                      </tr>

									  

									  

									  

									  

									<tr>

										

                                        <td align="right"> </td>



                                        <td colspan="3" align="left">

											<br />										</td>

                                      </tr>

                                      



                                      

      <tr>



                                        

                                        <td align="center" colspan="3"><select name="section_id" id="section_id">
										<?php 
										if($_POST['section_id']>0){
										?>
										<option value="<?=$_POST['section_id']?>"><?=find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['section_id']);?></option>
										<?php } ?>
											<option value="">All</option>
											<?php $sql='select * from item_sub_group where group_id=1096000100000000';
											$query=db_query($sql);
											while($row=mysqli_fetch_object($query)){
											?>
											<option value="<?=$row->sub_group_id?>"><?=$row->sub_group_name?></option>
											<?php } ?>
										</select></td>

                                        <td align="center">&nbsp;</td>

                                      </tr>

                                      <tr>



                                        <td align="center">&nbsp;</td>

                                        <td align="center">&nbsp;</td>

                                        <td align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>

                                        <td align="center">&nbsp;</td>

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
//////////////////total sales amount/////////////
$sql = "select a.ledger_id, sum(j.cr_amt) as cr_amt 
 from accounts_ledger a, journal j 
 where j.ledger_id=a.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."' group by j.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$cr_amt[$data->ledger_id]=$data->cr_amt;
}

///////////////raw opening////////////////
  $sqlr = "select a.ledger_id, sum(j.dr_amt-j.cr_amt) as opening ,s.sales_section_id
 from accounts_ledger a, journal j,section_wise_pnl_config s,item_sub_group i
 where j.ledger_id=a.ledger_id and s.raw_section_id=i.sub_group_id and i.item_ledger=j.ledger_id and  j.jv_date < '".$fdate."'  group by s.sales_section_id";
$queryr = db_query($sqlr);
while($datar=mysqli_fetch_object($queryr)){
$opening[$datar->sales_section_id]=$datar->opening;
}


///////////////raw purhcase////////////////
  $sqlrp = "select a.ledger_id, sum(j.dr_amt) as purchase ,s.sales_section_id
 from accounts_ledger a, journal j,section_wise_pnl_config s,item_sub_group i
 where j.ledger_id=a.ledger_id and s.raw_section_id=i.sub_group_id and i.item_ledger=j.ledger_id and  j.jv_date between '".$fdate."' and '".$tdate."'  group by s.sales_section_id";
$queryrp = db_query($sqlrp);
while($datarp=mysqli_fetch_object($queryrp)){
$purchase[$datarp->sales_section_id]=$datarp->purchase;
}

///////////////raw closing////////////////
  $sqlrpc = "select a.ledger_id, sum(j.dr_amt-j.cr_amt) as closing ,s.sales_section_id
 from accounts_ledger a, journal j,section_wise_pnl_config s,item_sub_group i
 where j.ledger_id=a.ledger_id and s.raw_section_id=i.sub_group_id and i.item_ledger=j.ledger_id and  j.jv_date <= '".$tdate."'  group by s.sales_section_id";
$queryrpc = db_query($sqlrpc);
while($datarpc=mysqli_fetch_object($queryrpc)){
$closing[$datarpc->sales_section_id]=$datarpc->closing;
}

if($_POST['section_id']>0){
$section_con='and sub_group_id="'.$_POST['section_id'].'"';
}
?>									<table width="100%" id="grp" border="1" cellspacing="0" cellpadding="0">

										<thead>
											<?php $sql2='select * from item_sub_group where group_id=1096000100000000 '.$section_con.' ';
											$query2=db_query($sql2);
											while($row2=mysqli_fetch_object($query2)){
											?>
											 
			<tr>
			<td colspan="3">								
<h2 style="text-align:center;font-weight:bold;background-color:green;color:white;"><?=$row2->sub_group_name?></h2>
</td>
</tr>
										<tr>

											<th width="70%" bgcolor="#82D8CF" colspan="2">&nbsp; Particular</th>

											<th width="30%" bgcolor="#82D8CF">&nbsp; Amount</th>
										</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="2">Total   <?=$row2->sub_group_name?>(A)</td>
												 
												<td><?php echo $cr_amt[$row2->item_ledger];?> </td>
											</tr>
											<tr>
												<td>-Opening Raw  (B)</td>
												<td><?php echo $opening[$row2->sub_group_id];?>  </td>
												<td> </td>
											</tr>
											<tr>
												<td>-Add Purchase Raw  (C)</td>
												<td> <?php echo $purchase[$row2->sub_group_id];?>   </td>
												<td> </td>
											</tr>
											<tr>
												<td>-Closing Raw  (D)</td>
												<td> <?php echo $closing[$row2->sub_group_id];?>   </td>
												<td> </td>
											</tr>
											<tr>

											<th width="70%" bgcolor="#82D8CF" colspan="2">&nbsp; Total Material Cost Raw  (E=(B+C)-D)</th>

											<th width="30%" bgcolor="#82D8CF"><?php echo $tot_material_cost=(($opening[$row2->sub_group_id]+$purchase[$row2->sub_group_id])-$closing[$row2->sub_group_id]) ?> </th>
										</tr>
											<tr>

											<th width="70%" bgcolor="#82D8CF" colspan="2">&nbsp; Total Local Sales Raw  (F)</th>

											<th width="30%" bgcolor="#82D8CF"><?php echo $tot_local_sales=0;?> </th>
										</tr>
										
											<tr>

											<th width="70%" bgcolor="#82D8CF" colspan="2">&nbsp; Total COGS (G=(E-F) )</th>

											<th width="30%" bgcolor="#82D8CF"><?php echo $tot_cogs=$tot_material_cost-$tot_local_sales;?> </th>
										</tr>
										
											<tr>

											<th width="70%" bgcolor="#82D8CF" colspan="2">&nbsp; Total Gross Profit (A-G) </th>

											<th width="30%" bgcolor="#82D8CF"><?php echo $tot_gross_profit=$cr_amt[$row2->item_ledger]-$tot_cogs; ?> </th>
										</tr>
										<?php } ?>
										</tbody>

										

										
 

</table>



<?

}

require_once SERVER_CORE."routing/layout.bottom.php";



?>