<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Transaction Statement (Ledger)';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];

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
                                        <td width="50%" colspan="2" align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
									  

									  
                                      <tr>
                                        <td align="right">Dealer Type:</td>
                                        <td colspan="2" align="left"><select name="dealer_type" id="dealer_type" >
                                            <option value="">Select Dealer Type</option>
                                            <option value="ALL"<?=($_POST['dealer_type']=="ALL")?'selected':'';?>>ALL</option>
                                            <option value="Distributor"<?=($_POST['dealer_type']=="Distributor")?'selected':'';?>>Distributor</option>
                                            <option value="SuperShop"<?=($_POST['dealer_type']=="SuperShop")?'selected':'';?>>SuperShop</option>
                                            <option value="Corporate"<?=($_POST['dealer_type']=="Corporate")?'selected':'';?>>Corporate</option>
                                            <option value="Retailer"<?=($_POST['dealer_type']=="Retailer")?'selected':'';?>>Retailer</option>
                                        </select></td>
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
									<td><div id="reporting">
									<table id="grp"  class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th height="20" align="center">S/N</th>
								<th align="center">Voucher</th>
								<th height="20" align="center">Tr Date</th>
								<th align="center">Particulars</th>
								<th align="center">Source</th>
								<th align="center">SS PO NO </th>
								<th height="20" align="center">Dr Amt </th>
								<th align="center">Cr Amt </th>
								<th align="center">Balance</th>
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

		$total_sql = "select sum(a.dr_amt),sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '$sledger_id%' and a.tr_from='".$tr_from."' and b.group_for=".$_SESSION['user']['group']." ".$cc_con.$d_where;
		
		$total=mysqli_fetch_row(db_query($total_sql));
		
		$c="select sum(a.dr_amt)-sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date<'$fdate' and a.ledger_id like '$sledger_id%' and b.group_for=".$_SESSION['user']['group']." ".$cc_con.$d_where;

		 $p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_no,a.jv_no,a.cheq_no,a.cheq_date from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' ".$cc_con." and a.ledger_id like '$sledger_id%' and b.group_for=".$_SESSION['user']['group']." ".$d_where;
		 
		 if($tr_from!='')
		 $p.=" and a.tr_from='".$tr_from."'";
		 
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
    <td align="left" bgcolor="#FFCCFF">Opening Balance </td>
    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF"><?php if($blance>0) echo '(Dr)'.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
    </tr>
  <?php
////////////////////////////////////
  //echo $p;
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
    <td align="center"><?php echo date("d.m.y",$data[0]);?></td>
    <td align="left"><?=$data[5];?><?=(($data[9]!='')?'-Cq#'.$data[9]:'');?><?=(($data[10]>943898400)?'-Cq-Date#'.date('d-m-Y',$data[10]):'');?></td>
    <td align="center"><?php echo $data[4];?></td>
    <td align="center">&nbsp;</td>
    <td align="right"><?php echo number_format($data[2],2);?></td>
    <td align="right"><?php echo number_format($data[3],2);?></td>
    <td align="right" bgcolor="#FFCCFF"><?php $blance = $blance+($data[2]-$data[3]); if($blance>0) echo '(Dr)'.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
    </tr>
  <?php } ?>
  <tr>
    <th colspan="4" align="center">Difference Balance : <?php echo number_format($t_total,2)." ".$t_type?> </th>
    <th colspan="2" align="right"><strong>Total : </strong></th>
    <th align="right"><strong><?php echo number_format($total[0],2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total[1],2);?></strong></th>
    <th align="right">&nbsp;</th>
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