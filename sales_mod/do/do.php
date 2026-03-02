<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
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



$table_master='sale_do_master';



$unique_master='do_no';



$table_detail='sale_do_details';



$unique_detail='id';

if($_GET['mhafuz']==2)
unset($_SESSION['do_no']);

if($_GET['old_do_no']>0)
$$unique_master=$_SESSION['do_no'] = $_GET['old_do_no'];

elseif($_GET['del']>0&&$_SESSION['do_no']>0)
{$$unique_master=$_SESSION['do_no']; $del = $_GET['del'];}

elseif($_SESSION['do_no']>0)
$$unique_master=$_SESSION['do_no'];



if(prevent_multi_submit()){

if(isset($_POST['new'])){

    $crud   = new crud($table_master);

    $_POST['entry_at']=date('Y-m-d H:i:s');

    $_POST['entry_by']=$_SESSION['user']['id'];

    if($_POST['flag']<1){

    $_POST['do_no'] =$_SESSION['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;

    $$unique_master=$crud->insert();

    unset($$unique);

    $type=1;

    $msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';

    }else{
    $crud->update($unique_master);
    $type=1;
    $msg='Successfully Updated.';
	
    }

}


if(isset($_POST['add'])&&($_POST[$unique_master]>0))
{

$details_insert = new crud($table_detail) ;

$_POST['unit_price']=$_POST['unit_price2'] ;

$details_insert->insert();

unset($$unique);

$type=1;

$msg='Item Entry Succesfull';

}

}else{
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
	$tr_type="Delete";
}




if($$unique_master>0)

{

    $condition=$unique_master."=".$$unique_master;

    $data=db_fetch_object($table_master,$condition);

    while (list($key, $value)=@each($data))

    { $$key=$value;}

}



$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

auto_complete_start_from_db('item_info','concat(finish_goods_code,"#>",item_name)','finish_goods_code','product_nature in ("Salable","Both") order by finish_goods_code ASC','item');


?>
<script language="javascript">
function count()
{


if(document.getElementById('unit_price').value!=''){

var vat = ((document.getElementById('vat').value)*1);
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var unit_price = ((document.getElementById('unit_price').value)*1);
var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
var dist_unit = ((document.getElementById('dist_unit').value)*1);

var total_unit = (document.getElementById('total_unit').value)=(pkt_unit*pkt_size)+dist_unit;

var total_amt = (document.getElementById('total_amt').value) = unit_price*total_unit;

var discount = ((document.getElementById('discount').value)*1);

var amt_after_discount = (document.getElementById('amt_after_discount').value) = total_amt-discount;

var vat_amt = (document.getElementById('vat_amt').value) = (amt_after_discount*vat)/100;

//document.getElementById('total_unit').value=dist_unit;

var total_amt_with_vat = (document.getElementById('total_amt_with_vat').value) = amt_after_discount+vat_amt ;


document.getElementById('total_amt_with_vat').value  = total_amt_with_vat.toFixed(2);

var do_total = ((document.getElementById('do_total').value)*1);


var do_ordering = total_amt_with_vat+do_total;

document.getElementById('do_ordering').value =do_ordering.toFixed(2);


}



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
<script>



/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////



function insert_item(){

var item1 = $("#item");

var total_unit = $("#total_unit");





if(item1.val()=="" || total_unit.val()==""){
alert('Please check Item ID,Qty');
return false;
}



  

$.ajax({

url:"do_input_ajax.php",
method:"POST",
dataType:"JSON",
data:$("#codz").serialize(),

success: function(result, msg){


var res = result;


$("#codzList").html(res[0]);  

$("#item").val('');
$("#item2").val('');
$("#total_unit").val('');
$("#total_amt").val('');
}
}); 
}






function grp_check(id)

{

if(document.getElementById("item").value!=''){

var myCars=new Array();

myCars[0]="01815224424";

getData2('do_ajax_s.php', 'do',document.getElementById("item").value,'<?=$depot_id;?>##'+document.getElementById("dealer_code").value);

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

  <form action="<?=$page?>" method="post" name="codz2" id="codz2" class="font-weight-bold">
  
         <div class="row ">
    
	
	     <div class="col-md-3 form-group">
            <label for="do_no" >Order No : </label>
          <input   name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1)        ;?>    " class="form-control" readonly/>
		  
		  
		  <input name="group_for" type="hidden" class="form-control" readonly="" id="group_for"  value="<?=$_SESSION['user']['group'];?>" tabindex="101" />
		  <input name="vat" type="hidden" class="form-control" readonly="" id="vat"  value="15" tabindex="101" />
          </div>
		  
		  <div class="col-md-3 form-group">
            <label for="dealer_code">Customer : </label>
            <select  id="dealer_code" class="form-control" name="dealer_code" readonly="readonly">
              <option value="<?=$dealer->dealer_code;?>">
              <?=$dealer->dealer_code.'-'.$dealer->dealer_name_e;?>
              </option>
            </select>
          </div>
		  
		  
		 <div class="col-md-3 form-group">
            <label for="sales_type">Sales Type : </label>
			
			
			<select name="sales_type" required id="sales_type"  class="form-control"  >

                      <? foreign_relation('sales_type','id','sales_type',$sales_type,'1');?>
                    </select>
          </div>
		  
		  
		   <div class="col-md-3 form-group">
            <label for="depot_id">Warehouse : </label>
            <select  id="depot_id" name="depot_id" class="form-control"  readonly="readonly">
              <option value="<?=$dealer->depot;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
            </select>
            
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
            <label for="do_date">Order Date : </label>
            <input   name="do_date" type="text" class="form-control"  id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>" />
          </div>
		  
		  
          <div class="col-md-3 form-group">
            <label for="do_date">Address: </label>
            <input name="delivery_address" type="text" class="form-control"  id="delivery_address"  value="<? if($delivery_address!='') echo $delivery_address; else echo $dealer->address_e?>" />
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="rcv_amt">Salesman: </label>
            <input name="salesman" type="text" class="form-control" readonly="" id="salesman"  value="<?=find_a_field('user_activity_management','fname','user_id='.$_SESSION['user']['id']);?>" tabindex="101" />
          </div>
		  
        <div class="col-md-3 form-group">
            <label for="remarks">Note: </label>
            <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" class="form-control"  />
          </div>
		  
		  
	
		  
   </div>  
   
   
   
   <? if($dealer->canceled=='Yes'){?>
          <div class="row justify-content-center">
            <? if($$unique_master>0) {?>
            <input name="new" type="submit" class="btn btn-warning" value="Update Demand Order" >
            <input name="flag" id="flag" type="hidden" value="1" />
            <? }else{?>
            <input name="new" type="submit" class="btn btn-success" value="Initiate Demand Order"  tabindex="12" />
            <input name="flag" id="flag" type="hidden" value="0" />
            <? }?>
            </div>
          <? }elseif($dealer->canceled=='No'){?>
<div class="alert alert-danger row justify-content-center" role="alert">DEALER IS BLOCKED</div>

          <? }else{?>
<div class="alert alert-danger row justify-content-center" role="alert">DEALER NOT FOUND</div>
          <? }?>

  </form>

  <form action="<?=$page?>" method="post" name="codz" id="codz">
    <? if($$unique_master>0){?>
    <table  class="table_input">
      <tr>
        <!--           <td align="left";><?=$msgg?></td>-->
        <td colspan="8" align="right" bgcolor="#009966" style="text-align:right"><strong>Total Ordering: </strong>
          <?







$total_do = find_a_field($table_detail,'sum(total_amt_with_vat)',$unique_master.'='.$$unique_master);







?>
          <input type="text" name="do_ordering" id="do_ordering" value="<?=$total_do-($total_do*$dealer->commission/100)?>" style="float:right; width:100px;" disabled="disabled" readonly />
          <input type="hidden" name="do_total" id="do_total" value="<?=$total_do?>" />
          &nbsp;</td>
      </tr>
      <tr>
        <td align="center" width="10%" bgcolor="#0099FF"><strong>Item Code</strong></td>
        <td align="center" bgcolor="#0099FF" width="20%"><strong>Item Name</strong></td>
        <td align="center" bgcolor="#0099FF" width="14%"><strong>Stock</strong></td>
        <td align="center" bgcolor="#0099FF" width="26%"><strong>Price</strong></td>
        <td align="center" bgcolor="#0099FF" width="8%"><strong>Ctn</strong></td>
        <td align="center" bgcolor="#0099FF" width="6%"><strong>Pcs</strong></td>
        <td align="center" bgcolor="#0099FF" width="8%"><strong>Discount</strong></td>
        <td width="8%"  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
            <input name="add" type="button" id="add" value="ADD" onclick="count();insert_item()" class="update" tabindex="5"/>
        </div></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#CCCCCC" width="10%"><span id="inst_no">
          <input name="item" type="text" id="item" class="form-control; background-color:white;" required onblur="grp_check(this.value);" tabindex="1" style="width:120px;"/>
          </span>
          <input name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>" readonly/>
          <input name="group_for" type="hidden" id="group_for" value="<?=$group_for;?>" readonly/>
          <input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code;?>"/>
          <input name="depot_id" type="hidden" id="depot_id" value="<?=$depot_id;?>"/>
		  <input name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"/>
		  <input name="vat" type="hidden" id="vat" value="<?=$vat;?>"/>
          <input name="flag" id="flag" type="hidden" value="1" />
          </span>
        <input style="width:10px;"  name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly/></td>
        <td bgcolor="#CCCCCC" colspan="3"><span id="do">
          <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <?php /*?><?php */?>
                <tr>
                <td  bgcolor="#CCCCCC" width=""><input name="item2" type="text" id="item2" class="form-control" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('dist_unit')"/></td>
                <td  bgcolor="#CCCCCC" width=""><input name="in_stock"  type="text" id="in_stock" class="form-control" value="<?=$in_stock?>" readonly onfocus="focuson('dist_unit')"/>
                <input name="item_id" type="hidden" class="form-control" id="item_id"  value="<?=$item_all->item_id?>" readonly/></td>
                <td  bgcolor="#CCCCCC" width=""><input name="unit_price" type="text" class="form-control" id="unit_price" onchange="count()" value="<?=$item_all->               d_price?>" />
                <input name="unit_price2" type="hidden" id="unit_price2" class="form-control" onchange="count()" value="<?=$item_all->d_price?>" />
                <input name="pkt_size" type="hidden" class="form-control" id="pkt_size" value="<?=$item_all->pack_size?>" readonly/></td>
                </tr>
          </table>
          </span></td>
        <td  bgcolor="#CCCCCC"><input name="pkt_unit" style="width:64px"  type="text" value=""  class="form-control" id="pkt_unit" onkeyup="count()" required="required"  tabindex="4"/></td>
        <td  bgcolor="#CCCCCC"><input name="dist_unit" style="width:64px" type="text" class="form-control" id="dist_unit"  onkeyup="count()" />
		<input name="total_unit" type="hidden" class="form-control"  style="width:64px" id="total_unit"  onkeyup="count()" readonly/>		</td>
        <td  bgcolor="#CCCCCC"><input name="discount" style="width:64px" type="text" class="form-control" id="discount"  onkeyup="count()" />
		
		<input style="width:70px" name="total_amt" type="hidden" class="form-control" id="total_amt" readonly/>
		<input style="width:70px" name="amt_after_discount" type="hidden" class="form-control" id="amt_after_discount" readonly/>
		<input style="width:70px" name="vat_amt" type="hidden" class="form-control" id="vat_amt" readonly/>
		 <input style="width:70px" name="total_amt_with_vat" type="hidden" class="form-control" id="total_amt_with_vat" readonly/>		</td>
      </tr>
    </table>
 
    <br />




<? if($$unique_master>0){?>


<? 

  $res='select a.id,b.item_name,a.crt_price as ctn_price, a.pkt_unit as ctn, a.dist_unit as pcs, a.total_amt as Net_sale, a.discount, a.vat_amt, a.total_amt_with_vat as Due_amt from 
   sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';

?>

<div  class="tabledesign2"><span id="codzList">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<th width="1%">SL</th>

<th width="33%">Product Name</th>

<th width="8%"><strong>Ctn</strong> Price</th>
<th width="6%"><strong>Ctn</strong></th>
<th width="6%">PCS</th>
<th width="9%">Amount</th>
<th width="10%">Discount</th>
<th width="10%">Vat Amt</th>
<th width="9%">Net Amt</th>
<th width="8%">X</th>
</tr>


<?

$i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){ ?>

<tr>

<td><?=$i++?></td>

<td><?=$data->item_name?></td>

<td><?=$data->ctn_price?></td>
<td>

<?=$data->ctn; $tot_ctn +=$data->ctn;?></td>
<td><?=$data->pcs; $tot_pcs +=$data->pcs;?></td>
<td><?=$data->Net_sale; $tot_Net_sale +=$data->Net_sale;?></td>
<td><?=$data->discount; $tot_discount +=$data->discount;?></td>
<td><?=$data->vat_amt; $tot_vat_amt +=$data->vat_amt;?></td>
<td><?=$data->Due_amt; $tot_Due_amt +=$data->Due_amt;?></td>
<td><a href="?del=<?=$data->id?>">X</a></td>
</tr>

<? } ?>

<tr>

<td colspan="3"><div align="right"><strong> Total:</strong></div></td>

<td><?=number_format($tot_ctn,2);?></td>
<td><?=number_format($tot_pcs,2);?></td>
<td><?=number_format($tot_Net_sale,2);?></td>
<td><?=number_format($tot_discount,2);?></td>
<td><?=number_format($tot_vat_amt,2);?></td>
<td><?=number_format($tot_Due_amt,2);?></td>
<td>&nbsp;</td>
</tr>





<? }?>
</table>

</span></div>








  </form>
  <form action="select_dealer_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    <table width="100%" border="0">
      <tr>
        <td align="center"><input name="delete"  type="submit" class="btn btn-danger" value="DELETE DO" style="width:100px; font-weight:bold; font-size:12px;color:white; height:38px" />
          <input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/></td>
        <td align="right" style="text-align:right"><input name="confirm" type="submit" class="btn btn-info" value="CONFIRM AND SEND WORK ORDER" style="width:270px; font-weight:bold; font-size:12px; height:38px; color:white; float:right" />
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
