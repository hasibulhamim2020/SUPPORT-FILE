<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sale Proceeds Received and Deposited to Bank';

$proj_id=$_SESSION['proj_id'];

$active='saleproceeds';

do_calander('#fdate');
do_calander('#tdate');

create_combobox('ledger_id');
if(isset($_REQUEST['show']))

{

$tdate=date('Y-m-d',strtotime($_REQUEST['tdate']));

//fdate-------------------

$fdate=date('Y-m-d',strtotime($_REQUEST["fdate"]));



$ledger_id=$_REQUEST["ledger_id"];

	if(substr($ledger_id,8,8)=='00000000')

	$sledger_id = substr($ledger_id,0,8);

	elseif(substr($ledger_id,12,4)=='0000')

	$sledger_id = substr($ledger_id,0,12);

	else $sledger_id = $ledger_id;

$tr_from=$_REQUEST["tr_from"];



if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')

$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];

if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')

$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"].' and group_for='.$_SESSION['user']['group']);

if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')

$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);
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

<?php $active=='saleproceeds'; ?>

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

</script>















<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">

									<table width="100%" border="0" cellspacing="2" cellpadding="2">

                                      <tr>

                                        <td width="22%" align="right">

		    Period :                                       </td>

                                        <td align="left"><input name="fdate" style="max-width:250px;" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 

                                          </td>                                            
<td align="left"><input name="tdate" type="text" style="max-width:250px;" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>

                                      </tr>

                                      <tr>

                                        <td align="right">Ledger Head :</td>

                                        <td width="28%" align="left"><select name="ledger_id" id="ledger_id" class="form-control" style="float:left"  >

                                                                                <option value="%">All</option>

                                                                             <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,"1  order by ledger_id"); ?>

                                                                      </select></td>

                                        <td width="50%" align="left"><? if($_REQUEST['ledger_id']>0) echo find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST['ledger_id']);?>&nbsp;</td>

                                      </tr>

									  

									  <tr>

                                        <td align="right">Transaction Type : </td>

                                        <td><select name="tr_from" id="tr_from" >

						  <option value="">Select Type</option>

										  <option value="Sales"<?=($_POST['tr_from']=="Sales")?'selected':'';?>>Sales</option>

                                          <option value="Opening"<?=($_POST['tr_from']=="Opening")?'selected':'';?>>Opening</option>

                                          <option value="Receipt"<?=($_POST['tr_from']=="Receipt")?'selected':'';?>>Receipt</option>

										 <option value="Payment"<?=($_POST['tr_from']=="Payment")?'selected':'';?>>Payment</option>

										 

										 <option value="Journal_info"<?=($_POST['tr_from']=="Journal_info")?'selected':'';?>>Journal</option>

										 

										  <option value="SalesReturn"<?=($_POST['tr_from']=="SalesReturn")?'selected':'';?>>SalesReturn</option>

					  </select></td>

                                      </tr>

									  

									  

                                        <!--<tr>

                                          <td align="right">Dealer Type:</td>

                                          <td colspan="2" align="left"><select name="dealer_type" id="dealer_type" >

                                              <option value="">Select Dealer Type</option>

                                              <option value="ALL"<?=($_POST['dealer_type']=="ALL")?'selected':'';?>>ALL</option>

                                              <option value="Distributor"<?=($_POST['dealer_type']=="Distributor")?'selected':'';?>>Distributor</option>

                                              <option value="SuperShop"<?=($_POST['dealer_type']=="SuperShop")?'selected':'';?>>SuperShop</option>

                                              <option value="Corporate"<?=($_POST['dealer_type']=="Corporate")?'selected':'';?>>Corporate</option>

                                              <option value="Retailer"<?=($_POST['dealer_type']=="Retailer")?'selected':'';?>>Retailer</option>

                                          </select></td>

                                        </tr>-->

                                        <tr>

                                          <td align="right">User Name : </td>

                                          <td colspan="2" align="left">

										  <select name="user_name" id="user_name" >

                                             <option></option>

                                          		<? foreign_relation('user_activity_management','user_id','fname',$_POST['user_name']);?>

                                          </select>

										  

										  

										  </td>

                                        </tr>

                                      <tr>

                                        <td align="right">Cost Center : </td>

                                        <td colspan="2" align="left"><select name="cc_code" id="cc_code">
										<option value="<?php echo $_REQUEST['cc_code'];?>"></option>
											<? foreign_relation('cost_center cc, cost_category c','cc.id','cc.center_name',$cc_code,"cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC");?>
										</select></td>

                                      </tr>

                                      <tr>

                                        <td colspan="3" align="center"><input class="btn"  name="show" type="submit" id="show" value="Show" /></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td><div id="reporting">

									<table id="grp"  class="tabledesign table-bordered table-condensed" width="100%" cellspacing="0" cellpadding="2" border="0">

							  <tr>

								<th width="4%" height="20" align="center">S/N</th>

								<th width="7%" align="center">Voucher</th>

								<th width="10%" height="20" align="center">Tr Date</th>

								<th width="24%" align="center">Bank Head </th>

								<th width="24%" align="center">Distributor Head </th>

								<th width="7%" align="center">Source</th>

								<th width="12%" height="20" align="center">Sale Amt </th>

								<th width="12%" align="center">Receipt Amt </th>

								</tr>

<?php

if(isset($_REQUEST['show']))

{

	$cc_code = (int) $_REQUEST['cc_code'];

	$dealer_type = $_REQUEST['dealer_type'];

	if($dealer_type!='')

	{

	$d_table = ',dealer_info d';

	$d_where = ' and d.account_code=b.ledger_id and d.dealer_type="'.$dealer_type.'" ';

	}

		if($cc_code > 0)

		$cc_con = " AND a.cc_code=$cc_code";



		$total_sql = "select sum(a.dr_amt),sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '$sledger_id%' and  b.group_for=".$_SESSION['user']['group']." ".$cc_con.$d_where;

		

		if($tr_from!='')

		 $total_sql.=" and a.tr_from='".$tr_from."'";

		 

		 if($_POST['user_name']!='')

		 $total_sql.=" and a.entry_by='".$_POST['user_name']."'";

		

		$total=mysqli_fetch_row(db_query($total_sql));

		

		$c="select sum(a.dr_amt)-sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date<'$fdate' and a.ledger_id like '$sledger_id%' and b.group_for=".$_SESSION['user']['group']." ".$cc_con.$d_where;



		 $p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_no,a.jv_no,a.cheq_no,a.cheq_date,a.relavent_cash_head from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' ".$cc_con." and a.ledger_id like '$sledger_id%' and b.group_for=".$_SESSION['user']['group']." ".$d_where;

		 

		 if($tr_from!='')

		 $p.=" and a.tr_from='".$tr_from."'";

		 

		 if($_POST['user_name']!='')

		 $p.=" and a.entry_by='".$_POST['user_name']."'";

		 

		 $p.=" order by a.jv_date,a.id";



	



	if($total[0]>$total[1])

	{

		$t_type="(Dr)";

		$t_total=$total[0]-$total[1];

	}

	else

	{

		$t_type="(Cr)";

		$t_total=$total[1]-$total[0];

	}

	/* ===== Opening Balance =======*/

	

	$psql=db_query($c);

	$pl = mysqli_fetch_row($psql);

	$blance=$pl[0];

  ?>

  

  <tr>

    <td align="center" bgcolor="#FFCCFF">#</td>

    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>

    <td align="center" bgcolor="#FFCCFF"><?php echo $_REQUEST["fdate"];?></td>

    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>

    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>

    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>

    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>

    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>

    </tr>

  <?php
  
  $sql=db_query($p);

  while($data=mysqli_fetch_row($sql))

  {

  $pi++;

  ?>

  <tr>

    <td align="center"><?php echo $pi;?></td>

    <td align="center">

	<?php

	if($data[4]=='Receipt'||$data[4]=='Payment'||$data[4]=='Journal_info'||$data[4]=='Contra')

	{

		$link="voucher_print.php?v_type=".$data[4]."&v_date=".$data[0]."&view=1&vo_no=".$data[8];

		echo "<a href='$link' target='_blank'>".$data[7]."</a>";

	}

	else {

		echo $data[6];

	}

	?>	</td>

    <td align="center"><?php echo date("d.m.y",strtotime($data[0]));?></td>

    <td align="left"><?=find_a_field('accounts_ledger','ledger_name','ledger_id='.$data[11]);?></td>

    <td align="left"><?=$data[1];?></td>

    <td align="center"><?php echo $data[4];?></td>

    <td align="right"><?php echo number_format($data[2],2);?></td>

    <td align="right"><?php echo number_format($data[3],2);?></td>

    </tr>

  <?php } ?>

  <tr>

    <th colspan="3" align="center">Difference Balance : <?php echo number_format($t_total,2)." ".$t_type?> </th>

    <th colspan="3" align="right"><strong>Total : </strong></th>

    <th align="right"><strong><?php echo number_format($total[0],2);?></strong></th>

    <th align="right"><strong><?php echo number_format($total[1],2);?></strong></th>

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