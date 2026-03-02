<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";



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









  <div class="form-container_large">

    <form  id="form1" name="form1" method="post" action="">
      <div class="d-flex  justify-content-center">

        <div class="n-form1 fo-short pt-2">
          <div class="container">
            <div class="form-group row  m-0 mb-1 pl-3 pr-3">
              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Class :</label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                <select name="group_class" id="group_class" width="50%">
                  <option value="">All</option>
                  <option value="1" <?=($_REQUEST['group_class']==1?"selected":"")?>>Asset</option>
                  <option value="4" <?=($_REQUEST['group_class']==4?"selected":"")?>>Expense</option>
                  <option value="3" <?=($_REQUEST['group_class']==3?"selected":"")?>>Income</option>
                  <option value="2" <?=($_REQUEST['group_class']==2?"selected":"")?>>Liabilities</option>
                </select>

              </div>
            </div>

          </div>

          <div class="n-form-btn-class">
            <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
          </div>

        </div>

      </div>

    </form>




    <div class="container-fluid">
      <p class="#"> <? include('PrintFormat.php');?></p>



      <div id="reporting">
        <div id="grp">

          <table class="table1  table-striped table-bordered table-hover table-sm">

            <thead class="thead1">
            <tr class="bgc-info">
              <th>Class</th>
              <th>Sub Class</th>
			  <th>Accounts Sub Class</th>
              <th>Ledger Group</th>
              <th>Accounts Ledger </th>
              </tr>
            </thead>
            <tbody class="tbody1">


            <?php

            if($_REQUEST['group_class']>0){
            $con.= " and id=".$_REQUEST['group_class']."";
            
            }
            $tr_type="Search";



            //if($_REQUEST['group_class']!="" && $_REQUEST['ladger_group']!="" ){$con.= " and group_name LIKE '%". mysqli_real_escape_string($_REQUEST['ladger_group'] )."%' and group_class LIKE '%". mysqli_real_escape_string($_REQUEST['group_class'] )."%'";}


            $a = "select id,class_name from acc_class where 1 ".$con." ";
            $aqry = db_query($a);
            while($adata=mysqli_fetch_row($aqry)){?>
              <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                <td>&nbsp;<?=$adata[1];?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>

              <?  $b = "select id,sub_class_name from acc_sub_class where acc_class=".$adata[0]." order by sub_class_name asc";
              $bqry = db_query($b);
              while($bdata=mysqli_fetch_row($bqry)){?>
                <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                  <td>&nbsp;</td>
                  <td><?=$bdata[1];?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
				        <?
                $rrr_ssc = "select id,sub_sub_class_name,acc_sub_class from  acc_sub_sub_class where acc_sub_class=".$bdata[0]." order by sub_sub_class_name asc";
                $report_ssc = db_query($rrr_ssc);
                while($rpssc=mysqli_fetch_row($report_ssc)){?>
                  <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><?=$rpssc[1];?>  </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <?
                 
                 $rrr = "select group_id,group_name,acc_sub_sub_class from ledger_group where acc_sub_sub_class=".$rpssc[0]." order by group_name asc";
                $report = db_query($rrr);
                while($rp=mysqli_fetch_row($report)){?>
                  <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
					 <td>&nbsp;</td>
                    <td><?=$rp[1];?> <?=$rp[0];?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?

                  $acc_sql = 'select * from accounts_ledger where  ledger_group_id = '.$rp[0].' order by ledger_name asc';
                  $acc_query = db_query($acc_sql);
                  while($r = mysqli_fetch_object($acc_query)){?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
					   <td></td>
                      <td><?=$r->ledger_name;?> <?=$r->ledger_id;?></td>
                    </tr>
                    <?
                    }?>
                <?php } } }}?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>








<?php /*>
  <br>
<br>
<br>
<br>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div class="box">
                <form id="form1" name="form1" method="post" action="">
                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    <tr>
                      
                      <td colspan="2" align="center">Class :
                        <select name="group_class" id="group_class" width="50%">
                          <option value="">All</option>
                          <option value="1" <?=($_REQUEST['group_class']==1?"selected":"")?>>Asset</option>
                          <option value="4" <?=($_REQUEST['group_class']==4?"selected":"")?>>Expense</option>
                          <option value="3" <?=($_REQUEST['group_class']==3?"selected":"")?>>Income</option>
                          <option value="2" <?=($_REQUEST['group_class']==2?"selected":"")?>>Liabilities</option>
                        </select>
                      </td>
                    </tr>
                   
                    <tr>
                      <td align="right">&nbsp;</td>
                      <td align="right">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" /></td>
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
                      <th>Class</th>
					  <th>Sub Class</th>
					  <th>Ledger Group</th>
                      <th>Accounts Ledger </th>
                      <th>Sub Ledger </th>
                      <th>Sub Sub Ledger </th>
                    </tr>
                  </thead>

                  <?php
	
	if($_REQUEST['group_class']>0){$con.= " and id=".$_REQUEST['group_class']."";}
	
	
	
	//if($_REQUEST['group_class']!="" && $_REQUEST['ladger_group']!="" ){$con.= " and group_name LIKE '%". mysqli_real_escape_string($_REQUEST['ladger_group'] )."%' and group_class LIKE '%". mysqli_real_escape_string($_REQUEST['group_class'] )."%'";}
	

	$a = "select id,class_name from acc_class where 1 ".$con."";
	$aqry = db_query($a);
	while($adata=mysqli_fetch_row($aqry)){?>
                  <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                    <td style="color:red;font-size:12px;">&nbsp;<?=$adata[1];?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                  </tr>
				  
				<?  $b = "select id,sub_class_name from acc_sub_class where acc_class=".$adata[0]." order by sub_class_name asc";
	$bqry = db_query($b);
	while($bdata=mysqli_fetch_row($bqry)){?>
                  <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                    <td style="color:red;font-size:12px;">&nbsp;</td>
                    <td><?=$bdata[1];?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                  </tr>
                  <?
				  $rrr = "select group_id,group_name,group_class from ledger_group where acc_sub_class=".$bdata[0]." order by group_name asc";
	$report = db_query($rrr);
	while($rp=mysqli_fetch_row($report)){?>
                  <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
                    <td style="color:red;font-size:12px;">&nbsp;</td>
					<td>&nbsp;</td>
                    <td><?=$rp[1];?><br><?=$rp[0];?></td>
                    <td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                  </tr>
                  <?
							  
							  $acc_sql = 'select * from accounts_ledger where  ledger_group_id = '.$rp[0].' order by ledger_name asc';
							  $acc_query = db_query($acc_sql);	
							  while($r = mysqli_fetch_object($acc_query)){?>
                  <tr>
                    <td></td>
					<td></td>
					<td></td>
                    <td style="color:blue;font-size:11"><?=$r->ledger_name;?><br><?=$r->ledger_id;?></td>
                    
                    
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                  </tr>
                  <? 
							   $sub_sql = 'select * from accounts_ledger where ledger_layer=2 and under_ledger = '.$r->ledger_id.' order by ledger_name asc';
							  $sub_query = db_query($sub_sql);	
							  while($s = mysqli_fetch_object($sub_query)){?>
                  <tr>
                    <td></td>
                    <td></td>
					<td></td>
					<td>&nbsp;</td>
                    <td style="color:green;font-size:10"><?=$s->ledger_name?><br><?=$s->ledger_id;?></td>
                    
					<td>&nbsp;</td>
                  </tr>
                  <?  $sub_sub_sql = 'select * from accounts_ledger where ledger_layer=3 and under_ledger = '.$s->ledger_id.' order by ledger_name asc';
							  $sub_sub_query = db_query($sub_sub_sql);	
							  while($ss = mysqli_fetch_object($sub_sub_query)){?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                    <td style="color:#666666;font-size:10"><?=$ss->ledger_name?></td>
                  </tr>
                  <? } }}?>
                  <?php } } }?>
                </table>
              </div>
              </div></td>
          </tr>
        </table>
  <*/?>


<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>