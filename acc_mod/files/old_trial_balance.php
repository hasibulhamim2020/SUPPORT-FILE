<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Trial Balance';

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

<?php 

	

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



    function formatItem(row) {

		//return row[0] + " " + row[1] + " ";

	}

	function formatResult(row) {

		return row[0].replace(/(<.+?>)/gi, '');

	}



    

	

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

</script>

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

                                        <td align="right">Cost Center : </td>

                                        <td align="left"><input type="text" name="cc_code" id="cc_code" value="<?php echo $_REQUEST['cc_code'];?>" size="50" /></td>

                                      </tr>
									  
									  <tr>

                                        <td align="right">Depot : </td>

                                        <td align="left">
											<select name="dealer_depot" id="dealer_depot" >
                           
												<? foreign_relation('warehouse','warehouse_id','warehouse_name',$dealer_depot,'use_type!="PL"');?>
                            
                          					</select>
										</td>

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

    <th width="8%" height="20" rowspan="2" align="center">S/N</th>

    <th width="35%" height="20" rowspan="2" align="center">Head Of Accounts </th>

    <th width="13%" rowspan="2" align="center">Opening</th>

    <th height="10" colspan="2" align="center"><div align="center">Closing Balance </div></th>
    </tr>
							  <tr>
							    <th width="13%" align="center">Debit </th>
							    <th width="13%" height="10" align="center">Credit </th>
							  </tr>

  <?php

if(isset($_REQUEST['show']))

{

	$total_dr=0;

	$total_cr=0;

	

	$cc_code = (int) $_REQUEST['cc_code'];

	if($cc_code > 0)

	{

		$g="select DISTINCT c.group_name,SUM(dr_amt),SUM(cr_amt),c.group_id, c.u_id FROM accounts_ledger a, journal b,ledger_group c where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date BETWEEN '$fdate' AND '$tdate' and c.group_for=".$_SESSION['user']['group']." AND b.cc_code=$cc_code group by c.group_name order by c.u_id asc";

		

	}

	else

	{

		$g="select DISTINCT c.group_name,SUM(dr_amt),SUM(cr_amt),c.group_id, c.u_id FROM accounts_ledger a, journal b,ledger_group c where a.ledger_id=b.ledger_id and a.ledger_group_id=c.group_id and b.jv_date BETWEEN '$fdate' AND '$tdate' and c.group_for=".$_SESSION['user']['group']." group by c.group_name order by c.u_id asc";



	}

//echo $g;

  $gsql=db_query($g);

  while($g=mysqli_fetch_row($gsql))

  {

  $total_dr=0;

  $total_cr=0;

?>

  <tr>

    <th align="left">&nbsp;</th>
    <th align="left"><?php echo $g[0];?></th>
    <th align="left">&nbsp;</th>
    <th align="left">&nbsp;</th>
    <th align="left">&nbsp;</th>
    </tr>



<?php

	$cc_code = (int) $_REQUEST['cc_code'];

	if($cc_code > 0)

	{

		$p="select DISTINCT a.ledger_name,SUM(dr_amt),SUM(cr_amt) from accounts_ledger a, journal b where a.ledger_id=b.ledger_id and b.jv_date BETWEEN '$fdate' AND '$tdate' and a.ledger_group_id='$g[3]' and 1 AND b.cc_code=$cc_code and a.group_for=".$_SESSION['user']['group']." group by ledger_name order by a.ledger_name";

		

	}

	else

	{
if($_POST['dealer_depot']!=''){
$depot_con=" and (a.warehouse_id='' or a.warehouse_id=".$_POST['dealer_depot'].") ";
}
		$p="select DISTINCT a.ledger_name,SUM(dr_amt),SUM(cr_amt),a.ledger_id from accounts_ledger a, journal b where a.ledger_id=b.ledger_id and b.jv_date BETWEEN '$fdate' AND '$tdate' and a.ledger_group_id='$g[3]' and a.group_for=".$_SESSION['user']['group'].$depot_con." group by ledger_name order by a.ledger_name";



	}

//echo $p;

$pi=0;

  $sql=db_query($p);

  while($p=mysqli_fetch_row($sql))

  {



$query="select SUM(dr_amt),SUM(cr_amt) from journal where jv_date < '$fdate' and ledger_id='$p[3]' and group_for=".$_SESSION['user']['group'];

$ssql=db_query($query);

$open=mysqli_fetch_row($ssql);

$opening = $open[0]-$open[1];

if($opening>0)

{ $tag='(Dr)';}

elseif($opening<0)

{ $tag='(Cr)';$opening=$opening*(-1);}



  $pi++;

//  if($p[2]>$p[1])

//  {

//	  $dr=0;

//	  $cr=$p[2]-$p[1];

//  }

//  else

//  {

//	  $dr=$p[1]-$p[2];

//	  $cr=0;

//  }

$dr=$p[1];

$cr=$p[2];

  ?>

  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>

    <td align="center"><?php echo $pi;?></td>

    <td align="left"><?php echo $p[0];?></td>

    <td align="right"><?=number_format($opening,2).' '.$tag;?></td>

    <td align="right"><?php echo number_format($dr,2);?></td>

    <td align="right"><?php echo number_format($cr,2);?></td>
    </tr>

  <?php

  $total_dr=$total_dr+$dr;

  $total_cr=$total_cr+$cr;

  $t_dr=$t_dr+$dr;

  $t_cr=$t_cr+$cr;

  }?>

  <tr>

    <th align="right">&nbsp;</th>

    <th align="right">Balance : <?php echo number_format(($total_dr-$total_cr),2);?></th>
    <th align="right">&nbsp;</th>

    <th align="right"><strong><?php echo number_format($total_dr,2);?></strong></th>

    <th align="right"><strong><?php echo number_format($total_cr,2)?></strong></th>
    </tr>

  <?php }?>

<tr>

    <th align="right">&nbsp;</th>

    <th align="right">Total Balance : </th>
    <th align="right">&nbsp;</th>

   <th align="right"><strong><?php echo number_format($t_dr,2);?></strong></th>

    <th align="right"><strong><?php echo number_format($t_cr,2)?></strong></th>
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>