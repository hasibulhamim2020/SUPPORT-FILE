<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Customer Statement';
$proj_id=$_SESSION['proj_id'];
$active='transdetrep';

do_calander('#fdate');
do_calander('#tdate');

create_combobox('group_id');

create_combobox('cc_code');

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

//$fdate=mktime(0,0,0,$time1[1],$time1[0],$time1[2]);

//tdate-------------------


$j=0;
for($i=0;$i<strlen($tdate);$i++)
{
if(is_numeric($tdate[$i]))
$time[$j]=$time[$j].$tdate[$i];
else $j++;
}
//$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);


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
<!--<script type="text/javascript">
$(document).ready(function(){
	
	$(function() {
		$("#fdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});
		$(function() {
		$("#tdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});

});
</script>-->
<style type="text/css">
.ui-datepicker{

width:18%;

}
/*body {*/
    /*font-size: 10px;*/
/*}*/
</style>







    <!--trial_balance_statment-->
    <div class="form-container_large">

        <form id="form1" name="form1" method="post" action="">

            <div class="container-fluid bg-form-titel">
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
                        <div class="form-group row m-0">
                            <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Period</label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                                <?php /*?> <input name="fdate" type="text" id="fdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['fdate'];?>" /><?php */?>
                                <input name="fdate" type="text" id="fdate" value="<?=$_REQUEST['fdate'];?>" />
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3  pt-1 pb-1">
                        <div class="form-group row m-0">
                            <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">-To-</label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                                <input name="tdate" type="text" id="tdate" size="12" value="<?php echo $_REQUEST['tdate'];?>"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                        <div class="form-group row m-0">
                            <label class="col-sm-3 col-md-3 col-lg-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Ledger Group</label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                                <select name="group_id" id="group_id" required>
                                    <option></option>
                                    <? foreign_relation('ledger_group','group_id','group_name',$_REQUEST['group_id'],"acc_sub_class=102");?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="n-form-btn-class">
                    <input class="btn1 btn1-bg-submit" name="show" type="submit" id="show" value="Show" />
                </div>
            </div>

        </form>



            <? include('PrintFormat.php');?>
            <div class="container-fluid pt-5 p-0 ">

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Code</th>
                        <th>Ledger Group</th>
                        <th>Side</th>

                        <th>Opening</th>
                        <th>Debit</th>
                        <th>Credit</th>

                        <th>Closing</th>
                        <th>Side</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">


                    <?php
                    if($_REQUEST['fdate']!='' )
                    {

                        if($_REQUEST['group_id']>0 )
                            $grp_con = " and  c.group_id='".$_REQUEST['group_id']."'";

                        if($_REQUEST['group_class']>0 )
                            $group_class_con = " and  c.group_class='".$_REQUEST['group_class']."'";



                        $total_dr=0;
                        $total_cr=0;
                        if($_REQUEST['cc_code']>0){
                            $cc_code = $_REQUEST['cc_code'];
                            $cc_con = " and b.cc_code = '".$cc_code."'";
                        }

                        $g="select a.ledger_id, c.group_id,c.group_name,a.ledger_name
  FROM accounts_ledger a, ledger_group c
  where a.ledger_group_id=c.group_id ".$grp_con.$group_class_con."  ";

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
  where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date < '$fdate' ".$grp_con.$cc_con.$group_class_con."   group by a.ledger_id ";

                        $gsql=db_query($g);
                        while($open=mysqli_fetch_object($gsql))
                        {
                            $cr_open[$open->ledger_id] = $open->cr_amt;
                            $dr_open[$open->ledger_id] = $open->dr_amt;
                        }

                        $g="select a.ledger_id,SUM(dr_amt) dr_amt,SUM(cr_amt) cr_amt,c.group_id
  FROM accounts_ledger a, journal b,ledger_group c
  where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date BETWEEN '$fdate' AND '$tdate' ".$grp_con.$cc_con.$group_class_con." group by ledger_id ";


                        $gsql=db_query($g);
                        while($info=mysqli_fetch_object($gsql))
                        {
                            $cr_amt[$info->ledger_id] = $info->cr_amt;
                            $dr_amt[$info->ledger_id] = $info->dr_amt;
                        }

                        $g="select c.group_name,c.group_id FROM ledger_group c where 1 ".$grp_con.$group_class_con."   group by  c.group_id";
                        $gsql=db_query($g);
                        while($g=mysqli_fetch_row($gsql))
                        {

                            ?>
                            <tr>
                                <th class="bg-table1" colspan="8"><?php echo $g[0];?></th>
                            </tr>

                            <?php
                            $cc_code = (int) $_REQUEST['cc_code'];

                            $p="select a.ledger_name,a.ledger_id from accounts_ledger a where a.parent=0 and a.ledger_group_id='$g[1]' order by a.ledger_id";

                            $pi=0;
                            $sql=db_query($p);
                            while($p=mysqli_fetch_row($sql))
                            {
                                $dr=$dr_amt[$p[1]];
                                $cr=$cr_amt[$p[1]];

                                $opening = $topening = $dr_open[$p[1]] - $cr_open[$p[1]];
                                $closing = $tclosing = $opening + $dr - $cr;

                                if($opening>0)
                                { $tag='(Dr)';}
                                elseif($opening<0)
                                { $tag='(Cr)'; $opening=$opening*(-1);}

                                if($closing>0)
                                { $tagc='(Dr)';}
                                elseif($closing<0)
                                { $tagc='(Cr)'; $closing=$closing*(-1);}

                                if($opening<>0 || $closing<>0  || $dr<>0 || $cr<>0){

                                    ?>
                                    <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                                        <td align="center"><?=$p[1]?></td>
                                        <td align="left"><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$p[1]?>" target="_blank"><?php echo $p[0];?> - [Code: <?=find_a_field('dealer_info','dealer_code',"account_code='".$p[1]."'");?>]</a></td>
                                        <td align="right"><div align="center">
                                                <? if ($opening>0) {?><?=$tag;?><? }?>
                                            </div></td>
                                        <td align="right"><?=number_format($opening,2);?></td>
                                        <td align="right"><?php echo number_format($dr_amt[$p[1]],2);?></td>
                                        <td align="right"><?php echo number_format($cr_amt[$p[1]],2);?></td>
                                        <td align="right"><?=number_format($closing,2);?></td>
                                        <td align="right"><div align="center">
                                                <? if ($closing>0) {?><?=$tagc;?><? }?>
                                            </div></td>
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
                            <tr>
                                <td class="bgc-light-green" colspan="2"><strong>Total</strong></td>
                                <td class="bgc-light-green">
                                        <? if ($topening_total>0) {?><?=$tag;?><? }?>
                                    </td>
                                <td class="bgc-light-green"><strong>
                                        <?=number_format($topening_total,2);?>
                                    </strong></td>
                                <td class="bgc-light-green"><strong>
                                        <?=number_format($t_dr,2);?>
                                    </strong></td>
                                <td class="bgc-light-green"><strong>
                                        <?=number_format($t_cr,2);?>
                                    </strong></td>
                                <td class="bgc-light-green">
                                    <strong>
                                        <?=number_format($tclosing_total,2);?>
                                    </strong>
                                </td>
                                <td class="bgc-light-green"><strong>
                                            <? if ($tclosing_total>0) {?> <?=$tagc;?> <? }?>
                                        </strong>
                                </td>
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
                        <tr class="bg-table1">
                            <th colspan="2" align="right">Total Balance : <?php echo number_format(($t_dr-$t_cr),2);?></th>
                            <th align="right"><div align="center">
                                    <? if ($totalopening_total>0) {?> <?=$tag;?> <? }?>
                                </div></th>
                            <th><?=number_format($totalopening_total,2);?></th>
                            <th><strong><?php echo number_format($total_dr,2);?></strong></th>
                            <th><strong><?php echo number_format($total_cr,2)?></strong></th>
                            <th><?=number_format($totalclosing_total,2);?></th>
                            <th>
                                    <? if ($totalclosing_total>0) {?><?=$tagc;?><? }?>

                            </th>
                        </tr>

                    <?php }?>



                    </tbody>
                </table>

            </div>

    </div>



















<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report">
                                            <form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>

                                        <td width="14%" align="right">

		    Period :                                       </td>

                                        <td width="26%" align="left">
                                      <!--    <input name="fdate" type="text" id="fdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['fdate'];?>" />-->
									  
                                            <input style="width:250px;"  name="fdate" type="text" id="fdate" value="<?=$_REQUEST['fdate'];?>" />
                                        </td>
									    <td width="13%" align="left"><div align="center">-----</div></td>
									    <td width="47%" align="left">

                                            
                                              <input name="tdate" type="text" id="tdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['tdate'];?>"/>                                       </td>
                                      </tr>
									  
									  
									   
									  
<!--									  <tr>
                                         <td height="35" align="right">Accounts Class  : </td>
                                         <td colspan="2" align="left">
                                           <select name="group_class" id="group_class">
										   <option></option>
                                             <? foreign_relation('ledger_group_class','group_class','ledger_group_class',$_REQUEST['group_class'],"1");?>
                                           </select>                                         </td>
                                         <td align="left">&nbsp;</td>
                                       </tr>-->
									  
									  <tr>
                                         <td align="right">&nbsp;</td>
                                         <td align="left">&nbsp;</td>
                                         <td align="left">&nbsp;</td>
                                         <td align="left">&nbsp;</td>
                                       </tr>
									  
                                       <tr>
                                         <td height="35" align="right">Ledger Group : </td>
                                         <td colspan="2" align="left">
                                           <select name="group_id" id="group_id" required>
										   <option></option>
                                             <? foreign_relation('ledger_group','group_id','group_name',$_REQUEST['group_id'],"acc_sub_class=102");?>
                                           </select>
                                         </td>
                                         <td align="left">&nbsp;</td>
                                       </tr>
                                       <tr>
                                         <td align="right">&nbsp;</td>
                                         <td align="left">&nbsp;</td>
                                         <td align="left">&nbsp;</td>
                                         <td align="left">&nbsp;</td>
                                       </tr>
									   
                                       <!--<tr>
                                        <td align="right">Cost Center : </td>
                                        <td colspan="2" align="left">
										
										<select name="cc_code" id="cc_code" class="form-control" style="float:left"  >

											<option value="0"></option>
											
											<?
											
											foreign_relation('cost_center','id','center_name',$_REQUEST['cc_code'],"1  order by id");
											
											?>
										</select>										</td>
                                        <td align="left">&nbsp;</td>
                                      </tr>-->
									  
									  <tr>
                                         <td align="right">&nbsp;</td>
                                         <td align="left">&nbsp;</td>
                                         <td align="left">&nbsp;</td>
                                         <td align="left">&nbsp;</td>
                                       </tr>
                                      
                                      <tr>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">
                                            <input class="btn1 btn1-bg-submit" name="show" type="submit" id="show" value="Show" />
                                        </td>
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
    <th width="3%" align="center">Code</th>
    <th width="35%" height="20" align="center">Ledger Group </th>
    <th width="8%" align="center">Side</th>
    <th width="12%" align="center">Opening</th>
    <th width="11%" align="center">Debit </th>
    <th width="11%" align="center">Credit </th>
    <th width="11%" height="20" align="center">Closing</th>
    <th width="6%" align="center">Side</th>
							  </tr>
  <?php
if($_REQUEST['fdate']!='' )
{

if($_REQUEST['group_id']>0 )
$grp_con = " and  c.group_id='".$_REQUEST['group_id']."'";

if($_REQUEST['group_class']>0 )
$group_class_con = " and  c.group_class='".$_REQUEST['group_class']."'";



	$total_dr=0;
	$total_cr=0;
	if($_REQUEST['cc_code']>0){
	$cc_code = $_REQUEST['cc_code'];
	$cc_con = " and b.cc_code = '".$cc_code."'";
	}
	
   $g="select a.ledger_id, c.group_id,c.group_name,a.ledger_name 
  FROM accounts_ledger a, ledger_group c 
  where a.ledger_group_id=c.group_id ".$grp_con.$group_class_con."  ";

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
  where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date < '$fdate' ".$grp_con.$cc_con.$group_class_con."   group by a.ledger_id ";

  $gsql=db_query($g);
  while($open=mysqli_fetch_object($gsql))
  {
  	$cr_open[$open->ledger_id] = $open->cr_amt;
  	$dr_open[$open->ledger_id] = $open->dr_amt;
  }
	
   $g="select a.ledger_id,SUM(dr_amt) dr_amt,SUM(cr_amt) cr_amt,c.group_id 
  FROM accounts_ledger a, journal b,ledger_group c 
  where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date BETWEEN '$fdate' AND '$tdate' ".$grp_con.$cc_con.$group_class_con." group by ledger_id ";


  $gsql=db_query($g);
  while($info=mysqli_fetch_object($gsql))
  {
  	$cr_amt[$info->ledger_id] = $info->cr_amt;
  	$dr_amt[$info->ledger_id] = $info->dr_amt;
  }
  
  $g="select c.group_name,c.group_id FROM ledger_group c where 1 ".$grp_con.$group_class_con."   group by  c.group_id";
  $gsql=db_query($g);
  while($g=mysqli_fetch_row($gsql))
  {

  ?>
  <tr>
    <th colspan="8" align="left"><?php echo $g[0];?></th>
    </tr>

<?php
	$cc_code = (int) $_REQUEST['cc_code'];

		$p="select a.ledger_name,a.ledger_id from accounts_ledger a where a.parent=0 and a.ledger_group_id='$g[1]' order by a.ledger_id";

$pi=0;
  $sql=db_query($p);
  while($p=mysqli_fetch_row($sql))
  {
$dr=$dr_amt[$p[1]];
$cr=$cr_amt[$p[1]];

$opening = $topening = $dr_open[$p[1]] - $cr_open[$p[1]];
$closing = $tclosing = $opening + $dr - $cr;

if($opening>0)
{ $tag='(Dr)';}
elseif($opening<0)
{ $tag='(Cr)'; $opening=$opening*(-1);}

if($closing>0)
{ $tagc='(Dr)';}
elseif($closing<0)
{ $tagc='(Cr)'; $closing=$closing*(-1);}

if($opening<>0 || $closing<>0  || $dr<>0 || $cr<>0){

  ?>
<tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
    <td align="center"><?=$p[1]?></td>
    <td align="left"><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$p[1]?>" target="_blank"><?php echo $p[0];?> - [Code: <?=find_a_field('dealer_info','dealer_code',"account_code='".$p[1]."'");?>]</a></td>
    <td align="right"><div align="center">
      <? if ($opening>0) {?><?=$tag;?><? }?>
    </div></td>
    <td align="right"><?=number_format($opening,2);?></td>
    <td align="right"><?php echo number_format($dr_amt[$p[1]],2);?></td>
    <td align="right"><?php echo number_format($cr_amt[$p[1]],2);?></td>
    <td align="right"><?=number_format($closing,2);?></td>
    <td align="right"><div align="center">
      <? if ($closing>0) {?><?=$tagc;?><? }?>
    </div></td>
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
    <td colspan="2" align="center" bgcolor="#82D8CF"><strong>Total</strong></td>
    <td align="right" bgcolor="#82D8CF"><div align="center">
      <? if ($topening_total>0) {?><?=$tag;?><? }?>
    </div></td>
    <td align="right" bgcolor="#82D8CF"><strong>
      <?=number_format($topening_total,2);?>
    </strong></td>
    <td align="right" bgcolor="#82D8CF"><strong>
      <?=number_format($t_dr,2);?>
    </strong></td>
    <td align="right" bgcolor="#82D8CF"><strong>
      <?=number_format($t_cr,2);?>
    </strong></td>
    <td align="right" bgcolor="#82D8CF"><strong>
      <?=number_format($tclosing_total,2);?>
    </strong></td>
    <td align="right" bgcolor="#82D8CF"><div align="center"><strong>
     <? if ($tclosing_total>0) {?> <?=$tagc;?> <? }?>
    </strong></div></td>
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
    <th colspan="2" align="right">Total Balance : <?php echo number_format(($t_dr-$t_cr),2);?></th>
    <th align="right"><div align="center">
     <? if ($totalopening_total>0) {?> <?=$tag;?> <? }?>
    </div></th>
    <th align="right"><?=number_format($totalopening_total,2);?></th>
    <th align="right"><strong><?php echo number_format($total_dr,2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total_cr,2)?></strong></th>
    <th align="right"><?=number_format($totalclosing_total,2);?></th>
    <th align="right"><div align="center">
      <? if ($totalclosing_total>0) {?><?=$tagc;?><? }?>
    </div></th>
</tr>

<?php }?>

</table> 
									</div>
																		</td>
								  </tr>
		</table>

							</div></td>
    
  </tr>
</table><?php */?>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>