<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='User wise Transaction';
$proj_id=$_SESSION['proj_id'];
$separator=$_SESSION['separator'];
$cash_and_bank_balance=find_a_field('config_group_class','cash_and_bank_balance',"1");

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
<?php 
$sql="select ledger_id,ledger_name from accounts_ledger where 1 order by ledger_name";
$led=db_query($sql);
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
        
             /*   var data = <?php echo $data1; ?>;
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
        });        */
        

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
                                                                    <td><div class="box_report"><form id="form1" name="form1" method="get" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="22%" align="right">
										Period :</td>
                                        <td align="left">
<input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php if($_REQUEST['fdate']=='') echo date('d-m-y'); else echo $_REQUEST['fdate'];?>" /> 
                                         -TO- 
<input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php if($_REQUEST['tdate']=='') echo date('d-m-y'); else echo $_REQUEST['tdate'];?>"/> 
<span class="hints">(Ex: Date Format:'31-12-10') </span></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Ledger Head :</td>
                                        <td align="left"><input type="text" name="ledger_id" id="ledger_id" value="<?php if($_REQUEST['ledger_id']=='') echo '%'; else echo $_REQUEST['ledger_id'];?>" size="50" />
                                          <span class="hints">(Ex: '%' means 'Show All Available Data') </span></td>
                                      </tr>
                                     
                                      <tr>
                                        <td align="right">User Name : </td>
                                        <td align="left">
										<select name="user_id" id="user_id">
										<option></option>
										<?
										$sql='select user_id,username from user_activity_management';
										$query=db_query($sql);
										if(mysqli_num_rows($query)>0)
										{
										while($info=mysqli_fetch_row($query))
										{
										if($info[0]==$_REQUEST['user_id'])
										echo '<option value="'.$info[0].'" selected>'.$info[1].'</option>';
										else
										echo '<option value="'.$info[0].'">'.$info[1].'</option>';
										}
										}
										?>
                                        </select>
                                        <span class="hints">(Ex: Blank field means 'Show All Available Data') </span></td>
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
									<td>
									<div id="reporting">
									<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
									<tr>
									<th>User Name </th>
									<th>Date</th>
									<th>Voucher No.</th>
									<th>Voucher From</th>
									<th>Account Code </th>
									<th>Account Name</th>
									<th>Transaction Narration</th>
									<th>Dr. Amt. BDT</th>
									<th>Cr. Amt. BDT</th>
									</tr>
<?php
        if(isset($_REQUEST['show'])){
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
$p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,b.ledger_id,a.tr_from,a.tr_no ,c.username
from 
journal a,accounts_ledger b ,user_activity_management c
where a.ledger_id=b.ledger_id 
and a.jv_date>'$fdate' 
and a.jv_date<'$tdate' 
and a.ledger_id like '$ledger_id' 
and 1 
and a.user_id=c.user_id 
and a.user_id='".$_REQUEST['user_id']."' 
order by a.jv_date, a.tr_no";
else
$p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,b.ledger_id,a.tr_from,a.tr_no ,c.username
from journal a,accounts_ledger b, user_activity_management c
where a.ledger_id=b.ledger_id 
and a.jv_date>'$fdate' 
and a.jv_date<'$tdate' 
and a.user_id=c.user_id 
and a.ledger_id like '$ledger_id' 
and 1 order by a.jv_date, a.tr_no";

        $report = db_query($p);
        $i=0;
        while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';
        $cr_total=$cr_total+$rp[3];
        $dr_total=$dr_total+$rp[2];
        ?>
								   <tr<?=$cls?>>
										<td><?=$rp[9];?></td>
										<td><?=date("Y-m-d",$rp[0]);?></td>
										<td><?=$rp[8];?></td>
										<td><?=$rp[7];?></td>
										<td><?=ledger_sep($rp[6],$separator);?></td>
										<td><?=$rp[1];?></td>
										<td><?=$rp[5];?></td>
										<td><?=$rp[2];?></td>
										<td><?=$rp[3];?></td>
								  </tr>
        <?php }?>
									<tr>
									<th colspan="7" align="right"><strong>Total : </strong></th>
									<th><strong>
									<?=number_format($dr_total,2);?>
									</strong></th>
									<th><strong>
									<?=number_format($cr_total,2);?>
									</strong></th>
									</tr>
									<?
									}?>
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