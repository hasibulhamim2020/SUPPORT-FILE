<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Statement(2)';
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
<?php $led=db_query("select * from item_info");
      $data = '[';
      $data .= '{ name: "All", id: "%" },';
	  while($ledg = mysqli_fetch_row($led)){
          $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
	  }
      $data = substr($data, 0, -1);
      $data .= ']';
//echo $data;

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
    $("#item_name").autocomplete(data, {
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
                                        <td align="right">Item Name :</td>
                                        <td align="left"><input type="text" name="item_name" id="item_name" value="<?php echo $_REQUEST['item_name'];?>" size="50" /></td>
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
								<th width="8%" height="20" align="center">S/N</th>
								<th width="9%" height="20" align="center">Date</th>
								<th width="14%" align="center">Invoice No </th>
								<th width="22%" height="20" align="center">Item Name</th>
								<th width="11%" height="20" align="center">Quantity</th>
								<th width="24%" align="center">Sales Price</th>
							  </tr>
                          <?php
                          if(isset($_REQUEST['show'])){
                          //$total=mysqli_fetch_row(db_query(""));
                          //$p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_no,a.narration from journal a,accounts_ledger b where tr_from='Purchase' and a.ledger_id=b.ledger_id and a.jv_date>'$fdate' and a.jv_date<'$tdate' and a.ledger_id like '$ledger_id' and 1 order by a.tr_no";
                        
                        
                          $query='SELECT a.s_inv_id, a.item, a.qty, a.amount, b.item_id, b.item_name FROM sales_invoice as a, item_info as b WHERE a.item=b.item_id and a.item like "'.$_REQUEST['item_name'].'"';
                          //echo $p;
                        $pi=0;
                          $sql=db_query($query);
                          while($data=mysqli_fetch_row($sql)){
                          $pi++;
                          ?>
                          <tr <? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                            <td align="center"><?php echo $pi;?></td>
                            <td align="center"><?php echo date("d.m.y",$data[0]);?></td>
                            <td align="center"><?php echo $data[0];?></td>
                            <td align="left"><?php echo $data[5];?></td>
                            <td align="left"><?php echo $data[2];?></td>
                            <td align="right"><?php echo $data[3];?></td>
                          </tr><?php }?>
                          <tr>
                            <th colspan="4" align="right"><strong>Total : </strong></th>
                            <th align="right"><strong><?php echo $total[0];?></strong></th>
                            <th align="right"><strong><?php echo $total[1];?></strong></th>
                          </tr>
                          <?php }?>
                        </table> </div>
															
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