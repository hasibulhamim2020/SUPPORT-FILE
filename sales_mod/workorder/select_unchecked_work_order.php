<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Work Order Create';
do_calander('#wo_date');
$table='lc_workorder';
$unique='id';


if(isset($_POST['new']))
{

		$crud   = new crud($table);
		$_POST['prepared_at']=date('Y-m-d H:i:s');
		if(!isset($_SESSION['wo_id'])){
		$wo_id=$_SESSION['wo_id']=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Work Order Initialized. (WORK ORDER ID-'.$wo_id.')';
		}
		else {
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
}

$wo_id=$_SESSION['wo_id'];

if(isset($_POST['delete']))
{

		$crud   = new crud('lc_workorder');
		$condition="id=".$wo_id;		
		$crud->delete($condition);
		$crud   = new crud('lc_workorder_details');
		$condition="wo_id=".$wo_id;		
		$crud->delete_all($condition);
		unset($wo_id);
		unset($_SESSION['wo_id']);
		$type=1;
		$msg='Successfully Deleted.';
}


if($wo_id>0)
{
		$condition=$unique."=".$wo_id;
		$data=db_fetch_object($table,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}

if(isset($_POST['add'])&&($_POST['wo_id']>0))
{
		$table		='lc_workorder_details';
		$crud      	=new crud($table);
		$crud->insert();
}


?><div class="form-container_large">
<form action="unchecked_work_order.php" method="post" name="codz" id="codz">
<table width="70%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Unchecked Work Order List: </strong></td>
    <td bgcolor="#FF9966"><strong>
      <select name="wo_id" id="wo_id">
        <? foreign_relation('lc_workorder','id','id',$wo_id,'status="UNCHECKED"');?>
      </select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW WORK ORDER" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>