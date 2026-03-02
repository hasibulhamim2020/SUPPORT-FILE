<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
ini_set('max_execution_time', '3000');
do_calander('#odate');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


$title='Upload FO Target. sale_target_so';
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





if(isset($_POST["upload"])){
    
$target_year 		= $_POST['target_year'];
$target_month 		= sprintf('%02d', $_POST['target_month']);
//$grp 				= $_POST['grp'];
$now                = date('Y-m-d H:i:s');
$target_period      = $target_year.$target_month;


// delete old upload if exists
$del = "DELETE FROM sale_target_so WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' ";
db_query($del); 
// end delete                                                                                                                                                    



$sql="SELECT * from item_info WHERE 1 and sub_group_id='100100000'";
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$i_id[$row->item_id] = $row->item_id;
		$i_dp[$row->item_id] = $row->d_price;
		//$i_ps[$row->item_id] = $row->pack_size;
	}




$s =0;
$filename=$_FILES["upload_file"]["tmp_name"];
	if($_FILES["upload_file"]["tmp_name"]!=""){

	$file = fopen($filename, "r");

while (($excelData = fgetcsv($file, 2000000, ",")) !== FALSE){

for($x=0;$x<2000000;$x++)
{
    if($excelData[$x]!='')
    $data[$s][$x] = $excelData[$x];
}

$s++;
} // end while loop
} // end upload file

fclose($file);

//echo $data[0][0];


// $data[column][row]
for($b=2;$b<=$s;$b++){

	for($g=4;$g<=$x;$g++){
	    
	    
        // $data[row][coll]	    
		if($data[$b][$g]>0 && $data[0][$g]>0){ // qty>0 and dealer>0


$sql = "INSERT INTO sale_target_so (target_year,target_month,target_period,     dealer_code,so_code,
                                            item_id,target_qty,price,target_amt,entry_by, entry_at 
)VALUES(
			'".$target_year."','".$target_month."','".$target_period."',    '".$data[0][$g]."','".$data[1][$g]."'
			,'".$i_id[$data[$b][1]]."','".$data[$b][$g]."'
			
			,'".($i_dp[$data[$b][1]])."','".($i_dp[$data[$b][1]])*($data[$b][$g])."'
			
			,'".$_SESSION['user']['id']."','".$now."'
			)";
			

			db_query($sql);
			    
		} // end if
	
	   
	} 


}




echo "Upload Complete";
}
?>








<style type="text/css">
<!--
.style2 {
	font-size: 18px;
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

                <td height="40" colspan="6" bgcolor="#00FF00"><div align="center" class="style2">Upload FO Target Qty</div></td>
                </tr>

              <tr>
                <td>Year </td>
                <td width="18%"><select name="target_year" style="width:160px;" id="target_year" required="required">

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
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>

              <tr>
                <td width="11%">&nbsp;</td>
                <td></td>
                <td>Upload File</td>
                <td colspan="3"><input name="upload_file"  type="file" id="upload_file" required="required"/></td>
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

<td colspan="6"><label>CSV File upload format example:</label>
<div align="center">

<table width="691" align="left" cellpadding="0" cellspacing="0" border=2>
  <col width="64" />
  <tr height="20">
    <td height="20" width="40"><div align="left"><strong></strong></div></td>
    <td width="55"><div align="left"><strong></strong></div></td>
    <td width="55"><div align="left"><strong></strong></div></td>
    <td width="250"><div align="left"><strong>Dealer Code </strong></div></td>
    <td width="125"><div align="left"><strong>10001</strong></div></td>
    <td width="73"><div align="center"><strong>10002</strong></div></td>
    <td width="90"><div align="center"><strong>10003</strong></div></td>
    <td width="116"><div align="center"><strong>10004</strong></div></td>
  </tr>

  <tr height="20">
    <td height="20" width="40"><div align="left"><strong>SL</strong></div></td>
    <td width="55"><div align="left"><strong>Item ID </strong></div></td>
    <td width="55"><div align="left"><strong>FG Code</strong></div></td>
    <td width="250"><div align="left"><strong>Item Name /FO Code=</strong></div></td>
    <td width="125"><div align="left"><strong>101</strong></div></td>
    <td width="73"><div align="center"><strong>102</strong></div></td>
    <td width="90"><div align="center"><strong>103</strong></div></td>
    <td width="116"><div align="center"><strong>104</strong></div></td>
  </tr>
  <tr height="20">
    <td height="20" align="right"><div align="left">1</div></td>
    <td align="right"><div align="left">100100001</div></td>
    <td align="right"><div align="left">P001/P2P001BL</div></td>
    <td><div align="left">Item 1 </div></td>
    <td align="right"><div align="left">1000</div></td>
    <td align="right"><div align="center">1200</div></td>
    <td align="right"><div align="center">2000</div></td>
   <td align="right"><div align="center">3000</div></td>
  </tr>
  <tr height="20">
    <td height="20" align="right"><div align="left">2</div></td>
    <td align="right"><div align="left">100100002</div></td>
    <td align="right"><div align="left">P002/P2P001WH</div></td>
    <td><div align="left">Item 2 </div></td>
    <td align="right"><div align="left">750 </div></td>
    <td align="right"><div align="center">1500</div></td>
    <td align="right"><div align="center">400</div></td>
    <td align="right"><div align="center">500</div></td>
  </tr>
</table>
</div>


    </td>
              </tr>
</table>
Note: This month old data will be deleted and new data insert accordingly.

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
require_once SERVER_CORE."routing/layout.bottom.php";
?>