<?php

ini_set('max_execution_time', 600);
ini_set('max_input_vars', 10000);
ini_set('memory_limit', '256M');

require_once "../../../assets/template/layout.top.php";
do_calander('#odate');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


$title='Upload Dealer Ratio. sale_target_dealer_ratio';
$table='sale_target_dealer_ratio';
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

$sql="SELECT * FROM  area a where 1";
$res = mysql_query($sql);
	while($row=mysql_fetch_object($res))
	{
		$zone_id[$row->AREA_CODE]=$row->ZONE_ID;
	}
	
$sql2="SELECT * FROM zon a where 1";
$res2 = mysql_query($sql2);
	while($row2=mysql_fetch_object($res2))
	{
		$region_id[$row2->ZONE_CODE]=$row2->REGION_ID;
	} 


$filename=$_FILES["mobile_bill"]["tmp_name"];
	if($_FILES["mobile_bill"]["tmp_name"]!=""){	

	$file = fopen($filename, "r");

// Delete all old data
$sql_del = "DELETE FROM sale_target_dealer_ratio WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
mysql_query($sql_del);
		
while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){
    if($emapData[1]>0){	
        
            $area_id = find1("select area_code from dealer_info where dealer_code='".$emapData[1]."'");
            $zone_id=$zone_id[$area_id];
            $region_id=$region_id[$zone_id];

            $sql = "INSERT INTO sale_target_dealer_ratio (target_year,target_month,target_period,region_id,zone_id,area_id,dealer_code,dealer_name,dealer_ratio,policy_no,entry_by,entry_at) VALUES
    			('".$target_year."','".$target_month."','".$target_period."'
    			,'".$region_id."','".$zone_id."','".$area_id."','".$emapData[1]."','".$emapData[2]."','".$emapData[3]."','".$emapData[4]."',
    			'".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."')";
    			
            mysql_query($sql); 
    }	

    
} // end while
fclose($file);} // end file upload if



echo "<h2>Upload Complete</h2>";
} // end submit button









if(isset($_POST['process'])){
    
$target_year 		= $_POST['target_year'];
$target_month 		= sprintf('%02d', $_POST['target_month']);
$now                = date('Y-m-d H:i:s');
$target_period      = $target_year.$target_month;


// old data delete
  $sql_del = "DELETE FROM sale_target_upload WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
  mysql_query($sql_del);


//item group for
$sql_item="select item_id,group_for from item_info where sub_group_id in(100100000)";
$query=mysql_query($sql_item);
while($data=mysql_fetch_object($query)){
    $item_grop_for[$data->item_id]=$data->group_for;
}

        
 
        
        // dealer list
        $sql2="select * from dealer_info where dealer_type=1 and status='Yes' ";
        $query2=mysql_query($sql2);
        while($info2=mysql_fetch_object($query2)){
            $dealer_code    = $info2->dealer_code;
            $area_id        = $info2->area_code;
            
            // Dealer ratio check
            $dealer_ratio = find1("select dealer_ratio from sale_target_dealer_ratio where dealer_code='".$dealer_code."' and target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ");
            //if($dealer_ratio>0) {}else{ $dealer_ratio=100;}
            if($dealer_ratio>0){
            
     
            
            // area item list loop
                $sql1="select * from sale_target_area where area_id='".$area_id."' and target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
                    $query1=mysql_query($sql1);
                    while($info1=mysql_fetch_object($query1)){
                   
                   // find out dealer target qty
                   $target_qty =round(($dealer_ratio/100) * $info1->target_qty,4);
                   $target_amount = $target_qty * $info1->price;
                   
                   
                    $sql = "INSERT INTO sale_target_upload (target_year,target_month,target_period,region_id,zone_id,area_id,dealer_code,
                    item_id,target_ctn,d_price,target_amount,group_for,entry_by,entry_at
                    )VALUES(
            	        '".$target_year."','".$target_month."','".$target_period."','".$info2->region_id."','".$info2->zone_id."','".$area_id."','".$dealer_code."',
            	        '".$info1->item_id."','".$target_qty."','".$info1->price."','".$target_amount."','".$item_group_for[$info1->item_id]."',
            			'".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."')";
            			
                    mysql_query($sql);      
                    }
            
            
        } // end if dealer ratio>0
        } // end while

echo "<h2>Process Done</h2>";
} // end process

















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

                <td height="40" colspan="3" bgcolor="#00FF00"><div align="center" class="style1">Upload Dealer Ratio </div></td>
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
<td> Process :</td>
<td>&nbsp;</td>
<td><input name="process" type="submit" id="process" value="Process File" /></td>
</tr>
              
              
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
                          <td width="218" align="right"><div align="left"><strong>Dealer Name </strong></div></td>
                          <td width="131" align="right"><div align="left"><strong>Ratio </strong></div></td>
                          <td width="289" align="right"><div align="left"><strong>Policy No</strong></div></td>
                        </tr>
						<tr>
                          <td height="19"><div align="left">1</div></td>
                          <td align="right"><div align="left">100003</div></td>
                          <td align="right"><div align="left">Gazi Distributor</div></td>
                          <td align="right"><div align="left">45</div></td>
                          <td align="right"><div align="left">1</div></td>
                        </tr>
						<tr>
                          <td height="19"><div align="left">2</div></td>
                          <td align="right"><div align="left">100004</div></td>
                          <td align="right"><div align="left">Hazi Distributor</div></td>
                          <td align="right"><div align="left">55</div></td>
                          <td align="right"><div align="left">2</div></td>
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
<br><p>
<h3>Policy note:</h3>
1 = Ratio
<br>2 = Upload qty
<br>3 = Company Wise
<br>4 = Group Wise
</div>


<?
require_once "../../../assets/template/layout.bottom.php";
?>