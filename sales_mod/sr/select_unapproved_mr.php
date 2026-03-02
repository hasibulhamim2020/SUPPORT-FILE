<?php
session_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Unapproved Material Requisition';

do_calander('#fdate');
do_calander('#tdate');
$tr_type="Show";
$table = 'requisition_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = '../mr/mr_checking.php';
/*if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}*/

$tr_from="Warehouse";
?>
<script language="javascript">
function custom(theUrl)
{
  
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl+'','_self');
	//window.open('<?=$target_url?>');
}
</script>




  <div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group row m-0">
              <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req Approval :</label>
              <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                <select name="status" id="status" style="width:200px;">
                  <option></option>
                  <option <?=($_POST['status']=='UNCHECKED')?'selected':''?>>UNCHECKED</option>
                  <option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option>
                </select>

              </div>
            </div>
          </div>

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                  <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Form Date : </label>
                  <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                    <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>"autocomplete="off" />
                  </div>
                </div>


              </div>


              <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                  <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date : </label>
                  <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                    <input type="text" name="tdate" id="tdate" value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" autocomplete="off"/>

                  </div>
                </div>

              </div>

            </div>



          </div>


          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
            <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
          </div>

        </div>
      </div>






      <div class="container-fluid pt-5 p-0 ">
        <?
        if($_POST['status']!=''&&$_POST['status']!='ALL')
          $con .= 'and a.status="'.$_POST['status'].'"';

        if($_POST['fdate']!=''&&$_POST['tdate']!=''){
          $con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

        $res='select  	a.req_no,a.req_no, a.req_date, a.req_for, b.warehouse_name as warehouse, a.req_note as note, a.need_by, c.fname as entry_by, a.entry_at,a.status from requisition_master a,warehouse b,user_activity_management c where a.warehouse_id='.$_SESSION['user']['depot'].' and a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id '.$con.' and a.status in ("UNCHECKED") order by a.req_no';
        //echo link_report($res,'mr_print_view.php');
        $query = db_query($res);
        ?>


        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
          <tr class="bgc-info">
            <th>Req No</th>
            <th>Req Date</th>
            <th>Req For</th>

            <th>Warehouse</th>
            <th>Note</th>
            <th>Need By</th>

            <th>Entry By</th>
            <th>Entry At</th>
            <th>Status</th>

            <th>Action</th>
          </tr>
          </thead>

          <tbody class="tbody1">
          <?
          while($row = mysqli_fetch_object($query)){
            ?>


          <tr>
            <td><?=$row->req_no?></td>
            <td><?=$row->req_date?></td>
            <td><?=$row->req_for?></td>

            <td><?=$row->warehouse?></td>
            <td><?=$row->note?></td>
            <td><?=$row->need_by?></td>

            <td><?=$row->entry_by?></td>
            <td><?=$row->entry_at?></td>
            <td><?=$row->status?></td>

            <td>
			<button type="button" name="submitit" id="submitit" value="VIEW" onclick="custom(<?=$row->req_no?>);" class="btn2 btn1-bg-submit">
			<i class="fa-solid fa-eye"></i>
			</button>
			
			</td>

          </tr>



          <? }?>
          </tbody>
        </table>


        <? }?>


      </div>
    </form>
  </div>















<?php /*>


<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="fdate" id="fdate" style="width:100px;" value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:100px;" value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />
    </strong></td>
    <td rowspan="2" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
<select name="status" id="status" style="width:200px;">
<option></option>
<option <?=($_POST['status']=='UNCHECKED')?'selected':''?>>UNCHECKED</option>
<option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option>
</select>
    </strong></td>
    </tr>
</table>

</form>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<?
if($_POST['status']!=''&&$_POST['status']!='ALL')
$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

$res='select  	a.req_no,a.req_no, a.req_date, a.req_for, b.warehouse_name as warehouse, a.req_note as note, a.need_by, c.fname as entry_by, a.entry_at,a.status from requisition_master a,warehouse b,user_activity_management c where a.warehouse_id='.$_SESSION['user']['depot'].' and a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id '.$con.' and a.status in ("UNCHECKED") order by a.req_no';
echo link_report($res,'mr_print_view.php');
?>
</div></td>
</tr>
</table>



 <*/?>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>