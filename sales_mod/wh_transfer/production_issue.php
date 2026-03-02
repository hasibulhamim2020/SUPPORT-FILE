<?php

session_start();

ob_start();

require "../../support/inc.all.php";

$title='Sales to Depot';



do_calander('#pi_date','-15','0');

do_calander('#old_production_date');

$page = 'production_issue.php';

if($_POST['line_id']>0) 

$line_id = $_SESSION['line_id']=$_POST['line_id'];

elseif($_SESSION['line_id']>0) 

$line_id = $_POST['line_id']=$_SESSION['line_id'];





$table_master='production_issue_master';

$unique_master='pi_no';



$table_detail='production_issue_detail';

$unique_detail='id';







if($_SESSION[$unique_master]>0)

$$unique_master=$_SESSION[$unique_master];

elseif(isset($_GET['del']))

{

$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];

}

else

$$unique_master=$_REQUEST[$unique_master];



if(prevent_multi_submit()){

if(isset($_POST['new']))

{

		$crud   = new crud($table_master);

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['entry_by']=$_SESSION['user']['id'];

		if($_POST['flag']<1){

		$$unique_master=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Product Issued. (PI No-'.$$unique_master.')';

		}

		else {

		$crud->update($unique_master);

		$type=1;

		$msg='Successfully Updated.';

		}

}



if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{

		$table		=$table_detail;

		$crud      	=new crud($table);



		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[2];

		if($_SESSION['user']['depot']==5)

		{

		$_POST['unit_pricei']= find_a_field('item_info','p_price','item_id='.$_POST['item_id']);

		$_POST['unit_price'] = $_POST['unit_pricer']= find_a_field('item_info','f_price','item_id='.$_POST['item_id']);

		}

		elseif($_SESSION['user']['depot']==51)

		{

		$_POST['unit_price'] = $_POST['unit_pricei']= find_a_field('item_info','f_price','item_id='.$_POST['item_id']);

		}

		else

		{

		$_POST['unit_price'] = $_POST['unit_pricei']= find_a_field('item_info','f_price','item_id='.$_POST['item_id']);

		}



		$_POST['total_amt']= ($_POST['total_unit'] * $_POST['unit_price']);



		$xid = $crud->insert();

		





}

}

else

{

	$type=0;

	$msg='Data Re-Submit Error!';

}



if($del>0)

{	

		$crud   = new crud($table_detail);

		$condition=$unique_detail."=".$del;		

		$crud->delete_all($condition);

		$sql = "delete from journal_item where tr_from = 'Transit' and tr_no = '".$del."'";

		db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

}



if($$unique_master>0)

{

		$condition=$unique_master."=".$$unique_master;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}



auto_complete_from_db('item_info','finish_goods_code','concat(item_name,"#>",item_description,"#>",item_id)','product_nature="Salable"','item_id');?>





<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}

function recal() {

document.getElementById('total_unit').value = (((document.getElementById('total_pkt').value)*1)*((document.getElementById('pkt_size').value)*1))+((document.getElementById('total_pcs').value)*1);

}

</script>

<div class="form-container_large">

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><fieldset style="width:240px;">

    <div>

      <label style="width:75px;">TR No : </label>



      <input style="width:155px;"  name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

    </div>

    <div>

      <label style="width:75px;">Carried by : </label>



          <label>

          <input type="text" name="carried_by" id="carried_by" value="<?=$carried_by?>" style="width:155px;" required/>

          </label>

      </div>
	  
	  
	  
	  <div>

      <label style="width:75px;">Note : </label>



          <label>

          <input type="text" name="remarks" id="remarks" value="<?=$remarks?>" style="width:155px;" />

          </label>

      </div>

    </fieldset></td>

    <td>

			<fieldset style="width:220px;">

			  <div>

			    <label style="width:105px;"><span style="width:75px;">TR</span> Date : </label>

			    <input style="width:105px;"  name="pi_date" type="text" id="pi_date" value="<?=$pi_date?>" required/>

	        </div>

			  <div>

			    <label style="width:105px;">S/L No: </label>

			    <input name="remarks" type="text" id="remarks" style="width:105px;" value="<?=$sl_no?>" tabindex="105" required />

		      </div>

		</fieldset>	</td>

    <td><fieldset style="width:240px;">

      <div>

        <label style="width:75px;">From: </label>

        <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$_SESSION['user']['depot']?>" />

        <input name="warehouse_from3" type="text" id="warehouse_from3" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" />

      </div>

      

            <div>

        <label style="width:75px;">Depot: </label>

        <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$line_id?>" />

        <input name="warehouse_from4" type="text" id="warehouse_from4" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" />

      </div>

    </fieldset></td>

  </tr>



  <tr>

    <td colspan="3"><div class="buttonrow" style="margin-left:240px;">

    <? if($$unique_master>0) {?>

<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />

<input name="flag" id="flag" type="hidden" value="1" />

<? }else{?>

<input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />

<input name="flag" id="flag" type="hidden" value="0" />

<? }?>

    </div></td>

    </tr>

	  <tr>

    <td colspan="3">&nbsp;</td>

  </tr>

</table>

</form>

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<? if($$unique_master>0){?>

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

  <tr>

    <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>

    <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">Unit</span></td>

    <td align="center" bgcolor="#0099FF"><strong>Stock</strong> </td>

    <td align="center" bgcolor="#0099FF"><strong>Rate</strong></td>
    <td align="center" bgcolor="#0099FF"><strong>Kg</strong></td>

    <td  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">

      <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update" onclick="recal();"/>

    </div></td>
  </tr>

  <tr>

    <td align="center" bgcolor="#CCCCCC"><div align="center">

      <input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>

      <input  name="warehouse_from2" type="hidden" id="warehouse_from2" value="<?=$warehouse_from?>"/>

      <input  name="warehouse_to2" type="hidden" id="warehouse_to2" value="<?=$warehouse_to?>"/>

      <input  name="pi_date" type="hidden" id="pr_date" value="<?=$pi_date?>"/>

      <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:350px;" required onblur="getData2('production_receive_ajax_fg.php', 'pr', this.value, document.getElementById('warehouse_from').value);"/>

      <input name="remarks" type="hidden" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" />

    </div></td>

    <td colspan="3" align="center" bgcolor="#CCCCCC"><div align="center"><span id="pr">

      <input name="total_unit2" type="text" class="input3" id="total_unit2"  maxlength="100" style="width:50px;" required/>

    
        <input name="old_production_date" type="text" class="input3" id="stock2"  maxlength="100" style="width:60px;"/>
        <input name="old_production_date2" type="text" class="input3" id="rate2"  maxlength="100" style="width:60px;"/>
       </span> </div></td>

    <td align="center" bgcolor="#CCCCCC">
<input name="total_unit" type="hidden" class="input3" id="total_unit"  maxlength="100" style="width:40px;" required/>
        <input name="total_pkt" type="hidden" class="input3" id="total_pkt"  maxlength="100" style="width:40px;" required/><input name="total_pcs" type="number" class="input3" id="total_pcs"  maxlength="100" style="width:60px;" required value="0" min="1"/></td>
  </tr>
</table>

<br /><br /><br /><br />



<? 



//$res='select a.id,b.finish_goods_code as code,b.item_name,b.unit_name,FLOOR(a.total_unit/b.pack_size) as total_qty,a.total_unit%b.pack_size as pcs_qty,"X" from production_issue_detail a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';


$res='select a.id,b.finish_goods_code as FG_code,b.item_name,b.unit_name,FLOOR(a.total_unit/b.pack_size) as total_qty,"X" from production_issue_detail a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td><div class="tabledesign2">

        <? 

echo link_report_del($res);

		?>



      </div></td>

    </tr>

	    	

	



				

    <tr>

     <td>



 </td>

    </tr>

  </table>



</form>

<form action="select_unfinished_depot_transfer.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="100%" border="0">

  <tr>

      <td align="center"><input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">

      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND PI" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />

      </td>

      

    </tr>

</table>





<? }?>

</form>

</div>

<script>$("#cz").validate();$("#cloud").validate();</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>