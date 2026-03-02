<?php

/*session_start();
ob_start();
require "../support/inc.report.php";*/

session_start();
ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../common/class.numbertoword.php');


$title='Receipt And Payment Statement';

$proj_id=$_SESSION['proj_id'];



if($_SESSION['user']['group']>1)

  $cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1009' and group_for=".$_SESSION['user']['group']);

else

$cash_and_bank_balance=find_a_field('ledger_group','group_id','group_sub_class=1020');





if(isset($_REQUEST['show']))

{



$tdate=$_REQUEST['tdate'];

//fdate-------------------

$fdate=$_REQUEST["fdate"];

$ledger_id=$_REQUEST["ledger_id"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')

$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];

if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')

$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"].' and group_for='.$_SESSION['user']['group']);

if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')

$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);


//tdate-------------------



}

?>

<?php 



$led=db_query("select ledger_id,ledger_name from accounts_ledger where group_for=".$_SESSION['user']['group']." and ledger_group_id in (1002,1003,1004) order by ledger_name");

      $data = '[';

      $data .= '{ name: "All", id: "%" },';

	  while($ledg = mysqli_fetch_row($led)){

          $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';

	  }

      $data = substr($data, 0, -1);

      $data .= ']';

	//echo $data;



$led1=db_query("SELECT id, center_name FROM cost_center WHERE 1 ORDER BY center_name");

  if(mysqli_num_rows($led1) > 0)

  {	

	  $data1 = '[';

	  while($ledg1 = mysqli_fetch_row($led1)){

		  $data1 .= '{ name: "'.$ledg1[1].'", id: "'.$ledg1[0].'" },';

	  }

	  $data1 = substr($data1, 0, -1);

	  $data1 .= ']';

  }

  else

  {

	$data1 = '[{ name: "empty", id: "" }]';

  }



?>

<script type="text/javascript">



$(document).ready(function(){

		

    var data = <?php echo $data; ?>;

    $("#ledger_id").autocomplete(data, {

		matchContains: true,

		minChars: 0,

		scroll: true,

		scrollHeight: 300,

        formatItem: function(row, i, max, term) {

			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>ID: " + row.id + "</span>";

            return row.name + " [" + row.id + "]";

		},

		formatResult: function(row) {

			return row.id;

		}

	});

		

	var data = <?php echo $data1; ?>;

    $("#cc_code").autocomplete(data, {

		matchContains: true,

		minChars: 0,        

		scroll: true,

		scrollHeight: 300,

        formatItem: function(row, i, max, term) {

			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>ID: " + row.id + "</span>";

            return row.name + " : [" + row.id + "]";

		},

		formatResult: function(row) {            

			return row.id;

		}

	});	

	

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

function DoNav(a,b,c)



{



	document.location.href = 'transaction_list.php?fdate='+a+'&tdate='+b+'&ledger_id='+c+'&show=Show';



}

</script>





<?php



if($_REQUEST['ledger_id']>0)

{$ledger_con = 'b.ledger_id="'.$_REQUEST['ledger_id'].'"';

$ledger_conx = 'a.relavent_cash_head="'.$_REQUEST['ledger_id'].'"';

}

else

{
//$ledger_con = 'b.ledger_group_id="'.$cash_and_bank_balance.'"';
$gr_all=find_all_field('config_group_class','*','group_for='.$_SESSION['user']['group']);



$ledger_con = 'b.ledger_group_id in ('.$cash_ledg_group_id=$gr_all->cash_group.','.$bank_ledg_group_id=$gr_all->bank_group.')';
$ledger_conx = '1';

}

$cash=mysqli_fetch_row(db_query("select b.ledger_id from accounts_ledger b where ".$ledger_con." and b.group_for=".$_SESSION['user']['group']." and b.ledger_name like '%ash%'"));

  //echo $cash[0];

$op_c1="select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$cash[0]' and group_for=".$_SESSION['user']['group']." and jv_date<'$fdate' and 1";

//echo $op_c1;

  $op_c=mysqli_fetch_row(db_query($op_c1));

  $op_b1="select distinct(b.ledger_name), SUM(dr_amt)-SUM(cr_amt) from journal a, accounts_ledger b where ".$ledger_con." and a.ledger_id<>'$cash[0]' and a.ledger_id=b.ledger_id and jv_date < '$fdate' and b.group_for=".$_SESSION['user']['group']." GROUP  BY ledger_name";





  //echo $op_b1;

  $cl_c="select SUM(dr_amt)-SUM(cr_amt) from journal where group_for=".$_SESSION['user']['group']." and ledger_id ='$cash[0]' and jv_date<'$tdate'";

  $cl_c=mysqli_fetch_row(db_query($cl_c));

  $cl_b="select distinct(b.ledger_name), SUM(dr_amt)-SUM(cr_amt) from journal a, accounts_ledger b where b.group_for=".$_SESSION['user']['group']." and ".$ledger_con." and a.ledger_id<>'$cash[0]' and a.ledger_id=b.ledger_id and jv_date < '$tdate' and 1 GROUP  BY ledger_name";

   //echo $cl_b;

?>









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

                                        <td colspan="2" align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off" /> 

                                          ---  

                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>" autocomplete="off"/></td>

                                      </tr>

                                      <tr>

                                        <td align="right">Cash/Bank Head :</td>

                                        <td align="left"><input type="text" name="ledger_id" id="ledger_id" value="<?=($_REQUEST['ledger_id']>0)?$_REQUEST['ledger_id']:'%';?>" size="50" /></td>

                                        <td align="left"><? if($_REQUEST['ledger_id']>0) echo find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST['ledger_id']);?>

                                          &nbsp;</td>

                                      </tr>

                                      <tr>

                                        <td align="right">Cost Center : </td>

                                        <td colspan="2" align="left"><input type="text" name="cc_code" id="cc_code" value="<?php echo $_REQUEST['cc_code'];?>" size="50" /></td>

                                      </tr>

                                      

                                      <tr>

                                        <td colspan="3" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td>

									<? if(isset($_POST['show'])){?>

									<div id="reporting"><div id="grp">



<table width="100%" cellspacing="0" cellpadding="2" border="0" class="tabledesign">

<thead>

				 <tr>

					<th colspan="2"><span class="style1">Opening Cash &amp; Bank Balance </span></th>

					 </tr>

					 </thead>

				 <tr>

					<td width="70%">Cash Opening  : </td>

					<td width="30%" align="right"><?php if($op_c[0]==0) echo "0.00";

					else {if($op_c[0]<0) echo "(".number_format($op_c[0]*(-1),0,'.','').")"; else echo number_format($op_c[0],0,'.','');}?></td>

				  </tr>



 <?php

 $opb=db_query($op_b1);

 $op_to=$op_c[0];

 while($op_b=mysqli_fetch_row($opb)){

 $op_to=$op_to+$op_b[1];

 ?>

  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?> >

    <td><?php echo $op_b[0];?> </td>

    <td align="right"><?php if($op_b[1]==0) echo "0.00"; else

	{if($op_b[1]<0) echo "(".number_format($op_b[1]*(-1),0,'.','').")"; else echo number_format($op_b[1],0,'.','');}?></td>

  </tr>

  <?php }?>



  <tr>

    <th align="right"><strong>Total : </strong></th>

    <th align="right"><?php if($op_to==0) echo "0.00"; else

	{if($op_to<0) echo "(".number_format($op_to*(-1),0,'.','').")"; else echo number_format($op_to,0,'.','');}?></th>

  </tr>

</table><br /><br />

<table width="100%" cellspacing="0" cellpadding="2" border="0" class="tabledesign">

<thead>

  <tr>

    <th height="20" colspan="5" align="left">Receipt</th>

    </tr>

	</thead>

  <?php

	if(isset($_REQUEST['show']))

	{

		$cc_code = (int) $_REQUEST['cc_code'];

		if($cc_code > 0)

		{

			$p = "select DISTINCT(group_name),SUM(dr_amt),b.ledger_group_id from journal a,accounts_ledger b,ledger_group c where a.ledger_id = b.ledger_id and b.ledger_group_id=c.group_id and a.jv_date>='$fdate' and a.jv_date<='$tdate' and a.ledger_id!=a.relavent_cash_head and ".$ledger_conx." and a.tr_from in ('Receipt','Journal_info') and b.group_for=".$_SESSION['user']['group']." and a.dr_amt>0 AND a.cc_code=$cc_code GROUP BY group_name";

			

		}

		else

		{

	//	$p = "select DISTINCT(group_name),SUM(a.dr_amt),b.ledger_group_id from journal a,accounts_ledger b,ledger_group c where a.ledger_id = b.ledger_id and b.ledger_group_id=c.group_id and a.jv_date>='$fdate' and a.jv_date<='$tdate' and a.tr_from in ('Receipt','Journal_info') and a.ledger_id!=a.relavent_cash_head and ".$ledger_conx." and b.group_for=".$_SESSION['user']['group']." and a.dr_amt>0 GROUP BY group_name";

       $p = "select c.group_name,SUM(a.dr_amt),b.ledger_group_id from journal a,accounts_ledger b,ledger_group c where a.ledger_id = b.ledger_id and b.ledger_group_id=c.group_id and a.jv_date>='$fdate' and a.jv_date<='$tdate' and a.tr_from in ('Receipt','journal_info') and cr_amt>0 GROUP BY c.group_id";

		}



	$pi=0;

	$re_to=0;

	$sql=db_query($p);

	while($data=mysqli_fetch_row($sql))

	{

		$pi++;

		$re_to=$re_to+$data[1];

  ?>



  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>

    <td width="19%" align="center"><?php echo $pi;?></td>

    <td colspan="2" align="left"><?php echo $data[0];?></td>

    <td colspan="2" align="right"><?php echo $data[1];?></td>

    </tr>



  <?php

// Start new code

	$cc_code = (int) $_REQUEST['cc_code'];

	if($cc_code > 0)

	{

		$Lg="select DISTINCT(b.ledger_name),SUM(cr_amt),b.ledger_id from journal a,accounts_ledger b where a.ledger_id = b.ledger_id and a.jv_date>='$fdate' and a.jv_date<='$tdate' and b.ledger_group_id='$data[2]' and a.tr_from in ('Receipt','Journal_info') and b.group_for=".$_SESSION['user']['group']." and a.ledger_id!=a.relavent_cash_head and ".$ledger_conx." AND a.cc_code=$cc_code GROUP BY ledger_name";



	}

	else

	{

		$Lg="select DISTINCT(b.ledger_name),SUM(cr_amt),b.ledger_id from journal a,accounts_ledger b where a.ledger_id = b.ledger_id and a.jv_date>='$fdate' and a.jv_date<='$tdate' and b.ledger_group_id='$data[2]' and a.tr_from in ('Receipt','Journal_info') and b.group_for=".$_SESSION['user']['group']." and a.ledger_id!=a.relavent_cash_head and ".$ledger_conx." GROUP BY ledger_name";

		

	}

	

	$Li=0;

//$re_to=0;

  $Lsql=db_query($Lg);

  while($Ldata=mysqli_fetch_row($Lsql)){

  $Li++;

  //$re_to=$re_to+$data[1];

  ?>

  <tr onclick="DoNav('<?php echo $f_date;?>','<?php echo $t_date;?>','<?php echo $Ldata[2];?>');">

    <td width="19%" align="center">&nbsp;</td>

    <td width="14%" align="center"><?php echo $pi.'.'.$Li;?></td>

    <td align="left"><?php echo $Ldata[0];?></td>

    <td width="22%" align="right"><?php echo $Ldata[1];?></td>

    <td width="15%" align="right">&nbsp;</td>

  </tr>

<?php }?>



<?php }?>

    <tr>

    <th colspan="3" align="right"><strong>Total : </strong></th>

    <th colspan="2" align="right"><strong><?php if($re_to==0) echo "0.00"; else echo number_format($re_to,0,'.','');?></strong></th>

    </tr>

  <tr>

    <th colspan="3" align="right">Grand Total : </th>

    <th colspan="2" align="right"><strong>

      <?php if(($op_to+$re_to)==0) echo "0.00"; else

	{if(($op_to+$re_to)<0) echo "(".number_format(($op_to+$re_to)*(-1),0,'.','').")"; else echo number_format(($op_to+$re_to),0,'.','');}?>

    </strong></th>

  </tr>

  <?php }?>

</table><br /><br />

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="grp"  class="tabledesign">

<thead>

  <tr>

    <th height="20" colspan="5" align="left">Payment</th>

  </tr>

  </thead>

  <?php

	if(isset($_REQUEST['show']))

	{

		$cc_code = (int) $_REQUEST['cc_code'];

		if($cc_code > 0)

		{

		$p = "select DISTINCT(group_name),SUM(dr_amt), b.ledger_group_id from journal a,accounts_ledger b,ledger_group c where a.ledger_id = b.ledger_id and b.ledger_group_id=c.group_id and a.jv_date>='$fdate' and a.jv_date<='$tdate'  and a.ledger_id!=a.relavent_cash_head and ".$ledger_conx." and a.tr_from in ('Payment','Journal_info') and ".$ledger_conx." and b.group_for=".$_SESSION['user']['group']." AND a.cc_code=$cc_code GROUP BY group_name";

			

		}

		else

		{

			$p ="select DISTINCT(group_name),SUM(dr_amt), b.ledger_group_id from journal a,accounts_ledger b,ledger_group c where a.ledger_id = b.ledger_id and b.ledger_group_id=c.group_id and a.jv_date>='$fdate' and a.jv_date<='$tdate' and a.tr_from in ('Payment','Journal_info') and ".$ledger_conx." and b.group_for=".$_SESSION['user']['group']." GROUP BY group_name";

			

		}

  //echo $p;

	$pi=0;

	$re_to=0;

	$sql=db_query($p);

  while($data=mysqli_fetch_row($sql))

  {

	  $pi++;

	  $re_to=$re_to+$data[1];

  ?>

  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>

    <td align="center"><?php echo $pi;?></td>

    <td colspan="2" align="left"><?php echo $data[0];?></td>

    <td colspan="2" align="right"><?php echo $data[1];?></td>

  </tr>



  <?php

// Start new code

	$cc_code = (int) $_REQUEST['cc_code'];

			if($cc_code > 0)

			{

			$Lg="select DISTINCT(b.ledger_name),SUM(dr_amt),b.ledger_id from journal a,accounts_ledger b where a.ledger_id = b.ledger_id and a.jv_date>='$fdate' and a.jv_date<='$tdate' and b.ledger_group_id='$data[2]' and a.tr_from in ('Payment','Journal_info') and b.group_for=".$_SESSION['user']['group']." AND a.cc_code=$cc_code GROUP BY ledger_name";

			}

			else

			{

			 $Lg="select DISTINCT(b.ledger_name),SUM(dr_amt),b.ledger_id from journal a,accounts_ledger b where a.ledger_id = b.ledger_id and a.jv_date>='$fdate' and a.jv_date<='$tdate' and b.ledger_group_id='$data[2]' and a.tr_from in ('Payment','Journal_info') and b.group_for=".$_SESSION['user']['group']." GROUP BY ledger_name";

			

			}



$Li=0;

//$re_to=0;

  $Lsql=db_query($Lg);

  while($Ldata=mysqli_fetch_row($Lsql)){

  $Li++;

  //$re_to=$re_to+$data[1];

  ?>

  <tr onclick="DoNav('<?php echo $f_date;?>','<?php echo $t_date;?>','<?php echo $Ldata[2];?>');">

    <td width="19%" align="center">&nbsp;</td>

    <td width="14%" align="center"><?php echo $pi.'.'.$Li;?></td>

    <td align="left"><?php echo $Ldata[0];?></td>

    <td width="22%" align="right"><?php echo $Ldata[1];?></td>

    <td width="15%" align="right">&nbsp;</td>

  </tr><?php }?>



<?php }?>



  <tr>

    <th colspan="3" align="right"><strong>Total : </strong></th>

    <th colspan="2" align="right"><strong>

      <?php if($re_to==0) echo "0.00"; else echo number_format($re_to,0,'.','');?>

    </strong></th>

  </tr>

  <?php }?>

</table><br /><br />

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="grp"  class="">

<thead>

  <tr>

    <th colspan="2" align="left">Closing Cash &amp; Bank Balance </th>

  </tr>

  <thead>

  <tr>

    <td width="70%">Cash Closing  : </td>

    <td width="30%" align="right"><?php if($cl_c[0]==0) echo "0.00";

	else {if($cl_c[0]<0) echo "(".number_format($cl_c[0]*(-1),0,'.','').")"; else echo number_format($cl_c[0],0,'.','');}?></td>

  </tr>



   <?php

 $clb=db_query($cl_b);

 $cl_to=$cl_c[0];

 while($cl_b=mysqli_fetch_row($clb)){

 $cl_to=$cl_to+$cl_b[1];

 ?>

  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?> >

    <td><?php echo $cl_b[0];?> </td>

    <td align="right"><?php if($cl_b[1]==0) echo "0.00"; else

	{if($cl_b[1]<0) echo "(".number_format($cl_b[1]*(-1),0,'.','').")"; else echo number_format($cl_b[1],0,'.','');}?></td>

  </tr>

  <?php }?>







  <tr>



    <th align="right">Total :</th>

    <th align="right"><?php if($cl_to==0) echo "0.00"; else

	{if($cl_to<0) echo "(".number_format($cl_to*(-1)).")"; else echo number_format($cl_to,0,'.','');}?></th>

  </tr>

  <tr>

    <th align="right">Grand Total :</th>

    <th align="right"><strong>

      <?php if($cl_to==0) echo "0.00"; else

	{if($cl_to<0) echo "(".number_format($cl_to*(-1)+$re_to,0,'.','').")"; else echo number_format($cl_to+$re_to,0,'.','');}?>

    </strong></th>

  </tr>

</table><br /><br />



</div>

</div>

<? }?>

		</td>

		</tr>

		</table>

		</div></td>    

  </tr>

</table>

<?

/*$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";*/

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";

?>