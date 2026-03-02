<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



//--========Table information==========-----------//
$table_master='sale_do_master';

$unique_master='do_no';

$table_detail='sale_do_details';

$unique_detail='id';

//--========Table information==========-----------//

$unique = $_POST[$unique_master];


//$_POST['unit_price']=$_POST['unit_price'] ;

$table		=$table_detail;
$crud      	=new crud($table);


		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['group_for']=$_SESSION['user']['group'];

		$_POST['entry_at']=date('Y-m-d h:i:s');

	
//		$_POST['dist_unit'] = ($_POST['pkt_unit'] * $_POST['pkt_size']);
//		$_POST['total_unit'] = $_POST['dist_unit'];
//		$_POST['net_total_amt'] = ($_POST['total_unit'] * $_POST['unit_price']);
//		$_POST['total_amt'] = ($_POST['net_total_amt'] - $_POST['discount']);
		



$crud->insert();




//$res='select a.id,b.finish_goods_code as code,b.item_name,a.unit_price as price, a.total_unit as qty , a.discount, a.amt_after_discount, "X" from sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$unique.' order by a.id';


//$all_dealer[]=link_report_add_del_auto($res,'',7);
$str .= '<div  class="tabledesign2">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<th width="1%">SL</th>
<th width="33%">Product Name</th>
<th width="8%">CRT Price</th>
<th width="6%">CRT</th>
<th width="6%">PCS</th>
<th width="9%">Net Sale</th>
<th width="10%">Discount</th>
<th width="10%">Vat Amt</th>
<th width="9%">Due Amt</th>
<th width="8%">X</th>
</tr>';

 $res='select a.id,b.item_name,a.crt_price as ctn_price, a.pkt_unit as ctn, a.dist_unit as pcs, a.total_amt as Net_sale, a.discount, a.vat_amt, a.total_amt_with_vat as Due_amt from 
   sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$unique.' order by a.id';

$i=1;


$query = db_query($res);

while($data=mysqli_fetch_object($query)){ 
$str .= '<tr>';
$str .= '<td>'.$i++.'</td>';

$str .= '<td>'.$data->item_name.'</td>';
$str .= '<td>'.$data->ctn_price.'</td>';
$str .= '<td>'.$data->ctn.'</td>'; $tot_ctn +=$data->ctn;
$str .= '<td>'.$data->pcs.'</td>'; $tot_pcs +=$data->pcs;
$str .= '<td>'.$data->Net_sale.'</td>'; $tot_Net_sale +=$data->Net_sale;
$str .= '<td>'.$data->discount.'</td>'; $tot_discount +=$data->discount;
$str .= '<td>'.$data->vat_amt.'</td>'; $tot_vat_amt +=$data->vat_amt;
$str .= '<td>'.$data->Due_amt.'</td>'; $tot_Due_amt +=$data->Due_amt;
$str .= '<td><a href="?del='.$data->id.'">X</a></td>';
$str .= '</tr>';


 }
 
 
$str .= '<tr>';
$str .= '<td></td>';

$str .= '<td><div align="right"><strong>TOTAL:</strong></div></td>';
$str .= '<td></td>';
$str .= '<td>'.$tot_ctn.'</td>';
$str .= '<td>'.$tot_pcs.'</td>'; 
$str .= '<td>'.$tot_Net_sale.'</td>'; 
$str .= '<td>'.$tot_discount.'</td>';
$str .= '<td>'.$tot_vat_amt.'</td>'; 
$str .= '<td>'.$tot_Due_amt.'</td>'; 
$str .= '<td></td>';
$str .= '</tr>';


$str .= '</table></div>';
$all_dealer[]=$str;
echo json_encode($all_dealer);

?>



