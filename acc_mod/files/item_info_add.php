<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Product Item Information';

$proj_id=$_SESSION['proj_id'];


$active='item';
$now=time();

$unique='item_id';

$unique_field='item_name';

$table='item_info';

$page="item_info.php";

$button="yes";

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
echo "ok";
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

$con .='and b.group_id=g.group_id and g.group_id="'.$item_group.'" ';}



if($_SESSION['src_sub_group_id']>0){

$src_sub_group_id = $_SESSION['src_sub_group_id'];

$con .='and b.group_id=g.group_id and a.sub_group_id="'.$src_sub_group_id.'" ';}


if($_SESSION['item_brand_n'] !=""){

$item_brand_n = $_SESSION['item_brand_n'];

$con .='and b.group_id=g.group_id and a.item_brand="'.$item_brand_n.'" ';}


if($_SESSION['src_item_id']!=''){

$src_item_id = $_SESSION['src_item_id'];

$con .='and b.group_id=g.group_id and a.item_name like "%'.$src_item_id.'%" ';}



if($_SESSION['fg_code']>0){

$fg_code = $_SESSION['fg_code'];

$con .='and b.group_id=g.group_id and a.finish_goods_code="'.$fg_code.'" ';}

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


  

							  <table  class="table table-bordered"width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr>

                                  <td width="100%" colspan="2">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      <tr>

                                        <td>Item Code: </td>

                                        <td><input name="item_name2" type="text" id="item_name2" value="<?=$$unique?>" size="30" maxlength="100" class="required" readonly="readonly" /></td>
                                      </tr>

                                      <tr>

                                        <td>Item  Name: </td>

                                        <td>

                                        <input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

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
                                     <!-- <tr>
                                        <td>Micro Segment :</td>
                                        <td><select name="item_brand" id="item_brand">
                                            <option value="<?=$item_brand?>">
                                              <?=$item_brand?>
                                          </option>
                                            <option value="Jasmin Coconut Oil Tin">Jasmin Coconut Oil Tin</option>
                                            <option value="Jasmin Nonsticky Hair Oil">Jasmin Nonsticky Hair Oil </option>
                                            <option value="Jasmin Vaseline">Jasmin Vaseline</option>
                                            <option value="Jasmin Lipgel">Jasmin Lipgel</option>
                                            <option value="Jasmin Lip Bam">Jasmin Lip Bam</option>
                                            <option value="Jasmin Pomade">Jasmin Pomade</option>
                                            <option value="Jasmin Glycerin">Jasmin Glycerin</option>
                                            <option value="Jasmin Glycerin N">Jasmin Glycerin N</option>
                                            <option value="Jasmin Glycerin N.T">Jasmin Glycerin N.T</option>
                                            <option value="Jasmin Acqua Glycerin">Jasmin Acqua Glycerin</option>
                                            <option value="Jasmin Talcum Powder">Jasmin Talcum Powder</option>
											<option value="Jasmin Luxary Talcum Powder">Jasmin Luxary Talcum Powder</option>
											<option value="Jasmin Pricklyheat Powder">Jasmin Pricklyheat Powder</option>
											<option value="Super Cool Pricklyheat Powder">Super Cool Pricklyheat Powder</option>
											<option value="Jasmin Power White">Jasmin Power White</option>
											<option value="Jasmin Detergent Powder">Jasmin Detergent Powder </option>
											<option value="Jasmin Laundry Soap">Jasmin Laundry Soap</option>
											<option value="Jasmin Nailpolish Remover">Jasmin Nailpolish Remover</option>
											<option value="Neat Hair Remover">Neat Hair Remover</option>
											<option value="Jasmin Hair Oil">Jasmin Hair Oil </option>
											<option value="Jasmin Super  Soap  Box">Jasmin Super  Soap  Box</option>
											<option value="Jasmin Fairness Soap">Jasmin Fairness Soap</option>
											<option value="Jasmin Beauty Soap Box">Jasmin Beauty Soap Box</option>
											<option value="Jasmin Sandal Soap">Jasmin Sandal Soap</option>
											<option value="Jasmin Attar">Jasmin Attar</option>
											<option value="Jasmin Attar New">Jasmin Attar New</option>
											<option value="Jasmin Darshan Agarbati ">Jasmin Darshan Agarbati </option>
											<option value="Jasmin Mahendi Gold">Jasmin Mahendi Gold</option>
											<option value="Just Hair Color Tube Black">Just Hair Color Tube Black</option>
											<option value="Just Hair Color Shache (Black)">Just Hair Color Shache (Black)</option>
											<option value="Just Hair Color Shache (Brown)">Just Hair Color Shache (Brown)</option>
											<option value="Just Hair Dai Black">Just Hair Dai Black</option>
											<option value="Extreme Perfume">Extreme Perfume</option>
											<option value="Jasmin Perfume">Jasmin Perfume</option>
											<option value="Gift Perfume">Gift Perfume</option>
											<option value="Orchid Perfume">Orchid Perfume</option>
											<option value="Angel Perfume">Angel Perfume</option>
											<option value="Spider Coil (Large)">Spider Coil (Large)</option>
											<option value="Just Baby Lotion">Just Baby Lotion</option>
											<option value="Just Aftershave Lotion">Just Aftershave Lotion</option>
											<option value="Jasmin Mustard Oil">Jasmin Mustard Oil</option>
											<option value="Just Mazoni (Spring)">Just Mazoni (Spring)</option>
											<option value="Just Mazoni (Net)">Just Mazoni (Net)</option>
											<option value="Just Tooth Powder">Just Tooth Powder</option>
											<option value="Just Bulb (Clear)">Just Bulb (Clear)</option>
											<option value="Just Energy Saving Lamp">Just Energy Saving Lamp</option>
											
                                        </select></td>
                                      </tr>-->
                                      

                                      <tr>

                                        <td>Consumable Type :</td>

                                        <td>

                                        <select name="consumable_type" id="consumable_type">

                                        <option value="<?=$consumable_type?>"><?=$consumable_type?></option>

                                        <option value="Consumable">Consumable</option>

                                        <option value="Non-Consumable">Non-Consumable</option>

                                        <option value="Service">Service</option>
                                        </select></td>
                                      </tr>

                                      <tr>

                                        <td>Product Nature :</td>

                                        <td><select name="product_nature" id="product_nature">

                                          <option value="<?=$product_nature?>"><?=$product_nature?></option>

                                          <option value="Salable">Salable</option>

                                          <option value="Purchasable">Purchasable</option>

                                          <option value="Both">Both</option>

                                        </select></td>
                                      </tr>

                                      <tr>

                                        <td>FG Code :</td>

                                        <td><input type="text" name="finish_goods_code" id="finish_goods_code" value="<?=$finish_goods_code?>" size="30"/></td>
                                      </tr>

                                      <!--<tr>

                                        <td>FG Group :</td>

                                        <td><select name="sales_item_type" id="sales_item_type">

                                          <option value="<?=$sales_item_type?>"><?=$sales_item_type?></option>

                                          <option value="A">A</option>

                                          <option value="B">B</option>

                                          <option value="C">C</option>

                                          <option value="D">D</option>

                                          <option value="AC">AC</option>

                                          <option value="BC">BC</option>

                                          <option value="CD">CD</option>

										  <option value="ABC">ABC</option>

										  <option value="ABCD">ABCD</option>

                                        </select>                                        </td>
                                      </tr>

                                      <tr>

                                        <td>FG Brand Category:</td>

                                        <td><select name="brand_category" id="brand_category">

<option value="<?=$brand_category?>"><?=$brand_category?></option>

<option value="NA">NA</option>

<option value="BISCUITS">BISCUITS</option>

<option value="COMMODITIES">COMMODITIES</option>

<option value="CONFECTIONERY">CONFECTIONERY</option>

<option value="DRINKS">DRINKS</option>

<option value="HOUSEHOLD">HOUSEHOLD</option>

<option value="IFDP">IFDP</option>

<option value="JUICE">JUICE</option>

<option value="NOODLES And SHEMAI">NOODLES And SHEMAI</option>

<option value="PHARMA">PHARMA</option>

<option value="PROMOTIONAL">PROMOTIONAL</option>

<option value="READY MIX">READY MIX</option>

<option value="SNACKS">SNACKS</option>



                                        </select></td>
                                      </tr>

                                      <tr>

                                        <td>FG Brand Category Type:</td>

                                        <td><select name="brand_category_type" id="brand_category_type">

										<option value="<?=$brand_category_type?>"><?=$brand_category_type?></option>

<option></option>

<option value="Afza">Afza</option>

<option value="Atta">Atta</option>

<option value="Bar-B-Q Noodles">Bar-B-Q Noodles</option>

<option value="Bhushi">Bhushi</option>

<option value="Biscuits">Biscuits</option>

<option value="Bourn Vita">Bourn Vita</option>

<option value="Chainess Noodles">Chainess Noodles</option>

<option value="Chips">Chips</option>

<option value="Chocolate">Chocolate</option>

<option value="Chutney">Chutney</option>

<option value="Cook Noodles">Cook Noodles</option>

<option value="Corn Flakes">Corn Flakes</option>

<option value="Cup Noodles">Cup Noodles</option>

<option value="Drinks">Drinks</option>

<option value="Egg Noodles">Egg Noodles</option>

<option value="Fried Peas">Fried Peas</option>

<option value="Glucose">Glucose</option>

<option value="Instant Noodles">Instant Noodles</option>

<option value="Jelly">Jelly</option>

<option value="Ketchup">Ketchup</option>

<option value="Lascha">Lascha</option>

<option value="Macaroni">Macaroni</option>

<option value="Maida">Maida</option>

<option value="Mango Bar">Mango Bar</option>

<option value="Masala">Masala</option>

<option value="Muri">Muri</option>

<option value="Mustard Oil">Mustard Oil</option>

<option value="Nocilla">Nocilla</option>

<option value="Pickle">Pickle</option>

<option value="Ready Mix">Ready Mix</option>

<option value="Rice">Rice</option>

<option value="Salt">Salt</option>

<option value="Sauce">Sauce</option>

<option value="Saya Nugget">Saya Nugget</option>

<option value="Saya sauce">Saya sauce</option>



<option value="Soft Drink">Soft Drink</option>

<option value="Stick Noodles">Stick Noodles</option>

<option value="Suji">Suji</option>

<option value="Tandury Noodles">Tandury Noodles</option>

<option value="Tang">Tang</option>

<option value="Thai Noodles">Thai Noodles</option>

<option value="Vermicelli">Vermicelli</option>



                                        </select></td>
                                      </tr>
-->
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

                                        <td><input type="text" name="pack_size" id="pack_size" value="<?=$pack_size?>" size="30"/></td>
                                      </tr>

                                     <!-- <tr>

                                        <td>Sale (Sub) Unit Size :</td>

                                        <td><input type="text" name="sub_pack_size" id="sub_pack_size" value="<?=$sub_pack_size?>" /></td>
                                      </tr>    -->
									                 
													                    <tr>
													                      <td>Pkgs/Ctn Size </td>
													                      <td><input type="text" name="pakg_ctn_size" id="pakg_ctn_size" value="<?=$pakg_ctn_size?>" size="30"/></td>
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

                                        <td><input type="text" name="purchase_size" id="purchase_size" value="<?=$purchase_size?>" size="30"/></td>
                                      </tr>

                                      <tr>

                                        <td>Production Cost :</td>

                                        <td><input type="text" name="p_price" id="p_price" value="<?=$p_price?>" size="30"/></td>
                                      </tr>

                                      <tr>

                                        
									  
									   <tr>

                                        <td>Sylhet Price :</td>

                                        <td><input type="text" name="s_price" id="s_price" value="<?=$s_price?>" size="30"/></td>
                                      </tr>

                                      <tr>

                                        <td>Dhaka Price :</td>

                                        <td><input type="text" name="d_price" id="d_price" value="<?=$d_price?>" size="30"/></td>
                                      </tr>
									  
									  <td>Chittagong Price :</td>

                                        <td><input type="text" name="c_price" id="c_price" value="<?=$c_price?>" size="30"/></td>
                                      </tr>

                                      <tr>

                                        <td>Trade Price:</td>

                                        <td><input type="text" name="t_price" id="t_price" value="<?=$t_price?>" size="30"/></td>
                                      </tr>

                                      <tr>

                                        <td>Market Price :</td>

                                        <td><input type="text" name="m_price" id="m_price" value="<?=$m_price?>" size="30"/></td>
                                      </tr>

                                      <tr>

                                        <td>Purchase  Price :</td>

                                        <td><input type="text" name="cost_price" id="cost_price" value="<?=$cost_price?>" size="30"/></td>
                                      </tr>

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>
                                      </tr>

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>
                                      </tr></table>

                                  </td>

                                </tr>

                                

                                <tr>

                                  <td colspan="2">&nbsp;</td>

                                </tr>

                                

                              </table>10000);

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