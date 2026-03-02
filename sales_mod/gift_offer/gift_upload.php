<?php
session_start();
ob_start();
require "../../support/inc.all.php";

do_calander('#start_date');
do_calander('#end_date');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

$table='sale_gift_offer';
$unique='id';

if(isset($_POST["upload"])){
$offer_name 			= $_POST['offer_name'];
$dealer_type 			= $_POST['dealer_type'];
$group_for 				= $_POST['group_for'];
$start_date 			= $_POST['start_date'];
$end_date 				= $_POST['end_date'];
$status					= 'Active';


$filename=$_FILES["mobile_bill"]["tmp_name"];
	if($_FILES["mobile_bill"]["tmp_name"]!=""){	
	//echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");
		
while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){

$item_id = find_a_field('item_info','item_id','finish_goods_code="'.$emapData[4].'"');
$gift_id = find_a_field('item_info','item_id','finish_goods_code="'.$emapData[6].'"');

if ($emapData[6]==2001){$calculation = 'Auto'; $gift_type='Cash';}else{$calculation = 'Manual'; $gift_type='Non-Cash';}

	if($emapData[5]>0){ 
	
	$sql = "INSERT INTO sale_gift_offer (offer_name,group_for,dealer_type,item_id,item_qty,gift_id,gift_qty,
	start_date,end_date,status,calculation,gift_type,
	entry_by,entry_at,dealer_code) 
	VALUES
	('".$offer_name."','".$group_for."','".$dealer_type."','".$item_id."','".$emapData[5]."','".$gift_id."','".$emapData[7]."',
	'".$start_date."','".$end_date."','".$status."','".$calculation."','".$gift_type."'
	,'".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."','".$emapData[8]."')";
							
	db_query($sql); 
	}
} // end while loop
} 
fclose($file);
echo "Upload Complete";
} // end submit button

?>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>


<div class="oe_view_manager oe_view_manager_current">
<form action=""  method="post" enctype="multipart/form-data">
        <div class="oe_view_manager_body">
<div  class="oe_view_manager_view_list"></div>
<div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">
          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
            <table width="80%" border="1" align="center">
              <tr>

                <td height="40" colspan="6" bgcolor="#00FF00"><div align="center" class="style1">Upload Gift Offer </div></td>
                </tr>

              <tr>
                <td>Offer Name </td>
                <td width="18%"><input name="offer_name" type="text" id="offer_name" style="width:100px;" value="" required="required"/></td>
                <td width="12%">Group For </td>
                <td width="59%" colspan="3"><select name="group_for" id="group_for">
                  <option></option>
				  <option value="A">A</option>
				  <option value="B">B</option>
				  <option value="C">C</option>
				  <option value="D">D</option>
				  <option value="E">E</option>
                </select></td>
              </tr>
              <tr>
                <td>Dealer Type </td>
                <td><select name="dealer_type" id="dealer_type" required="required">
                  <option value="Distributor">Distributor</option>
				  <option value="SuperShop">SuperShop</option>
				  
                </select></td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>Start Date </td>
                <td><input name="start_date" type="text" id="start_date" style="width:100px;" 
value="<?=date('Y-m-d')?>" /></td>
                <td>End Date </td>
                <td colspan="3">
<input name="end_date" type="text" id="end_date" style="width:100px;" 
value="<?=date('Y-m-d')?>" /></td>
              </tr>

              <tr>
                <td width="11%">&nbsp;</td>
                <td></td>
                <td>Upload File</td>
                <td colspan="3"><input name="mobile_bill"  type="file" id="mobile_bill" required="required"/></td>
                </tr>



              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><p>
                  <input name="upload" type="submit" id="upload" value="Upload File" />
                </p>
                  <p>&nbsp; </p></td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>

                <td colspan="6">
                  <div align="center"></div></td>
                </tr>
<tr>
<td colspan="6"><label>
<div align="center">
<p>CSV File Example: </p>
<table width="688" align="left" cellpadding="0" cellspacing="0">
  <col width="64" span="11" />
  <tr height="20">
    <td height="20" width="36"><div align="left"><strong>sl</strong></div></td>
    <td width="93"><div align="left"><strong>offer_name</strong></div></td>
    <td width="77"><div align="left"><strong>group_for</strong></div></td>
    <td width="92"><div align="left"><strong>type</strong></div></td>
    <td width="95"><div align="left"><strong>item_id</strong></div></td>
    <td width="92"><div align="left"><strong>item_qty</strong></div></td>
    <td width="84"><div align="left"><strong>gift_id</strong></div></td>
    <td width="63"><div align="left"><strong>gift_qty</strong></div></td>
    <td width="101"><div align="left"><strong>dealer_code</strong></div></td>
  </tr>
  <tr height="20">
    <td height="20" align="right"><div align="left">1</div></td>
    <td align="right"><div align="left">999</div></td>
    <td><div align="left">A</div></td>
    <td><div align="left">Distributor</div></td>
    <td align="right"><div align="left">845</div></td>
    <td align="right"><div align="left">48</div></td>
    <td align="right"><div align="left">2001</div></td>
    <td align="right"><div align="left">48</div></td>
    <td align="right"><div align="left">101,102</div></td>
  </tr>
  <tr height="20">
    <td height="20" align="right"><div align="left">2</div></td>
    <td align="right"><div align="left">999</div></td>
    <td><div align="left">A</div></td>
    <td><div align="left">Distributor</div></td>
    <td align="right"><div align="left">137</div></td>
    <td align="right"><div align="left">1</div></td>
    <td align="right"><div align="left">5085</div></td>
    <td align="right"><div align="left">1</div></td>
    <td align="right"><div align="left">201,202</div></td>
  </tr>
</table>
</div>

                    </label></td>
              </tr>
            </table>

            <br />
          </div>
          </div>

          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
</div>
 </form>   </div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>