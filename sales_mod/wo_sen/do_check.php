<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Demand Order Create Corporate';

do_calander('#est_date');
$page = 'do.php';
if($_POST['dealer']>0) 
$dealer_code = $_POST['dealer'];


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
		$table		=$table_detail;
		$crud      	=new crud($table);
		$_POST['gift_on_order'] = $crud->insert();
		$do_date = date('Y-m-d');
		$_POST['gift_on_item'] = $_POST['item_id'];


		$sss = "select * from sale_gift_offer where item_id='".$_POST['item_id']."' and start_date<='".$do_date."' and end_date>='".$do_date."' and group_for=''";
		$qqq = db_query($sss);
		while($gift=mysqli_fetch_object($qqq)){
		
		if($gift->dealer_code!='') 
		{
		$dealers = explode(',',$gift->dealer_code);
		if(!in_array($_POST['dealer_code'],$dealers))
		$not_found = 1;
		else
		$not_found = 0;
		}
		if($not_found==0){
		if($gift->item_qty>0)
		{
			$_POST['gift_id'] = $gift->id;
			$gift_item = find_all_field('item_info','','item_id="'.$gift->gift_id.'"');
			$_POST['item_id'] = $gift->gift_id;
			
			if($gift->gift_id== 1096000100010239)
			{
				$_POST['unit_price'] = (-1)*($gift->gift_qty);
				$_POST['total_amt']  = (((int)($_POST['total_unit']/$gift->item_qty))*($_POST['unit_price']));
				$_POST['total_unit'] = (((int)($_POST['total_unit']/$gift->item_qty)));
				
				$_POST['dist_unit'] = $_POST['total_unit'];
				$_POST['pkt_unit']  = '0.00';
				$_POST['pkt_size']  = '1.00';
				$_POST['t_price']   = '-1.00';
				$crud->insert();
			}
			elseif($gift->gift_id== 1096000100010312)
			{
				$_POST['unit_price'] = (-1)*($gift->gift_qty);
				$_POST['total_amt']  = (((int)($_POST['total_unit']/$gift->item_qty))*($_POST['unit_price']));
				$_POST['total_unit'] = (((int)($_POST['total_unit']/$gift->item_qty)));
				
				$_POST['dist_unit'] = $_POST['total_unit'];
				$_POST['pkt_unit']  = '0.00';
				$_POST['pkt_size']  = '1.00';
				$_POST['t_price']   = '-1.00';
				$crud->insert();
			}
			else
			{
			$_POST['unit_price'] = '0.00';
			$_POST['total_amt'] = '0.00';
			$_POST['total_unit'] = (((int)($_POST['total_unit']/$gift->item_qty))*($gift->gift_qty));
			
			$_POST['dist_unit'] = ($_POST['total_unit']%$gift_item->pack_size);
			$_POST['pkt_unit'] = (int)($_POST['total_unit']/$gift_item->pack_size);
			$_POST['pkt_size'] = $gift_item->pack_size;
			$_POST['t_price'] = '0.00';
			$crud->insert();
			}
		//unset($_POST['gift_id']);
		//unset($_POST['gift_on_order']);
		//unset($_POST['gift_on_item']);
}

}
}

}
}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}

if($del>0)
{	
		$next_del = find_a_field($table_detail,$unique_detail,'gift_on_order = '.$del);
		$crud   = new crud($table_detail);
		$condition=$unique_detail."=".$del;		
		$crud->delete_all($condition);
		if($next_del>0)
		{
			$condition=$unique_detail."=".$next_del;		
			$crud->delete_all($condition);
		}
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
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var total_unit = (pkt_unit*pkt_size)+dist_unit;
var unit_price = ((document.getElementById('unit_price').value)*1);
var total_amt  = (total_unit*unit_price);
document.getElementById('total_unit').value=total_unit;
document.getElementById('total_amt').value	= total_amt .toFixed(2);
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
  document.getElementById("remarks").focus();
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
$item_i = 1;
$sql_i='select finish_goods_code from item_info where sales_item_type like "%'.$dealer->product_group.'%" and product_nature="Salable"';
$query_i=db_query($sql_i);
while($is=mysqli_fetch_object($query_i))
{
	echo 'myCars['.$item_i.']="'.$is->finish_goods_code.'";';
	$item_i++;
}
?>
var item_check=id;
var f=myCars.indexOf(item_check);
if(f>0)
getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$dealer->depot.'<#>'.$dealer->dealer_code;?>');
else
{
alert('Item is not Accessable');
document.getElementById("item").value='';
document.getElementById("item").focus();
}}
}
</script>






<!--Mr create 2 form with table-->
<div class="form-container_large">
    <form action="<?=$page?>" method="post" name="codz2" id="codz2">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order No</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="do_no" type="text" id="do_no" 
	  value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
    
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delaer name</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                               <select id="dealer_code" name="dealer_code" readonly="readonly">
								<option value="<?=$dealer->dealer_code;?>"><?=$dealer->dealer_name_e.'-'.$dealer->dealer_code;?></option>
								</select>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depot</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select id="depot_id2" name="depot_id2"  class="from-control" readonly="readonly">
									<option value="<?=$dealer->depot;?>">
									  <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
									  </option>
								  </select>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Address</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <textarea name="delivery_address" id="delivery_address" ><? if($delivery_address!='') echo $delivery_address; else echo $dealer->address_e?></textarea>

                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order Date</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="do_date" type="text"  id="do_date" value="<?=date('Y-m-d')?>" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Ref PO NO</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="ref_no" type="text"  id="ref_no"  value="<?=$ref_no?>"/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">CO Discount</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="sp_discount"  type="text" id="sp_discount" value="<?=$sp_discount?>"\/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="remarks" type="text" id="remarks" value="<?=$remarks?>" tabindex="10" />

                            </div>
                        </div>

                    </div>



                </div>


            </div>

            <div class="n-form-btn-class">
                <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Update Requsition Information" tabindex="6">
            </div>
        </div>

        <!--return Table design start-->
		
		
		
        <!--<div class="container-fluid pt-5 p-0 ">
		<? if($$unique_master>0){?>
            <div class="d-flex justify-content-center">
			
			
				<table border="1" align="center" cellpadding="0" cellspacing="0">
			
			  <tbody>
			  		<tr>
			
						<td colspan="3" align="center"><strong>Entry Information</strong></td>
			
					</tr>
			
			  <tr>
			
					<td align="right"> Entry By:</td>
				
					<td align="left">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
				
					<td rowspan="2" align="center" class="p-2"><a href="sales_order_print_view.php?do_no=<?=$do_no?>" target="_blank"><i class="fas fa-print " style="color:black;"></i></td>
			
			  </tr>
			
			  <tr>
			
					<td align="right">Entry On:</td>
				
					<td align="left">&nbsp;&nbsp;<?=$entry_at?></td>
			
			</tr>
			
			</tbody></table>
	
		</div>

        </div>-->
    </form>




    <form action="" method="post" name="cloud" id="cloud">
        <!--Table input one design-->
        <div class="container-fluid pt-5 p-0 ">


            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>S/L</th>
                    <th>Code</th>
                    <th>Item Name</th>

                    <th>Unit Price</th>
                    <th>Crt Qty</th>
                    <th>Pcs</th>

                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                	<? 
					$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price,a.pkt_unit as crt_qty,a.dist_unit as pcs ,a.total_amt,"X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';
					$i=1;
					$query=db_query($res);
					while($data=mysqli_fetch_object($query)){
					
					?>
                <tr>
                    <td><?=$i++?></td>
                    <td><?=$data->code?></td>
					<td style="text-align:left"><?=$data->item_name?></td>
					<td><?=$data->unit_price?></td>
					<td><?=$data->crt_qty; $total_crt+=$data->crt_qty?></td>
					<td><?=$data->pcs?></td>
					<td><?=$data->total_amt; $total_amount+=$data->total_amt;?></td>
                    <td><a href="?del=<?=$data->id?>">X</a></td>

                </tr>
					<? } ?>
					
					 <tr>
                    <td align="center" colspan="4">Total</td>
                    
					<td align="center"><?=number_format($total_crt,2)?></td>
					<td></td>
					<td align="center"><?=number_format($total_amount,2)?></td>
					<td></td>
                    

                </tr>

                </tbody>
            </table>





        </div>


        <!--Data multi Table design start-->
        
    </form>

    <!--button design start-->
    <form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
							
				   <input name="return"  type="submit" class="btn1 btn1-bg-update" value="RETURN TO USER" onclick="return_function()" />
				   <input  name="do_no" type="hidden" id="do_no" value="<?=$do_no?>"/><input type="hidden" name="return_remarks" id="return_remarks">
				 
				   <input name="cancel"  type="submit" class="btn1 btn1-bg-cancel" value="CANCEL" />
				 
				 <input type="button" class="btn1 btn1-bg-cancel" value="CLOSE" onclick="window.location.href='select_uncheck_do.php'" /></td>
			
				  <input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD SO" />
	 
                
            </div>

        </div>
    </form>

<? } ?>

</div>









<?php /*?><div class="form-container_large">
<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset style="width:500px;">
    <div>
      <label style="width:75px;">Order No : </label>

      <input style="width:255px;" class="form-control"  name="do_no" type="text" id="do_no" 
	  value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
    </div>
	
    <div>
      <label style="width:75px;">Dealer : </label>
        <select style="width:255px;" id="dealer_code" name="dealer_code" class="form-control" readonly="readonly">
        <option value="<?=$dealer->dealer_code;?>"><?=$dealer->dealer_name_e.'-'.$dealer->dealer_code;?></option>
        </select>
    </div>
	
      <div>
          <label style="width:75px;">Depot : </label>
          <select style="width:255px;" id="depot_id2" name="depot_id2"  class="from-control" readonly="readonly">
            <option value="<?=$dealer->depot;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
          </select>
        </div>
		
		 <div>
        <label style="width:75px;">Address: </label>
        <textarea name="delivery_address" id="delivery_address" class="from-control" style="width:255px;"><? if($delivery_address!='') echo $delivery_address; else echo $dealer->address_e?></textarea>
      </div>
    </fieldset></td>
    <td>
			<fieldset style="width:500px;">
			  <div>
			    <label style="width:105px;">Order Date: </label>
			    <input style="width:255px;" name="do_date" type="text"  id="do_date" value="<?=date('Y-m-d')?>" readonly="readonly"/>
		      </div>
			  <div>
			    <label style="width:105px;">Ref PO No : </label>
			    <input style="width:255px;"  name="ref_no" type="text" class="from-control" id="ref_no"  value="<?=$ref_no?>"/>
		      </div>
			  <div>
			    <label style="width:105px;">CO Discount : </label>
			    <input style="width:255px;"  name="sp_discount" class="from-control" type="text" id="sp_discount" value="<?=$sp_discount?>"\/>
		      </div>
			  
			    <div>
               <label style="width:105px;">Note: </label>
               <input name="remarks" type="text" id="remarks" style="width:255px;"  class="from-control"value="<?=$remarks?>" tabindex="10" />
               </div>
			</fieldset>	</td>
			
   </tr><?php */?>
   
  <!--<tr>
    <td colspan="3"><div class="buttonrow" style="margin-left:400px;">
    <? if($$unique_master>0) {?>
<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="1" />
<? }else{?>
<input name="new" type="submit" class="" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px; text-align:center"  bac  tabindex="12" />
<input name="flag" id="flag" type="hidden" value="0" />
<? }?>
    </div></td>
    </tr>
</table>
</form>
<?php /*?><form action="<?=$page?>" method="post" name="codz" id="codz">
<? if($$unique_master>0){?>
<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <tr>

    <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>

    </tr>

  <tr>

    <td align="right" bgcolor="#CCFF99">Created By:</td>

    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

    <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="sales_order_print_view.php?do_no=<?=$do_no?>" target="_blank"><i class="fas fa-print" style="color:black;"></i><!--<img src="../../images/print.png" width="26" height="26" />--></a></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#CCFF99">Created On:</td>

    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=$entry_at?></td>

    </tr>

</table><?php */?>
<!--<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Code</strong></td>
                        <td align="center" bgcolor="#0099FF"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                          <tr>
<td align="center" bgcolor="#0099FF" width="42%"><strong>Item Name</strong></td>
<td align="center" bgcolor="#0099FF" width="10%"><strong>In Stk</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>UnDel</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Price</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Crt Qty</strong></td>
<td align="center" bgcolor="#0099FF" width="9%"><strong>Pcs</strong></td>
<td align="center" bgcolor="#0099FF" width="12%"><strong>Total</strong></td>
                          </tr>
                        </table></td>
                        <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" onclick="count()" class="update" tabindex="5"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<span id="inst_no">
<input name="item" type="text" class="input3" id="item"  style="width:80px;" required onblur="getData2('do_ajax.php', 'do',document.getElementById('item').value,'<?=$dealer->depot.'<#>'.$dealer->dealer_code;?>')" tabindex="1"/>

<input name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>" readonly="readonly"/>
<input name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly="readonly"/>
<input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
<input name="depot_id" type="hidden" id="depot_id" value="<?=$dealer->depot;?>"/>
<input name="flag" id="flag" type="hidden" value="1" />
</span>
<input style="width:10px;"  name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly="readonly"/></td>

<td bgcolor="#CCCCCC">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td bgcolor="#CCCCCC"><span id="do"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><input name="item2" type="text" class="input3" id="item2"  style="width:260px;" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('dist_unit')"/></td>
      <td><input name="in_stock" type="text" class="input3" id="in_stock"  style="width:55px;" value="0" readonly="readonly" onfocus="focuson('dist_unit')"/>
        <input name="item_id" type="hidden" class="input3" id="item_id"  style="width:55px;"  value="<?=$item_all->item_id?>" readonly="readonly"/></td>
      <td><input name="undel" type="text" class="input3" id="undel"  style="width:55px;" readonly="readonly"  value="<?=($ordered_qty+$del_qty)?>"/></td>
      <td><input name="unit_price" type="text" class="input3" id="unit_price"  style="width:55px;" value="<?=$item_all->s_price?>" readonly="readonly"/>
        <input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:55px;"  value="<?=$item_all->pack_size?>" readonly="readonly"/></td>
    </tr>
  </table></span></td>
<td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input name="pkt_unit" type="text" value="0" readonly="readonly" class="input3" id="pkt_unit" style="width:55px;" onkeyup="count()" required="required"  tabindex="4"/></td>
    <td><input name="dist_unit" type="text" class="input3" id="dist_unit" style="width:55px;" onkeyup="count()"/></td>
    <td><input name="total_unit" type="hidden" class="input3" id="total_unit"  style="width:55px;" readonly="readonly"/>
    <input name="total_amt" type="text" class="input3" id="total_amt" style="width:70px;" readonly="readonly"/></td>
    </tr>
</table></td>
</tr>
</table>

</td>
</tr>
    </table>-->
					 
<?php /*?>
<? 
$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price,a.pkt_unit as crt_qty,a.dist_unit as pcs ,a.total_amt,"X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
echo link_report_add_del_auto($res,'',5,7);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table></form>
<form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">
	   <input name="return"  type="submit" class="btn btn-warning" value="RETURN TO USER" onclick="return_function()" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" />
	   <input  name="do_no" type="hidden" id="do_no" value="<?=$do_no?>"/><input type="hidden" name="return_remarks" id="return_remarks">
      </td>
	  
	  <td align="center">
	   <input name="cancel"  type="submit" class="btn btn-danger" value="CANCEL" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" />
      </td>
	  <td><input type="button" class="btn btn-primary" value="CLOSE" style="width:240px; font-weight:bold; font-size:12px;color:white; height:30px" onclick="window.location.href='select_uncheck_do.php'" /></td>

      <td align="center">
	  <input name="confirmm" type="submit" class="btn btn-info" value="CONFIRM AND FORWARD SO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white;" />
	  </td>

    </tr>

  </table>

<? } ?>
</form>
</div><?php */?>
<script>
function return_function() {
  var notes = prompt("Why Return This DO?","");
  if (notes!=null) {
    document.getElementById("return_remarks").value =notes;
	document.getElementById("cz").submit();
  }
  return false;
}
</script>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>