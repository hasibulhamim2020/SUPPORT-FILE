<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$depot=$_SESSION['user']['depot'];

$title='Demand Order Create';

do_calander('#est_date');

do_calander('#do_date');

$page = 'do.php';

$depot_id = $_POST['depot_id'];

if($_POST['dealer']>0) 

$dealer_code = $_POST['dealer'];

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

//$depot_id = find_a_field('warehouse','warehouse_name','warehouse_id='.$dealer->depot);

$table_master='sale_do_master';

$unique_master='do_no';

$table_detail='sale_do_details';

$unique_detail='id';

if($_REQUEST['old_do_no']>0)

$$unique_master=$_REQUEST['old_do_no'];

elseif(isset($_GET['del']))

{$$unique_master=find_a_field('sale_do_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}

else

$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){

if(isset($_POST['new']))

{
		$crud   = new crud($table_master);

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['entry_by']=$_SESSION['user']['id'];

		if($_POST['flag']<1){

		$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;

		$$unique_master=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';

		}



		else {



		$crud->update($unique_master);



		$type=1;



		$msg='Successfully Updated.';



		}



}





if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{
$details_insert = new crud($table_detail)	;
$_POST['unit_price']=$_POST['unit_price2'] ;
$details_insert->insert();
unset($$unique);
$type=1;
$msg='Item Entry Succesfull';
}



}



else



{



	$type=0;



	$msg='Data Re-Submit Error!';



}







if($del>0)



{	







		$main_del = find_a_field($table_detail,'gift_on_order','id = '.$del);



		$crud   = new crud($table_detail);



		if($del>0)



		{



			$condition=$unique_detail."=".$del;		



			$crud->delete_all($condition);



			



			$condition="gift_on_order=".$del;		



			$crud->delete_all($condition);



			



			if($main_del>0){



			$condition=$unique_detail."=".$main_del;		



			$crud->delete_all($condition);



			$condition="gift_on_order=".$main_del;		



			$crud->delete_all($condition);}



		}



		$type=1;



		$msg='Successfully Deleted.';



}











if($$unique_master>0)



{



		$condition=$unique_master."=".$$unique_master;



		$data=db_fetch_object($table_master,$condition);



		while (list($key, $value)=@each($data))



		{ $$key=$value;}



		



}



		$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);



		if($dealer->product_group!='M') $dgp = $dealer->product_group;



auto_complete_start_from_db('item_info','concat(finish_goods_code,"#>",item_name)','finish_goods_code','product_nature="Salable" order by finish_goods_code ASC','item');



?>



<script language="javascript">



function count()



{



if(document.getElementById('pkt_unit').value!=''){

var pkt_unit = ((document.getElementById('pkt_unit').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);

var pkt_size = 1;

var unit_price2 = ((document.getElementById('unit_price2').value)*1);



var total_unit = (pkt_unit*1)+dist_unit;



if(unit_price2==0)

var unit_price =0;

else

var unit_price = ((document.getElementById('unit_price2').value)*1);

var total_amt  = (total_unit*unit_price);



document.getElementById('total_unit').value=total_unit;



document.getElementById('total_amt').value	= total_amt.toFixed(2);



var do_total = ((document.getElementById('do_total').value)*1);



var do_ordering	= total_amt+do_total;



document.getElementById('do_ordering').value =do_ordering.toFixed(2);



}



else



document.getElementById('dist_unit').focus();



}



</script>







<script language="javascript">



function focuson(id) {
  if(document.getElementById('item').value=='')
  document.getElementById('item').focus();
  else
  document.getElementById(id).focus();
}







window.onload = function() {

if(document.getElementById("flag").value=='0')
  document.getElementById("rcv_amt").focus();
  else
  document.getElementById("item").focus();
}



</script>



<script language="javascript">



function grp_check(id)



{



if(document.getElementById("item").value!=''){



var myCars=new Array();



myCars[0]="01815224424";



<?



//$item_i = 1;



//$sql_i='select finish_goods_code from item_info where product_nature="Salable"';



//$query_i=db_query($sql_i);



//while($is=mysqli_fetch_object($query_i))



//{



	//echo 'myCars['.$item_i.']="'.$is->finish_goods_code.'";';



	//$item_i++;



//}



?>



//var item_check=id;



//var f=myCars.indexOf(item_check);



//if(f>0)

getData2('do_ajax_s.php', 'do',document.getElementById("item").value,'<?=$depot_id;?>');


 


//else



//{



//alert('Item is not Accessable');



//document.getElementById("item").value='';



//document.getElementById("item").focus();



//}

}



}



</script>



<style type="text/css">



<!--



.style1 {



	color: #FFFFFF;



	font-weight: bold;



}



-->


.ac_results{
width:inherit !important;
}
.ac_results > ul{
height:250px;
}
</style>







<div class="form-container_large">



<form action="<?=$page?>" method="post" name="codz2" id="codz2">



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td width="33%"><fieldset >



    <div>



      <label style="width:81px;">Order No : </label>







      <input   name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>
    </div>



    <div>



      <label style="width:81px;">Dealer : </label>



        <select  id="dealer_code" name="dealer_code" readonly="readonly">



        <option value="<?=$dealer->dealer_code;?>"><?=$dealer->dealer_code.'-'.$dealer->dealer_name_e;?></option>
        </select>
    </div>

	



      <div>



        <label style="width:81px;">Area : </label>



        <input   name="wo_detail2" type="text" id="wo_detail2" value="<?=$dealer->area_name?>" readonly/>
      </div>



      <div>



        <label style="width:81px;">Zone : </label>



        <input   name="wo_detail" type="text" id="wo_detail" value="<?=$dealer->zone_name?>" readonly/>
      </div>



        <div>



        <label style="width:81px;">Region : </label>



        <input  name="wo_detail" type="text" id="wo_detail" value="<?=$dealer->region_name?>" readonly/>
        </div>



        <div>



          <label style="width:81px;">Depot : </label>



          <select  id="depot_id" name="depot_id" readonly="readonly">

            <option value="<?=$dealer->depot;?>">

              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
          </select>

		  

		 <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
        </div>



    </fieldset></td>



    <td width="33%">



			<fieldset >



			  <div>



			    <label style="width:113px;">Order Date : </label>



			    <input   name="do_date" type="text" id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>" />
		      </div>



			<div>



			<label style="width:113px;">Undel Amt : </label> 



            <?



            



			?>



			<input   name="wo_subject" type="text" id="wo_subject" value="<? echo $av_amt=(find_a_field_sql('select sum(total_amt) from sale_do_details where  	dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"')-find_a_field_sql('select sum(total_amt) from sale_do_chalan where  	dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"'))?>" readonly/>
			</div>



			<div>



			<label style="width:113px;">Credit Limit : </label> 



			<input  name="wo_subject" type="text" id="wo_subject" value="<?=$dealer->credit_limit?>" readonly/>
			</div>



			<div>



			  <label style="width:113px;">Available Amt : </label>



            <input name="thickness" type="text" id="thickness" value="<? echo $av_amt=find_a_field_sql('select sum(dr_amt)-sum(cr_amt) from journal where ledger_id='.$dealer->account_code)?>" readonly/>
			</div>



            <div>



			  <label style="width:113px;">Order Limit : </label>



            <input   name="thickness" type="text" id="thickness" value="" readonly/>
			</div>



            <div>



              <label style="width:113px;">Address: </label>



              <input name="delivery_address" type="text" id="delivery_address"  value="<? if($delivery_address!='') echo $delivery_address; else echo $dealer->address_e?>" />
            </div>
        </fieldset>	</td>



    <td width="33%"><fieldset style="height:240px;" >



    <div>



        <label style="width:120px;">Rcv Amt: </label>



        <input name="rcv_amt" type="text" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
      </div>

<div>



        <label style="width:120px;">Money Rcv No: </label>



        <input name="mr_no" type="text" id="mr_no"  value="<?=$mr_no?>" tabindex="101" />
      </div>



            <div>



        <label style="width:120px;">Payment By: </label>



        <select  id="payment_by" name="payment_by" tabindex="102">



			<option value="Online" <?=($payment_by=='Online')?'selected':''?>>Online</option>



			<option value="DD" <?=($payment_by=='DD')?'selected':''?>>DD</option>



			<option value="PO" <?=($payment_by=='PO')?'selected':''?>>PO</option>

			<option value="TT" <?=($payment_by=='TT')?'selected':''?>>TT</option>

			<option value="Cash" <?=($payment_by=='Cash')?'selected':''?>>Cash</option>


			<option value="Cheque" <?=($payment_by=='Cheque')?'selected':''?>>Cheque</option>
        </select>
      </div>



         <!-- <div>



              <label style="width:75px;">Party Bank: </label>



              <select style="width:155px;" id="bank" name="bank" tabindex="103">



                <option value=""></option>



				<? if($bank!='') echo '<option selected="selected">'.$bank.'</option>'; ?>



                <? foreign_relation('bank','distinct(BANK_NAME)','BANK_NAME',$bank,' 1 order by BANK_NAME');?>



              </select>



            </div>



            <div>



        <label style="width:75px;">Our Bank: </label>



        <?



		$bank_head = find_a_field('config_group_class','collection_bank_head','group_for='.$_SESSION['user']['group']);



		$collection_bank_head = substr($bank_head,0,12);



		?>



        <select style="width:155px;" id="receive_acc_head" name="receive_acc_head">



        <option></option>



        <? 



		foreign_relation('accounts_ledger','ledger_id','ledger_name',$receive_acc_head,' ledger_id LIKE "'.$collection_bank_head.'%" and ledger_id!="'.$bank_head.'" order by ledger_name');?>



        </select>



      </div>



      <div>



        <label style="width:75px;">Branch: </label>



        <span id="branch">



        <input name="branch" type="text" id="branch" value="<?=$branch?>" style="width:155px;" />







        </span>



      </div>-->



      <div>



        <label style="width:120px;">Note: </label>



        <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" tabindex="105" required/>
      </div>

	  

	  <div>



        <label style="width:120px;">Commission: </label>



        

		<input   name="cash_discount" type="text" id="cash_discount" value="<? if($cash_discount>0) echo $cash_discount; else echo $dealer->commission;?>" />
      </div>



    </fieldset></td>
  </tr>



  <tr>
    <td colspan="3"><div align="center"></div></td>
  </tr>
  <tr>



    <td colspan="3">



	<? if($dealer->canceled=='Yes'){?>



		<div class="buttonrow" style="margin-left:240px;"><span class="buttonrow" style="margin-left:240px;">
		  <? if($$unique_master>0) {?>
          <input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px; tabindex="12>
          <input name="flag2" id="flag2" type="hidden" value="1" />
          <? }else{?>
          <input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
          <input name="flag2" id="flag2" type="hidden" value="0" />
          <? }?>
        </span></div>



        <? }elseif($dealer->canceled=='No'){?>



		<table width="40%" border="0" align="center" cellpadding="5" cellspacing="0">



          <tr>



            <td bgcolor="#FF3333"><div align="center" class="style1">DEALER IS BLOCKED </div></td>
          </tr>
        </table>



<? }else{?>



		<table width="40%" border="0" align="center" cellpadding="5" cellspacing="0">



          <tr>



            <td bgcolor="#FF3333"><div align="center" class="style1">DEALER NOT FOUND</div></td>
          </tr>
        </table>



<? }?>	</td>
    </tr>
</table>



</form>



<form action="<?=$page?>" method="post" name="codz2" id="codz2">



<? if($$unique_master>0){?>



<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">



                      <tr>


                 <!--           <td align="left";><?=$msgg?></td>-->
                            <td colspan="3" align="right" bgcolor="#009966" style="text-align:right"><strong>Total Ordering: 



                            </strong>



<?



$total_do = find_a_field($table_detail,'sum(total_amt)',$unique_master.'='.$$unique_master);



?>



					  <input type="text" name="do_ordering" id="do_ordering" value="<?=$total_do-($total_do*$dealer->commission/100)?>" style="float:right; width:100px;" disabled="disabled" readonly />



					  <input type="hidden" name="do_total" id="do_total" value="<?=$total_do?>" />&nbsp;</td>

      </tr>



                      <tr>



                        <td align="center" bgcolor="#0099FF"><strong>Item Code</strong></td>



                        <td align="center" bgcolor="#0099FF"><table width="100%" border="1" cellspacing="0" cellpadding="0">



                          <tr>



<td align="center" bgcolor="#0099FF" width="35%"><strong>Item Name</strong></td>



<td align="center" bgcolor="#0099FF" width="10%"><strong>In Stk</strong></td>



<td align="center" bgcolor="#0099FF" width="8%"><strong>UnDel</strong></td>



<td align="center" bgcolor="#0099FF" width="9%"><strong>Price</strong></td>



<td align="center" bgcolor="#0099FF" width="9%"><strong>Crt Qty</strong></td>



<td align="center" bgcolor="#0099FF" width="8%"><strong>Unit</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Qty</strong></td>



<td align="center" bgcolor="#0099FF" width="12%"><strong>Total</strong></td>
                          </tr>



                        </table></td>



                        <td  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">



                          <input name="add" type="submit" id="add" value="ADD" onclick="count()" class="update" tabindex="5"/>



                        </div></td>

      </tr>



                      <tr>



<td align="center" bgcolor="#CCCCCC">



<span id="inst_no">

<span id="inst_no">

<input name="item" type="text" class="input3" id="item"  style="width:80px; background-color:white;" required onblur="grp_check(this.value);" tabindex="1"/>

</span>

<input name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>" readonly/>



<input name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly/>



<input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>



<input name="depot_id" type="hidden" id="depot_id" value="<?=$depot_id;?>"/>



<input name="flag" id="flag" type="hidden" value="1" />

</span>



<input style="width:10px;"  name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly/></td>







<td bgcolor="#CCCCCC">



  



  <table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>



    <td bgcolor="#CCCCCC"><span id="do"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<?php /*?><?php */?>

  <tr>



  <td><input name="item2" type="text" class="input3" id="item2"  style="width:260px;" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('dist_unit')"/></td>



  <td><input name="in_stock"  type="text" class="input3" id="in_stock"  style="width:55px;" value="<?=$in_stock?>" readonly onfocus="focuson('dist_unit')"/>



  <input name="item_id" type="hidden" class="input3" id="item_id"  style="width:55px;"  value="<?=$item_all->item_id?>" readonly/></td>



  <td><input name="undel" type="text" class="input3" id="undel"  style="width:55px;" readonly  value="<?=($ordered_qty+$del_qty)?>"/></td>



  <td><input name="unit_price" type="text" class="input3" id="unit_price"  style="width:55px;" onchange="count()" value="<?=$item_all->d_price?>" />
  <input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:55px;"  value="<?=$item_all->pack_size?>" readonly/></td>
  </tr>



      </table>
    </span></td>



  <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>



      <td><input name="pkt_unit" type="text" value="0" readonly class="input3" id="pkt_unit" style="width:55px;" onkeyup="count()" required="required"  tabindex="4"/></td>

      <td><input name="pkt_unit" type="text" value="Pcs" readonly class="input3" id="pkt_unit" style="width:55px;" onkeyup="count()" required="required"  tabindex="4"/></td>



      <td><input name="dist_unit" type="text" class="input3" id="dist_unit" style="width:55px;" onkeyup="count()" /></td>
      <td><input name="total_unit" type="hidden" class="input3" id="total_unit"  style="width:55px;" readonly/>



        <input name="total_amt" type="text" class="input3" id="total_amt" style="width:70px;" readonly/></td>
      </tr>



  </table></td>

  </tr>

  </table></td>

</tr>

    </table>



					  



					  <br /><br /><br /><br />







<? 



$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price as price,a.dist_unit as qty ,a.total_amt,"X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';



?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">







    <tr>



      <td><div class="tabledesign2">



        <? 



echo link_report_add_del_auto($res,'',6);



		?>







      </div></td>



    </tr>



	    	



	







				



    <tr>



     <td>







 </td>



    </tr>



  </table>







</form>



<form action="select_dealer_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">



<table width="100%" border="0">



  <tr>



      <td align="center">



      <input name="delete"  type="submit" class="btn1" value="DELETE DO" style="width:100px; font-weight:bold; font-size:12px;color:#F00; height:30px" />



      <input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">



      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND SEND WORK ORDER" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />



      </td>



      



    </tr>



</table>











<? }?>



</form>



</div>






<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>