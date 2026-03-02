<?php

ini_set('max_execution_time', 6000);
ini_set('max_input_vars', 200000);
ini_set('memory_limit', '512M');

require_once "../../../assets/template/layout.top.php";

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
mysql_query($sql_del);        
}

$old_dealer_code = $emapData[1];

        $sql = "INSERT INTO z_dealer_stock (tr_from,ji_date,dealer_code,item_id,item_in,non_offerable_stock,total_stock,entry_by,entry_at) VALUES
			('Opening','".$tdate."','".$emapData[1]."','".$emapData[2]."','".$emapData[3]."','".$emapData[3]."','".$emapData[3]."','".$entry_by."','".date('Y-m-d H:i:s')."')";
			
        mysql_query($sql); 
    }	

    
} // end while
fclose($file);} // end file upload if

echo "<h2>Upload Complete</h2>";
} // end submit button






// #################################### Dealer Transection Collection ##############################
if(isset($_POST['stock_calculation'])){
    
$now        = date('Y-m-d H:i:s');
$fdate		= $_POST['fdate'];
$tdate		= $_POST['tdate'];



if($_POST['item_id']>0)     { $item_con=' and item_id="'.$_POST['item_id'].'"'; }
if($_POST['dealer_code']>0) { $dealer_con=' and dealer_code="'.$_POST['dealer_code'].'"'; }


// Dealer List
$sql_d="select * from z_dealer_stock where 1 ".$dealer_con." and tr_from='Opening' group by dealer_code order by dealer_code";
$queryd=mysql_query($sql_d);
    while($data=mysql_fetch_object($queryd)){

$dealer_code    = $data->dealer_code;        

        

// old stock data delete
$sql_del = "DELETE FROM z_dealer_stock WHERE ji_date between '".$fdate."' and '".$tdate."' ".$item_con." and dealer_code='".$dealer_code."' and ji_date>'2023-09-30'";
mysql_query($sql_del);


// get primary chalan
$sql1="select * from sale_do_chalan where dealer_code='".$dealer_code."' ".$item_con." and chalan_date between '".$fdate."' and '".$tdate."' ";
$query1=mysql_query($sql1);
    while($data1=mysql_fetch_object($query1)){
        
        // free item tr_from
        if($data1->unit_price==0){$tr_from='Sales Free';}else{$tr_from='Sales';}
        
        // insert data
        $sql_i_chalan="insert into z_dealer_stock(tr_from,tr_no,sr_no,ji_date,dealer_code,item_id,unit_price,tp_price,item_in,entry_by,entry_at)
        values('".$tr_from."','".$data1->id."','".$data1->chalan_no."','".$data1->chalan_date."',$data1->dealer_code,$data1->item_id,$data1->unit_price,$data1->tp_price,$data1->total_unit,'".$entry_by."','".$entry_at."')";
        mysql_query($sql_i_chalan);
    }
    
    
// get 2nd sales qty
$sql2="select * from ss_do_chalan where depot_id='".$dealer_code."' ".$item_con." and chalan_date between '".$fdate."' and '".$tdate."' ";
$query2=mysql_query($sql2);
    while($data2=mysql_fetch_object($query2)){
        
        // insert data
        $sql_i_2nd="insert into z_dealer_stock(tr_from,tr_no,sr_no,ji_date,dealer_code,item_id,item_ex,offer_per,tp_price,entry_by,entry_at)
        values('Sec_Sales','".$data2->id."','".$data2->chalan_no."','".$data2->chalan_date."',$data2->depot_id,$data2->item_id,$data2->total_unit,'".$data2->nsp_per."','".$data2->t_price."','".$entry_by."','".$entry_at."')";
        mysql_query($sql_i_2nd);
    }

    
// get primary return
$sql3="select d.* from sale_return_master m,sale_return_details d 
where m.do_no=d.do_no and m.dealer_code='".$dealer_code."' ".$item_con." and m.status in ('CHECKED') and m.do_date between '".$fdate."' and '".$tdate."' ";
$query3=mysql_query($sql3);
    while($data3=mysql_fetch_object($query3)){
        
        // insert data
        $sql_pr="insert into z_dealer_stock(tr_from,tr_no,sr_no,ji_date,dealer_code,item_id,item_ex,entry_by,entry_at)
        values('Pri_return','".$data3->id."','".$data3->do_no."','".$data3->do_date."',$data3->dealer_code,$data3->item_id,$data3->total_unit,'".$entry_by."','".$entry_at."')";
        mysql_query($sql_pr);
    }  
    
    
// get 2nd return
$sql4="select d.* from ss_receive_master m,ss_receive_details d 
where m.or_no=d.or_no and m.warehouse_id='".$dealer_code."' and m.status in ('CHECKED') ".$item_con." and m.or_date between '".$fdate."' and '".$tdate."' ";
$query4=mysql_query($sql4);
    while($data4=mysql_fetch_object($query4)){
        
        // insert data
        $sql_secpr="insert into z_dealer_stock(tr_from,tr_no,sr_no,ji_date,dealer_code,item_id,item_in,entry_by,entry_at,tp_price)
        values('Sec_return','".$data4->id."','".$data4->or_no."','".$data4->or_date."',$data4->warehouse_id,$data4->item_id,$data4->qty,'".$entry_by."','".$entry_at."',$data4->rate)";
        mysql_query($sql_secpr);
    }     


// get 2nd journal adjust
$sql5="select * from ss_journal_item 
where warehouse_id='".$dealer_code."' and tr_from='Adjust' ".$item_con." and ji_date between '".$fdate."' and '".$tdate."' ";
$query5=mysql_query($sql5);
    while($data5=mysql_fetch_object($query5)){
        
        // insert data
        $sql_adjust="insert into z_dealer_stock(tr_from,ji_date,dealer_code,item_id,item_in,item_ex,entry_by,entry_at)
        values('Adjust','".$data5->ji_date."',$data5->warehouse_id,$data5->item_id,$data5->item_in,$data5->item_ex,'".$entry_by."','".$entry_at."')";
        mysql_query($sql_adjust);
    } 



} // end dealer list loop

echo '<h2>Stock Calculation Complete</h2>';
} // end stock calculation









// #################################### Final Process ##############################
if(isset($_POST['process'])){
    
$now        = date('Y-m-d H:i:s');

$fdate		= $_POST['fdate'];
$tdate		= $_POST['tdate'];    




if($_POST['item_id']>0)     { $item_con=' and item_id="'.$_POST['item_id'].'"'; }
if($_REQUEST['dealer_code']>0) { $dealer_con=' and dealer_code="'.$_REQUEST['dealer_code'].'"'; }

// Dealer item list
$sql="select * from z_dealer_stock where 1 and ji_date between '".$fdate."' and '".$tdate."' 
".$dealer_con.$item_con." 
and tr_from not in ('Opening') 
group by dealer_code,item_id order by dealer_code,item_id";
$q2=mysql_query($sql);
while($data=mysql_fetch_object($q2)){


    
    // get opening qty
    $st="select id,ji_date,offerable_stock,non_offerable_stock 
    from z_dealer_stock where dealer_code='".$data->dealer_code."' and item_id='".$data->item_id."' and ji_date<'".$fdate."' order by ji_date desc,id desc limit 1";
    $opening_qty = findall($st);
    $opening_offerable_stock        = $opening_qty->offerable_stock;
    $opening_non_offerable_stock    = $opening_qty->non_offerable_stock;
    
    $stock_non_offer    = $opening_non_offerable_stock; // 100
    $stock_offer        = $opening_offerable_stock;
    
    // Dealer item details
    $sql3="select * from z_dealer_stock 
    where ji_date between '".$fdate."' and '".$tdate."' and dealer_code='".$data->dealer_code."' and item_id='".$data->item_id."' order by ji_date,id";
    
    $query=mysql_query($sql3);
    while($data2=mysql_fetch_object($query)){
    
        $do_qty     = $data2->item_in;
        $sec_qty    = $data2->item_ex;
        
        $old_stock_offer    =$stock_offer;
        $old_stock_nonoffer =$stock_non_offer;
        
        
        
        // ----- Offerable qty
        if($data2->tr_from=='Sec_return' || $data2->tr_from=='Adjust' || $data2->tr_from=='Sales Free'){
            $stock_offer=$old_stock_offer;
        }else{
           if(($stock_offer+$do_qty)>$sec_qty){ $stock_offer= $stock_offer+$do_qty-$sec_qty; }else{ $stock_offer=0;} 
        }
        
        
        // ----- NON Offerable qty
        if($data2->tr_from=='Sec_return' || $data2->tr_from=='Adjust' || $data2->tr_from=='Sales Free'){
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
        mysql_query($sql_update);
        
        
        
        $comm_amt='';
        $old_stock_offer='';
    
    
        
    } // end do item while



} // end master while




echo "<h2>Process Done</h2>";
} // end process







if(isset($_POST['stock_calculation2'])){
    
$now        = date('Y-m-d H:i:s');
$fdate		= $_POST['fdate'];
$tdate		= $_POST['tdate'];



if($_POST['item_id']>0)     { $item_con=' and item_id="'.$_POST['item_id'].'"'; }
if($_POST['dealer_code']>0) { $dealer_con=' and dealer_code="'.$_POST['dealer_code'].'"'; }


// Clear data from z_dealer_stock2
$clear_sql = "TRUNCATE TABLE z_dealer_stock2";
mysql_query($clear_sql);


// Dealer List
$sql_d="select * from z_dealer_stock where 1 ".$dealer_con." and tr_from='Opening' group by dealer_code order by dealer_code";
$queryd=mysql_query($sql_d);
    while($data=mysql_fetch_object($queryd)){

$dealer_code    = $data->dealer_code;        


// old stock data delete
//$sql_del = "DELETE FROM z_dealer_stock2 WHERE ji_date between '".$fdate."' and '".$tdate."' ".$item_con." and dealer_code='".$dealer_code."' and ji_date>'2023-09-30'";
//mysql_query($sql_del);


// get primary chalan
$sql1="select * from sale_do_chalan where dealer_code='".$dealer_code."' ".$item_con." and chalan_date between '".$fdate."' and '".$tdate."' ";
$query1=mysql_query($sql1);
    while($data1=mysql_fetch_object($query1)){
        
        // free item tr_from
        if($data1->unit_price==0){$tr_from='Sales Free';}else{$tr_from='Sales';}
        
        // insert data
        $sql_i_chalan="insert into z_dealer_stock2(tr_from,tr_no,sr_no,ji_date,dealer_code,item_id,unit_price,tp_price,item_in,entry_by,entry_at)
        values('".$tr_from."','".$data1->id."','".$data1->chalan_no."','".$data1->chalan_date."',$data1->dealer_code,$data1->item_id,$data1->unit_price,$data1->tp_price,$data1->total_unit,'".$entry_by."','".$entry_at."')";
        mysql_query($sql_i_chalan);
    }
    
    
// get 2nd sales qty
$sql2="select * from ss_do_chalan where depot_id='".$dealer_code."' ".$item_con." and chalan_date between '".$fdate."' and '".$tdate."' ";
$query2=mysql_query($sql2);
    while($data2=mysql_fetch_object($query2)){
        
        // insert data
        $sql_i_2nd="insert into z_dealer_stock2(tr_from,tr_no,sr_no,ji_date,dealer_code,item_id,item_ex,offer_per,tp_price,entry_by,entry_at)
        values('Sec_Sales','".$data2->id."','".$data2->chalan_no."','".$data2->chalan_date."',$data2->depot_id,$data2->item_id,$data2->total_unit,'".$data2->nsp_per."','".$data2->t_price."','".$entry_by."','".$entry_at."')";
        mysql_query($sql_i_2nd);
    }

    
// get primary return
$sql3="select d.* from sale_return_master m,sale_return_details d 
where m.do_no=d.do_no and m.dealer_code='".$dealer_code."' ".$item_con." and m.status in ('CHECKED') and m.do_date between '".$fdate."' and '".$tdate."' ";
$query3=mysql_query($sql3);
    while($data3=mysql_fetch_object($query3)){
        
        // insert data
        $sql_pr="insert into z_dealer_stock2(tr_from,tr_no,sr_no,ji_date,dealer_code,item_id,item_ex,entry_by,entry_at)
        values('Pri_return','".$data3->id."','".$data3->do_no."','".$data3->do_date."',$data3->dealer_code,$data3->item_id,$data3->total_unit,'".$entry_by."','".$entry_at."')";
        mysql_query($sql_pr);
    }  
    
    
// get 2nd return
$sql4="select d.* from ss_receive_master m,ss_receive_details d 
where m.or_no=d.or_no and m.warehouse_id='".$dealer_code."' and m.status in ('CHECKED') ".$item_con." and m.or_date between '".$fdate."' and '".$tdate."' ";
$query4=mysql_query($sql4);
    while($data4=mysql_fetch_object($query4)){
        
        // insert data
        $sql_secpr="insert into z_dealer_stock2(tr_from,tr_no,sr_no,ji_date,dealer_code,item_id,item_in,entry_by,entry_at,tp_price)
        values('Sec_return','".$data4->id."','".$data4->or_no."','".$data4->or_date."',$data4->warehouse_id,$data4->item_id,$data4->qty,'".$entry_by."','".$entry_at."',$data4->rate)";
        mysql_query($sql_secpr);
    }     


// get 2nd journal adjust
$sql5="select * from ss_journal_item 
where warehouse_id='".$dealer_code."' and tr_from='Adjust' ".$item_con." and ji_date between '".$fdate."' and '".$tdate."' ";
$query5=mysql_query($sql5);
    while($data5=mysql_fetch_object($query5)){
        
        // insert data
        $sql_adjust="insert into z_dealer_stock2 (tr_from,ji_date,dealer_code,item_id,item_in,item_ex,entry_by,entry_at)
        values('Adjust','".$data5->ji_date."',$data5->warehouse_id,$data5->item_id,$data5->item_in,$data5->item_ex,'".$entry_by."','".$entry_at."')";
        mysql_query($sql_adjust);
    } 



} // end dealer list loop

echo '<h2>Stock Calculation Complete2</h2>';
} // end stock calculation





// new process system
if(isset($_POST['process2'])){
    
$now        = date('Y-m-d H:i:s');

$fdate		= $_POST['fdate'];
$tdate		= $_POST['tdate'];    



if($_POST['item_id']>0)     { $item_con=' and item_id="'.$_POST['item_id'].'"'; }
if($_REQUEST['dealer_code']>0) { $dealer_con=' and dealer_code="'.$_REQUEST['dealer_code'].'"'; }



// get last closing
$sql_closing = "SELECT a.dealer_code, a.item_id, a.offerable_stock, a.non_offerable_stock
FROM z_dealer_stock a
INNER JOIN (
    SELECT item_id, dealer_code, MAX(CONCAT(ji_date, LPAD(id, 10, '0'))) AS max_ji_date_id
    FROM z_dealer_stock
    WHERE ji_date < '".$fdate."'
    GROUP BY dealer_code, item_id
) groupedp 
ON a.item_id = groupedp.item_id 
AND a.dealer_code = groupedp.dealer_code 
AND CONCAT(a.ji_date, LPAD(a.id, 10, '0')) = groupedp.max_ji_date_id
ORDER BY a.dealer_code, a.item_id";
$ccl=mysql_query($sql_closing);
while($datac=mysql_fetch_object($ccl)){
    $closing_offerable_stock[$datac->dealer_code][$datac->item_id]=$datac->offerable_stock;
    $closing_non_offerable_stock[$datac->dealer_code][$datac->item_id]=$datac->non_offerable_stock;
}


// Dealer item list
$sql="select * from z_dealer_stock2 where 1 and ji_date between '".$fdate."' and '".$tdate."' 
".$dealer_con.$item_con." 
and tr_from not in ('Opening') 
group by dealer_code,item_id order by dealer_code,item_id";
$q2=mysql_query($sql);
while($data=mysql_fetch_object($q2)){


    
    // get opening qty
    // $st="select id,ji_date,offerable_stock,non_offerable_stock 
    // from z_dealer_stock 
    // where dealer_code='".$data->dealer_code."' and item_id='".$data->item_id."' and ji_date<'".$fdate."' 
    // order by ji_date desc,id desc limit 1";
    // $opening_qty = findall($st);
    //$opening_offerable_stock        = $opening_qty->offerable_stock;
    //$opening_non_offerable_stock    = $opening_qty->non_offerable_stock;

    
    $opening_offerable_stock        = $closing_offerable_stock[$data->dealer_code][$data->item_id];
    $opening_non_offerable_stock    = $closing_non_offerable_stock[$data->dealer_code][$data->item_id];
    
    
    
    $stock_non_offer    = $opening_non_offerable_stock; // 100
    $stock_offer        = $opening_offerable_stock;
    
    // Dealer item details
    $sql3="select * from z_dealer_stock2 
    where ji_date between '".$fdate."' and '".$tdate."' and dealer_code='".$data->dealer_code."' and item_id='".$data->item_id."' order by ji_date,id";
    
    $query=mysql_query($sql3);
    while($data2=mysql_fetch_object($query)){
    
        $do_qty     = $data2->item_in;
        $sec_qty    = $data2->item_ex;
        
        $old_stock_offer    =$stock_offer;
        $old_stock_nonoffer =$stock_non_offer;
        
        
        
        // ----- Offerable qty
        if($data2->tr_from=='Sec_return' || $data2->tr_from=='Adjust' || $data2->tr_from=='Sales Free'){
            $stock_offer=$old_stock_offer;
        }else{
           if(($stock_offer+$do_qty)>$sec_qty){ $stock_offer= $stock_offer+$do_qty-$sec_qty; }else{ $stock_offer=0;} 
        }
        
        
        // ----- NON Offerable qty
        if($data2->tr_from=='Sec_return' || $data2->tr_from=='Adjust' || $data2->tr_from=='Sales Free'){
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
        $sql_update="update z_dealer_stock2 set opening_qty='".$op_qty."', offerable_stock='".$stock_offer."', non_offerable_stock='".$stock_non_offer."',total_stock='".$total_qty."',comm_amt='".$comm_amt."'
        where id='".$data2->id."' ";
        mysql_query($sql_update);
        
        
        
        $comm_amt='';
        $old_stock_offer='';
    
    
        
    } // end do item while



} // end master while


// now i have to copy all my update row data to my original table: z_dealer_stock
// delete old data
$sql_del = "DELETE FROM z_dealer_stock WHERE ji_date between '".$fdate."' and '".$tdate."' ".$item_con.$dealer_con."  and ji_date>'2023-09-30'";
mysql_query($sql_del);

$copy_sql = "INSERT INTO z_dealer_stock (ji_date, dealer_code, item_id, tr_from, tr_no, sr_no, opening_qty, item_in, item_ex, offer_per, unit_price, tp_price, offerable_stock, non_offerable_stock, total_stock, comm_amt, comm_amt2, entry_by, entry_at) 
    SELECT ji_date, dealer_code, item_id, tr_from, tr_no, sr_no, opening_qty, item_in, item_ex, offer_per, unit_price, tp_price, offerable_stock, non_offerable_stock, total_stock, comm_amt, comm_amt2, entry_by, entry_at
    FROM z_dealer_stock2 where 1 ".$item_con.$dealer_con." ";
mysql_query($copy_sql);


echo "<h2>Process Done</h2>";
} // end process









// off ase
if (isset($_POST['process33'])) {
    
    $now = date('Y-m-d H:i:s');
    $fdate = $_POST['fdate'];
    $tdate = $_POST['tdate'];    

    // Apply filters
    $item_con = ($_POST['item_id'] > 0) ? ' and item_id="' . $_POST['item_id'] . '"' : '';
    $dealer_con = ($_REQUEST['dealer_code'] > 0) ? ' and dealer_code="' . $_REQUEST['dealer_code'] . '"' : '';

    // Step 1: Fetch and store opening stock details for each dealer and item
    $opening_stock = [];
    $sql_opening = "SELECT dealer_code, item_id, offerable_stock, non_offerable_stock 
                    FROM z_dealer_stock 
                    WHERE ji_date < '$fdate' 
                    $dealer_con $item_con 
                    ORDER BY dealer_code, item_id, ji_date DESC, id DESC";
    $result_opening = mysql_query($sql_opening);

    while ($row = mysql_fetch_object($result_opening)) {
        $key = $row->dealer_code . '-' . $row->item_id;
        if (!isset($opening_stock[$key])) { // Store only the latest opening stock per dealer and item
            $opening_stock[$key] = [
                'offerable_stock' => $row->offerable_stock,
                'non_offerable_stock' => $row->non_offerable_stock
            ];
        }
    }

    // Step 2: Retrieve dealer items
    $sql = "SELECT * FROM z_dealer_stock2 
            WHERE ji_date BETWEEN '$fdate' AND '$tdate' 
            $dealer_con $item_con 
            AND tr_from NOT IN ('Opening') 
            GROUP BY dealer_code, item_id 
            ORDER BY dealer_code, item_id";
    $dealer_data = mysql_query($sql);
    
    //$batch_updates = [];

    // Step 3: Process each dealer and item with pre-fetched opening stock
    while ($data = mysql_fetch_object($dealer_data)) {
        $key = $data->dealer_code . '-' . $data->item_id;

        // Retrieve pre-fetched opening stock details
        $opening_offerable_stock = isset($opening_stock[$key]['offerable_stock']) ? $opening_stock[$key]['offerable_stock'] : 0;
        $opening_non_offerable_stock = isset($opening_stock[$key]['non_offerable_stock']) ? $opening_stock[$key]['non_offerable_stock'] : 0;


        // Initialize stock values
        $stock_non_offer = $opening_non_offerable_stock; 
        $stock_offer = $opening_offerable_stock;

        // Get dealer item details for the date range
        $sql3 = "SELECT * FROM z_dealer_stock2 
                 WHERE ji_date BETWEEN '$fdate' AND '$tdate' 
                 AND dealer_code='$data->dealer_code' 
                 AND item_id='$data->item_id' 
                 ORDER BY ji_date, id";
        $items = mysql_query($sql3);
        
        while ($item = mysql_fetch_object($items)) {
            // Your existing calculation logic here
            $do_qty = $item->item_in;
            $sec_qty = $item->item_ex;

            $old_stock_offer = $stock_offer;
            $old_stock_nonoffer = $stock_non_offer;

            // Calculations for offerable and non-offerable stock
            if ($item->tr_from == 'Sec_return' || $item->tr_from == 'Adjust' || $item->tr_from == 'Sales Free') {
                $stock_offer = $old_stock_offer;
            } else {
                if (($stock_offer + $do_qty) > $sec_qty) {
                    $stock_offer = $stock_offer + $do_qty - $sec_qty;
                } else {
                    $stock_offer = 0;
                }
            }

            // Non-offerable stock calculations
            if ($item->tr_from == 'Sec_return' || $item->tr_from == 'Adjust' || $item->tr_from == 'Sales Free') {
                $stock_non_offer = $stock_non_offer + $do_qty;
            } else {
                if (($old_stock_offer + $do_qty) > $sec_qty) {
                    $stock_non_offer = $stock_non_offer;
                } else {
                    $stock_non_offer = $stock_non_offer + $old_stock_offer + $do_qty - $sec_qty;
                }
            }

            $op_qty = $old_stock_offer + $old_stock_nonoffer;
            $total_qty = $stock_offer + $stock_non_offer;

            // Comm amt calculation for 'Sec_Sales' transactions
            if ($item->tr_from == 'Sec_Sales') {
                $nsp_per = $item->offer_per / 100;
                $tp = $item->tp_price;

                $comm_amt = (($old_stock_offer + $do_qty) > $sec_qty) ?
                            ($sec_qty * $tp) * $nsp_per :
                            (($old_stock_offer + $do_qty) * $tp) * $nsp_per;
            }

            // Add update query to batch
            //$batch_updates[] = 
            $sql_update= "UPDATE z_dealer_stock2 SET 
                        opening_qty='$op_qty', 
                        offerable_stock='$stock_offer', 
                        non_offerable_stock='$stock_non_offer', 
                        total_stock='$total_qty', 
                        comm_amt='$comm_amt'
                        WHERE id='$item->id'";
            mysql_query($sql_update);
                                
       
            // update done 
            //$sql_done="update z_dealer_stock2 set done=1 where ji_date BETWEEN '$fdate' AND '$tdate' and dealer_code='".$data->dealer_code."' and item_id='".$data->item_id."' ";
            //mysql_query($sql_done);        
                                
        } // end while
    
       
        
    } // end while

    // Execute batch updates
    // if (!empty($batch_updates)) {
    //     foreach ($batch_updates as $query) {
    //         mysql_query($query);
    //     }
    // }


// now i have to copy all my update row data to my original table: z_dealer_stock
// delete old data
$sql_del = "DELETE FROM z_dealer_stock WHERE ji_date between '".$fdate."' and '".$tdate."' ".$item_con.$dealer_con."  and ji_date>'2023-09-30'";
mysql_query($sql_del);

$copy_sql = "INSERT INTO z_dealer_stock (dealer_code, item_id, ji_date, offerable_stock, non_offerable_stock, total_stock, comm_amt, opening_qty) 
    SELECT dealer_code, item_id, ji_date, offerable_stock, non_offerable_stock, total_stock, comm_amt, opening_qty
    FROM z_dealer_stock2";
mysql_query($copy_sql);



echo "<h2>Process Done</h2>";


} // end submit




// #################################### Auto Final Process ##############################
if(isset($_POST['auto_process']) || $_GET['dealer_code']>0 ){
    
$now        = date('Y-m-d H:i:s');

$fdate		= $_REQUEST['fdate'];
$tdate		= $_REQUEST['tdate'];    



if($_POST['item_id']>0) { $item_con=' and item_id="'.$_POST['item_id'].'"'; }
if($_REQUEST['dealer_code']>0) { $dealer_con=' and dealer_code="'.$_REQUEST['dealer_code'].'"'; }

// Dealer item list
$sql="select * from z_dealer_stock where 1 and ji_date between '".$fdate."' and '".$tdate."' 
".$dealer_con.$item_con." 
and tr_from not in ('Opening')
group by dealer_code,item_id order by dealer_code,item_id";
$q2=mysql_query($sql);
while($data=mysql_fetch_object($q2)){


    // get opening qty
    $st="select id,ji_date,offerable_stock,non_offerable_stock 
    from z_dealer_stock where dealer_code='".$data->dealer_code."' and item_id='".$data->item_id."' and ji_date<'".$fdate."' order by ji_date desc,id desc limit 1";
    $opening_qty = findall($st);
    $opening_offerable_stock        = $opening_qty->offerable_stock;
    $opening_non_offerable_stock    = $opening_qty->non_offerable_stock;
    
    $stock_non_offer    = $opening_non_offerable_stock; // 100
    $stock_offer        = $opening_offerable_stock;
    
        // Dealer item transection loop
        $sql3="select * from z_dealer_stock 
        where ji_date between '".$fdate."' and '".$tdate."' and dealer_code='".$data->dealer_code."' and item_id='".$data->item_id."' 
        order by ji_date,id";
        
        $query=mysql_query($sql3);
        while($data2=mysql_fetch_object($query)){
        
        $do_qty     = $data2->item_in;
        $sec_qty    = $data2->item_ex;
        
        $old_stock_offer    =$stock_offer;
        $old_stock_nonoffer =$stock_non_offer;
        
        
        
        // ----- Offerable qty
        if($data2->tr_from=='Sec_return' || $data2->tr_from=='Adjust' || $data2->tr_from=='Sales Free'){
            $stock_offer=$old_stock_offer;
        }else{
           if(($stock_offer+$do_qty)>$sec_qty){ $stock_offer= $stock_offer+$do_qty-$sec_qty; }else{ $stock_offer=0;} 
        }
        
        
        // ----- NON Offerable qty
        if($data2->tr_from=='Sec_return' || $data2->tr_from=='Adjust' || $data2->tr_from=='Sales Free'){
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
        where id='".$data2->id."' ";
        mysql_query($sql_update);
        
    
        $comm_amt='';
        $old_stock_offer='';
        
        
            
        } // end do item while


    } // end dealer while
    
    // Next dealer code
        $dcode=$_REQUEST['dealer_code'];
        $sqln="select dealer_code from z_dealer_stock where dealer_code>'".$dcode."' and ji_date between '".$fdate."' and '".$tdate."' order by dealer_code asc limit 1";
        //$sqln="select dealer_code from dealer_info where dealer_type=1 and dealer_code>$dcode order by dealer_code asc limit 1";
        
        $next_dealer_code=find1($sqln);
        if($next_dealer_code>0){
            redirect("dealer_comm.php?dealer_code=".$next_dealer_code."&fdate=".$fdate."&tdate=".$tdate);
        }else{
            echo 'Dealer Done.... '.$dcode;
        }


echo "<h2>Auto Process Done</h2>";
} // end auto process

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
                
                <!--<td><input name="upload" type="submit" id="upload" value="Upload Opening" /></td>-->
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
                <td width="18%"><input type="text" name="dealer_code" style="width:160px;" id="dealer_code"  value='<?=$_POST['dealer_code']?>'/ ></td>
              </tr>
              
              <tr>
                <td>Item Code</td>
                <td width="18%"><input type="text" name="item_id" style="width:160px;" id="item_id"  value='<?=$_POST['item_id']?>'/ ></td>
              </tr>              

              <tr>
                <td>Start Date </td>
                <td width="18%"><input type="date" name="fdate" style="width:160px;" id="fdate" required="required" value='<?=$_POST['fdate']?$_POST['fdate']:date('Y-m-01')?>'/ ></td>
              </tr>
              
              <tr>
                <td>End Date </td>
                <td width="18%"><input type="date" name="tdate" style="width:160px;" id="tdate" required="required" value='<?=$_POST['tdate']?$_POST['tdate']:date('Y-m-d')?>'/ ></td>
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
<td><input name="process" type="submit" id="process" value="Make Commission" /></td>
<td><input name="auto_process" type="submit" id="auto_process" value="Auto Dealer Make Commission" /></td>
</tr>
              
              
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
    <input name="stock_calculation2" type="submit" id="stock_calculation2" value="Stock Calculation2" />
<input name="process2" type="submit" id="process2" value="Make Commission (Demo test)" />
</td>
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
require_once "../../../assets/template/layout.bottom.php";
?>