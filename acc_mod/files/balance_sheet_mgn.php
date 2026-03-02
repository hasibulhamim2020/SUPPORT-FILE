<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Balance Sheet';

$proj_id=$_SESSION['proj_id'];



if(isset($_REQUEST['show']))

{

$tdate=$_REQUEST['tdate'];

//fdate-------------------



$ledger_id=$_REQUEST["ledger_id"];





if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')

$report_detail.='<br>Report date Till: '.$_REQUEST['tdate'];





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

<?php $led=db_query("select ledger_id,ledger_name from accounts_ledger where group_for=".$_SESSION['user']['group']." order by ledger_name");

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

                                        <td align="right"> As On: </td>

                                        <td align="left"><input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>" />

                                        </td>

                                      </tr>

                                      <tr>

                                        <td width="22%" align="right">Ledger Group : </td>

                                        <td align="left"><select name="group_id" id="group_id">

                                            <option></option>

                                            <? foreign_relation('ledger_group','group_id','group_name',$_REQUEST['group_id'],"group_for=".$_SESSION['user']['group']);?>

                                          </select>

                                          <input type="hidden" name="flag" id="flag" value="1" /></td>

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

									<td><div id="reporting">

			<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">

							 <tr>

							<th height="20" colspan="2" align="center">Class</th>

							<th width="47%" height="20" align="center">Head of Account </th>

							<th width="18%" height="20" align="center">Amount</th>
							</tr>

							

  <?php

  if(($_REQUEST['flag']==1)){

  if($_REQUEST['group_id']>0)

  $con="and a.group_id ='".$_REQUEST['group_id']."'";



  $p="SELECT a.group_name,sum(dr_amt),sum(cr_amt),a.group_id from ledger_group a, accounts_ledger b, journal c where (a.group_class='1000' or a.group_class='2000') and a.group_id=b.ledger_group_id and b.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and a.group_for=".$_SESSION['user']['group']." ".$con." group by a.group_name order by a.DESC";

    $sql=db_query($p);



$pi=0;

$te=0;



  while($data=mysqli_fetch_row($sql)){

$pi++;

$amt2=($data[1]-$data[2]);

$te=$te+$amt2;

  ?>

  <tr>

    <th align="center">&nbsp;</th>

    <th colspan="2" align="left"><?php echo $data[0];?></th>

    <th colspan="2" align="right"><?php if(($amt2)<0) echo "(".($amt2*(-1)).")"; else echo $amt2;?></th>
  </tr>



  <?php

  $pa="SELECT a.ledger_name,sum(dr_amt-cr_amt) from accounts_ledger a, journal c where a.ledger_group_id='$data[3]' and a.ledger_id=c.ledger_id and c.jv_date between '$fdate' and '$tdate' and a.group_for=".$_SESSION['user']['group']." group by a.ledger_name";

  //echo $pa;

  $asql=db_query($pa);

  while($adata=mysqli_fetch_row($asql)){

  $api++;

  ?><?php }?>

<?php }?>

  <tr>

    <th colspan="3" align="right">Total : </th>

    <th align="right"><?php if(($te)<0) echo "(".($te*(-1)).")"; else echo $te;?>&nbsp;</th>
  </tr><?php }?>



	<?php

  if(($_REQUEST['flag']==1)){}?>
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