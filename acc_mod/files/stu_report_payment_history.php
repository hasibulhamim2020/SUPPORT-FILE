<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Student Payment History';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$ledger_id=$_REQUEST["ledger_id"];
$sql='select a.customer_company,a.customer_name,c.item_name,b.amount,a.customer_id from stu_student_info a, stu_course_register b,stu_course c where a.customer_id=b.customer and b.item=c.item_id and b.customer='.$ledger_id;
$query=db_query($sql);
if(mysqli_num_rows($query)>0)
{
$info=mysqli_fetch_row($query);
}
}

$sql="select customer_id,customer_name from stu_student_info where 1";
$led=db_query($sql);
      $data = '[';
          while($ledg = mysqli_fetch_row($led)){
          $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
          }
      $data = substr($data, 0, -1);
      $data .= ']';
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
                                                                    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      
                                      <tr>
                                        <td width="22%" align="right">Student Name  :</td>
                                        <td align="left"><input type="text" name="ledger_id" id="ledger_id" value="<?php if($_REQUEST['ledger_id']=='') echo ''; else echo $_REQUEST['ledger_id'];?>" size="50" /></td>
                                      	</tr>
                                     
                                      <tr>
                                        <td colspan="2" align="center">
										<input class="btn" name="show" type="submit" id="show" value="Show" /></td>
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
									  <td colspan="6"><table width="40%" border="0" align="center" cellpadding="0" cellspacing="8">
                                          <tr>
                                            <td align="right"><strong>Student  ID :</strong></td>
                                            <td><strong><?=$info[0]?></strong></td>
                                          </tr>
                                          <tr>
                                            <td align="right"><strong>Name : </strong></td>
                                            <td><strong><?=$info[1]?></strong></td>
                                          </tr>
                                          <tr>
                                            <td align="right"><strong>Course : </strong></td>
                                            <td><strong><?=$info[2]?></strong></td>
                                          </tr>
                                          <tr>
                                            <td align="right"><strong>Total  Payable(tk) : </strong></td>
                                            <td><strong><?=$info[3]?></strong></td>
                                          </tr>
                                        </table>
									  </th>									  </tr>
									<tr>
									<th>Action</th>
									<th>Scroll No.</th>
									<th>Date</th>
									<th>Voucher No.</th>
									<th>Student Name</th>
									<th>Narration</th>
									<th>Amt. BDT</th>
									</tr>
<?php
if(isset($_REQUEST['show'])){
$p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_from,a.tr_no from journal a,accounts_ledger b where a.ledger_id=b.ledger_id and a.ledger_id like '$ledger_id' and 1 and a.cr_amt>0 order by a.jv_date, a.tr_no";

        $report = db_query($p);
        $i=0;
        while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';
        $cr_total=$cr_total+$rp[3];
        $dr_total=$dr_total+$rp[2];
        ?>
								   <tr<?=$cls?>>
								   		<td><a href="stu_voucher_print.php?tr_no=<?=$rp[8]?>" target="_blank">Voucher</a></td>
										<td><?=$i;?></td>
										<td><?=date("Y-m-d",$rp[0]);?></td>
										<td><?=$rp[8];?></td>
										<td><?=$rp[1];?></td>
										<td><?=$rp[5];?></td>
										<td><?=number_format($rp[3],2);?></td>
									  </tr>
        <?php }?>
									<tr>
									<th colspan="6" align="right"><strong>Total : </strong></th>
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