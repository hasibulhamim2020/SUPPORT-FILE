<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Demand Order Create';



do_calander('#order_date');
do_calander('#ims_date');

$page = 'do.php';
$depot_id = $_POST['depot_id'];
if($_POST['dealer']>0) 

$dealer_code = $_POST['dealer'];

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

//$depot_id = find_a_field('warehouse','warehouse_name','warehouse_id='.$dealer->depot);



$table_master='ims_master';

$unique_master='ims_no';



$table_detail='ims_details';

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

		$table		=$table_detail;

		$crud      	=new crud($table);



		$_POST['total_unit'] = ($_POST['pkt_unit'] * $_POST['pkt_size']) + $_POST['dist_unit'];

		if($_POST['unit_price2']==0) $_POST['unit_price'] = 0;

		$_POST['total_amt'] = ($_POST['total_unit'] * $_POST['unit_price']);

		$_POST['t_price'] = find_a_field('item_info','t_price','item_id ='.$_POST['item_id']);

		$_POST['gift_on_order'] = $crud->insert();

		$do_date = date('Y-m-d');

		$_POST['gift_on_item'] = $_POST['item_id'];





if($_POST['group_for']!='M')

$sss = "select * from sale_gift_offer where item_id='".$_POST['item_id']."' and start_date<='".$do_date."' and end_date>='".$do_date."' and group_for like '%".$_POST['group_for']."%'";

else

$sss = "select * from sale_gift_offer where item_id='".$_POST['item_id']."' and start_date<='".$do_date."' and end_date>='".$do_date."' and (group_for like '%A%' or group_for like '%B%' or group_for like '%C%' or group_for like '%D%')";



		$qqq = db_query($sss);

		$total_unit = $_POST['total_unit'];

		while($gift=mysqli_fetch_object($qqq)){

		

		if($gift->item_qty>0)

		{

			$_POST['gift_id'] = $gift->id;

			$gift_item = find_all_field('item_info','','item_id="'.$gift->gift_id.'"');

			$_POST['item_id'] = $gift->gift_id;

			

			if($gift->gift_id== 1096000100010239)

			{

			$_POST['unit_price'] = (-1)*($gift->gift_qty);

			$_POST['total_amt']  = (((int)($total_unit/$gift->item_qty))*($_POST['unit_price']));

			$_POST['total_unit'] = (((int)($total_unit/$gift->item_qty)));

			

			$_POST['dist_unit'] = $_POST['total_unit'];

			$_POST['pkt_unit']  = '0.00';

			$_POST['pkt_size']  = '1.00';

			$_POST['t_price']   = '-1.00';

			$crud->insert();

			}

			elseif($gift->gift_id== 1096000100010312)

			{

			$_POST['unit_price'] = (-1)*($gift->gift_qty);

			$_POST['total_amt']  = (((int)($total_unit/$gift->item_qty))*($_POST['unit_price']));

			$_POST['total_unit'] = (((int)($total_unit/$gift->item_qty)));

			

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

			$_POST['total_unit'] = (((int)($total_unit/$gift->item_qty))*($gift->gift_qty));

			

			$_POST['dist_unit'] = ($_POST['total_unit']%$gift_item->pack_size);

			$_POST['pkt_unit'] = (int)($_POST['total_unit']/$gift_item->pack_size);

			$_POST['pkt_size'] = $gift_item->pack_size;

			$_POST['t_price'] = '0.00';

			if($_POST['unit_price']==0&&$_POST['total_unit']==0)

			{echo '';

			}

			else

			$crud->insert();

			}//

//		unset($_POST['gift_id']);

//		unset($_POST['gift_on_order']);

//		unset($_POST['gift_on_item']);

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
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var unit_price2 = ((document.getElementById('unit_price2').value)*1);
var total_unit = (pkt_unit*pkt_size)+dist_unit;

if(unit_price2==0)
var unit_price =0;
else
var unit_price = ((document.getElementById('unit_price').value)*1);
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

getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$depot_id;?>');

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

</style>



<div class="form-container_large">

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td align="center"><fieldset style="width:310px;">

 <div>

      <label style="width:75px;">IMS No : </label>



      <input style="width:155px;"  name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>

    </div>

    <div>

      <label style="width:75px;">Area: : </label>



      <select style="width:145px;" id="area_id" name="area_id" readonly="readonly">

        <?php foreign_relation('area', 'AREA_CODE', 'AREA_NAME', $area_id); ?>
		
		

        </select>

    </div>

    <div>

      <label style="width:80px;">Base Market: </label>

       <select style="width:145px;" id="base_market" name="base_market" readonly="readonly">

        <?php foreign_relation('area', 'AREA_CODE', 'AREA_NAME', $base_market); ?>
		
		

        </select>
    </div>
	

      <div>

        <label style="width:75px;">Order Date : </label>

        <input style="width:105px;"  name="order_date" type="text" id="order_date" value="<?=$order_date?>" readonly="readonly"/>

        

      </div>

     

       

    </fieldset></td>
</tr>

</table>
<br />

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>

    

    <td>

			<fieldset style="width:320px;">

			  <div>

			    <label style="width:105px;">Order Date : </label>

			    <input style="width:105px;"  name="order_date" type="text" id="order_date" value="<?=$order_date?>" readonly="readonly"/>

		      </div>

			<div>

			<label style="width:105px;">IMS Date : </label> 

           <input style="width:105px;"  name="ims_date" type="text" id="ims_date" value="<?=$ims_date?>" readonly="readonly"/>

			</div>

			<div>

			<label style="width:105px;">Dealer : </label> 

			 <select style="width:145px;" id="dealer_code" name="dealer_code" readonly="readonly">

        <?php foreign_relation('dealer_info', 'dealer_code', 'dealer_name_e', $dealer_code); ?>
		
		

        </select>

			</div>

			<div>

			  <label style="width:105px;">Field Officer : </label>

            <input style="width:105px;"  name="thickness" type="text" id="thickness" value="<? /*echo $av_amt=find_a_field_sql('select sum(dr_amt)-sum(cr_amt) from journal where ledger_id='.$dealer->account_code)*/?>" readonly="readonly"/>

			</div>

       

            </fieldset>	</td>

    <td><fieldset style="width:320px;">

    <div>

        <label style="width:75px;">Team: </label>

         <select style="width:145px;" id="team_name" name="team_name" readonly="readonly">

        <?php foreign_relation('teams', 'team_name', 'team_name', $team_name); ?>
		
		

        </select>

      </div>

            <div>

        <label style="width:75px;">Region: </label>

        <select style="width:155px;" id="region" name="region" tabindex="102">

			<?php foreign_relation('branch', 'BRANCH_ID', 'BRANCH_NAME', $region);?>

        </select>

      </div>

          <div>

              <label style="width:75px;">Zone: </label>

              <select style="width:155px;" id="zone" name="zone" tabindex="103">

                <?php foreign_relation('zon', '	ZONE_CODE', 'ZONE_NAME', $zone);?>

              </select>

          </div>

          <div>

        
        <label style="width:75px;">Area: : </label>
        <select style="width:145px;" id="select" name="select" readonly="readonly">
          <?php foreign_relation('area', 'AREA_CODE', 'AREA_NAME', $area_id); ?>
        </select>
          </div>

      

    </fieldset></td>

  </tr>

  <tr>

    <td colspan="3">

	<? if($dealer->canceled=='Yes'){?>

		<div class="buttonrow" style="margin-left:240px;">

		<? if($$unique_master>0) {?>

		<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />

		<input name="flag" id="flag" type="hidden" value="1" />

		<? }else{?>

		<input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />

		<input name="flag" id="flag" type="hidden" value="0" />

		<? }?>

		</div>

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

                            <td colspan="3" align="right" bgcolor="#009966" style="text-align:right"><strong>Total Ordering: 

                            </strong>

<?

$total_do = find_a_field($table_detail,'sum(total_amt)',$unique_master.'='.$$unique_master);

?>

					  <input type="text" name="do_ordering" id="do_ordering" value="<?=$total_do-($total_do*$dealer->commission/100)?>" style="float:right; width:100px;" disabled="disabled" readonly="readonly" />

					  <input type="hidden" name="do_total" id="do_total" value="<?=$total_do?>" />&nbsp;</td>
      </tr>

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

                        <td  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">

                          <input name="add" type="submit" id="add" value="ADD" onclick="count()" class="update" tabindex="5"/>

                        </div></td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<span id="inst_no">
<span id="inst_no">
<input name="item" type="text" class="input3" id="item"  style="width:80px;" required onblur="grp_check(this.value);" tabindex="1"/>
</span>
<input name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>" readonly="readonly"/>

<input name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly="readonly"/>

<input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>

<input name="depot_id" type="hidden" id="depot_id" value="<?=$depot_id;?>"/>

<input name="flag" id="flag" type="hidden" value="1" />
</span>

<input style="width:10px;"  name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly="readonly"/></td>



<td bgcolor="#CCCCCC">

  

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td bgcolor="#CCCCCC"><span id="do"><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

  <td><input name="item2" type="text" class="input3" id="item2"  style="width:260px;" required="required" tabindex="3" value="<?=$item_all->item_name?>" onfocus="focuson('dist_unit')"/></td>

  <td><input name="in_stock" type="text" class="input3" id="in_stock"  style="width:55px;" value="<?=$in_stock?>" readonly="readonly" onfocus="focuson('dist_unit')"/>

  <input name="item_id" type="hidden" class="input3" id="item_id"  style="width:55px;"  value="<?=$item_all->item_id?>" readonly="readonly"/></td>

  <td><input name="undel" type="text" class="input3" id="undel"  style="width:55px;" readonly="readonly"  value="<?=($ordered_qty+$del_qty)?>"/></td>

  <td><input name="unit_price" type="text" class="input3" id="unit_price"  style="width:55px;" value="<?=$item_all->d_price?>" readonly="readonly"/>

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
  </table></td>
</tr>
    </table>

					  

					  <br /><br /><br /><br />



<? 

$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price as dPrice,a.pkt_unit as crt_qty,a.dist_unit as pcs ,a.total_amt,"X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';

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

<script>$("#cz").validate();$("#cloud").validate();</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>