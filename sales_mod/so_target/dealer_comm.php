<?php

ini_set('max_execution_time', 600);
ini_set('max_input_vars', 10000);
ini_set('memory_limit', '256M');


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


$entry_by   = $_SESSION['user']['username'];
$entry_at = date('Y-m-d H:i:s');

$title='Dealer Commission Calculation';
$table='z_dealer_commission';
$unique='id';




// #################################### UPLOAD ##############################
if(isset($_POST['upload'])){
    
//$fdate		= $_POST['fdate'];
$tdate		= $_POST['tdate'];


$filename=$_FILES["upload_file"]["tmp_name"];
	if($_FILES["upload_file"]["tmp_name"]!=""){	

	$file = fopen($filename, "r");


while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){
    if($emapData[1]>0){
        

// Delete OLD dealer data
if($emapData[1]!=$old_dealer_code){        
$sql_del = "DELETE FROM z_dealer_stock WHERE dealer_code='".$emapData[1]."' and tr_from='Opening'";
db_query($sql_del);        
}

$old_dealer_code = $emapData[1];

        $sql = "INSERT INTO z_dealer_stock (tr_from,ji_date,dealer_code,item_id,item_in,non_offerable_stock,total_stock,entry_by,entry_at) VALUES
			('Opening','".$tdate."','".$emapData[1]."','".$emapData[2]."','".$emapData[3]."','".$emapData[3]."','".$emapData[3]."','".$entry_by."','".date('Y-m-d H:i:s')."')";
			
        db_query($sql); 
    }	

    
} // end while
fclose($file);} // end file upload if

echo "<h2>Upload Complete</h2>";
} // end submit button






// #################################### Dealer Transection Collection ##############################
if(isset($_POST['stock_calculation'])){
    
$now  = date('Y-m-d H:i:s');
$fdate		= $_POST['fdate'];
$tdate		= $_POST['tdate'];

if($_POST['dealer_code']>0) { $dealer_con=' and dealer_code="'.$_POST['dealer_code'].'"'; }


// Dealer List
$sql_d="select * from z_dealer_stock where 1 ".$dealer_con." and tr_from='Opening' group by dealer_code order by dealer_code";
$queryd=db_query($sql_d);
    while($data=mysqli_fetch_object($queryd)){

$dealer_code    = $data->dealer_code;        

        

// old stock data delete
$sql_del = "DELETE FROM z_dealer_stock WHERE ji_date between '".$fdate."' and '".$tdate."' and dealer_code='".$dealer_code."'";
db_query($sql_del);


// get primary chalan
$sql1="select * from sale_do_chalan where dealer_code='".$dealer_code."' and chalan_date between '".$fdate."' and '".$tdate."' ";
$query1=db_query($sql1);
    while($data1=mysqli_fetch_object($query1)){
        
        // insert data
        $sql_i_chalan="insert into z_dealer_stock(tr_from,ji_date,dealer_code,item_id,item_in,entry_by,entry_at)
        values('Sales','".$data1->chalan_date."',$data1->dealer_code,$data1->item_id,$data1->total_unit,'".$entry_by."','".$entry_at."')";
        db_query($sql_i_chalan);
    }
    
    
// get 2nd sales qty
$sql2="select * from ss_do_chalan where depot_id='".$dealer_code."' and chalan_date between '".$fdate."' and '".$tdate."' ";
$query2=db_query($sql2);
    while($data2=mysqli_fetch_object($query2)){
        
        // insert data
        $sql_i_2nd="insert into z_dealer_stock(tr_from,ji_date,dealer_code,item_id,item_ex,offer_per,tp_price,entry_by,entry_at)
        values('Sec_Sales','".$data2->chalan_date."',$data2->depot_id,$data2->item_id,$data2->total_unit,'".$data2->nsp_per."','".$data2->t_price."','".$entry_by."','".$entry_at."')";
        db_query($sql_i_2nd);
    }

    
// get primary return
$sql3="select d.* from sale_return_master m,sale_return_details d 
where m.do_no=d.do_no and m.dealer_code='".$dealer_code."' and m.status in ('CHECKED') and m.do_date between '".$fdate."' and '".$tdate."' ";
$query3=db_query($sql3);
    while($data3=mysqli_fetch_object($query3)){
        
        // insert data
        $sql_pr="insert into z_dealer_stock(tr_from,ji_date,dealer_code,item_id,item_ex,entry_by,entry_at)
        values('Pri_return','".$data3->do_date."',$data3->dealer_code,$data3->item_id,$data3->total_unit,'".$entry_by."','".$entry_at."')";
        db_query($sql_pr);
    }  
    
    
// get 2nd return
$sql4="select d.* from ss_receive_master m,ss_receive_details d 
where m.or_no=d.or_no and m.warehouse_id='".$dealer_code."' and m.status in ('CHECKED') and m.or_date between '".$fdate."' and '".$tdate."' ";
$query4=db_query($sql4);
    while($data4=mysqli_fetch_object($query4)){
        
        // insert data
        $sql_secpr="insert into z_dealer_stock(tr_from,ji_date,dealer_code,item_id,item_in,entry_by,entry_at)
        values('Sec_return','".$data4->or_date."',$data4->warehouse_id,$data4->item_id,$data4->qty,'".$entry_by."','".$entry_at."')";
        db_query($sql_secpr);
    }     





} // end dealer list loop

echo '<h2>Stock Calculation Complete</h2>';
} // end stock calculation









// #################################### Final Process ##############################
if(isset($_POST['process'])){
    
$now  = date('Y-m-d H:i:s');
$fdate		= $_POST['fdate'];
$tdate		= $_POST['tdate'];

if($_POST['dealer_code']>0) { $dealer_con=' and dealer_code="'.$_POST['dealer_code'].'"'; }

// Dealer item list
$sql="select * from z_dealer_stock where 1 and ji_date between '".$fdate."' and '".$tdate."' 
".$dealer_con."
and tr_from not in ('Opening') 
group by dealer_code,item_id order by dealer_code,item_id";
$q2=db_query($sql);
while($data=mysqli_fetch_object($q2)){


// get opening qty
$st="select offerable_stock,non_offerable_stock from z_dealer_stock where dealer_code='".$data->dealer_code."' and item_id='".$data->item_id."' and ji_date<'".$fdate."' order by id desc limit 1";
$opening_qty = findall($st);
$opening_offerable_stock        = $opening_qty->offerable_stock;
$opening_non_offerable_stock    = $opening_qty->non_offerable_stock;

$stock_non_offer    = $opening_non_offerable_stock; // 100
$stock_offer        = $opening_offerable_stock;

// Dealer item details
$sql3="select * from z_dealer_stock 
where ji_date between '".$fdate."' and '".$tdate."' and dealer_code='".$data->dealer_code."' and item_id='".$data->item_id."' order by ji_date,id";

$query=db_query($sql3);
while($data2=mysqli_fetch_object($query)){

$do_qty     = $data2->item_in;
$sec_qty    = $data2->item_ex;

$old_stock_offer    =$stock_offer;
$old_stock_nonoffer =$stock_non_offer;


// ----- Offerable qty
if($data2->tr_from=='Sec_return'){
    $stock_offer=$old_stock_offer;
}else{
   if(($stock_offer+$do_qty)>$sec_qty){ $stock_offer= $stock_offer+$do_qty-$sec_qty; }else{ $stock_offer=0;} 
}


// ----- NON Offerable qty
if($data2->tr_from=='Sec_return'){
    //$stock_non_offer=($stock_non_offer+$old_stock_offer+$do_qty-$sec_qty);
    $stock_non_offer=($stock_non_offer+$do_qty);
}else{
    if(($old_stock_offer+$do_qty)>$sec_qty){ $stock_non_offer = $stock_non_offer;}else{$stock_non_offer=($stock_non_offer+$old_stock_offer+$do_qty-$sec_qty);}
}


$op_qty     = $old_stock_offer+$old_stock_nonoffer;
$total_qty  = $stock_offer+$stock_non_offer;


// comm amt calculation
if($data2->tr_from=='Sec_Sales'){
    $nsp_per    = $data2->offer_per/100;
    $tp         = $data2->tp_price;
    
    if(($old_stock_offer+$do_qty)>$sec_qty){
        $comm_amt=($sec_qty*$tp)*$nsp_per;
    }else{ 
        $comm_amt=(($old_stock_offer+$do_qty)*$tp)*$nsp_per;
    } 
}


// update data
$sql_update="update z_dealer_stock set opening_qty='".$op_qty."', offerable_stock='".$stock_offer."', non_offerable_stock='".$stock_non_offer."',total_stock='".$total_qty."',comm_amt='".$comm_amt."'
where id='".$data2->id."'
";
db_query($sql_update);



$comm_amt='';
$old_stock_offer='';


    
} // end do item while



} // end master while

     

echo "<h2>Process Done</h2>";
} // end process



?>




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

                <td height="40" colspan="6" bgcolor="#00FF00"><div align="center" class="style2">Upload Dealer Opening Qty</div></td>
                </tr>

              <!--<tr>-->
              <!--  <td>Start Date </td>-->
              <!--  <td width="18%"><input type="date" name="fdate" style="width:160px;" id="fdate" required="required" / ></td>-->
              <!--</tr>-->
              <tr>
                <td>End Date </td>
                <td width="18%"><input type="date" name="tdate" style="width:160px;" id="tdate" required="required" / ></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr> 
              
              <tr>
                <td>Upload File</td>
                <td colspan="1"><input name="upload_file"  type="file" id="upload_file" required="required"/></td>
                
                <td><input name="upload" type="submit" id="upload" value="Upload Opening" /></td>
                <td>&nbsp;</td>
              </tr>
</form>

              <tr>
                <td colspan='3'> Upload CSV File Example: <br>Sl,Dealer_code,Item_id,stock</td>
              </tr> 
              
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr> 
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>               






<form action=""  method="post">


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
<td height="40" colspan="6" bgcolor="#00FF00"><div align="center" class="style2">Dealer Transection Collection</div></td>
</tr>


              <tr>
                <td>Dealer Code</td>
                <td width="18%"><input type="text" name="dealer_code" style="width:160px;" id="dealer_code"  value=''/ ></td>
              </tr>

              <tr>
                <td>Start Date </td>
                <td width="18%"><input type="date" name="fdate" style="width:160px;" id="fdate" required="required" value='2023-10-01'/ ></td>
              </tr>
              
              <tr>
                <td>End Date </td>
                <td width="18%"><input type="date" name="tdate" style="width:160px;" id="tdate" required="required" value='2023-10-31'/ ></td>
              </tr>

              
              <tr>
                <td></td>
                <td colspan="1"></td>
                
                <td><input name="stock_calculation" type="submit" id="stock_calculation" value="Stock Calculation" /></td>
                <td>&nbsp;</td>
              </tr>

              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>  
              
              
            <tr>
                <td height="40" colspan="3" bgcolor="#00FF00"><div align="center" class="style1">Dealer Commission Calculation System</div></td>
            </tr>

            <tr>
                <td width="20%">&nbsp;</td>
                <td width="30%">&nbsp;</td>
            </tr>


<tr>
<td> Process :</td>
<td>&nbsp;</td>
<td><input name="process" type="submit" id="process" value="Make Commission" /></td>
</tr>
              
              
<tr>
<td>&nbsp;</td>
</tr>

           

</table>
<br/>
</div>
</div>

</div>
</div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
</div>
</form></div>




<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>