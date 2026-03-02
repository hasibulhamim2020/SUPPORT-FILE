<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Fixed Asset Report';

$proj_id=$_SESSION['proj_id'];



if(isset($_REQUEST['show']))

{

$tdate=$_REQUEST['tdate'];

//fdate-------------------

$fdate=$_REQUEST["fdate"];

$ledger_id=$_REQUEST["ledger_id"];

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

<?php $led=db_query("select ledger_id,ledger_name from accounts_ledger where 1 order by ledger_name");

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



    function formatItem(row) {

		//return row[0] + " " + row[1] + " ";

	}

	function formatResult(row) {

		return row[0].replace(/(<.+?>)/gi, '');

	}



    var data = <?php echo $data; ?>;

    $("#ledger_id").autocomplete(data, {

		matchContains: true,

		minChars: 0,

		scroll: true,

		scrollHeight: 300,

        formatItem: function(row, i, max, term) {

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

                                        <td align="right">Ledger Head :</td>

                                        <td align="left">

                                        

                                        <select name="tdate">

										  <?php 

                                          

                                          if(isset($_REQUEST['tdate'])) echo "<option>".$_REQUEST['tdate']."</option>";?>

                                          <option value="0000">Running Year</option>

                                          <option value="2016">2016</option>

                                          <option value="2017">2017</option>

                                          </select>

                                        

                                        

                                        </td>

                                      </tr>

                                     

                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>

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

								<th width="3%" rowspan="2" align="center"><strong>S/L</strong></th>

								<th width="8%" rowspan="2" align="center"><strong>Name of Asset </strong></th>

								<th colspan="4" align="center"><strong>COST</strong></th>

								<th width="7%" rowspan="2" align="center"><strong>Rate of Depreciation (5) </strong></th>

								<th colspan="4" align="center"><strong>Depreciation</strong></th>

								<th width="8%" rowspan="2" align="center"><strong>Written Down Value 10=(4-9) </strong></th>

							  </tr>

							  <tr>

								<th width="7%" align="center"><strong>Opening (1) </strong></th>

								<th width="9%" align="center"><strong>Addition (2) </strong></th>

								<th width="8%" align="center"><strong>Disposal/ Adjustment (3) </strong></th>

								<th width="7%" align="center"><strong>Total</strong> 4=(1+2-3) </th>

								<th width="8%" align="center"><strong>Opening (6) </strong></th>

								<th width="9%" align="center"><strong>During the year (7) </strong></th>

								<th width="8%" align="center"><strong>Disposal/ Adjustment (8) </strong></th>

								<th width="9%" align="center"><strong>Total 9=(6+7-8) </strong></th>

							  </tr>

	<?php 

	$newp="select distinct a.ledger_name,a.ledger_id,a.depreciation_rate from accounts_ledger a,ledger_group b where b.group_name='PROPERTY AND ASSETS' and a.ledger_group_id=b.group_id and 1 order by ledger_name";

	$sql=db_query($newp);

	$pi=0;

	$total_open=0;

	$total_close=0;

	$total_add=0;

	$total_depr=0;

	while($data=mysqli_fetch_row($sql)){

	$pi++;

$open=mysqli_fetch_row(db_query("select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id='$data[1]' and jv_date<'$fdate'"));

$add=mysqli_fetch_row(db_query("select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id='$data[1]' and jv_date between '$fdate' and '$tdate'"));

if(is_null($open[0])) $open[0]=0;

if(is_null($add[0])) $add[0]=0;

$total=$open[0]+$add[0];

$total_open=$total_open+$open[0];

$total_add=$total_add+$add[0];

$total_close=$total_close+$total-($total*$data[2]/100);

$total_depr=$total_depr+($total*$data[2]/100);

	?>

  <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>

    <td align="center"><?php echo $pi;?></td>

    <td align="left"><?php echo $data[0];?></td>

    <td align="right"><?php echo number_format($open[0],2);?></td>

    <td align="right"><?php echo number_format($add[0],2);?></td>

    <td align="right">&nbsp;</td>

    <td align="right"><?php echo number_format($total,2);?></td>

    <td align="right"><?php echo $data[2]." %";?></td>

    <td align="right">&nbsp;</td>

    <td align="right"><?php echo number_format($total*$data[2]/100,2);?></td>

    <td align="right">&nbsp;</td>

    <td align="right"><?php echo number_format($total*$data[2]/100,2);?></td>

    <td align="right"><?php echo number_format($total-($total*$data[2]/100),2);?></td>

  </tr>

  <?php }?>

  <tr>

    <th colspan="2" align="center">Total : </th>

    <th align="right"><strong><?php echo number_format($total_open,2);?></strong></th>

    <th align="right"><strong><?php echo number_format($total_add,2);?></strong></th>

    <th align="right">&nbsp;</th>

    <th align="right"><strong><?php echo number_format(($total_open+$total_add),2);?></strong></th>

    <th>&nbsp;</th>

    <th>&nbsp;</th>

    <th><div align="right"><strong><?php echo number_format($total_depr,2);?></strong></div></th>

    <th>&nbsp;</th>

    <th>&nbsp;</th>

    <th><div align="right"><strong><?php echo number_format($total_close,2);?></strong></div></th>

  </tr>

</table></div>

																		</td>

								  </tr>

		</table>



							</div></td>

    

  </tr>

</table>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>