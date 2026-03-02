<?

session_start();

require "../../support/inc.all.php";

date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)

{

	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))

	{

		$t_date=$_POST['t_date'];

		$f_date=$_POST['f_date'];


	}

if($_POST['group_id']!='') 	$group_id=$_POST['group_id'];

if ($_POST['group_name']!='')	$group_name=$_POST['group_name'];

if($_POST['item_sub_group']!='') 	$item_sub_group=$_POST['item_sub_group'];

if($_POST['group_for']!='') 	$group_for=$_POST['group_for'];

if($_POST['zon_id']!='') 	$zon_id=$_POST['zon_id'];

if($_POST['item_brand']!='') 		$item_brand=$_POST['item_brand'];

if($_POST['product_nature']!='') 	$product_nature=$_POST['product_nature'];

if($_POST['dealer_code']!='')	$dealer_code=$_POST['dealer_code'];


if(isset($group_id)) 			{$group_id_con=' and s.group_id ='.$group_id;} 

if(isset($item_group))			{$item_group_con=' and a.group_id ='.$item_group;}

if(isset($item_sub_group)) 			{$item_sub_group_con=' and i.sub_group_id ='.$item_sub_group;} 

if(isset($group_for)) 			{$group_for_con=' and i.group_for ='.$group_for;} 

if(isset($zon_id)) 			{$zon_id_con=' and a.ZONE_ID ='.$zon_id;} 

if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 

if(isset($product_nature)) 			{$product_nature=' and i.product_nature="'.$product_nature.'"';} 

if(isset($dealer_code))			{$dealer_code_con=' and dealer_code="'.$dealer_code.'"';}



switch ($_POST['report']) {


case 1:



$report="Product List";




$sql="select 

a.group_name,

s.sub_group_name,

i.item_id as product_code,
 
i.item_name as product_name,

i.unit_name as unit,

i.bag_size,

i.d_price as Dealer_Price,

i.status

from 

item_group a, item_info i,item_sub_group s, item_group g, user_group c

where a.group_id=g.group_id and g.group_id=s.group_id and s.sub_group_id=i.sub_group_id and i.group_for=c.id

".$item_sub_group_con.$zon_id_con.$product_nature.$group_for_con.$item_group_con.$group_id_con."

order by i.item_id";



break;



case 111:



$report="Dealer Report Details";



$sql="select s.do_no, s.do_date, m.do_type, i.item_name, s.total_unit, s.bag_unit, s.unit_price, d.dealer_code, d.dealer_type, d.zone_name, d.dealer_name_e, d.address_e, s.status



from 



dealer_info d, sale_do_details s, item_info i, sale_do_master m



where d.dealer_code=s.dealer_code and s.item_id=i.item_id and s.do_no=m.do_no order by s.do_no";



break;





case 888:

				$report="Product Information (Rate Changable)";

				break;
				

				





case 10:
        
        if(isset($zon_id)) 			{$zon_id_con=' and a.zone_code ='.$zon_id;} 
	
	$report="Dealer Report";
	
	$sql="select
	
	  a.dealer_code, 
    
      a.dealer_name_e as dealer_name, 
    
      a.zone_name, 
    
      a.dealer_type
		
	from 
    
      dealer_info a
	
	
	where 1 ".$zon_id_con."";
	
	
	break;


case 2:



$report="Product List Details";



$sql="select i.item_id, i.item_name,s.sub_group_name, i.finish_goods_code, i.product_nature,i.unit_name,i.pack_unit,i.pack_size,i.purchase_unit,i.purchase_size
,i.p_price,i.f_price,i.d_price,i.t_price,i.m_price,i.cost_price,i.sale_price,i.sales_item_type,i.item_brand



from 



item_info i,item_sub_group s



where s.sub_group_id=i.sub_group_id ".$product_group_con.$item_brand_con.$product_nature."order by i.finish_goods_code asc";



break;





case 3:



$report="Price List Details";



$sql="select i.item_id, i.item_name,s.sub_group_name, i.finish_goods_code, i.product_nature,i.unit_name,i.d_price as net_price,i.t_price as trade_price,i.m_price as market_price,i.c_price as corporate_price ,i.s_price as supershop_price,i.sales_item_type,i.item_brand



from 



item_info i,item_sub_group s



where s.sub_group_id=i.sub_group_id ".$product_group_con.$item_brand_con.$product_nature."order by i.finish_goods_code asc";



break;







}



}



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="content-type" content="text/html; charset=utf-8" />



<title><?=$report?></title>



<link href="../../css/report.css" type="text/css" rel="stylesheet" />



<script language="javascript">



function hide()



{



document.getElementById('pr').style.display='none';



}



</script>



    <style type="text/css" media="print">



      div.page



      {



        page-break-after: always;



        page-break-inside: avoid;



      }



    </style>



</head>



<body>



<div align="center" id="pr">



<input type="button" value="Print" onclick="hide();window.print();"/>



</div>



<div class="main">



<?



		$str 	.= '<div class="header">';



		if(isset($_SESSION['company_name'])) 



		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';



		if(isset($report)) 



		$str 	.= '<h2>'.$report.'</h2>';
		
		
		


		
		if(isset($group_for)) 

		$str 	.= '<h2>Concern Name :' .find_a_field('user_group','group_name','id='.$group_for).'</h2>';
		
		

		if(isset($to_date)) 



		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';



		if(isset($product_group)) 



		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';



		$str 	.= '</div>';



		$str 	.= '<div class="left" style="width:100%">';







echo report_create($sql,1,$str);








if($_POST['report']==888) 

{




         $sql="select g.group_name, s.sub_group_name, i.item_id, i.item_name, i.unit_name, i.d_price from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id ".$item_sub_group_con.$zon_id_con.$product_nature.$group_for_con.$group_id_con;

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><td style="border:0px;" colspan="5"><?=$str?></td></tr>

<tr><th>S/L</th>

<th>Group Name </th>

<th>Sub Group Name </th>

<th>Product Code </th>
<th>Product Name </th>

<th>Unit Name </th>
<th>Dealer Price</th>

<th>Submit</th>
</tr></thead>

<tbody>

<?

$ajax_page = "rd_issue_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

<td><?=$datas[0]?></td>

<td><?=$datas[1]?></td>

  <td><?=$datas[2]?></td>
  <td><?=$datas[3]?></td>

  <td><?=$datas[4]?></td>
  <td><input type="hidden" name="item_id#<?=$datas[2]?>" id="item_id#<?=$datas[2]?>" value="<?=$datas[2]?>" />

      <input name="item_id#<?=$datas[5]?>" type="text" id="item_id#<?=$datas[5]?>" value="<?=$datas[5]?>" />  </td>

  <td><div id="po<?=$datas[2]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[2]?>',document.getElementById('item_id#<?=$datas[2]?>').value,document.getElementById('item_id#<?=$datas[2]?>').value);" /></div></td>
  </tr>

<?

}

?></tbody></table>

<?

}









?></div>



</body>



</html>