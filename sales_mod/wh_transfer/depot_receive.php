<?php

session_start();

ob_start();


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Warehouse Receive';



do_calander('#receive_date');



$table_master='warehouse_transfer_master';

$table_details='warehouse_transfer_detail';

$unique='pi_no';



if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];



if($_REQUEST[$unique]>0){

$$unique=$_REQUEST[$unique];

$_SESSION[$unique]=$$unique;}

else

$$unique = $_SESSION[$unique];







if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$_POST['status']='COMPLETED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';

}



//if(isset($_POST['delete']))
//
//{
//
//		unset($_POST);
//
//		$_POST[$unique]=$$unique;
//
//		$_POST['edit_by']=$_SESSION['user']['id'];
//
//		$_POST['edit_at']=date('Y-m-d h:s:i');
//
//		$_POST['status']='CANCELED';
//
//		$crud   = new crud($table_master);
//
//		$crud->update($unique);
//
//		
//
//
//
//		unset($$unique);
//
//		unset($_SESSION[$unique]);
//
//		$type=1;
//
//		$msg='Canceled Remainning All Purchase Order.';
//
//}



if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

		$rec_sl_no = $_POST['rec_sl_no'];

		$receive_date = $_POST['receive_date'];

		$warehouse_from=$_POST['warehouse_from'];
		//$warehouse_to=$_POST['warehouse_to'];

		$sales_type=$_POST['sales_type'];
		
		$remarks=$_POST['remarks'];
		
		$entry_by =$_SESSION['user']['id'];

		$entry_at = date('Y-m-d H:s:i');
		
		//if($sales_type==2) {
//			$adv_sale_date=$pi_date;
//			$adv_status='PENDING';
//		}
		
		

		$sql = 'select * from warehouse_transfer_detail where pi_no = '.$pi_no;

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{

			if(($_POST['qty_chalan_'.$data->id]>0))

			{
			
				$pack_chalan=$_POST['pack_chalan_'.$data->id];

				$qty_chalan=$_POST['qty_chalan_'.$data->id];

				$vat_price=$_POST['rate_'.$data->id];

				$item_id = $_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;

				$vat_amt = ($qty_chalan*$vat_price);



journal_item_control($item_id, $data->warehouse_to, $receive_date, $qty_chalan, 0, 'Transit', $data->id, '', $warehouse_from, $pi_no);





			}

		}
		
		
		
		
		$up_sql = 'update warehouse_transfer_master set status="RECEIVED", rec_sl_no="'.$rec_sl_no.'", receive_date="'.$receive_date.'", remarks="'.$remarks.'",
		 received_by="'.$entry_by.'", received_at="'.$entry_at.'" where pi_no = '.$pi_no;
		db_query($up_sql);
		
		$up_sql_ji = 'update journal_item set tr_from="Transfered" where tr_from="Transit" and sr_no = '.$pi_no;
		db_query($up_sql_ji);



}

}

else

{

	$type=0;

	//$msg='Data Re-Submit Warning!';

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($delivery_within>0)

{

	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);

}

?>


<script>



function TRcalculation(id){

var pack_size = document.getElementById('pack_size_'+id).value*1;
var pack_chalan = document.getElementById('pack_chalan_'+id).value*1;

var qty_chalan = document.getElementById('qty_chalan_'+id).value= (pack_size*pack_chalan);

// if(unit_price<final_price)
//  {
//alert('You can`t reduce the price');
//document.getElementById('unit_price#'+id).value='';
//  } 

}


</script>


<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="50%"  border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top">

    <? $field='pi_no';?>

      <div>

        <label style="width:85px;" for="<?=$field?>">TR  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>

    <? $field='pi_date';?>

      <div>

        <label style="width:85px;" for="<?=$field?>">TR Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
	  
	  <? $field='warehouse_from'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

      <div>

        <label style="width:85px;" for="<?=$field?>">From Depot:</label>

        <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly="readonly"/>

		<input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>" required="required"/>
      </div>
	  
	  
      <div></div>
	
	
	 <? $field='warehouse_to'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

      <div>

        <label style="width:85px;" for="<?=$field?>">To Depot:</label>

        <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly="readonly"/>

		<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>" required="required"/>
      </div>

   
	  
	   
	  
	  
	  

      <div></div>

    
     


    

   

      

    </td>
    </tr>

  <tr>

    <td valign="top"><table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="depot_transfer_print_view.php?pi_no=<?=$pi_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created On:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=$entry_at?></td>
      </tr>

    </table></td>
  </tr>

  <tr>

    <td valign="top">

<?php /*?>	<? if($ex<time()){?>

	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">

      <tr>

        <td align="right" bgcolor="#FF0000"><div align="center" style="text-decoration:blink"><strong>THIS PURCHASE ORDER IS EXPIRED</strong></div></td>

        </tr>

    </table>

    <? }?><?php */?>

	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr height="30">

        <td width="16%" align="right" bgcolor="#9999FF"><strong> Date:</strong></td>

        <td width="9%" bgcolor="#9999FF"><strong>
		
		 <input style="width:120px;"  name="rec_sl_no"  type="hidden" id="rec_sl_no" value="1"/>

          <input style="width:120px;"  name="receive_date" type="text" id="receive_date" value="<?=($_POST['receive_date']!='')?$_POST['receive_date']:date('Y-m-d')?>" required="required"/>

        </strong></td>

        <td width="15%" align="right" bgcolor="#9999FF"><strong>Note:</strong></td>

        <td width="11%" bgcolor="#9999FF"><strong>

          <input style="width:120px;"  name="remarks" type="text" id="remarks" />

        </strong></td>
        </tr>
    </table></td>
    </tr>
</table>

<? if($$unique>0){

   $sql='select a.id, a.item_id, b.finish_goods_code,  b.item_name, b.unit_name, a.pkt_size, a.pkt_unit, a.total_unit as total_unit, a.unit_price, a.crt_price, a.total_amt from warehouse_transfer_detail a, item_info b 
 where b.item_id=a.item_id and a.pi_no='.$$unique;

$res=db_query($sql);

?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px;">

      <tbody>

          <tr>

            <th width="5%">SL</th>

            <th width="45%">Item Name</th>

            <th width="10%" bgcolor="#FFFFFF"> Ctn Price </th>
            <th width="10%" bgcolor="#FFFFFF">Pcs Price </th>
            <th width="10%" bgcolor="#0099CC">Ctn</th>
            <th width="10%" bgcolor="#0099CC">Pcs</th>
            <th width="10%" bgcolor="#0099CC">Amount</th>
          </tr>
          

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
 <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />
                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->c_price?>" />
				
				<input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" />
				
				<input type="hidden" name="pkt_size_<?=$row->id?>" id="pkt_size_<?=$row->id?>" value="<?=$row->pkt_size?>" onkeyup="TRcalculation(<?=$row->id?>)"  />				</td>

              <td width="6%" align="center"><?=$row->crt_price?></td>
              <td width="5%" align="center"><?=$row->unit_price?></td>
              <td width="6%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($status=="SEND"){?>

                <input name="pack_chalan_<?=$row->id?>" type="text" id="pack_chalan_<?=$row->id?>" style="width:95%; float:none" readonly="" value="<?=$row->pkt_unit?>" onkeyup="TRcalculation(<?=$row->id?>)"  />

                <? } else echo 'Done';?></td>
              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center">
			   <? if($status=="SEND"){?>

                <input name="qty_chalan_<?=$row->id?>" type="text" id="qty_chalan_<?=$row->id?>" style="width:95%; float:none" readonly="" value="<?=$row->total_unit?>"  />

                <? } else echo 'Done';?>			  </td>
              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center">
			  
			  <? if($status=="SEND"){?>

                <input name="rec_chalan_<?=$row->id?>" type="text" id="rec_chalan_<?=$row->id?>" style="width:95%; float:none" readonly="" value="<?=$row->total_amt?>"  />

                <? } else echo 'Done';?>			  </td>
          </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /><br /><br />

<table width="100%" border="0">

<? if($status=="RECEIVED"){

//$vars['status']='COMPLETED';

//db_update($table_master, $po_no, $vars, 'po_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS DESPATCH IS RECEIVED</strong></td>

</tr>

<? }else{?>

<tr>


<td align="center" width="50%">

<!--onclick="window.location = 'select_dealer_chalan.php?del=1&po_no=<?=$po_no?>';"-->
<input name="delete" type="submit" class="btn1" value="CANCEL" style="width:50%; background:#0099CC; font-weight:bold; font-size:12px;color:#000000; height:30px"  />

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center" width="50%"><input name="confirm" type="submit" class="btn1" value="CONFIRM" style="width:50%; background:#0099CC; font-weight:bold; font-size:12px; height:30px; color: #000000; float:right;" /></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>