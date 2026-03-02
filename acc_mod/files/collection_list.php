<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
if($_POST['received_status']=='pending')
$title='Cash Collection Pending List';
else
$title='Cash Collection List';

$bank_head = find_a_field('config_group_class','collection_bank_head','group_for='.$_SESSION['user']['group']);
$collection_bank_head = substr($bank_head,0,12);

$_POST['fct_date'] = date('Y-m-d',strtotime($_POST['ct_date'])+24*60*60);


if(isset($_REQUEST['t_date'])&&$_REQUEST['t_date']!='')
$report_detail.='<br>DO Date Period: '.$_REQUEST['f_date'].' to '.$_REQUEST['t_date'];

if(isset($_REQUEST['ct_date'])&&$_REQUEST['ct_date']!='')
$report_detail.='<br>Check Date Period: '.$_REQUEST['cf_date'].' to '.$_REQUEST['ct_date'];

if(isset($_REQUEST['rt_date'])&&$_REQUEST['rt_date']!='')
$report_detail.='<br>Receive Date Period: '.$_REQUEST['rf_date'].' to '.$_REQUEST['rt_date'];

if($_REQUEST['product_group']!='')
$report_detail.='<br>Product Group : '.$_REQUEST['product_group'];



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
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','party_ledger');
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
                $("#f_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                });
        });
                $(function() {
                $("#t_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                });
        });
		$(function() {
                $("#cf_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                });
        });
		$(function() {
                $("#ct_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                });
        });
		$(function() {
                $("#rf_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                });
        });
		$(function() {
                $("#rt_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
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
										DO Period :</td>
                                        <td align="left">
<input name="f_date" type="text" id="f_date" size="12" maxlength="12" value="<?php if($_REQUEST['f_date']!='') echo $_REQUEST['f_date'];?>" /> 
                                         -TO- 
<input name="t_date" type="text" id="t_date" size="12" maxlength="12" value="<?php if($_REQUEST['t_date']!='') echo $_REQUEST['t_date'];?>"/></td>
                                      </tr>
                                      <tr>
                                        <td align="right"> Check Date :</td>
                                        <td align="left"><input name="cf_date" type="text" id="cf_date" size="12" maxlength="12" value="<?php if($_REQUEST['cf_date']!='') echo $_REQUEST['cf_date'];?>" />
                                          -TO-
                                          <input name="ct_date" type="text" id="ct_date" size="12" maxlength="12" value="<?php if($_REQUEST['ct_date']!='') echo $_REQUEST['ct_date'];?>"/></td>
                                      </tr>
                                      <tr>
                                        <td align="right"> Receive Date :</td>
                                        <td align="left"><input name="rf_date" type="text" id="rf_date" size="12" maxlength="12" value="<?php if($_REQUEST['rf_date']!='') echo $_REQUEST['rf_date'];?>" />
                                          -TO-
                                          <input name="rt_date" type="text" id="rt_date" size="12" maxlength="12" value="<?php if($_REQUEST['rt_date']!='') echo $_REQUEST['rt_date'];?>"/></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Party Head  :</td>
                                        <td align="left"><label>
<input name="rt_date" type="text" id="rt_date" size="12" maxlength="12" value="<?php if($_REQUEST['rt_date']!='') echo $_REQUEST['rt_date'];?>"/>
                                          <select  id="party_ledger" name="party_ledger" style="width:200px;">
                                            <option value="">ALL</option>
<? foreign_relation('sub_sub_ledger','sub_sub_ledger_id','concat(sub_sub_ledger,":",sub_sub_ledger_id)',$_POST['receive_acc_head'],' sub_sub_ledger_id LIKE "1051%" order by sub_sub_ledger');?>
                                          </select>
                                        </label></td>
                                      </tr>
                                     
                                      <tr>
                                        <td align="right">Bank Head  : </td>
                                        <td align="left"><select  id="receive_acc_head" name="receive_acc_head" style="width:200px;">
                                          <option value="">ALL</option>
                                          <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['receive_acc_head'],' ledger_id LIKE "'.$collection_bank_head.'%" and ledger_id!="'.$bank_head.'" order by ledger_name');?>
                                        </select></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Collection Check Status : </td>
                                        <td align="left"><select style="width:155px;" id="received_status" name="received_status">
                                            <option value="">ALL</option>
                                            <option value="received">CHECKED</option>
                                            <option value="pending">NOT CHECKED</option>
                                        </select></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Product Group : </td>
                                        <td align="left"><select style="width:155px;" id="product_group" name="product_group">
                                          <option><?=$_POST['product_group']?></option>
										  <? foreign_relation('product_group','group_name','group_name',$product_group);?>
                                        </select></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="center"><input class="btn" name="submitit" type="submit" id="submitit" value="Show" /></td>
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
      <tbody>
      <tr>
      <th>SL</th>
      <th>DO# </th>
      <th>Dealer Name  </th>
      <th>Rec Date </th>
      <th>Bank Acc </th>
      <th>Received At </th>
      <th>Ck Date </th>
      <th height="20">Rec</th>
      <th>Acc Rec</th>
      <th>OK?</th>
      </tr>
	  <?


	 if(isset($_POST['t_date'])){
	 
	 	 if($_POST['product_group']!='')
	 $con .= " and d.product_group = '".$_POST['product_group']."'";
	 
	 if($_POST['receive_acc_head']!='')
	 $con .= " and a.receive_acc_head = '".$_POST['receive_acc_head']."'";
	 
	 if($_POST['received_status']!='')
	 $con .= " and a.received_status = '".$_POST['received_status']."'";
	 
	 if($_POST['f_date']!=''&&$_POST['t_date']!='')
	 $con .= " and a.do_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'";
	 
	 if($_POST['cf_date']!=''&&$_POST['ct_date']!='')
	 $con .= " and a.checked_at between '".$_POST['cf_date']."' and '".$_POST['fct_date']."'";
	 	 if($_POST['rf_date']!=''&&$_POST['rt_date']!='')
	 $con .= " and a.rec_date between '".$_POST['rf_date']."' and '".$_POST['rt_date']."'";
	
	  $i=0;
	$sql="select 
	 
a.do_no,
a.dealer_code,
concat('<b>',d.dealer_name_e,'</b>','(',product_group,')','(',d.dealer_code,')','(',b.AREA_NAME,')','(',d.account_code,')'),
b.AREA_NAME,
concat(payment_by,'@',bank,'@',branch,':',remarks),
a.rcv_amt,
a.received_amt,
a.received_status,
d.account_code,
a.receive_acc_head,
a.final_jv_no,
a.rec_date,
a.do_date,
date(a.checked_at) as checked_at,
a.acc_note
	 
	 from sale_do_master a,dealer_info d,area b where 
	 
	 a.rcv_amt>0 and a.status!='Manual' and b.AREA_CODE=d.area_code and a.dealer_code=d.dealer_code and d.dealer_type='Distributor' ".$con." ";
	 

	  $query=db_query($sql);
	  
	  while($data=mysqli_fetch_row($query)){
	  $received = $received + $data[6];
	  ?>

      <tr <? if(++$i%2==0) echo ''; else echo ' class="alt"';?>>
      <td align="center"><div align="left">
        <?=$i;?>
      </div></td>
      <td align="center"><div align="left"><b><? echo $data[0];?></b><br /><? echo $data[12];?></div></td>
      <td align="center"><div align="left"><? echo $data[2];?></div></td>
      <td align="center">

	  <?=$data[11]?></td>
      <td align="center"><div align="left">


<?=find_a_field('accounts_ledger','ledger_name','ledger_id='.$data[9]);?>

      </div></td>
      <td align="center"><div align="left"><? echo $data[4].' - '.$data[14];?></div></td>
      <td align="center"><? echo $data[13];?>&nbsp;</td>
      <td align="right"><? echo number_format($data[5],2); $rcv_total = $rcv_total +$data[5];?></td>
      <td align="right"><div align="right"><? echo number_format($data[6],2); ?></div></td>
      <td align="center"><span id="divi_<?=$data[0]?>">
            <? 
			  if(($data[10]>0))
			  {?>
Checked
<?
			  }
			  else
			  {
			  ?>
Pending<? }?>
          </span></td>
      </tr>
	  <? }}?>
	        <tr class="alt">
        <td colspan="7" align="center"><div align="right"><strong>Total Received: </strong></div></td>
        <td align="center"><div align="right">
          <?=number_format($rcv_total,2)?>
        </div></td>
        <td align="center">
          
              <div align="right">
                <?=number_format($received,2);?>
                </div></td>
        <td align="center"><div align="left"></div></td>
      </tr>
  </tbody></table>
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