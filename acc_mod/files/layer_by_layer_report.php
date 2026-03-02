<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Trial Balance Periodical(Detail)';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
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

$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);

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
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="1" cellpadding="0">
                                      
                                       <tr>
                                         <td width="22" colspan="2" align="right">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="40%"><div align="right">Period : </div></td>
							<td align="left">
								<input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" required="required" />
								---
								<input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"  required="required" />
							</td>
						</tr>
					</table>
										 </td>
                                       </tr>
                                       <tr>
                                         <td colspan="2" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                           <tr>
                                             <td width="40%"><div align="right">Ledger Group : </div></td>
                                             <td align="left">
	 <select name="group_id" id="group_id" required="required"  onchange="getData2('layer_ledger_id_ajax.php', 'ledger_id', this.value,  this.value)">
	   <? foreign_relation('ledger_group','group_id','group_name',$_REQUEST['group_id'],"group_for=".$_SESSION['user']['group']);?>
	 </select>
											 </td>
                                           </tr>
                                         </table></td>
                                       </tr>
                                       <tr>
                                         <td colspan="2" align="right"><div id="ledger_id">
										 <?
										 if($_REQUEST['ledger_id']>0){
										 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%"><div align="right">Ledger A/C Head : </div></td>
    <td align="left">
<select name="ledger_id" id="ledger_id"  onchange="getData2('layer_sub_ledger_id_ajax.php', 'sub_ledger_id', this.value,  this.value)">
<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_REQUEST['ledger_id'],"ledger_id like '%00000000' and ledger_group_id='".$_REQUEST['group_id']."' and group_for=".$_SESSION['user']['group']);?>
</select>
	</td>
  </tr>
</table>
										 <? }
										 ?>
										 </div></td>
                                       </tr>
                                       <tr>
                                         <td colspan="2" align="right"><div id="sub_ledger_id">
<?
if($_REQUEST['sub_ledger_id']>0){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%"><div align="right">Sub Ledger A/C Head : </div></td>
    <td align="left">
<select name="sub_ledger_id" id="sub_ledger_id"  onchange="getData2('layer_sub_ledger_id_ajax.php', 'sub_ledger_id', this.value,  this.value)">

<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_REQUEST['sub_ledger_id'],"ledger_id not like '%00000000' and ledger_id like '%0000' and ledger_group_id='".$_REQUEST['group_id']."' and group_for=".$_SESSION['user']['group']);?>
</select>
	</td>
  </tr>
</table>
										 <? } ?>
										 </div></td>
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
							    <th width="1%" rowspan="2" align="center">S/N</th>
    <th width="17%" height="20" rowspan="2" align="center">Ledger Id </th>
    <th width="45%" height="20" rowspan="2" align="center">Head Of Accounts </th>
    <th width="19%" colspan="2" align="center">Opening</th>
    <th colspan="2" align="center">Current</th>
    <th width="19%" height="10" colspan="2" align="center">Closing</th>
    </tr>
							  <tr>
							    <th align="center">Debit</th>
							    <th align="center">Credit</th>
							    <th width="19%" align="center">Debit</th>
							    <th width="19%" align="center">Credit</th>
							    <th height="10" align="center">Debit</th>
							    <th align="center">Credit</th>
							  </tr>
  <?php
if(isset($_REQUEST['show']))
{

$total_dr=0;
$total_cr=0;

if($_REQUEST['sub_ledger_id']>0) 
{
$cledger_id = substr($_REQUEST['sub_ledger_id'],0,12);
$con .= ' and a.ledger_id like "'.$cledger_id.'%" ';
}
elseif($_REQUEST['ledger_id']>0) 
{
$cledger_id = substr($_REQUEST['ledger_id'],0,8);
$con .= ' and a.ledger_id like "'.$cledger_id.'%" ';
}

$p="select DISTINCT a.ledger_name, 1, 1, a.ledger_id, c.group_id from accounts_ledger a, ledger_group c where a.ledger_group_id=c.group_id and a.ledger_group_id='".$_REQUEST['group_id']."' and parent=0 and a.group_for=".$_SESSION['user']['group'].$con." order by a.ledger_id";

$pi=0;
$sql=db_query($p);
while($p=mysqli_fetch_row($sql))
{
$amt = find_all_field_sql('select SUM(dr_amt) as dr_amt, SUM(cr_amt) as cr_amt from journal where jv_date between "$fdate" and "$tdate" and b.ledger_id = '.$p[3]);
$open = find_all_field_sql("select SUM(dr_amt - cr_amt) as open from journal where jv_date < '$fdate' and ledger_id='$p[3]'");

$dr=$amt->dr_amt; $cr=$amt->cr_amt;
$opening =$openning = $open->open;
$closing =$clossing = $openning + ($dr-$cr);       

if($opening==0&&(($dr-$cr)==0)){ $p;} else
{
$new_group_id = $p[4];
$new_ledger_id = substr($p[3],0,8).'00000000';
$new_sub_ledger_id = substr($p[3],0,12).'0000';
$new_ledger = $p[3];

$opening_cr = 0;
$opening_dr = 0;

$closing_dr = 0;
$closing_cr = 0;

if($opening>0)
{ $opening_dr = $opening;}
elseif($opening<0)
{ $opening_cr =($opening*(-1));}

         
if($closing>0)
{ $closing_dr=$closing;}
elseif($closing<0)
{ $closing_cr=$closing*(-1);}

if($old_ledger_id == $new_ledger_id||$old_ledger_id==0){

	$total_openning_ledger_dr = $total_openning_ledger_dr + $opening_dr;
	$total_openning_ledger_cr = $total_openning_ledger_cr + $opening_cr;
	$total_closing_ledger_dr = $total_closing_ledger_dr + $closing_dr;
	$total_closing_ledger_cr = $total_closing_ledger_cr + $closing_cr;
}

if($old_sub_ledger_id== $new_sub_ledger_id||$old_sub_ledger_id==0){
	$total_openning_sub_dr = $total_openning_sub_dr + $opening_dr;
	$total_closing_sub_dr = $total_closing_sub_dr + $closing_dr;
	$total_openning_sub_cr = $total_openning_sub_cr + $opening_cr;
	$total_closing_sub_cr = $total_closing_sub_cr + $closing_cr;
}
$total_opening_dr = $total_opening_dr + $opening_dr;
$total_closing_dr = $total_closing_dr + $closing_dr;

$total_opening_cr = $total_opening_cr + $opening_cr;
$total_closing_cr = $total_closing_cr + $closing_cr;



$pi++;





if($old_group_id != $new_group_id){
?>
<tr>
<td colspan="9" align="left" bgcolor="#003366"><span class="style3">Group Name : 
  <? echo $group_name = find_a_field('ledger_group','group_name','group_id='.$p[4]);?>
</span></td>
</tr>
<?
}
if($old_ledger_id != $new_ledger_id){

?>
<?
if($old_sub_ledger_id != $new_sub_ledger_id){


if($old_sub_ledger_id >0){

?>
<tr>
<td colspan="3" align="left" bgcolor="#999999"><span class="style3"><?=$sub_ledger?> (Sub Ledger) Total: </span></td>
<td align="right" bgcolor="#999999"><?=$total_openning_sub_dr;?></td>
<td align="right" bgcolor="#999999"><?=$total_openning_sub_cr;?></td>
<td align="left" bgcolor="#999999"><div align="right" class="style3"><?=number_format($sub_ledger_dr,2)?></div></td>
<td align="left" bgcolor="#999999"><div align="right"><span class="style3"><?=number_format($sub_ledger_cr,2)?></span></div></td>
<td align="left" bgcolor="#999999"><div align="right" class="style3"><?=$total_closing_sub;?></div></td>
<td align="left" bgcolor="#999999">&nbsp;</td>
</tr>
<tr>
<td colspan="9" align="left" bgcolor="#FFFFFF" height="1"></td>
</tr>
<? 
  if($old_sub_ledger_id != $new_sub_ledger_id&&$old_sub_ledger_id !=0){
  
	$total_openning_sub_dr = 0;
	$total_closing_sub_dr = 0;
	$total_openning_sub_cr = 0;
	$total_closing_sub_cr = 0;
	
	$total_openning_sub_dr = $total_openning_sub_dr + $opening_dr;
	$total_closing_sub_dr = $total_closing_sub_dr + $closing_dr;
	$total_openning_sub_cr = $total_openning_sub_cr + $opening_cr;
	$total_closing_sub_cr = $total_closing_sub_cr + $closing_cr;
	}
$old_sub_ledger_id=0;
$sub_ledger_cr = 0;
$sub_ledger_dr = 0; 

}?>
<?
if($old_ledger_id >0){ 
?>
<tr>
<td colspan="3" align="left" bgcolor="#333333"><span class="style3"><?=$ledger_name?> (Ledger) Total: </span></td>
<td align="right" bgcolor="#333333"><?=$total_openning_ledger_dr;?></td>
<td align="right" bgcolor="#333333"><?=$total_openning_ledger_cr;?></td>
<td align="left" bgcolor="#333333"><div align="right" class="style3">
  <?=number_format($ledger_dr,2)?>
</div></td>
<td align="left" bgcolor="#333333"><div align="right"><span class="style3">
  <?=number_format($ledger_cr,2)?>
</span></div></td>
<td align="left" bgcolor="#333333"><div align="right" class="style3"><?=$total_closing_ledger_dr;?></div></td>
<td align="left" bgcolor="#333333"><?=$total_closing_ledger_cr;?></td>
</tr>
<tr>
<td colspan="9" align="left" bgcolor="#FFFFFF" height="1"></td>
</tr>
<? 
if($old_ledger_id != $new_ledger_id&&$old_ledger_id !=0){
	$total_openning_ledger_dr = 0;
	$total_closing_ledger_dr = 0;
	$total_openning_ledger_cr = 0;
	$total_closing_ledger_cr = 0;
	
	$total_openning_ledger_dr = $total_openning_ledger_dr + $opening_dr;
	$total_closing_ledger_dr = $total_closing_ledger_dr + $closing_dr;
	$total_openning_ledger_cr = $total_openning_ledger_cr + $opening_cr;
	$total_closing_ledger_cr = $total_closing_ledger_cr + $closing_cr;
	
	$total_openning_sub_dr = $total_openning_sub_dr + $opening_dr;
	$total_closing_sub_dr = $total_closing_sub_dr + $closing_dr;
	$total_openning_sub_cr = $total_openning_sub_cr + $opening_cr;
	$total_closing_sub_cr = $total_closing_sub_cr + $closing_cr;
	}
$ledger_cr = 0;
$ledger_dr = 0;}}?>
<tr>
<td colspan="9" align="left" bgcolor="#333333"><span class="style3">A/C Ledger Name :
    <? echo $ledger_name = find_a_field('accounts_ledger','ledger_name','ledger_id='.$new_ledger_id);?>
</span></td>
</tr>
<?
}
?>

<?
if($old_sub_ledger_id != $new_sub_ledger_id){


if($old_sub_ledger_id >0){ ?>
<tr>
<td colspan="3" align="left" bgcolor="#999999"><span class="style3"><?=$sub_ledger?> (Sub Ledger) Total: </span></td>
<td align="right" bgcolor="#999999"><?=$total_openning_sub_dr;?></td>
<td align="right" bgcolor="#999999"><?=$total_openning_sub_cr;?></td>
<td align="left" bgcolor="#999999"><div align="right" class="style3"><?=number_format($sub_ledger_dr,2)?></div></td>
<td align="left" bgcolor="#999999"><div align="right"><span class="style3"><?=number_format($sub_ledger_cr,2)?></span></div></td>
<td align="right" bgcolor="#999999"><div align="right" class="style3"><?=$total_closing_sub;?></div></td>
<td align="right" bgcolor="#999999">&nbsp;</td>
</tr>
<tr>
<td colspan="9" align="left" bgcolor="#FFFFFF" height="1"></td>
</tr>
<? 

$sub_ledger_cr = 0;
$sub_ledger_dr = 0;}?>
<tr>
<td colspan="9" align="left" bgcolor="#999999"><span class="style3">Sub Ledger  Name :
    <? echo $sub_ledger = find_a_field('sub_ledger','sub_ledger','sub_ledger_id='.$new_sub_ledger_id);$pi=1;?>
</span></td>
</tr>
<?
}




?>
  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="center"><?php echo $pi;?></td>
    <td align="center"><?php echo $p[3];?></td>
    <td align="left"><?php echo $p[0];?></td>
    <td align="right"><?=$opening_dr;?></td>
    <td align="right"><?=$opening_cr;?></td>
    <td align="right"><?php echo number_format($dr,2);?></td>
    <td align="right"><?php echo number_format($cr,2);?></td>
    <td align="right"><?=$closing_dr;?></td>
    <td align="right"><?=$closing_cr;?></td>
  </tr>
  <?php
  

  if($old_sub_ledger_id != $new_sub_ledger_id&&$old_sub_ledger_id !=0){
	$total_openning_sub_dr = 0;
	$total_closing_sub_dr = 0;
	$total_openning_sub_cr = 0;
	$total_closing_sub_cr = 0;
	$total_openning_sub_dr = $total_openning_sub_dr + $opening_dr;
	$total_closing_sub_dr = $total_closing_sub_dr + $closing_dr;
	$total_openning_sub_cr = $total_openning_sub_cr + $opening_cr;
	$total_closing_sub_cr = $total_closing_sub_cr + $closing_cr;
	}
	
	$old_group_id = $new_group_id;
$old_ledger_id = $new_ledger_id;
$old_sub_ledger_id = $new_sub_ledger_id;
$group_cr = $group_cr + $cr;
$group_dr = $group_dr + $dr;

$ledger_cr = $ledger_cr + $cr;
$ledger_dr = $ledger_dr + $dr;

$sub_ledger_cr = $sub_ledger_cr + $cr;
$sub_ledger_dr = $sub_ledger_dr + $dr;
  $t_dr=$t_dr+$dr;
  $t_cr=$t_cr+$cr;


  }}?>
 
 <?
if($old_sub_ledger_id >0){

?>
<tr>
	<td colspan="3" align="left" bgcolor="#999999"><span class="style3"><?=$sub_ledger?> (Sub Ledger) Total: </span></td>
	<td align="right" bgcolor="#999999"><?=$total_openning_sub_dr;?></td>
	<td align="right" bgcolor="#999999"><?=$total_openning_sub_cr;?></td>
	<td align="left" bgcolor="#999999"><div align="right" class="style3"><?=number_format($sub_ledger_dr,2)?></div></td>
	<td align="left" bgcolor="#999999"><div align="right"><span class="style3"><?=number_format($sub_ledger_cr,2)?></span></div></td>
	<td align="left" bgcolor="#999999"><div align="right" class="style3"><?=$total_closing_sub;?></div></td>
    <td align="left" bgcolor="#999999">&nbsp;</td>
</tr>
<tr>
<td colspan="9" align="left" bgcolor="#FFFFFF" height="1"></td>
</tr>
<? 

$old_sub_ledger_id=0;
$sub_ledger_cr = 0;
$sub_ledger_dr = 0;
}?>
<?
if($old_ledger_id >0){ 
?>
<tr>
<td colspan="3" align="left" bgcolor="#333333"><span class="style3"><?=$ledger_name?> (Ledger) Total: </span></td>
<td align="right" bgcolor="#333333"><?=$total_openning_ledger_dr;?></td>
<td align="right" bgcolor="#333333"><?=$total_openning_ledger_cr;?></td>
<td align="left" bgcolor="#333333"><div align="right" class="style3">
  <?=number_format($ledger_dr,2)?>
</div></td>
<td align="left" bgcolor="#333333"><div align="right"><span class="style3">
  <?=number_format($ledger_cr,2)?>
</span></div></td>
<td align="right" bgcolor="#333333"><div align="right" class="style3">
  <?=$total_closing_ledger;?>
</div></td>
<td align="right" bgcolor="#333333">&nbsp;</td>
</tr>
<tr>
<td colspan="9" align="left" bgcolor="#FFFFFF" height="1"></td>
</tr>
<? 

if($old_ledger_id != $new_ledger_id&&$new_ledger_id !=0){
	$total_openning_ledger_dr = 0;
	$total_closing_ledger_dr = 0;
	$total_openning_ledger_cr = 0;
	$total_closing_ledger_cr = 0;
	
	$total_openning_ledger_dr = $total_openning_ledger_dr + $opening_dr;
	$total_closing_ledger_dr = $total_closing_ledger_dr + $closing_dr;
	$total_openning_ledger_cr = $total_openning_ledger_cr + $opening_cr;
	$total_closing_ledger_cr = $total_closing_ledger_cr + $closing_cr;
	}

$ledger_cr = 0;
$ledger_dr = 0;}
?>


<tr>
	<th colspan="3" align="right">Total Balance : </th>
	<th align="right"><?=$total_opening_dr;?></th>
	<th align="right"><?=$total_opening_cr;?></th>
	<th align="right"><strong><?php echo number_format($t_dr,2);?></strong></th>
	<th align="right"><strong><?php echo number_format($t_cr,2)?></strong></th>
	<th align="right"><?=$total_closing_dr;?></th>
    <th align="right"><?=$total_closing_cr;?></th>
</tr>

<?php }?>
</table> 
									</div>
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