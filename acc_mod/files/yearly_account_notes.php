<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Ledger Note';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$t_date=$_REQUEST['tdate'];
//date-------------------
//hour,min,sec,mon,day,year)
$fdate=mktime(0,0,0,1,1,$t_date);
$tdate=mktime(0,0,-1,1,1,($t_date+1));

//lastyear date-------------------
$lastfdate=mktime(0,0,0,1,1,($t_date-1));
$lasttdate=mktime(0,0,-1,1,1,$t_date);
echo $tdatel;
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
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      
                                      <tr>
                                        <td align="right">Till Period :</td>
                                        <td align="left">
        								<select name="tdate">
									  <?php if(isset($_REQUEST['tdate'])) echo "<option>".$_REQUEST['tdate']."</option>";?>
                                      <option value="2008">2008</option>
                                      <option value="2009">2009</option>
                                      <option value="2010">2010</option>
                                      <option value="2011">2011</option>
                                      <option value="2012">2012</option>
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
									<table id="grp" class="tabledesign" cellspacing="0">
							  <tr bgcolor="#FFCCCC">
    <th height="20" rowspan="2" align="center">S/L</th>
    <th width="47%" height="20" rowspan="2" align="center">Particulars</th>
    <th height="20" colspan="2" align="center">Amount in Taka </th>
    </tr>
  <tr bgcolor="#FFCCCC">
    <th width="17%" align="center"><?php echo $_REQUEST['tdate'];?> </th>
    <th width="18%" height="20" align="center"><?php echo ($_REQUEST['tdate']-1);?></th>
  </tr>
	  <tr bgcolor="#99CCCC">
	    <th colspan="4" align="left" bgcolor="#FFFFFF">&nbsp;</th>
    </tr>
  </table>
	
	
	
	
<?php 
$p=0;
$sql_grp="select group_id,group_name from ledger_group where 1";
$query_grp=db_query($sql_grp);
while($data_grp=mysqli_fetch_row($query_grp)){
$p++;
$pi=0;
$total_amt=0;
$total_amtl=0;
?>
<table width="80%" border="1" align="center" id="table1">
<tr bgcolor="#99CCCC">
<th align="center"><?php echo number_format($p,2);?></th>
<th colspan="3" align="left"><?php echo $data_grp[1];?> : </th>
</tr>
<?php 
$sql="select ledger_name,ledger_id from accounts_ledger where 1 and ledger_group_id='$data_grp[0]' order by ledger_name";
//echo $sql;
$query=db_query($sql);
while($data=mysqli_fetch_row($query)){
$pi++;
?>
  <tr <?php  if($pi%2==0) echo "bgcolor=\"#E8FFFF\""; else echo "bgcolor=\"#F0F0FF\"";?>>
    <th width="4%" align="center"><?php echo number_format((($p*100)+$pi)/100,2);?></th>
    <td width="38%" align="left"><?php echo $data[0];?></td>
	<td width="40%" align="right"><?php
	$amt=mysqli_fetch_row(db_query("select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$data[1]' and jv_date between '$fdate' and '$tdate' and 1"));
$total_amt=$total_amt+$amt[0];
	 if($amt[0]==0) echo "0.00"; echo $amt[0];?></td>
    <td width="18%" align="right"><?php
	$amtl=mysqli_fetch_row(db_query("select SUM(dr_amt)-SUM(cr_amt) from fiscal_journal where ledger_id ='$data[1]' and jv_date between '$lastfdate' and '$lasttdate' and 1"));
$total_amtl=$total_amtl+$amtl[0];
if($amtl[0]==0) echo "0.00"; echo $amtl[0];?></td>
    </tr> 
  <?php } if($pi>1){?>
  <tr>
    <th colspan="2" align="right" bgcolor="#FFCCCC">&nbsp;Sub Total :</th>
    <th align="right" bgcolor="#FFCCCC"><?php echo number_format($total_amt,2);?></th>
    <th align="right" bgcolor="#FFCCCC"><?php echo number_format($total_amtl,2)?></th>
  </tr>
<?php }?>
  <tr>
    <th colspan="4" align="left" bgcolor="#FFFFFF">&nbsp;</th>
  </tr></table>
<?php }?> </div>
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