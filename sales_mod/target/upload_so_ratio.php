<?php

ini_set('max_execution_time', 600);
ini_set('max_input_vars', 10000);
ini_set('memory_limit', '256M');


require_once "../../../assets/template/layout.top.php";
do_calander('#odate');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


$title='Upload Field Officer Ratio. sale_target_so_per';
$table='sale_target_so_per';
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




$filename=$_FILES["mobile_bill"]["tmp_name"];
	if($_FILES["mobile_bill"]["tmp_name"]!=""){	

	$file = fopen($filename, "r");

// Delete all old data
$sql_del = "DELETE FROM sale_target_so_per WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
mysql_query($sql_del);
		
while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){
    if($emapData[1]>0){	
        
            $policy_no = find1("select policy_no from sale_target_dealer_ratio where target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' and dealer_code='".$emapData[1]."'");
        
            $sql = "INSERT INTO sale_target_so_per (target_year,target_month,target_period,dealer_code,so_code,policy_no,so_ratio,so_com_id,so_group_list,entry_by,entry_at) 
            VALUES(
    			'".$target_year."','".$target_month."','".$target_period."','".$emapData[1]."','".$emapData[2]."','".$policy_no."','".$emapData[5]."','".$emapData[6]."','".$emapData[7]."',
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





// ############### POLICY 1 (SO RATIO)

        // delete old data
        $sql_del = "DELETE FROM sale_target_so WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."'";
        mysql_query($sql_del); 
        
        // dealer list
        $sql1="select * from sale_target_so_per where policy_no=1 and target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
        $query1=mysql_query($sql1);
        while($info1=mysql_fetch_object($query1)){
            $so_code        = $info1->so_code;
            $dealer_code    = $info1->dealer_code;
            
            // dealer ratio table
            $sql2 ="select * from sale_target_upload where dealer_code='".$dealer_code."' and target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
            $query2=mysql_query($sql2);
            while($info2=mysql_fetch_object($query2)){
                $item_id = $info2->item_id;
                $so_target_qty = round(($info1->so_ratio/100)*$info2->target_ctn,4);
                $so_amount  =$so_target_qty*$info2->d_price;
            
                $sql = "INSERT INTO sale_target_so (target_year,target_month,target_period,dealer_code,so_code,item_id,target_qty,price,target_amt,entry_by,entry_at) 
                VALUES(
    			'".$target_year."','".$target_month."','".$target_period."','".$dealer_code."','".$so_code."','".$item_id."','".$so_target_qty."','".$info2->d_price."','".$so_amount."',
    			'".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."'
    			)";
    			
            mysql_query($sql); 
            
            } // end dealer while loop
        
        } // end while
        
        
// ############### POLICY 3 (Company Wise)        
        // dealer list
        $sql1="select * from sale_target_so_per where policy_no=3 and target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
        $query1=mysql_query($sql1);
        while($info1=mysql_fetch_object($query1)){
            $so_code        = $info1->so_code;
            $dealer_code    = $info1->dealer_code;
            
                // Dealer ratio table
                $sql2 ="select * from sale_target_upload where dealer_code='".$dealer_code."' and target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' 
                and group_for in ($info1->so_com_id)
                ";
                $query2=mysql_query($sql2);
                while($info2=mysql_fetch_object($query2)){
                    $item_id = $info2->item_id;
                    $so_target_qty = $info2->target_ctn;
                
                // delete old data
                   //$sql_del = "DELETE FROM sale_target_so WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' 
                   //and item_id='".$item_id."' and so_code='".$so_code."'";
                //mysql_query($sql_del);                
                
                
                $sql = "INSERT INTO sale_target_so (target_year,target_month,target_period,dealer_code,so_code,item_id,target_qty,price,target_amt,entry_by,entry_at) 
                VALUES(
    			'".$target_year."','".$target_month."','".$target_period."','".$dealer_code."','".$so_code."','".$item_id."','".$so_target_qty."','".$info2->d_price."','".$info2->target_amount."',
    			'".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."'
    			)";
    			
            mysql_query($sql);                 
                
            
                } //end while
        
        } //end while
        
        
        
        

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

                <td height="40" colspan="3" bgcolor="#00FF00"><div align="center" class="style1">Upload Field Force Ratio </div></td>
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
                      <p>
                        <!--td {border: 1px solid #cccccc;}br {mso-data-placement:same-cell;}-->
                      </p>
                      <table xmlns="http://www.w3.org/1999/xhtml" cellspacing="0" cellpadding="0" dir="ltr" border="1">
                        <colgroup>
                          <col width="53"/>
                          <col width="100"/>
                          <col width="166"/>
                          <col width="100"/>
                          <col width="100"/>
                          <col width="100"/>
                          <col width="100"/>
                          <col width="136"/>
                          </colgroup>
                        <tbody>
                          <tr>
                            <td data-sheets-value="{'1':2,'2':'sl'}"><strong>sl</strong></td>
                            <td data-sheets-value="{'1':2,'2':'dealer code'}"><strong>dealer code</strong></td>
                            <td data-sheets-value="{'1':2,'2':'FO Code'}"><strong>FO Code</strong></td>
                            <td data-sheets-value="{'1':2,'2':'FO Name'}"><strong>FO Name</strong></td>
                            <td data-sheets-value="{'1':2,'2':'Policy_no'}"><strong>Policy_no</strong></td>
                            <td data-sheets-value="{'1':2,'2':'FO Ratio'}"><strong>FO Ratio</strong></td>
                            <td data-sheets-value="{'1':2,'2':'Company Code'}"><strong>Company Code</strong></td>
                            <td data-sheets-value="{'1':2,'2':'Product Group'}"><strong>Product Group</strong></td>
                          </tr>
                          <tr>
                            <td data-sheets-value="{'1':3,'3':1}">1</td>
                            <td data-sheets-value="{'1':3,'3':10003}">10003</td>
                            <td data-sheets-value="{'1':3,'3':101}">101</td>
                            <td data-sheets-value="{'1':2,'2':'mr. karim'}">mr. karim</td>
                            <td data-sheets-value="{'1':3,'3':1}">1</td>
                            <td data-sheets-value="{'1':3,'3':55}">55</td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td data-sheets-value="{'1':3,'3':2}">2</td>
                            <td data-sheets-value="{'1':3,'3':10003}">10003</td>
                            <td data-sheets-value="{'1':3,'3':102}">102</td>
                            <td data-sheets-value="{'1':2,'2':'mr. rahim'}">mr. rahim</td>
                            <td data-sheets-value="{'1':3,'3':1}">1</td>
                            <td data-sheets-value="{'1':3,'3':45}">45</td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td data-sheets-value="{'1':3,'3':3}">3</td>
                            <td data-sheets-value="{'1':3,'3':10009}">10009</td>
                            <td data-sheets-value="{'1':3,'3':301}">301</td>
                            <td data-sheets-value="{'1':2,'2':'mr. karim'}">mr. karim</td>
                            <td data-sheets-value="{'1':3,'3':3}">3</td>
                            <td></td>
                            <td data-sheets-value="{'1':2,'2':'1,2'}">1,2</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td data-sheets-value="{'1':3,'3':4}">4</td>
                            <td data-sheets-value="{'1':3,'3':10009}">10009</td>
                            <td data-sheets-value="{'1':3,'3':101}">101</td>
                            <td data-sheets-value="{'1':2,'2':'Mr. Sumon'}">Mr. Sumon</td>
                            <td data-sheets-value="{'1':3,'3':3}">3</td>
                            <td></td>
                            <td data-sheets-value="{'1':2,'2':'3,4'}">3,4</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td data-sheets-value="{'1':3,'3':5}">5</td>
                            <td data-sheets-value="{'1':3,'3':10010}">10010</td>
                            <td data-sheets-value="{'1':3,'3':401}">401</td>
                            <td data-sheets-value="{'1':2,'2':'Mr. Babu'}">Mr. Babu</td>
                            <td data-sheets-value="{'1':3,'3':4}">4</td>
                            <td></td>
                            <td></td>
                            <td data-sheets-value="{'1':2,'2':'A,B'}">A,B</td>
                          </tr>
                          <tr>
                            <td data-sheets-value="{'1':3,'3':6}">6</td>
                            <td data-sheets-value="{'1':3,'3':10010}">10010</td>
                            <td data-sheets-value="{'1':3,'3':402}">402</td>
                            <td data-sheets-value="{'1':2,'2':'Mr. Shiblu'}">Mr. Shiblu</td>
                            <td data-sheets-value="{'1':3,'3':4}">4</td>
                            <td></td>
                            <td></td>
                            <td data-sheets-value="{'1':2,'2':'C,D'}">C,D</td>
                          </tr>
                        </tbody>
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