<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Work Order Create';

do_calander('#wo_date');

do_calander('#chalan_date');

$table='lc_workorder';

$unique='id';



$wo_id=$_SESSION['wo_id']=$_POST['wo_id'];



if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST['id']=$wo_id;

		$_POST['status']='DONE';

		$crud   = new crud('lc_workorder');

		$crud->update('id');

		unset($wo_id);

		unset($_SESSION['wo_id']);

		$type=1;

		$msg='Successfully Send to Factory.';

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
		$_POST['entry_at']=time();
		$table		='lc_workorder_chalan';
		$crud      	=new crud($table);
		$crud->insert();
		$sdate=time();
		$wo_id=$_POST['wo_id'];
		$sql='select a.ledger_id from lc_buyer a,  lc_workorder b where a.id=b.buyer_id and b.id='.$wo_id;
		$ledger=find_a_field_sql($sql);
		$sales_ledger='200000000';
		$order_id=$_POST['specification_id'];
		$qty=$_POST['qty'];
		$sql='select e.billing_unit_id as unit_id,b.rate as rate from lc_workorder_details b,lc_product_item e where e.id=b.item_id and b.id='.$order_id;
		$all=find_all_field_sql($sql);
		if($all->unit_id==3)
		$amt=($all->rate)*($qty/12);
		else
		$amt=($all->rate)*($qty);
		
		if($amt>0)
		auto_insert_sales($sdate,$ledger,$sales_ledger,$order_id,$amt);
		
}





?><div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><fieldset>


      <div>

        <label for="email">Work Order Date : </label>
<input  name="id" type="hidden" id="id" value="<?=$_SESSION['wo_id']?>"/>
        <input  name="wo_date" type="text" id="wo_date" value="<?=$wo_date?>"/>

      </div>

      <div>

        <label for="email">Party Name : </label>

        <select id="buyer_id" name="buyer_id">

        <? foreign_relation('lc_buyer','id','buyer_name',$buyer_id);?>

        </select>

      </div>

      <div>
        <label for="email">Buyer Name : </label>
        <input  name="buyer" type="text" id="buyer" value="<?=$buyer?>" />
      </div>
      <div>

        <label for="email">Prepared By : </label>

        <input  name="prepared_bys" type="text" id="prepared_bys" value="<?=find_a_field('user_activity_management','fname','user_id='.$prepared_by)?>" readonly="readonly"/>

        <input  name="prepared_by" type="hidden" id="prepared_by" value="<?=$_SESSION['user']['id']?>" readonly="readonly" />

      </div>
<div>

        <label for="email">WO From: </label>

        <input  name="for" type="for" id="for" value="<?=$for?>" readonly="readonly"/>

      </div>
    </fieldset></td>

    <td>

			<fieldset>

			<div>

			<label>Work Order No : </label> 

			<input  name="ppp" type="text" id="ppp" value="<?=$wo_id?>" readonly="readonly"/>

			</div>

			<div>

			<label>Work Order For : </label> 

			<input  name="wo_subject" type="text" id="wo_subject" value="<?=$wo_subject?>"/>

			</div>

			<div>

			<label for="email">Details : </label>

            <textarea name="wo_detail" style="height:50px; width:140px" id="wo_detail"><?=$wo_detail ?></textarea>

			</div>
<div>
			<label for="thickness">Thickness : </label>
            <input  name="thickness" type="text" id="thickness" value="<?=$thickness?>"/>
			</div>
			</fieldset>	</td>

  </tr>

  <tr>

    <td colspan="2">



    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006600" style="color:#CCC">

      <tr>

        <td align="center" <? if($status=='UNCHECKED') echo 'bgcolor="#FF0000"'; elseif($status=='CHECKED') echo 'bgcolor="#009900"';elseif($status=='DONE') echo 'bgcolor="#FC0"';?>  style="height:30px; color:#FFF; font-size:18px;"><strong><?=$status?>
           <a target="_blank" href="../report/work_order_factory_print.php?wo_id=<?=$_SESSION['wo_id']?>">
           <img src="../../images/print.png" width="26" height="26" /></a></strong></td>

      </tr>

    </table></td>

    </tr>

</table>

</form>

<? if($wo_id>0){

$res='select a.id,a.id as order_id ,b.item_name,a.style_no,a.specification,a.meassurment,a.qty,(select sum(qty) from lc_workorder_chalan where a.id=specification_id) as chalan_qty, (select a.qty-sum(qty) from lc_workorder_chalan where a.id=specification_id) as balance_qty from lc_workorder_details a,lc_product_item b where b.id=a.item_id and a.wo_id='.$wo_id;

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td><div class="tabledesign2">

        <p>

          <? 

echo link_report($res);

		?>

        </p>

      </div></td>

    </tr>

	

    <tr>

     <td>



 </td>

    </tr>

  </table>

<form action="?req_id=<?=$req_id?>" method="post" name="cloud" id="cloud">

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                            <td colspan="6" align="center" bgcolor="#CCCCFF"><strong>CHALAN DELIVER</strong></td>

      </tr>

                      <tr>

                        <td align="center" bgcolor="#0099FF"><strong>Item Specification</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Delivery Place</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Chalan From</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Chalan Date</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Chalan Qty</strong></td>

                        <td rowspan="2" align="center" bgcolor="#FF0000"><div class="button">

                          <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>

                        </div></td>

      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC"><span id="inst_no">
  
  <select name="specification_id" id="specification_id" style="width:300px">
    
    <? $sql="select c.id,concat(b.category_name,'-',a.item_name,' (',c.style_no,'::',c.specification,'::',c.meassurment,')') from lc_product_item a,lc_product_category b,lc_workorder_details c where c.item_id=a.id and a.product_category_id=b.id and c.wo_id=".$wo_id;

advance_foreign_relation($sql,$value='');

?>
    
    </select>
  
  <input  name="wo_id" type="hidden" id="wo_id" value="<?=$wo_id?>"/>
  
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="delivery_place" type="text" class="input3" id="delivery_place"  maxlength="400" style="width:100px;"/></td>
<td align="center" bgcolor="#CCCCCC"><select name="chalan_from" id="chalan_from"style="width:60px;">
<option value="Total Trims">TT</option>
<option value="Netrokona Accories">NAL</option>
</select></td>
<td align="center" bgcolor="#CCCCCC"><input name="chalan_date" type="text" class="input3" id="chalan_date"  maxlength="400" style="width:60px;"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:60px;"/></td>

</tr>

    </table>
					  <br /><br /><br /><br />
<?

$res="select d.id,d.id as chalan_id,concat(b.category_name,'-',a.item_name,' (',c.style_no,'::',c.specification,'::',c.meassurment,')') as item,d.delivery_place,d.chalan_from,d.chalan_date,d.qty,'Print' from lc_product_item a,lc_product_category b,lc_workorder_details c,lc_workorder_chalan d where c.item_id=a.id and a.product_category_id=b.id and c.id=d.specification_id  and c.wo_id=".$wo_id;





?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td><div class="tabledesign2">

        <? 

//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';

echo link_report_add_report($res);

		?>

      </div></td>

    </tr>

	

    <tr>

     <td>



 </td>

    </tr>

  </table>

<table width="100%" border="0">

  <tr>

      <td align="center"><p>&nbsp;</p>

        <table width="1%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td><input name="confirm" type="submit" class="btn1" value="ALL CHALAN COMPLETE FOR THIS WORKORDER" style="width:370px; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>

        </tr>

    </table></td>

      

    </tr>

</table>

</form>

<? }?>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>