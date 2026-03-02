<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Quotation Approval List';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_requisition_master';
$unique_master='do_no';

$table_detail='sale_requisition_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$$unique_master=$_POST[$unique_master];
$tr_type="Show";
if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		$crud   = new crud($table_chalan);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
		$tr_type="Delete";
}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
    $tr_type="Confirmed";
		$msg='Successfully Instructed to Depot.';
}


$table='sale_requisition_master';
$show='dealer_code';
$id='do_no';
$text_field_id='old_do_no';

$target_url = '../do/do_check.php';

?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?do_no='+theUrl);
}
</script>







  <div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">

      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date:</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />
              </div>
            </div>

          </div>
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                 <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />

              </div>
            </div>
          </div>

          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>
    </form>





      <div class="container-fluid pt-5 p-0 ">

        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
          <tr class="bgc-info">
            <th>Req. No</th>
            <th>Req. Date</th>
            <th>Dealer Name</th>

            <th>Rcv. Amount</th>
            <th>Money Rcv No</th>
            <th>Action</th>
          </tr>
          </thead>

          <tbody class="tbody1">


          <?

          if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


          if($_POST['product_group']=='ABCD') $con .= ' and d.product_group != "M"';
          elseif($_POST['product_group']!='') $con .= ' and d.product_group = "'.$_POST['product_group'].'"';

          //$res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e,'(',team_name,')') as dealer_name, a.AREA_NAME, concat(m.payment_by) as Payment_Details,m.rcv_amt, m.mr_no from
          //sale_requisition_master m,dealer_info d, area a
          //where m.status in ('PROCESSING') and d.area_code=a.AREA_CODE  and m.dealer_code=d.dealer_code ".$con." and d.dealer_type='Distributor' order by m.do_date,d.dealer_name_e";




         $res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,  concat(m.payment_by) as Payment_Details,m.rcv_amt from
sale_requisition_master m,dealer_info d
where m.status in ('PROCESSING')  and m.dealer_code=d.dealer_code ".$con." order by m.do_date,d.dealer_name_e";
          $query = db_query($res);
          while($data = mysqli_fetch_object($query))
          {
            ?>
            <tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
              <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;Q-000<?=$data->do_no;?></td>
              <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_date;?></td>
              <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?> style="text-align:left">&nbsp;<?=$data->dealer_name;?></td>
              <td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->rcv_amt;?></td>
              <td><?=$data->mr_no;?></td>
              <td>
                <? if($data->RCV_AMT>0&$data->do_date==date('Y-m-d')){?>
                  <form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
                    <input  name="do_no" type="hidden" id="do_no" value="<?=$data->do_no;?>"/>
                    <input name="confirm" type="submit" value="SEND" class="btn1 btn1-bg-submit" />
                  </form>
                <? }?>
              </td>

            </tr>

            <?
            $total_send_amt = $total_send_amt + $data->SEND_AMT;
            $total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
          }

          ?>
          <tr>
            <td class="bg-table1" colspan="3"><strong>Total:</strong></td>
            <td class="bg-table1" colspan="0"><strong><?=number_format($total_send_amt,2);?></strong></td>
            <td class="bg-table1" colspan="1"><strong><?=number_format($total_rcv_amt,2);?></strong></td>
            <td class="bg-table1">&nbsp;</td>
          </tr>


          </tbody>
        </table>

      </div>

  </div>











<?php /*?><div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=$fdate?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=$tdate?>" />
        </strong></td>
        <td rowspan="2" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
        </strong></td>
      </tr>
      
    </table>
  </form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th>Req. No</th>
  <th>Req. Date</th>
  <th>Dealer Name</th><th>RCV AMT</th>
  <th>MONEY RCV NO </th>
  <th>&nbsp;</th>
  </tr>


<? 



if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


if($_POST['product_group']=='ABCD') $con .= ' and d.product_group != "M"';
elseif($_POST['product_group']!='') $con .= ' and d.product_group = "'.$_POST['product_group'].'"';

//$res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e,'(',team_name,')') as dealer_name, a.AREA_NAME, concat(m.payment_by) as Payment_Details,m.rcv_amt, m.mr_no from 
//sale_requisition_master m,dealer_info d, area a
//where m.status in ('PROCESSING') and d.area_code=a.AREA_CODE  and m.dealer_code=d.dealer_code ".$con." and d.dealer_type='Distributor' order by m.do_date,d.dealer_name_e";




 $res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,  concat(m.payment_by) as Payment_Details,m.rcv_amt from 
sale_requisition_master m,dealer_info d
where m.status in ('PROCESSING')  and m.dealer_code=d.dealer_code ".$con." order by m.do_date,d.dealer_name_e";
$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;Q-000<?=$data->do_no;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_date;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->rcv_amt;?></td>
<td>&nbsp;
    <?=$data->mr_no;?></td>
<td><? if($data->RCV_AMT>0&$data->do_date==date('Y-m-d')){?>
<form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
      <input  name="do_no" type="hidden" id="do_no" value="<?=$data->do_no;?>"/>
      <input name="confirm" type="submit" value="SEND" class="btn1 btn1-bg-submit" />
</form>
  <? }?>

</td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
}

?>
<tr class="alt"><td colspan="3"><span style="text-align:right;"> Total: </span></td><td colspan="0"><?=number_format($total_send_amt,2);?></td>
  <td colspan="1"><?=number_format($total_rcv_amt,2);?></td>
  <td>&nbsp;</td>
  </tr>

</tbody>
</table>
</div>
</td>
</tr>
</table>
</div><?php */?>
 




<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>