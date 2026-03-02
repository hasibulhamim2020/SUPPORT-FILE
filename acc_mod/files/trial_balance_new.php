<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Trial Balance Periodical(Detail)';
$proj_id=$_SESSION['proj_id'];

if($_REQUEST['tdate']!='' )
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST["fdate"].' to '.$_REQUEST['tdate'];
if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
$report_detail.='<br>CC Code : '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);

$j=0;
for($i=0;$i<strlen($fdate);$i++)
{
if(is_numeric($fdate[$i]))
$time1[$j]=$time1[$j].$fdate[$i];

else $j++;
}

echo $fdate=mktime(0,0,0,$time1[1],$time1[0],$time1[2]);

//tdate-------------------


$j=0;
for($i=0;$i<strlen($tdate);$i++)
{
if(is_numeric($tdate[$i]))
$time[$j]=$time[$j].$tdate[$i];
else $j++;
}
$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);


}
?>

<script type="text/javascript">

$(document).ready(function(){

    function formatItem(row) {
		//return row[0] + " " + row[1] + " ";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	
  });
</script>
<script type="text/javascript">
$(document).ready(function(){
	
	$(function() {
		$("#fdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-y'
		});
	});
		$(function() {
		$("#tdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-y'
		});
	});

});
</script>
<style type="text/css">
body {
    font-size: 10px;
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
		    Period :                                       </td>
                                        <td align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
									  
                                       <tr>
                                         <td align="right">Ledger Group : </td>
                                         <td align="left"><select name="group_id" id="group_id">
                                             <? foreign_relation('ledger_group','group_id','group_name',$_REQUEST['group_id'],"group_for=".$_SESSION['user']['group']);?>
                                           </select>
                                         </td>
                                       </tr>
                                       <tr>
                                         <td align="right">Cost Center :</td>
                                         <td align="left"><span style="text-align:left">
                                           <select name="cc_code" id="cc_code"  style="width:250px; text-align:left; float:left">
                                             <option></option>
                                             <?  

 $sqled1 = "select cc.id, cc.center_name FROM cost_center cc, cost_category c WHERE cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY center_name ASC";
$ccd=db_query($sqled1);
if(mysqli_num_rows($ccd)>0){
while($cc=mysqli_fetch_object($ccd))
{?>
<option  value="<?=$cc->id?>" <?=($cc->id==$_POST['cc_code'])? 'selected':'' ?>><?=$cc->id.' - '.$cc->center_name?></option>';
<? }}
		  ?>
                                           </select>
                                         </span></td>
                                       </tr>
									   
									   <tr>

                                        <!--<td align="right">Depot : </td>

                                        <td align="left">
											<select name="dealer_depot" id="dealer_depot" style="width:250px; text-align:left; float:left">
                           
												<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['dealer_depot'],'use_type!="PL"');?>
                            
                          					</select>
										</td>-->

                                      </tr>
                                      
                                      <tr>
                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td> <div id="reporting">
									<table id="grp"  class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
    <th width="4%" height="20" align="center">S/N</th>
    <th width="41%" height="20" align="center">Ledger Group </th>
    <th width="12%" align="center">Debit </th>
    <th width="12%" align="center">Credit </th>
    </tr>
  <?php
if($_REQUEST['fdate']!='' )
{

if($_REQUEST['group_id']>0 ){
$grp_con = " and  c.group_id='".$_REQUEST['group_id']."'";
}




	$total_dr=0;
	$total_cr=0;
	if($_REQUEST['cc_code']>0){
	$cc_code = $_REQUEST['cc_code'];
	$cc_con = " and b.cc_code = '".$cc_code."'";
	}
	
  $g="select a.ledger_id, c.group_id,c.group_name,a.ledger_name 
  FROM accounts_ledger a, ledger_group c 
  where a.ledger_group_id=c.group_id ".$grp_con.$depot_con." and c.group_for='".$_SESSION['user']['group']."' ";

  $gsql=db_query($g);
  while($ledger=mysqli_fetch_row($gsql))
  {
  	$data[$ledger->ledger_id]['ledger_id'] = $ledger->ledger_id;
	$data[$ledger->ledger_id]['ledger_name'] = $ledger->ledger_name;
	$group[$ledger->ledger_id]['group_id'] = $ledger->group_id;
  	$group[$ledger->ledger_id]['group_name'] =  $ledger->group_name;
  }
  
  	
	
$g="select a.ledger_id,c.group_id,SUM(dr_amt) dr_amt,SUM(cr_amt) cr_amt
  FROM accounts_ledger a, journal b,ledger_group c 
  where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date < '$fdate' ".$grp_con.$cc_con.$depot_con." and c.group_for='".$_SESSION['user']['group']."'  group by a.ledger_id order by c.u_id";

  $gsql=db_query($g);
  while($open=mysqli_fetch_object($gsql))
  {
  	$cr_open[$open->ledger_id] = $open->cr_amt;
  	$dr_open[$open->ledger_id] = $open->dr_amt;
  }
	

	
  echo $g="select a.ledger_id,SUM(dr_amt) dr_amt,SUM(cr_amt) cr_amt,c.group_id 
  FROM accounts_ledger a, journal b,ledger_group c 
  where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date BETWEEN '$fdate' AND '$tdate' ".$grp_con.$cc_con.$depot_con." and c.group_for='".$_SESSION['user']['group']."' group by ledger_id  order by c.u_id";


  $gsql=db_query($g);
  while($info=mysqli_fetch_object($gsql))
  {
  	$cr_amt[$info->ledger_id] = $info->cr_amt;
  	$dr_amt[$info->ledger_id] = $info->dr_amt;
  }
  
   //$g="select c.group_name,c.group_id FROM ledger_group c where 1 ".$grp_con." and  c.group_id not like '4%' and c.group_for=".$_SESSION['user']['group']."  group by  c.group_id"; (1090,2064,3001,3024,4014,4029,4064,4065,4066)
  
  
  $g="select c.group_name,c.group_id FROM ledger_group c where 1 ".$grp_con." and  c.group_id in (1016,1024,1032,1051,1070,1086,1088,2032,2050,2062,2062,2063,2065,2066,2067) and c.group_for=".$_SESSION['user']['group']."  group by  c.group_id";
  $gsql=db_query($g);
  while($g=mysqli_fetch_row($gsql))
  {

  ?>
  <tr>
    <th colspan="4" align="left"><?php echo $g[0];?></th>
    </tr>

<?php
	$cc_code = (int) $_REQUEST['cc_code'];

$p="select distinct j.ledger_id, a.ledger_name,a.ledger_id from accounts_ledger a, journal j where  a.parent=0 and a.ledger_id=j.ledger_id and a.ledger_group_id='$g[1]' ".$depot_con." order by a.ledger_id";

$pi=0;
  $sql=db_query($p);
  while($p=mysqli_fetch_row($sql))
  {
$dr=$dr_amt[$p[2]];
$cr=$cr_amt[$p[2]];

$opening = $topening = $dr_open[$p[2]] - $cr_open[$p[2]];
$closing = $tclosing = $opening + $dr - $cr;

if($opening>0)
{ $tag='(Dr)';}
elseif($opening<0)
{ $tag='(Cr)'; $opening=$opening*(-1);}

if($closing>0)
{ $tagc='(Dr)';}
elseif($closing<0)
{ $tagc='(Cr)'; $closing=$closing*(-1);}

if($dr>0 || $cr>0){
  ?>
<tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="center"><?=++$pi;?></td>
    <td align="left"><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$p[2]?>" target="_blank"><?php echo $p[1];?></a></td>
    <td align="right"><?php if($tagc=='(Dr)') echo number_format($closing,2);?></td>
    <td align="right"><?php if($tagc=='(Cr)') echo number_format($closing,2);?></td>
    </tr>
  <?php
  if($tagc=='(Dr)') $total_dr=$total_dr+$closing; 
  if($tagc=='(Cr)') $total_cr=$total_cr+$closing;
  if($tagc=='(Dr)') $t_dr=$t_dr+$closing; 
  if($tagc=='(Cr)') $t_cr=$t_cr+$closing;
  }
  }
  
  
  if($topening_total>0)
{ $tag='(Dr)';}
  elseif($topening_total<0)
{ $tag='(Cr)'; $topening_total=$topening_total*(-1);}

  if($tclosing_total>0)
{ $tagc='(Dr)';}
  elseif($tclosing_total<0)
{ $tagc='(Cr)'; $tclosing_total=$tclosing_total*(-1);}



  ?>
  <tr bgcolor="#99CCFF">
    <td colspan="2" align="center"><strong>Total</strong></td>
    <td align="right"><?=number_format($t_dr,2);?></td>
    <td align="right"><?=number_format($t_cr,2);?></td>
    </tr>
  <?php 
  $t_dr=0;
  $t_cr=0;
  $topening_total = 0;
  $tclosing_total = 0;
  }
  
   //$g="select c.group_name,c.group_id FROM ledger_group c where 1 ".$grp_con." and  c.group_id like '4%' and c.group_for=".$_SESSION['user']['group']."  group by  c.group_id";
  
  
  
   $g="select c.group_name,c.group_id FROM ledger_group c where 1 ".$grp_con." and  c.group_id in (1090,1078,2064,3001,3024,4014,4029,4064,4065,4066,1061) and c.group_for=".$_SESSION['user']['group']."  group by  c.group_id";
  $gsql=db_query($g);
  while($g=mysqli_fetch_row($gsql))
  {

  ?>
  <tr>
    <th colspan="4" align="left"><?php echo $g[0];?></th>
    </tr>

<?php
	$cc_code = (int) $_REQUEST['cc_code'];

$p="select distinct j.ledger_id, a.ledger_name,a.ledger_id from accounts_ledger a, journal j where  a.parent=0 and a.ledger_id=j.ledger_id and a.ledger_group_id='$g[1]' ".$depot_con." order by a.ledger_id";

$pi=0;
  $sql=db_query($p);
  while($p=mysqli_fetch_row($sql))
  {
$dr=$dr_amt[$p[2]];
$cr=$cr_amt[$p[2]];

$opening = $topening = $dr_open[$p[2]] - $cr_open[$p[2]];
$closing = $tclosing = $opening + $dr - $cr;

if($opening>0)
{ $tag='(Dr)';}
elseif($opening<0)
{ $tag='(Cr)'; $opening=$opening*(-1);}

if($closing>0)
{ $tagc='(Dr)';}
elseif($closing<0)
{ $tagc='(Cr)'; $closing=$closing*(-1);}

if($dr>0 || $cr>0){
  ?>
<tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="center"><?=++$pi;?></td>
    <td align="left"><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$p[2]?>" target="_blank"><?php echo $p[1];?></a></td>
    <td align="right"><?php echo number_format($dr_amt[$p[2]],2);?></td>
    <td align="right"><?php echo number_format($cr_amt[$p[2]],2);?></td>
    </tr>
  <?php
  $total_dr=$total_dr+$dr;
  $total_cr=$total_cr+$cr;
  $t_dr=$t_dr+$dr;
  $t_cr=$t_cr+$cr;
 // $t_cr=$t_cr+$cr;
  
  $topening_total=$topening_total+$topening;
  $totalopening_total=$totalopening_total+$topening;
  
  $tclosing_total=$tclosing_total+$tclosing;
  $totalclosing_total=$totalclosing_total+$tclosing;
  }
  }
  
  
  if($topening_total>0)
{ $tag='(Dr)';}
  elseif($topening_total<0)
{ $tag='(Cr)'; $topening_total=$topening_total*(-1);}

  if($tclosing_total>0)
{ $tagc='(Dr)';}
  elseif($tclosing_total<0)
{ $tagc='(Cr)'; $tclosing_total=$tclosing_total*(-1);}



  ?>
  <tr bgcolor="#99CCFF">
    <td colspan="2" align="center"><strong>Total</strong></td>
    <td align="right"><?=number_format($t_dr,2);?></td>
    <td align="right"><?=number_format($t_cr,2);?></td>
    </tr>
  <?php 
  $t_dr=0;
  $t_cr=0;
  $topening_total = 0;
  $tclosing_total = 0;
  }
  
  
    if($totalopening_total>0)
{ $tag='(Dr)';}
  elseif($totalopening_total<0)
{ $tag='(Cr)'; $totalopening_total=$totalopening_total*(-1);}

  if($totalclosing_total>0)
{ $tagc='(Dr)';}
  elseif($totalclosing_total<0)
{ $tagc='(Cr)'; $totalclosing_total=$totalclosing_total*(-1);}



  ?>

  
  
   
  <tr>
    <th colspan="2" align="right">Total Balance : <?php /*?><?php echo number_format(($total_cr-$total_dr),2);?><?php */?></th>
    <th align="right"><strong><?php echo number_format($total_dr,2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total_cr,2)?></strong></th>
    </tr>

<?php }?>
</table> 
									</div>
																		</td>
								  </tr>
								  
								  
								  
								  
								  
								  <!--Sales Accounts-->
								  
								 
								  <!--#/Sales Accounts-->
		</table>

							</div></td>
    
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>