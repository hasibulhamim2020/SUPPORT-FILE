<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Promotional Offer';

do_calander('#start_date');
do_calander('#end_date');

$table_master='sale_gift_offer';
$unique_master='id';
$page = $target_url = 'gift_offer.php';

if(isset($_POST['new']))
{if(prevent_multi_submit()){
		$crud   = new crud($table_master);
		$item=explode('#>',$_POST['item_id']);
		$_POST['item_id']=find_a_field('item_info','item_id','finish_goods_code='.$item[1]);
		
		$g=explode('#>',$_POST['gift_id']);
		$_POST['gift_id']=find_a_field('item_info','item_id','finish_goods_code='.$g[1]);
		
		if($g[1]==2000)
		$_POST['gift_qty']=find_a_field('item_info','d_price','finish_goods_code='.$item[1])*$_POST['gift_qty'];

	// Dump Min Max Calculation
		$pack_size = find_a_field('item_info','pack_size','finish_goods_code='.$item[1]);
		$_POST['min_qty']= $_POST['min_qty']*$pack_size;
		$_POST['max_qty']= $_POST['max_qty']*$pack_size;
		if($_POST['min_qty']>0) { $_POST['item_qty'] = $_POST['min_qty']; }
	// End // Dump Min Max Calculation	
		
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		if($_POST['flag']<1){
		$$unique_master=$crud->insert();
		unset($$unique_master);
		$type=1;
		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';}
}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}
}

if($_GET[$unique_master]>0) $$unique_master = $_GET[$unique_master];
if($$unique_master>0)
{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}

if($_GET['del']>0)
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
}

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','item_id');

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",finish_goods_code)','product_nature="Salable"','gift_id');
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
document.getElementById('pkt_unit').focus();
}
</script>

<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique_master?>='+theUrl);
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
$sql_i='select finish_goods_code from item_info where sales_item_type="'.$dealer->product_group.'" and product_nature="Salable"';
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
getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$dealer->depot;?>');
else
{
alert('Item is not Accessable');
document.getElementById("item").value='';
document.getElementById("item").focus();
}}
}
</script>

<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset style="width:700px;">
      <div>
        <label style="width:150px;">Offer ID : </label>
        
        <input style="width:155px;"  name="id" type="text" id="id" value="<? if($_POST['flag']==1) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
        </div>
      <div>
        <label style="width:150px;">Promotional Offer Name : </label>
        <input style="width:255px;"  name="offer_name" type="text" id="offer_name" value="<?=$_POST['offer_name']?>"/>
      </div>
      <div>
        <label style="width:150px;">Group For : </label>
        <select id="group_for" name="group_for">
<!--        <option value="A" <?=($_POST['group_for']=='A')?'selected':''?>>A</option>
        <option value="B" <?=($_POST['group_for']=='B')?'selected':''?>>B</option>
        <option value="C" <?=($_POST['group_for']=='C')?'selected':''?>>C</option>
		<option value="D" <?=($_POST['group_for']=='D')?'selected':''?>>D</option>
		<option value="E" <?=($_POST['group_for']=='E')?'selected':''?>>E</option>
		<option value="M" <?=($_POST['group_for']=='M')?'selected':''?>>M</option>	-->
			
<? foreign_relation('product_group','group_name','group_name',$_POST['group_for'],'1 order by group_name');?>
        </select>
      </div>
      <div>
        <label style="width:150px;">Start Date :  </label>
        <input style="width:155px;"  name="start_date" type="text" id="start_date" value="<?=$_POST['start_date'];?>" autocomplete="off"/>
        
        </div>
      <div>
        <label style="width:150px;">End Date : </label>
        <input style="width:155px;"  name="end_date" type="text" id="end_date" value="<?=$_POST['end_date'];?>" autocomplete="off"/>
        </div>
      <div>
        <label style="width:150px;">Product Item Name : </label>
        <input style="width:355px;"  name="item_id" type="text" id="item_id" value="<?=$item_id?>"/>
      </div>
      

    
	  <div>
        <label style="width:150px;">On Unit Qty (Pcs): </label>
        <input style="width:155px;"  name="item_qty" type="text" id="item_qty" value="<?=$item_qty?>"/>
      </div>
	  
	  
<div>
<label style="width:300px;"><strong>Dump Range Qty Setup: </strong></label>
</div>	
	  <div>
        <label style="width:150px;">Min Qty (Ctn): </label>
        <input style="width:155px;"  name="min_qty" type="text" id="min_qty" value="<?=$min_qty?>"/>
      </div>
	  	  <div>
        <label style="width:150px;">Max Qty (Ctn): </label>
        <input style="width:155px;"  name="max_qty" type="text" id="max_qty" value="<?=$max_qty?>"/>
      </div>
<div>
<label style="width:300px;"><strong>End Dump Range Qty Setup: </strong></label>
</div>




      <div>
        <label style="width:150px;">Gift Item Name : </label>
        <input style="width:355px;"  name="gift_id" type="text" id="gift_id" value="<?=$gift_id?>"/>
      </div>
      <div>
        <label style="width:150px;">Gift Unit Qty (Pcs): </label>
        <input style="width:155px;"  name="gift_qty" type="text" id="gift_qty" value="<?=$gift_qty?>"/>
      </div>
	        <div>
        <label style="width:150px;">Gift Type : </label>
        <select id="gift_type" name="gift_type">
        <option value="Non-Cash" <?=($gift_type=='Non-Cash')?'selected':''?>>Non-Cash</option>
		<option value="Cash" <?=($gift_type=='Cash')?'selected':''?>>Cash</option>
        </select>
      </div>
	        <div>
        <label style="width:150px;">Calculation Mode : </label>
        <select id="calculation" name="calculation">
        <option value="Manual" <?=($calculation=='Manual')?'selected':''?>>Manual</option>
		<option value="Auto" <?=($calculation=='Auto')?'selected':''?>>Auto</option>
		<option value="OnTotal" <?=($calculation=='OnTotal')?'selected':''?>>OnTotal</option>
        </select>
      </div>
    </fieldset></td>
    </tr>
  <tr>
    <td><div class="buttonrow" style="margin-left:240px;">
    <? if($$unique_master>0) {?>
<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="1" />
<? }else{?>
<input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="0" />
<? }?>
    </div></td>
    </tr>
</table>
</form>






<!--<form action="?req_id=<?=$req_id?>" method="post" name="cloud" id="cloud"><br />-->
 
<table width="100%" cellspacing="0" cellpadding="2" border="0" class="tabledesign2">
<thead>
<tr>
<th>ID</th>
<th>Offer</th>
<th>Duration</th>
<th>Item Name/Gift Item</th>
<th>Item/Gift Qty</th>

<th>Slab Range Ctn</th>
</tr>
</thead>
<tbody>
<? 
$sql='select a.id,b.pack_size,concat(a.offer_name,"-",a.group_for) as offer,a.start_date as Start,a.end_date as End,
b.finish_goods_code as code,b.item_name,a.item_qty, c.finish_goods_code as g_code, a.gift_qty, c.item_name as gift_name, 
(a.min_qty/c.pack_size) as min_ctn, (a.max_qty/c.pack_size) as max_ctn

from sale_gift_offer a,item_info b,item_info c 
where b.item_id=a.item_id and c.item_id=a.gift_id and a.end_date>="'.date('Y-m-d').'" and a.group_for!="" 
order by id desc';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
?>
<tr>
<td><?=$data->id?></td>
<td><?=$data->offer?></td>
<td><?=date('d-M', strtotime($data->Start));?><br><?=date('d-M', strtotime($data->End));?></td>

<td><strong><?=$data->code?>-<?=$data->item_name?></strong><br><span style="color: #FF6699"><?=$data->g_code?>-<?=$data->gift_name?></span></td>
<td><strong><?=$data->item_qty/$data->pack_size?> Ctn</strong><br><span style="color: #FF6699"><?=$data->gift_qty?> Pcs</span></td>

<td><? if ($data->min_ctn==0 && $data->max_ctn==0){ echo '';}else { ?><?=(int)$data->min_ctn?> to <?=(int)$data->max_ctn?> <? } ?></td>

</tr>
<? } ?>
</table>
  

  <!--</form>-->

</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>