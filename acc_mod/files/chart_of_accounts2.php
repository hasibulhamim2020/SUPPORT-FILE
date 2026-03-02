<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Chart Of Accounts';
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
?>
<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'ledger_account2_report.php?g_id='+theUrl;
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div class="box">
                <form id="form1" name="form1" method="post" action="">
                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    <tr>
                      <td width="40%" align="right"> Class : </td>
                      <td width="60%" align="right"><select name="group_class" id="group_class">
                          <option value="">All</option>
                          <option value="1000" <?=($_REQUEST['group_class']==1000?"selected":"")?>>Asset</option>
                          <option value="2000" <?=($_REQUEST['group_class']==2000?"selected":"")?>>Expense</option>
                          <option value="3000" <?=($_REQUEST['group_class']==3000?"selected":"")?>>Income</option>
                          <option value="4000" <?=($_REQUEST['group_class']==4000?"selected":"")?>>Liabilities</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td align="right">Group name : </td>
                      <td align="right"><? auto_complete_from_db('ledger_group','group_name','group_name','1 order by group_name asc ','ladger_group');?>
                        <input name="ladger_group" type="text" id="ladger_group" value="<?php echo $_REQUEST['ladger_group']; ?>" size="20" /></td>
                    </tr>
                    <?
									//  if($_POST['ladger_group']!=""){ $group_id = find_a_field('ledger_group','group_id' ,'group_name ="'.$_POST['ladger_group'].'"');
									  ?>
                    <tr>
                      <td align="right">Ledger Name </td>
                      <? auto_complete_from_db('accounts_ledger','ledger_name','ledger_name','1 and ledger_id like "%00000000" order by ledger_name asc ','ledger_name');?>
                      <td align="right"><input name="ledger_name" type="text" id="ledger_name" value="<?php echo $_REQUEST['ledger_name']; ?>" size="20" /></td>
                    </tr>
                    <? //}?>
                    <tr>
                      <td align="right">&nbsp;</td>
                      <td align="right">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2"><input class="btn" name="search" type="submit" id="search" value="Show" /></td>
                    </tr>
                  </table>
                </form>
              </div></td>
          </tr>
          <tr>
            <td align="right"><? include('PrintFormat.php');?></td>
          </tr>
          <tr>
            <td><div id="reporting">
                <table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
                  <thead>
                    <tr>
                      <th>Ledger Group</th>
                      <th>Accounts Ledger </th>
                      <th>Sub Ledger </th>
                      <th>Sub Sub Ledger </th>
                    </tr>
                  </thead>
                  <?php

	if($_REQUEST['ladger_group']!="" && $_REQUEST['group_class']==""){$con.= " and group_name LIKE '%". mysqli_real_escape_string($_REQUEST['ladger_group'] )."%'";}
	
	if($_REQUEST['group_class']!="" && $_REQUEST['ladger_group']==""){$con.= " and group_class LIKE '%". mysqli_real_escape_string($_REQUEST['group_class'] )."%'";}
	
	
	
	if($_REQUEST['group_class']!="" && $_REQUEST['ladger_group']!="" ){$con.= " and group_name LIKE '%". mysqli_real_escape_string($_REQUEST['ladger_group'] )."%' and group_class LIKE '%". mysqli_real_escape_string($_REQUEST['group_class'] )."%'";}
	

	 $rrr = "select group_id,group_name,group_class,group_under from ledger_group where 1 ".$con." order by group_name asc";
	
	//echo $rrr;
	$report = db_query($rrr);
	while($rp=mysqli_fetch_row($report)){?>
                  <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                    <td style="color:red;font-size:12px;">&nbsp;
                      <?=$rp[1];?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;
                      <? //if($rp[2] == 1000){
//									echo "Asset";
//									
//								}elseif($rp[2] == 4000){
//									echo "Expense";
//								}elseif($rp[2] == 3000){
//									echo "Income";
//									
//								}else{
//									echo "Liabilities";
//								}?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?
							  if($_REQUEST['ledger_name']!="" ){$l_con.= " and ledger_name LIKE '%". mysqli_real_escape_string($_REQUEST['ledger_name'] )."%'";}
							  $acc_sql = 'select * from accounts_ledger where  ledger_id like "%00000000" and ledger_group_id = '.$rp[0].' '.$l_con.' order by ledger_name asc';
							  $acc_query = db_query($acc_sql);	
							  while($r = mysqli_fetch_object($acc_query)){						  ?>
                  <tr>
                    <td></td>
                    <td style="color:blue;font-size:11"><?=$r->ledger_name;?></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <? 
							   $sub_sql = 'select * from sub_ledger where ledger_id='.$r->ledger_id.' order by sub_ledger asc';
							  $sub_query = db_query($sub_sql);	
							  while($s = mysqli_fetch_object($sub_query)){?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td style="color:green;font-size:10"><?=$s->sub_ledger?></td>
                    <td></td>
                  </tr>
                  <?  $sub_sub_sql = 'select * from sub_sub_ledger where sub_ledger_id='.$s->sub_ledger_id.' order by sub_sub_ledger asc';
							  $sub_sub_query = db_query($sub_sub_sql);	
							  while($ss = mysqli_fetch_object($sub_sub_query)){?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="color:#666666;font-size:10"><?=$ss->sub_sub_ledger?></td>
                  </tr>
                  <? } }}?>
                  <?php }?>
                </table>
              </div>
              <!--<div id="pageNavPosition">--></div></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
<!--<script type="text/javascript">
    var pager = new Pager('grp', 100);
    pager.init();
    pager.showPageNav('pager', 'pageNavPosition');
    pager.showPage(1);
</script>
<script type="text/javascript">
	document.onkeypress=function(e){
	var e=window.event || e
	var keyunicode=e.charCode || e.keyCode
	if (keyunicode==13)
	{
		return false;
	}
}
</script>-->
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>