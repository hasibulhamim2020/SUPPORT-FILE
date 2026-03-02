<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Journal Book (Detail)';
$proj_id=$_SESSION['proj_id'];
$separator=$_SESSION['separator'];

if($_SESSION['user']['group']>1)
$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' and group_for=".$_SESSION['user']['group']);
else
$cash_and_bank_balance=find_a_field('ledger_group','group_id','group_sub_class=1020');



if(isset($_REQUEST['show']))
{
if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')
$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"].' and group_for='.$_SESSION['user']['group']);
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
$report_detail.='<br>User ID : '.$_REQUEST['user_id'];

$fdate=date_value($_REQUEST["fdate"]);
$tdate=date_value($_REQUEST["tdate"]);
$ledger_id=$_REQUEST["ledger_id"];
}
?>
<?php 
$sql="select ledger_id,ledger_name from accounts_ledger where  group_for=".$_SESSION['user']['group']." order by ledger_name";
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
                                          <span class="hints">(Ex: '%' means 'Show All') </span></td>
                                      </tr>
                                     
                                      <tr>
                                        <td align="right">User Name : </td>
                                        <td align="left">
										<select name="user_id">
										<? foreign_relation('user_activity_management','user_id','fname',$_REQUEST['user_id'],'1 and group_for="'.$_SESSION['user']['group'].'"');?>
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
									<th>S/L</th>
									<th>Date</th>
									<th>Vou No.</th>
									<th>Vou From</th>
									<th>Ledger Name</th>
									<th>Transaction Narration</th>
									<th>Dr. Amt</th>
									<th>Cr. Amt</th>
									</tr>
<?php
        if(isset($_REQUEST['show'])){
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
$p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,b.ledger_id,a.tr_from,a.tr_no,a.jv_no from journal a,accounts_ledger b where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' and '$tdate' and a.ledger_id like '$ledger_id' and 1 and a.user_id='".$_REQUEST['user_id']."' and b.group_for=".$_SESSION['user']['group']." order by a.jv_date, a.tr_no";
else
$p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,b.ledger_id,a.tr_from,a.tr_no,a.jv_no from journal a,accounts_ledger b where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' and '$tdate' and a.ledger_id like '$ledger_id' and b.group_for=".$_SESSION['user']['group']." order by a.jv_date, a.tr_no";

        $report = db_query($p);
        $i=0;
        while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';
        $cr_total=$cr_total+$rp[3];
        $dr_total=$dr_total+$rp[2];
        ?>
								   <tr<?=$cls?>>
										<td><?=$i;?></td>
										<td><?=date("Y-m-d",$rp[0]);?></td>
										<td>
<?php
if($rp[4]=='Receipt'||$rp[4]=='Payment'||$rp[4]=='Journal_info'||$rp[4]=='Contra')
{
$link="voucher_print.php?v_type=".$rp[4]."&v_date=".$rp[0]."&view=1&vo_no=".$rp[9];
echo "<a href='$link'>".$rp[8]."</a>";
}
else {
echo $rp[8];
}
?>
                                        </td>
										<td><?=$rp[7];?></td>
										<td><?=$rp[1];?></td>
										<td><?=$rp[5];?></td>
										<td><?=$rp[2];?></td>
										<td><?=$rp[3];?></td>
								  </tr>
        <?php }?>
									<tr>
									<th colspan="6" align="right"><strong>Total : </strong></th>
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