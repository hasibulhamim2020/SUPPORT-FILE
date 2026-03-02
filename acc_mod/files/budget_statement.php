<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Financial Performance Report';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$fyear=$_REQUEST['fyear'];

$fdate=mktime(0,0,0,1,1,($fyear));
$tdate=mktime(0,0,-1,1,1,$fyear+1);
$fdatelast=mktime(0,0,0,1,1,($fyear-1));
$tdatelast=mktime(0,0,-1,1,1,($fyear));
//echo date("d-m-Y g:i:s A",$fdate);
//echo date("d-m-Y g:i:s A",$tdate);


}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="50%" align="right">
		    Fiscal Year:                                       </td>
                                        <td align="left">
										<select name="fyear">
										<? if(isset($_POST['fyear'])) echo '<option>'.$_POST['fyear'].'</option>';?>
										<option>2007</option>
										<option>2008</option>
										<option>2009</option>
										<option>2010</option>
										<option>2011</option>
										<option>2012</option>
										<option>2013</option>
										<option>2014</option>
										<option>2015</option>
										<option>2016</option>
										<option>2017</option>
										</select>
										</td>
                                      </tr>
                                      
                                      
                                      <tr>
                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show Report" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td><div id="reporting">
									<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							   <tr>
								<th width="20%" rowspan="2" align="center">Head of A/C </th>
								<th width="10%" rowspan="2" align="center">Yearly Budget </th>
							<!--    <th width="10%" rowspan="2" align="center">Budget of Period </th>-->
								<th width="10%" rowspan="2" align="center">Actual Amount </th>
								<th rowspan="2" align="center">% of Achievement </th>
								<th rowspan="2" align="center">Variance</th>
								<th rowspan="2" align="center"><p>Actual in (<?=($fyear-1)?>) </p>      </th>
								<th colspan="2" align="center">Growth</th>
								</tr>
							  <tr>
								<th align="center">Amount</th>
								<th align="center">%</th>
							  </tr>
  <?php
  if(isset($_REQUEST['show'])){
$p="select Distinct a.ledger_name,b.total_amt,(select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id=b.ledger_id and jv_date between '$fdate' and '$tdate'),(select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id=b.ledger_id and jv_date between '$fdatelast' and '$tdatelast') from accounts_ledger a,monthly_budget b where b.ledger_id=a.ledger_id and b.f_year='$fyear' and 1";
  //echo $p;

  $sql=db_query($p);
  while($data=mysqli_fetch_row($sql)){
  $y_budget=$data[1];
  $gor=0;
  $growth=0;
  $amt=0;
  $amtl=0;
  //$period_t=0;
  //$period_tk=0;
  //$period_t=$data[1]*$days/360;
  //$period_tk=number_format($period_t,2);
  if($data[2]<0) {$actual_amt= $data[2]*(-1); $actual_amt='('.$actual_amt.')';} else $actual_amt= $data[2];
  if($data[3]<0) {$amt1= $data[3]*(-1); $amt1='('.$amt1.')';} else $amtl= $data[3];
  $variance=($y_budget-$actual_amt); if($variance<0) {$variance= $variance*(-1); $variance='('.$variance.')';}
  $achievement=($data[2]*100)/$y_budget;
  $growth=$amt-$amtl; if($growth<0){$growth_amt= $growth*(-1); $growth_amt='('.$growth_amt.')';} else $growth_amt= $growth;
  if($amtl!=0)$gor=($growth*100)/$amtl;

  ?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="left"><?php echo $data[0];?></td>
    <td align="right"><?php echo $y_budget;?></td>
<!--    <td align="right"><?php echo $period_tk;?></td>-->
    <td align="right"><?php echo $actual_amt;?></td>
    <td width="11%" align="right"><?php echo number_format($ach,2)."%";?></td>
    <td width="11%" align="right"><?php echo $variance;?></td>
    <td width="11%" align="right"><?php echo $amtl;?></td>
    <td width="9%" align="right"><?php echo $growth_amt?></td>
    <td width="8%" align="right"><?php echo number_format($gor,2)."%";?></td>
  </tr>
    <?php }}?>
</table> </div>
																		</td>
								  </tr>
		</table>

							</div></td>
    
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>