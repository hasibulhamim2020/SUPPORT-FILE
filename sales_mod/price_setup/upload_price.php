<?php
session_start();
ob_start();
require "../../support/inc.all.php";
do_calander('#m_date');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$table='hrm_inout';
$unique='id';

if(isset($_POST["upload"])){

$dealer_code = $_POST["dealer_code"];

db_query('delete from sales_corporate_price where dealer_code ="'.$dealer_code.'" ');

$filename=$_FILES["mobile_bill"]["tmp_name"];

	if($_FILES["mobile_bill"]["tmp_name"]!=""){
	
	//echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");
			while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
			{
			

						
if($dealer_code==$emapData[1]){
$item_id = find_a_field('item_info','item_id','finish_goods_code="'.$emapData[2].'"');			
$t_price='SELECT (m_price * (100-'.$emapData[5].')) /100 FROM item_info WHERE finish_goods_code ="'.$emapData[2].'"';
$set_price = find_a_field_sql($t_price);

$sql = "INSERT into sales_corporate_price (dealer_code,item_id,discount,set_price,entry_by, entry_at) 
values('".$emapData[1]."','".$item_id."','".$emapData[5]."','".$set_price."','".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."')";
db_query($sql);
}
				

			}
			
	}
fclose($file);
 
echo 'Price Upload process done.';
} 

?>





<style type="text/css">

<!--

.style1 {font-size: 24px}
.style2 {
	color: #FF66CC;
	font-weight: bold;
}

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

                <td height="40" colspan="5" bgcolor="#00FF00"><div align="center" class="style1">Upload SuperShop Price </div></td>
                </tr>

              <tr>

                <td width="20%"><div align="right">Upload CSV File : </div></td>

                <td><input name="mobile_bill"  type="file" id="mobile_bill"/></td>
                <td>Dealer Code </td>
                <td><label>
                  <input type="text" name="dealer_code"/>
                </label></td>
                <td><input name="upload" type="submit" id="upload" value="Upload File" /></td>
              </tr>


              <tr>

                <td colspan="5"><label>

                    Process: Delete all old data for this dealer and insert newly. So be careful to execute this function.
                      <div align="center">
                      <p>&nbsp;</p>
                      <p align="left" class="style2">Note: File must be at CSV format. Example: upload.csv </p>
                      <p align="left" class="style2"> And Filed example: sl | dealer code| item code | item name| MRP | GP | TP</p>
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