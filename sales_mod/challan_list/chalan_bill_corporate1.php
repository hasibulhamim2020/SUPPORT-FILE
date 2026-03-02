<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$chalan_no 		= $_REQUEST['v_no'];



$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$v_no);



$sql1="select d.*,b.*, sum(b.total_unit) as total_unit, d.total_unit as ord_unit, sum(b.total_amt) as total_amt, b.total_unit as item_ex, m.depot_id as depot, m.remarks, m.mr_no, m.rcv_amt, m.payment_by, m.cash_discount as cash_discountm

from sale_do_chalan b,sale_do_details d,  sale_do_master m 

where d.id=b.order_no and m.do_no=d.do_no and b.chalan_no = '".$chalan_no."' and (b.item_id!=1096000100010239 and b.item_id!=1096000100010312) group by b.order_no order by d.id";
//echo $sql1;
$data1=db_query($sql1);





$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;

$depot_id=$info->depot;

$cash_discountm=$info->cash_discountm;

$remarks=$info->remarks;

$entry_time=$info->entry_time;

$chalan_date=$info->chalan_date;

$do_no=$info->do_no;

$payment_by=$info->payment_by;

$mr_no=$info->mr_no;

$rcv_amt=$info->rcv_amt;

$item_ex[]=$info->item_ex;

$order_no[]=$info->order_no;

$store_sl=$info->driver_name; 

$driver_name=$info->driver_name_real;

$vehicle_no=$info->vehicle_no;

$delivery_man=$info->delivery_man;

$cash_discount=$info->cash_discount;

$del_ord[]=$info->ord_unit;

$undel_ord[]=$info->ord_unit - find_a_field('sale_do_chalan','sum(total_unit)','order_no='.$info->order_no);


$item_id[] = $info->item_id;

$unit_price[] = $info->unit_price;
$t_price[] = $info->t_price;
$pkt_size[] = $info->pkt_size;

$sps = find_a_field('item_info','sub_pack_size','item_id='.$info->item_id);

$sub_pkt_size[] = (($sps>1)?$sps:1);



$total_unit[] = $info->total_unit;

$pkt_unit[] = (int)($info->total_unit/$info->pkt_size);

$dist_unit[] = (int)($info->total_unit%$info->pkt_size);

$ord_unit[] = ($info->ord_unit);

$total_amt[] = $info->total_amt;



}

$entry_sql = 'select u.fname from user_activity_management u, sale_do_master b where u.user_id=b.entry_by and b.do_no='.$do_no;

$entry_by = find_all_field_sql($entry_sql);

$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$ssql = 'select b.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$do = find_all_field_sql($ssql);

$ssqld = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dd = find_all_field_sql($ssqld);


$dept = 'select warehouse_name from warehouse where warehouse_id='.$depot_id;

$deptt = find_all_field_sql($dept);


//if(isset($_POST['cash_discount']))

//{

//

//	$c_no = $_POST['c_no'];

//	$cash_discount = $_POST['cash_discount'];

//	$ssql='update sale_do_chalan set cash_discount="'.$_POST['cash_discount'].'" where chalan_no="'.$c_no.'"';

//	db_query($ssql);

//

//}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>.: Delivery Chalan Bill Report :.</title>
	<script>
function print_cus(){
document.getElementById('pr').style.display='none';
window.print();
}
</script>
    <style>
      * {
    margin: 0;
    padding: 0;
	font-size:13px;
  }
  p {
    margin: 0;
    padding: 0;
  }
  h1,
  h2,
  h3,
  h4,
  h5,
  h6
   {
    margin: 0 !important;
    padding: 0 !important;
  }
  
  th,tr,th,td{
  border:1px solid;
  }

    </style>
  </head>
 
  <body>

    <section >
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-9">
             <div class="company-title">
              <div class="d-flex justify-content-around">
                <div class="d-flex align-items-center">
                  <h4><img style="width:60px" src="habib.png"></h4>
                </div>
                <div class="company-header">
                  <h1 class="text-uppercase text-center"><?php echo find_a_field('project_info','proj_name','1')?></h1>
                  <h5 style="letter-spacing: 2px;" class="bg-dark text-light text-capitalize text-center p-1">Quality product at affordable cost</h5>
                  <p class="text-center"><?php echo find_a_field('project_info','proj_address','1')?></p>
  <p class="text-center">Cell :<?php echo find_a_field('project_info','proj_phone','1')?>.Web:<?php echo find_a_field('project_info','proj_email','1')?>  </p>
                </div>
                <div class="d-flex align-items-center">
                  <h4>Logo 2</h4>
                </div>
              </div>
            </div>
            <div class="text-center">
              <button class="btn btn-default outline border rounded-pill border border-dark"><h4>Challan</h4></button>
            </div>
			     <button type="button" class="btn btn-success" id="pr"  onClick="print_cus()">Print</button>
            <div class="row">
              <div class="col-6 row mb-2 mb-sm-3">
                <label for="no" class="col-sm-2 col-form-label">Challan No</label>
                <div class="col-sm-10">
                  <input type="number" readonly class="form-control" id="no" value="<?php echo $chalan_no;?>">
                </div>
              </div>
              <div class="col-6 row mb-2 mb-sm-3">
                <label for="date" class="col-sm-2 col-form-label">DO No:</label>
                <div class="col-sm-10">
                  <input type="text" readonly class="form-control" id="no" value=" <?=$do_no?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 row mb-2 mb-sm-3">
                <label for="name" class="col-sm-2 col-form-label"> Party Name</label>
                <div class="col-sm-10">
                  <input type="text" readonly class="form-control" id="name" value="<?php echo ($dealer->dealer_name_b=='')?$dealer->dealer_name_e.'- '.$dealer->dealer_code.' ('.$dealer->team_name.')':$dealer->dealer_name_b.'- '.$dealer->dealer_code.' ('.$dealer->team_name.')';?>">
                </div>
              </div>
			  <div class="col-6 row mb-2 mb-sm-3">
                <label for="date" class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                  <input type="text" readonly class="form-control" id="no" value=" <?=$chalan_date?>">
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col-sm-6 row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10  mb-3">
                  <input type="text" readonly class="form-control" id="address" value="<?php echo ($dealer->address_b=='')?$dealer->address_e:$dealer->address_b;?>">
                </div>
              </div>
			  <div class="col-6 row mb-3">
                <label for="cell-tell" class="col-sm-2 col-form-label">Cell/Tell</label>
                <div class="col-sm-10">
                  <input type="text" readonly class="form-control" id="cell-tell" value="<?php echo $dealer->mobile_no;?>">
                </div>
              </div>
            </div>

            <div class="data-table">
              <table class="table table-bordered border-primary  text-center">
                <thead>
                  <tr>
                    <th colspan="1">Sl</th>
					<th colspan="1">Product Code</th>
                    <th colspan="7">Description</th>
                    <th colspan="2">Quantity</th>
					<th colspan="2" >Remark</th>
                  
                  </tr>
                </thead>
                <tbody class=" text-center table-striped">
				
<? for($i=0;$i<$pi;$i++){ 

$gift_o = find_all_field('sale_do_details','','gift_on_order="'.$order_no[$i].'"  and (item_id=1096000100010239 || item_id=1096000100010312)');

$gift_order  = $gift_o->id;



if($gift_order>0){

$gifts = 'select sum(total_unit) total_unit, unit_price from sale_do_chalan where order_no="'.$gift_order.'" and chalan_no = "'.$chalan_no.'"';

$giftq = db_query($gifts);

$gift = mysqli_fetch_object($giftq);



$per_pcs =  (-1)*(@(($gift->unit_price)/@($total_unit[$i]/$gift->total_unit)));

}

else

{

$gift = 0;

$per_pcs = 0;

}



$g=0;

$items = find_all_field('item_info','item_name','item_id='.$item_id[$i]);

$set = find_all_field('sales_corporate_price','discount','dealer_code="'.$dealer->dealer_code.'" and item_id="'.$item_id[$i].'"');

$fit_size = ($items->sub_pack_size>0)?$items->sub_pack_size:1;

?>
				
                  <tr>
                    <td colspan="1"><?=$i+1?></td>
					<td colspan="1"><?=$items->finish_goods_code?></td>
                    <td colspan="7"><? echo $items->item_name; if($unit_price[$i]<1) echo ' <b>[Gift Item]</b>'; ?>
					<? $gsql = 'select offer_name from sale_gift_offer g, sale_do_details d where g.id=d.gift_id and d.gift_on_order="'.$order_no[$i].'"';
                     $gquery = db_query($gsql);
					 while($qdata=mysqli_fetch_object($gquery)){if($g==0) echo '<b>  [Offer-'.$qdata->offer_name; else echo '/'.$qdata->offer_name; $g++; }
					if($g>0) echo ']</b>';?></td>
                    <td colspan="2"><? echo $qty= number_format($item_ex[$i],2);$tttttd = $tttttd + $item_ex[$i];?></td>
                    <td colspan="2"></td>
                  </tr> 
				   <? }?>  
				   
					  <tr>
					 <td colspan="8">Total Qty:</td>
					 <td colspan="2"><b><?php echo $tttttd ?></b></td>
					 <td colspan="2"></td>
					 
					</tr> 
                </tbody>
              </table>
			  
			<?php /*?>  <b>In Word: </b>  <span class="text-capitalize">		  
		<?php $ab=$tot-($tot*$cash_discountm); $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

                 echo $f->format($ab);  ?> Only.<?php */?>
</span>
             
            </div>
			<br><br>
            <div class="row">
              <div class="col-4 text-center">
               
                <br>
               <p style="border-top:1px solid">  Received By  </p>
                
              </div>
			  <div class="col-1"></div>
              <div class="col-3 text-center">
                <b><?php echo $entry_by->fname; ?></b>
                <br>
               <p style="border-top:1px solid"> prepared By  </p>
                
              </div>
			  <div class="col-1"></div>
              <div class="col-3 text-center">
               
                <br>
                 <p style="border-top:1px solid">Checked By  </p>
                
              </div>
			  
            </div>
          </div> 
        </div>
      </div>
    </section>
    

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>