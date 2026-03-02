<?php

ini_set('max_execution_time', 600);
ini_set('max_input_vars', 10000);
ini_set('memory_limit', '256M');


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#odate');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


$title='Upload Dealer Ratio. sale_target_so';
$table='sale_target_so';
$unique='id';

if($_POST['target_month']!=''){
$target_month=$_POST['target_month'];}
else{
$target_month=date('n');
}

if($_POST['target_year']!=''){
$target_year=$_POST['target_year'];}
else{
$target_year=date('Y');
}




if(isset($_POST['upload'])){
    
$target_year 		= $_POST['target_year'];
$target_month 		= sprintf('%02d', $_POST['target_month']);
$now                = date('Y-m-d H:i:s');
$target_period      = $target_year.$target_month;

//item price
$sql_item="select item_id,d_price as price from item_info where sub_group_id in(100100000)";
$query=db_query($sql_item);
while($data=mysqli_fetch_object($query)){ 
    $item_price[$data->item_id]=$data->price;
}


$filename=$_FILES["mobile_bill"]["tmp_name"];
	if($_FILES["mobile_bill"]["tmp_name"]!=""){	

	$file = fopen($filename, "r");
		
while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){
    if($emapData[1]>0){	
        
        $dealer_code=$emapData[1];
        $item_id = $emapData[4];
        $price = $item_price[$item_id];
        $target_amount = $price*$emapData[5];
        
        
                // delete old data
                  $sql_del = "DELETE FROM sale_target_so WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' 
                and dealer_code='".$dealer_code."' and item_id='".$item_id."' and so_code='".$emapData[2]."'";
                db_query($sql_del); 
        
        
            $sql = "INSERT INTO sale_target_so (target_year,target_month,target_period,dealer_code,so_code,item_id,target_qty,price,target_amt,entry_by,entry_at) 
            VALUES(
    			'".$target_year."','".$target_month."','".$target_period."','".$emapData[1]."','".$emapData[2]."','".$item_id."','".$emapData[5]."','".$price."','".$target_amount."',
    			'".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."')";
    			
            db_query($sql); 
    }	

    
} // end while
fclose($file);} // end file upload if



echo "<h2>Upload Complete</h2>";
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

                <td height="40" colspan="3" bgcolor="#00FF00"><div align="center" class="style1">Upload FO Target Qty</div></td>
                </tr>

              <tr>
                <td>Year </td>
                <td width="18%"><select name="target_year" style="width:160px;" id="target_year" required="required">
				  <option <?=($target_year=='2022')?'selected':''?>>2022</option>
				  <option <?=($target_year=='2023')?'selected':''?>>2023</option>
				  <option <?=($target_year=='2024')?'selected':''?>>2024</option>
				  <option <?=($target_year=='2025')?'selected':''?>>2025</option>
                </select></td>
               
			   

              </tr>
              <tr>
                <td>Month</td>
                <td><span class="oe_form_group_cell">
                  <select name="target_month" style="width:160px;" id="target_month" required="required">
                    <option value="1" <?=($target_month=='1')?'selected':''?>>Jan</option>
                    <option value="2" <?=($target_month=='2')?'selected':''?>>Feb</option>
                    <option value="3" <?=($target_month=='3')?'selected':''?>>Mar</option>
                    <option value="4" <?=($target_month=='4')?'selected':''?>>Apr</option>
                    <option value="5" <?=($target_month=='5')?'selected':''?>>May</option>
                    <option value="6" <?=($target_month=='6')?'selected':''?>>Jun</option>
                    <option value="7" <?=($target_month=='7')?'selected':''?>>Jul</option>
                    <option value="8" <?=($target_month=='8')?'selected':''?>>Aug</option>
                    <option value="9" <?=($target_month=='9')?'selected':''?>>Sep</option>
                    <option value="10" <?=($target_month=='10')?'selected':''?>>Oct</option>
                    <option value="11" <?=($target_month=='11')?'selected':''?>>Nov</option>
                    <option value="12" <?=($target_month=='12')?'selected':''?>>Dec</option>
                  </select>
                </span></td>

              </tr>
              
              

              <tr>
                <td width="20%">&nbsp;</td>
                <td width="30%">&nbsp;</td>
            </tr>

<tr>
<td> Upload  File :</td>
<td colspan="1"><input name="mobile_bill"  type="file" id="mobile_bill"/></td>

<td><input name="upload" type="submit" id="upload" value="Upload File" /></td>
</tr>

<tr><td>&nbsp;&nbsp;</td></tr>

              
              
              <tr>
                <td>&nbsp;</td>
                </tr>


              <tr>

                <td colspan="3">

                    <div align="center">
                      <p>CSV File Example: </p>
                      <table width="807" cellpadding="0" cellspacing="0">
                                                <tr>
                          <td width="30" height="19"><div align="left"><strong>SL</strong></div></td>
                          <td width="137" align="right"><div align="left"><strong>Dealer Code</strong></div></td>
                          <td width="218" align="right"><div align="left"><strong>FO Code </strong></div></td>
                          <td width="131" align="right"><div align="left"><strong>FO Name </strong></div></td>
                          <td width="289" align="right"><div align="left"><strong>Item ID</strong></div></td>
                          <td width="30" height="19"><div align="left"><strong>Target QTY</strong></div></td>
                        </tr>
						<tr>
                          <td height="19"><div align="left">1</div></td>
                          <td align="right"><div align="left">10003</div></td>
                          <td align="right"><div align="left">101</div></td>
                          <td align="right"><div align="left">45</div></td>
                          <td align="right"><div align="left">100100002</div></td>
                          <td height="19"><div align="left">100</div></td>
                        </tr>
						<tr>
                          <td height="19"><div align="left">2</div></td>
                          <td align="right"><div align="left">10004</div></td>
                          <td align="right"><div align="left">102</div></td>
                          <td align="right"><div align="left">55</div></td>
                          <td align="right"><div align="left">100100003</div></td>
                          <td height="19"><div align="left">120</div></td>
                        </tr>                        
                      </table>
                    </div>

</td>
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

<div align="left">
Note:<br>
  Step 1: Delete all Old Data at selected month.<br>
  Step 2: Insert all new data.
</div>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>