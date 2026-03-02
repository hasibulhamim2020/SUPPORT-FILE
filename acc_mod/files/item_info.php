<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Product Item Information';

$proj_id=$_SESSION['proj_id'];



$now=time();

$unique='item_id';

$unique_field='item_name';

$table='item_info';

$page="item_info.php";

$crud      =new crud($table);

$$unique = $_GET[$unique];





if(isset($_POST[$unique_field]))

{

$$unique = $_POST[$unique];

//for Record..................................

$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);

$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);



$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);



$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);

$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);

if(isset($_POST['record']))

{

$_POST['entry_at']=time();

$_POST['entry_by']=$_SESSION['user']['id'];



$min=number_format($_POST['sub_group_id'] + 1, 0, '.', '');

$max=number_format($_POST['sub_group_id'] + 10000, 0, '.', '');

$_POST[$unique]=number_format(next_value('item_id','item_info','1',$min,$min,$max), 0, '.', '');

$crud->insert();



$type=1;

$msg='New Entry Successfully Inserted.';



unset($_POST);

unset($$unique);

}



//for Modify..................................



if(isset($_POST['modify']))

{

		

$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);

$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);



$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);



$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);

$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);



		$_POST['edit_at']=time();

		$_POST['edit_by']=$_SESSION['user']['id'];

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

}



//for Delete..................................







if(isset($_POST['delete']))



{		

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}







}



if(isset($$unique))

{

	$condition=$unique."=".$$unique;	

	$data=db_fetch_object($table,$condition);

	foreach ($data as $key => $value){ $$key=$value;}

}





//for Modify..................................

if($_REQUEST['item_group']>0){$_SESSION['item_group'] = $_REQUEST['item_group'];}

if($_REQUEST['src_sub_group_id']>0){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}

if($_REQUEST['item_brand_n']!=""){$_SESSION['item_brand_n'] = $_REQUEST['item_brand_n'];}

if($_REQUEST['src_item_id']!=''){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}

if($_REQUEST['fg_code']!=''){$_SESSION['fg_code'] = $_REQUEST['fg_code'];$_SESSION['fg_code'] = $_REQUEST['fg_code'];}



if(isset($_REQUEST['cancel'])){unset($_SESSION['item_group']); unset($_SESSION['item_brand_n']); unset($_SESSION['src_sub_group_id']);unset($_SESSION['src_item_id']);unset($_SESSION['fg_code']);}




if($_SESSION['item_group']>0){

$item_group = $_SESSION['item_group'];

$con .=' and g.group_id="'.$item_group.'" ';}



if($_SESSION['src_sub_group_id']>0){

$src_sub_group_id = $_SESSION['src_sub_group_id'];

$con .='  and a.sub_group_id="'.$src_sub_group_id.'" ';}


if($_SESSION['item_brand_n'] !=""){

$item_brand_n = $_SESSION['item_brand_n'];

$con .=' and a.item_brand="'.$item_brand_n.'" ';}


if($_SESSION['src_item_id']!=''){

$src_item_id = $_SESSION['src_item_id'];

$con .='  and a.item_name like "%'.$src_item_id.'%" ';}



if($_SESSION['fg_code']>0){

$fg_code = $_SESSION['fg_code'];

$con .='  and a.finish_goods_code="'.$fg_code.'" ';}

?>
<script type="text/javascript">

$(function() {

		$("#fdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'yy-mm-dd'

		});

});

function Do_Nav()

{

	var URL = 'pop_ledger_selecting_list.php';

	popUp(URL);

}



function DoNav(theUrl)

{

	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;

}

function popUp(URL) 

{

	day = new Date();

	id = day.getTime();

	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div class="box">
                <form id="form1" name="form1" method="post" action="">
                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    <tr>
                      <td width="40%" align="right"> Group: </td>
                      <td width="60%" align="right"><select name="item_group" id="item_group">
                          <option></option>
                          <?php

$g2="select group_id, group_name from item_group";

//echo $a2;

$g1=db_query($g2);



while($g=mysqli_fetch_row($g1))

{

if($g[0]==$item_group)

echo "<option value=\"".$g[0]."\" selected>".$g[1]."</option>";

else

echo "<option value=\"".$g[0]."\">".$g[1]."</option>";

}

?>
                        </select></td>
                    </tr>
                    <tr>
                      <td width="40%" align="right"> Sub Group: </td>
                      <td width="60%" align="right"><select name="src_sub_group_id" id="src_sub_group_id">
                          <option></option>
                          <?php

$a2="select sub_group_id, sub_group_name from item_sub_group";

//echo $a2;

$a1=db_query($a2);



while($a=mysqli_fetch_row($a1))

{

if($a[0]==$src_sub_group_id)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

?>
                        </select></td>
                    </tr>
                    <tr>
                      <td align="right">Item Name: </td>
                      <td align="right"><input name="src_item_id" type="text" id="src_item_id" value="<?php echo $_SESSION['src_item_id']; ?>" size="20" /></td>
                    </tr>
                    <tr>
                      <td align="right">Finish Goods Code: </td>
                      <td align="right"><input name="fg_code" type="text" id="fg_code" value="<?php echo $_SESSION['fg_code']; ?>" size="20" /></td>
                    </tr>
                    <tr>
                      <td colspan="2"><input class="btn" name="search" type="submit" id="search" value="Show" />
                        <input class="btn" name="cancel" type="submit" id="cancel" value="Cancel" /></td>
                    </tr>
                  </table>
                </form>
              </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><?

//if($_SESSION['item_group']>0 || $_SESSION['src_sub_group_id']>0 || $_SESSION['src_item_id']!='' || $_SESSION['item_brand_n'] !='' || $_SESSION['fg_code']>0){

?>
              <table id="grp" class="table table-bordered" cellspacing="0">
                <tr>
                  <th>FG Code </th>
                  <th>Item Name</th>
                  <th>Sub Group</th>
                  <th>Item Details</th>
                </tr>
                <?php

$td="select a.item_id,a.item_name,b.sub_group_name,  a.item_description FROM item_info a, item_sub_group b, item_group g where b.sub_group_id=a.sub_group_id and b.group_id=g.group_id".$con;
//echo $td;
$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
                <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
                  <td><?=$rp[0];?></td>
                  <td><?=$rp[1];?></td>
                  <td><?=$rp[2];?></td>
                  <td><?=$rp[3];?></td>
                </tr>
                <?php }?>
              </table>
              <? //}?>
              </td>
          </tr>
        </table>
      </div></td>    <td valign="top" width="34%" >
	<div class="rights">
        <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="100%" colspan="2"><div class="box">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Item Code: </td>
                      <td><input name="item_name2" type="text" id="item_name2" value="<?=$$unique?>" size="30" maxlength="100" class="required" readonly="readonly" /></td>
                    </tr>
                    <tr>
                      <td>Item  Name: </td>
                      <td><input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />
                        <input name="item_name" type="text" id="item_name" value="<?php echo $item_name;?>" size="30" maxlength="100" class="required" /></td>
                    </tr>
                    <tr>
                      <td>Item Description:</td>
                      <td><textarea name="item_description" id="item_description" cols="27" rows="3"><?php echo $item_description;?></textarea></td>
                    </tr>
                    <tr>
                      <td>Item Sub Group :</td>
                      <td><?php



$a2="select sub_group_id, sub_group_name from item_sub_group";

//echo $a2;

$a1=db_query($a2);

echo "<select name=\"sub_group_id\" id=\"sub_group_id\"\">";

while($a=mysqli_fetch_row($a1))

{

	echo "<option></option>";

if($a[0]==$sub_group_id)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?></td>
                    </tr>
                    
                    <tr>
                      <td>Consumable Type :</td>
                      <td><select name="consumable_type" id="consumable_type">
                          <option value="<?=$consumable_type?>">
                          <?=$consumable_type?>
                          </option>
                          <option value="Consumable">Consumable</option>
                          <option value="Non-Consumable">Non-Consumable</option>
                          <option value="Service">Service</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td>Product Nature :</td>
                      <td><select name="product_nature" id="product_nature">
                          <option value="<?=$product_nature?>">
                          <?=$product_nature?>
                          </option>
                          <option value="Salable">Salable</option>
                          <option value="Purchasable">Purchasable</option>
                          <option value="Both">Both</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td>FG Code :</td>
                      <td><input type="text" name="finish_goods_code" id="finish_goods_code" value="<?=$finish_goods_code?>" /></td>
                    </tr>
                    <tr>
                      <td>BarCode : </td>
                      <td><input type="text" name="item_barcode" id="item_barcode" value="<?=$item_barcode?>" /></td>
                    </tr>
                    <tr>
                      <td>FG Group :</td>
                      <td><select name="sales_item_type" id="sales_item_type">
                          <option value="<?=$sales_item_type?>">
                          <?=$sales_item_type?>
                          </option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="C">C</option>
                          <option value="D">D</option>
                        </select>                      </td>
                    </tr>
                    
                    <tr>
                      <td>Unit Name :</td>
                      <td><?php



$a2="select unit_name, unit_name from unit_management";

//echo $a2;

$a1=db_query($a2);

echo "<select name=\"unit_name\" id=\"unit_name\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysqli_fetch_row($a1))

{

if($a[0]==$unit_name)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?></td>
                    </tr>
                    <tr>
                      <td>Sale Unit Name :</td>
                      <td><?php



$a2="select unit_name, unit_name from unit_management";

//echo $a2;

$a1=db_query($a2);

echo "<select name=\"pack_unit\" id=\"pack_unit\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysqli_fetch_row($a1))

{

if($a[0]==$pack_unit)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?></td>
                    </tr>
                    <tr>
                      <td>Sale Unit Size :</td>
                      <td><input type="text" name="pack_size" id="pack_size" value="<?=$pack_size?>" /></td>
                    </tr>
                    <tr>
                      <td>Sale (Sub) Unit Size :</td>
                      <td><input type="text" name="sub_pack_size" id="sub_pack_size" value="<?=$sub_pack_size?>" /></td>
                    </tr>
                    <tr>
                      <td>Buy Unit Name :</td>
                      <td><?php



$a2="select unit_name, unit_name from unit_management";

//echo $a2;

$a1=db_query($a2);

echo "<select name=\"purchase_unit\" id=\"purchase_unit\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysqli_fetch_row($a1))

{

if($a[0]==$purchase_unit)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?></td>
                    </tr>
                    <tr>
                      <td>Buy Unit Size :</td>
                      <td><input type="text" name="purchase_size" id="purchase_size" value="<?=$purchase_size?>" /></td>
                    </tr>
                    
                    <tr>
                      <td>Net Price :</td>
                      <td><input type="text" name="d_price" id="d_price" value="<?=$d_price?>" /></td>
                    </tr>
                    <tr>
                      <td>Trade Price:</td>
                      <td><input type="text" name="t_price" id="t_price" value="<?=$t_price?>" /></td>
                    </tr>
                    <tr>
                      <td>Market Price :</td>
                      <td><input type="text" name="m_price" id="m_price" value="<?=$m_price?>" /></td>
                    </tr>
                    <tr>
                      <td>Purchase  Price :</td>
                      <td><input type="text" name="cost_price" id="cost_price" value="<?=$cost_price?>" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </div></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><div class="box1">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><? if($$unique<1){?>
                        <input name="record" type="submit" id="record" value="Record" onclick="return checkUserName()" class="btn" />
                        <? }?></td>
                      <td><? if($$unique>0){?>
                        <input name="modify" type="submit" id="modify" value="Modify" class="btn" />
                        <? }?></td>
                      <td><input name="clear" type="button" class="btn" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </div></td>
            </tr>
          </table>
        </form>
      </div></td>
  </tr>
</table>50);

    pager.init();

    pager.showPageNav('pager', 'pageNavPosition');

    pager.showPage(1);

//-->

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
