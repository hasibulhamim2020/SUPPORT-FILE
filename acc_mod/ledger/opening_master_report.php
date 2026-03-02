<?



session_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";






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




if($_POST['item_name']!='') 	$item_name=$_POST['item_name'];

if(isset($item_name)) 			{$item_name_con=' and i.item_name like "%'.$item_name.'%"';}



if(isset($group_id)) 			{$group_id_con=' and s.group_id ='.$group_id;} 

if(isset($item_group))			{$item_group_con=' and a.group_id ='.$item_group;}

if(isset($item_sub_group)) 			{$item_sub_group_con=' and i.sub_group_id ='.$item_sub_group;} 

if(isset($group_for)) 			{$group_for_con=' and i.group_for ='.$group_for;} 

if(isset($zon_id)) 			{$zon_id_con=' and a.ZONE_ID ='.$zon_id;} 



if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 



if(isset($product_nature)) 			{$product_nature=' and i.product_nature="'.$product_nature.'"';} 






switch ($_POST['report']) {





case 1:



$report="Finish Good Product List";




 $sql="select i.item_id, g.group_name, s.sub_group_name,  i.finish_goods_code as Item_code, i.item_name,  i.recommended_name, i.item_name_arabic as Arabic_name, i.unit_name,  i.pack_size as CTN_size, 
 i.cost_price, i.sale_price as cash_sale, i.cr_30_days, i.cr_60_days from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id 
  and s.sub_group_id=i.sub_group_id ".$item_sub_group_con.$item_name_con.$product_nature.$group_for_con.$group_id_con;



break;



case 888:

				$report="Product Information (Rate Changable)";

				break;
				
				
				
				
case 889:

				$report="Product Mesh Size Information";

				break;
				
				case 11:

				$report="Ledger Opening Balance Report";

				break;
				
				
				
							
				
case 8888:

				$report="Product Information";

				break;
				
				case 118888:

				$report="Product Information (MINWAL)";

				break;
				
				case 888811:

				$report="Turky Sajjada & Swadie Item";

				break;
				
				case 888822:

				$report="Zadi Item Information";

				break;
				
				case 888833:

				$report="Minwal Carpet Item List";

				break;
				
				case 888898:

				$report="Warehouse Report";

				break;
				
				
				
				case 8889:

				$report="Product Rate Change Information";

				break;
				
				
				case 8890:

				$report="Area and Transport Changes Information";

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



<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script> 
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script> 
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script> 
<script type="text/javascript" src="../../js/jquery.validate.js"></script> 
<script type="text/javascript" src="../../js/paging.js"></script> 
<script type="text/javascript" src="../../js/ddaccordion.js"></script> 
<script type="text/javascript" src="../../js/js.js"></script> 

<script type="text/javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}

function update_value(id)
{
var mobile 	= document.getElementById('mobile#'+id).value;
var sim 	= document.getElementById('sim#'+id).value;
getData2('rd_issue_ajax.php', 'po'+id,id,mobile+'#>'+sim);
}

function Pager(tableName, itemsPerPage) {
    this.tableName = tableName;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;
    
    this.showRecords = function(from, to) {        
        var rows = document.getElementById(tableName).rows;
        // i starts from 1 to skip table header row
        for (var i = 1; i < rows.length; i++) {
            if(i < from || i > to) rows[i].style.display = 'none';
            else rows[i].style.display = '';
        }
    }
    
    this.showPage = function(pageNumber) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}

        var oldPageAnchor = document.getElementById('pg'+this.currentPage);
        oldPageAnchor.className = 'pg-normal';
        
        this.currentPage = pageNumber;
        var newPageAnchor = document.getElementById('pg'+this.currentPage);
        newPageAnchor.className = 'pg-selected';
        
        var from = (pageNumber - 1) * itemsPerPage + 1;
        var to = from + itemsPerPage - 1;
        this.showRecords(from, to);
    }   
    
    this.prev = function() {
        if (this.currentPage > 1)
            this.showPage(this.currentPage - 1);
    }
    
    this.next = function() {
        if (this.currentPage < this.pages) {
            this.showPage(this.currentPage + 1);
        }
    }                        
    
    this.init = function() {
        var rows = document.getElementById(tableName).rows;
        var records = (rows.length - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
    }

    this.showPageNav = function(pagerName, positionId) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}
    	var element = document.getElementById(positionId);
    	
    	var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal">Prev</span>';
        for (var page = 1; page <= this.pages; page++) 
            pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span>';
        pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal">Next</span>';            
        
        element.innerHTML = pagerHtml;
    }
}
var XMLHttpRequestObject = false;

if (window.XMLHttpRequest) 
	XMLHttpRequestObject = new XMLHttpRequest(); 
else if (window.ActiveXObject) 
	{
     	XMLHttpRequestObject = new
        ActiveXObject("Microsoft.XMLHTTP");
    }
function getData(dataSource, divID, data)
	{
	  if(XMLHttpRequestObject) 
		  {
				var obj = document.getElementById(divID);
				XMLHttpRequestObject.open("POST", dataSource);
				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		
				XMLHttpRequestObject.onreadystatechange = function()
					{
						if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
							obj.innerHTML =   XMLHttpRequestObject.responseText;
					}
				XMLHttpRequestObject.send("ledger=" + data);
		  }
	}
function getData2(dataSource, divID, data1, data2)
	{
	//alert('and');
	  if(XMLHttpRequestObject) 
		  {
				var obj = document.getElementById(divID);
				XMLHttpRequestObject.open("POST", dataSource);
				XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		
				XMLHttpRequestObject.onreadystatechange = function()
					{
						if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
							obj.innerHTML =   XMLHttpRequestObject.responseText;
					}
				XMLHttpRequestObject.send("data=" + data1+"##" + data2);

		  }
	}
	function getflatData3()
{
	var b=document.getElementById('category_to').value;
	var a=document.getElementById('proj_code_to').value;
			$.ajax({
		  url: '../../common/flat_option_new3.php',
		  data: "a="+a+"&b="+b,
		  success: function(data) {						
				$('#fid3').html(data);	
			 }
		});
}
	function getflatData2()
{
	var b=document.getElementById('category_from').value;
	var a=document.getElementById('proj_code_from').value;
			$.ajax({
		  url: '../../common/flat_option_new2.php',
		  data: "a="+a+"&b="+b,
		  success: function(data) {						
				$('#fid2').html(data);	
			 }
		});
}








function mm_calculation(id)
{
var mesh_mm 	= document.getElementById('mesh_mm#'+id).value;

var mesh_inch 	= document.getElementById('mesh_inch#'+id).value= (mesh_mm/25.4);

}

//function myClickFunction(id) {
//  document.getElementById("myCheck").click();
//  
//}








function focus_fg(id)
{


var item_short_name 	= document.getElementById('item_short_name#'+id).value;


   if(item_short_name=="")
  {
  
alert('Can not sale more than closing stock quantity.');
  } 


}



var $th = $('.tableFixHead').find('thead th')
$('.tableFixHead').on('scroll', function() {
  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
});


</script>






    <style type="text/css" media="print">
	
	
	.tableFixHead { overflow-y: auto; height: 100px; }

/* Just common table stuff. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }



      div.page



      {



        page-break-after: always;



        page-break-inside: avoid;



      }



    </style>



    <style type="text/css">
<!--
.style1 {color: #FFFFFF}
.image-width{width:150px;}
-->
    </style>


	<?
	require_once "../../../controllers/core/inc.exporttable.php";
	?>



</head>



<body>



<!--<div align="center" id="pr">-->
<!--<input type="button" value="Print" onclick="hide();window.print();"/>-->
<!--</div>-->



<div class="main">



<?



		$str 	.= '<div class="header">';



		//if(isset($_SESSION['company_name'])) 

		//$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		
		if(isset($group_for)) 

		$str 	.= '<img src="<?=SERVER_ROOT?>public/uploads/logo/'.$group_for.'.png"  />';



		if(isset($report)) 



		$str 	.= '<h2>'.$report.'</h2>';
		
		
		


		
		if(isset($group_for)) 

		$str 	.= '<h2>Concern Name : ' .find_a_field('user_group','group_name','id='.$group_for).'</h2>';
		
		if(isset($item_sub_group)) 

		$str 	.= '<h2>Sub Group : ' .find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group).'</h2>';
		
		

		if(isset($t_date)) 



		$str 	.= '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



		if($_POST['group_id']>0) 



		$str 	.= '<h2>Ledger Group : '.find_a_field('ledger_group','group_name','group_id="'.$_POST['group_id'].'"').'</h2>';
		
		if($_POST['ledger_id']>0) 



		$str 	.= '<h2>Ledger : '.find_a_field('accounts_ledger','ledger_name','ledger_id="'.$_POST['ledger_id'].'"').'</h2>';



		$str 	.= '</div>';



		$str 	.= '<div class="left" style="width:100%">';







echo report_create($sql,1,$str);








if($_POST['report']==888) 

{


         $sql="select g.group_name, s.sub_group_name, i.item_id, i.item_name, i.unit_name, i.d_price from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id ".$item_sub_group_con.$zon_id_con.$product_nature.$group_for_con.$group_id_con;

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

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

$ajax_page = "fg_price_change_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

<td><?=$datas[0]?></td>

<td><?=$datas[1]?></td>

  <td><?=$datas[2]?></td>
  <td><?=$datas[3]?></td>

  <td><?=$datas[4]?></td>
  <td><input type="hidden" name="item_id#<?=$datas[2]?>" id="item_id#<?=$datas[2]?>" value="<?=$datas[2]?>" />

      <input name="d_price#<?=$datas[2]?>" type="text" id="d_price#<?=$datas[2]?>" value="<?=$datas[5]?>" />  </td>

  <td><div id="po<?=$datas[2]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[2]?>',document.getElementById('item_id#<?=$datas[2]?>').value,
 
document.getElementById('d_price#<?=$datas[2]?>').value);" /></div></td>
  </tr>

<?

}

?></tbody></table>

<?

}










if($_POST['report']==889) 

{


         $sql="select g.group_name, s.sub_group_name, i.item_id, i.item_name, i.unit_name, i.d_price, i.mesh_size, i.mesh_inch, i.mesh_hend, i.log_sheet, i.mesh_mm from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id ".$item_sub_group_con.$zon_id_con.$product_nature.$group_for_con.$group_id_con;

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

<thead><tr><td style="border:0px;" colspan="13"><?=$str?></td></tr>

<tr><th>S/L</th>

<th>Group Name </th>

<th>Sub Group Name </th>

<th>Product Code </th>
<th>Product Name </th>

<th>Unit Name </th>
<th>Mesh Size </th>
<th>Mesh Inch </th>
<th>Mesh MM </th>
<th>Mesh Hend </th>
<th>Log Sheet </th>
<th>Dealer Price</th>

<th>Submit</th>
</tr></thead>

<tbody>

<?

$ajax_page = "mesh_size_change_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

<td><?=$datas[0]?></td>

<td><?=$datas[1]?></td>

  <td><?=$datas[2]?></td>
  <td><?=$datas[3]?></td>

  <td><?=$datas[4]?></td>
  <td><input name="mesh_size#<?=$datas[2]?>" type="text" id="mesh_size#<?=$datas[2]?>" value="<?=$datas[6]?>" style="width:100px;" /></td>
  <td><input name="mesh_inch#<?=$datas[2]?>" type="text" id="mesh_inch#<?=$datas[2]?>" value="<?=$datas[7]?>"  style="width:60px;" /></td>
  <td><input name="mesh_mm#<?=$datas[2]?>" type="text" id="mesh_mm#<?=$datas[2]?>" value="<?=$datas[10]?>"  style="width:60px;" onKeyUp="mm_calculation(<?=$datas[2]?>)" /></td>
  <td><input name="mesh_hend#<?=$datas[2]?>" type="text" id="mesh_hend#<?=$datas[2]?>" value="<?=$datas[8]?>"style="width:60px;"  /></td>
  <td><select name="log_sheet#<?=$datas[2]?>" id="log_sheet#<?=$datas[2]?>" style="width:50px;">
    <option value=""></option>
    <option <?=($datas[9]=='Yes')?'selected':'';?>>Yes</option>
    <option <?=($datas[9]=='No')?'selected':'';?>>No</option>
  </select></td>
  <td><input type="hidden" name="item_id#<?=$datas[2]?>" id="item_id#<?=$datas[2]?>" value="<?=$datas[2]?>" />

      <input name="d_price#<?=$datas[2]?>" type="text" id="d_price#<?=$datas[2]?>" value="<?=$datas[5]?>" style="width:60px;"  />  </td>

  <td><div id="po<?=$datas[2]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[2]?>',<?=$datas[2]?>,
document.getElementById('d_price#<?=$datas[2]?>').value+'#'+
document.getElementById('mesh_size#<?=$datas[2]?>').value+'#'+
document.getElementById('mesh_inch#<?=$datas[2]?>').value+'#'+
document.getElementById('mesh_hend#<?=$datas[2]?>').value+'#'+
document.getElementById('mesh_mm#<?=$datas[2]?>').value+'#'+
document.getElementById('log_sheet#<?=$datas[2]?>').value);
" /></div></td>
  </tr>

<?

}

?></tbody></table>

<?

}







if($_POST['report']==8888) 

{


          $sql="select g.group_name, s.sub_group_name, i.item_id,  i.finish_goods_code,  i.item_name, i.unit_name,   i.pack_size, 
 i.cost_price, i.sale_price, i.status, i.item_description, i.cost_crt_price, i.sale_crt_price  from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id ".$item_sub_group_con.$item_name_con.$product_nature.$group_for_con.$group_id_con;

$query = db_query($sql);

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

<thead>
<tr><td style="border:0px; text-align:center;" colspan="11"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" width="15%" /></td></tr>
<tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>

<tr><th rowspan="2">SL</th>

  <th rowspan="2">Product Group </th>
  <th rowspan="2">Product Category </th>
  <th rowspan="2">Product Code </th>
<th rowspan="2">Product Name </th>

<th rowspan="2">Description</th>
<th rowspan="2">Unit Type </th>
<th rowspan="2">Pack Size </th>
<th bgcolor="#00A59A"><div align="center">Product Pricing In Carton</div></th>
<th rowspan="2" bgcolor="#FF0000">Status</th>
<th rowspan="2" bgcolor="#FF0000">Submit</th>
</tr>
<tr>
  <th bgcolor="#00A59A">Puying  Price</th>
  </tr>
</thead>

<tbody>

<?

$ajax_page = "rate_change_update_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

  <td><?=$datas[0]?></td>
  <td><?=$datas[1]?></td>
  <td><?=$datas[3]?></td>
  <td><? $datas[4]?> 
   <input name="item_name#<?=$datas[2]?>" type="text" id="item_name#<?=$datas[2]?>" value="<?=$datas[4]?>"  style="width:280px;" />  </td>
  <td><?=$datas[10]?></td>
  <td><?=$datas[5]?></td>
  <td>
   <input name="pack_size#<?=$datas[2]?>" type="hidden" id="pack_size#<?=$datas[2]?>" value="<?=$datas[6]?>"  style="width:60px;" />
   
   <?=$datas[6]?>
  </td>
  <td><input name="cost_crt_price#<?=$datas[2]?>" type="text" id="cost_crt_price#<?=$datas[2]?>" value="<?=$datas[11]?>"  style="width:80px;" placeholder="Cost Price" />
  
  <input name="sale_crt_price#<?=$datas[2]?>" type="hidden" id="sale_crt_price#<?=$datas[2]?>" value="<?=$datas[12]?>"  style="width:80px;" placeholder="Sale Price"/>  </td>
  <td>
  
  <select name="status#<?=$datas[2]?>" id="status#<?=$datas[2]?>" style="width:60px;">

    <option <?=($datas[9]=='Active')?'selected':'';?>>Active</option>
    <option <?=($datas[9]=='Inactive')?'selected':'';?>>Inactive</option>
  </select>
  <input type="hidden" name="item_id#<?=$datas[2]?>" id="item_id#<?=$datas[2]?>" value="<?=$datas[2]?>" />  </td>
  <td><div id="po<?=$datas[2]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[2]?>',<?=$datas[2]?>,
document.getElementById('item_name#<?=$datas[2]?>').value+'#'+
document.getElementById('pack_size#<?=$datas[2]?>').value+'#'+
document.getElementById('cost_crt_price#<?=$datas[2]?>').value+'#'+
document.getElementById('sale_crt_price#<?=$datas[2]?>').value+'#'+
document.getElementById('status#<?=$datas[2]?>').value);
" /></div></td>
  </tr>

<?

}

?></tbody></table>


<?

}





/*if($_POST['report']==11) 

{


          $sql="select g.group_name, s.sub_group_name, i.item_id, i.item_name, i.unit_name, i.recommended_name,  i.d_price,  i.status, i.finish_goods_code, i.sku_code,  i.r_price, i.cn_price, i.cm_price, i.pack_size, 
 i.cost_price, i.sale_price, i.cr_30_days, i.cr_60_days, i.color_detail,  i.manufacture_price, i.distributor_price, i.wholesale_price, i.retail_price from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id ".$item_sub_group_con.$item_name_con.$product_nature.$group_for_con.$group_id_con;

$query = db_query($sql);

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>
<tr><td style="border:0px; text-align:center;" colspan="13"><img src="<?=SERVER_ROOT?>public/uploads/logo/80.png" width="300" /></td></tr>
<tr><td style="border:0px;" colspan="13"><?=$str?></td></tr>

<tr><th rowspan="2">S/L</th>

  <th rowspan="2">Product Code </th>
<th rowspan="2">Product Name </th>

<th rowspan="2">Unit  </th>
<th rowspan="2">Recommended Name </th>
<th rowspan="2">Color</th>
<th rowspan="2">Units in CTN/BALA </th>
<th colspan="4" bgcolor="#982A3B"><div align="center" class="style1">Product Pricing</div></th>
<th rowspan="2" bgcolor="#FF0000">Status</th>
<th rowspan="2" bgcolor="#FF0000">Submit</th>
</tr>
<tr>
  <th bgcolor="#982A3B"><span class="style1">Manufacture Price</span></th>
  <th bgcolor="#982A3B"><span class="style1">Distributor Price</span></th>
  <th bgcolor="#982A3B"><span class="style1">Wholesale Price</span></th>
  <th bgcolor="#982A3B"><span class="style1">Retail Price</span></th>
</tr>
</thead>

<tbody>

<?

$ajax_page = "rate_change_update_minwal_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

  <td><?=$datas[8]?></td>
  <td><?=$datas[3]?> </td>
  <td><?=$datas[4]?></td>
  <td><?=$datas[5]?><input name="item_short_name#<?=$datas[2]?>" type="hidden" id="item_short_name#<?=$datas[2]?>" value="<?=$datas[5]?>" style="width:150px;" required   /></td>
  <td><?=$datas[18]?></td>
  <td>
  
  <input name="pack_size#<?=$datas[2]?>" type="text" id="pack_size#<?=$datas[2]?>" value="<?=$datas[13]?>"  style="width:60px;" />  </td>
  <td><input name="manufacture_price#<?=$datas[2]?>" type="text" id="manufacture_price#<?=$datas[2]?>"  style="width:80px;" value="<?=$datas[19]?>"
  placeholder="Manufacture Price"  />
  
<!--click="myClickFunction(<?=$datas[2]?>)" onclick="alert('Manufacture Price')"
 click="myClickFunction(<?=$datas[2]?>)" onclick="alert('Distributor Price')"
 click="myClickFunction(<?=$datas[2]?>)" onclick="alert('Wholesale Price')"
 click="myClickFunction(<?=$datas[2]?>)" onclick="alert('Retail Price')"-->
 
  </td>
  <td><input name="distributor_price#<?=$datas[2]?>" type="text" id="distributor_price#<?=$datas[2]?>"  style="width:80px;" value="<?=$datas[20]?>" 
  placeholder="Distributor Price"/></td>
  <td><input name="wholesale_price#<?=$datas[2]?>" type="text" id="wholesale_price#<?=$datas[2]?>"  style="width:80px;" value="<?=$datas[21]?>" 
  placeholder="Wholesale Price" /></td>
  <td><input name="retail_price#<?=$datas[2]?>" type="text" id="retail_price#<?=$datas[2]?>"  style="width:80px;" value="<?=$datas[22]?>" 
  placeholder="Retail Price"  /></td>
  <td>
  
  <select name="status#<?=$datas[2]?>" id="status#<?=$datas[2]?>" style="width:60px;">

    <option <?=($datas[9]=='Active')?'selected':'';?>>Active</option>
    <option <?=($datas[9]=='Inactive')?'selected':'';?>>Inactive</option>
  </select>
  <input type="hidden" name="item_id#<?=$datas[2]?>" id="item_id#<?=$datas[2]?>" value="<?=$datas[2]?>" />  </td>
  <td><div id="po<?=$datas[2]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[2]?>',<?=$datas[2]?>,

document.getElementById('item_short_name#<?=$datas[2]?>').value+'#'+
document.getElementById('pack_size#<?=$datas[2]?>').value+'#'+
document.getElementById('manufacture_price#<?=$datas[2]?>').value+'#'+
document.getElementById('distributor_price#<?=$datas[2]?>').value+'#'+
document.getElementById('wholesale_price#<?=$datas[2]?>').value+'#'+
document.getElementById('retail_price#<?=$datas[2]?>').value+'#'+
document.getElementById('status#<?=$datas[2]?>').value);
" /></div></td>
  </tr>

<?

}

?></tbody></table>


<?

}*/

if($_POST['report']==11) 

{

if($_POST['group_id']){
$con = ' and g.group_id="'.$_POST['group_id'].'"';
}
if($_POST['ledger_id']){
$con .= ' and a.ledger_id="'.$_POST['ledger_id'].'"';
}
$op_sql = 'select g.group_name,a.ledger_name,j.dr_amt,j.cr_amt from journal j, accounts_ledger a, ledger_group g where j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and j.tr_from="Opening" '.$con.'';

$query = db_query($op_sql);

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

<thead>
<tr><td style="border:0px; text-align:center;" colspan="13"></td></tr>
<tr><td style="border:0px;" colspan="13"><?=$str?></td></tr>

<tr>
<th rowspan="2">S/L</th>
<th rowspan="2">Ledger Group Name</th>
<th rowspan="2">Ledger Name</th>
<th rowspan="2">Debit Amount</th>
<th rowspan="2">Credit Amount</th>
</tr>
</thead>

<tbody>

<?


while($datas=mysqli_fetch_object($query)){$s++;

?>

<tr><td><?=$s?></td>

  <td><?=$datas->group_name?></td>
  <td><?=$datas->ledger_name?> </td>
  <td><?=number_format($datas->dr_amt,2)?></td>
  <td><?=number_format($datas->cr_amt,2)?></td>
  </tr>

<?
$total_dr += $datas->dr_amt;
$total_cr += $datas->cr_amt;
}

?>
<tr>
  <td colspan="3"><strong>Total</strong></td>
  <td><strong><?=number_format($total_dr,2)?></strong></td>
  <td><strong><?=number_format($total_cr,2)?></strong></td>
</tr>
</tbody>

</table>


<?

}


if($_POST['report']==8890) 

{


         $sql="select z.ZONE_NAME, a.AREA_CODE, a.AREA_NAME, a.transport_cost as transport_charges  from zon z, area a where z.ZONE_CODE=a.ZONE_ID";

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">

<thead><tr><td style="border:0px;" colspan="6"><?=$str?></td></tr>

<tr><th>S/L</th>

<th>Zone Name </th>

<th>Area Code </th>

<th>Area Name </th>
<th>Transport Charge </th>
<th>Submit</th>
</tr></thead>

<tbody>

<?

$ajax_page = "transport_change_update_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

<td><?=$datas[0]?></td>

<td><?=$datas[1]?></td>

  <td><?=$datas[2]?></td>
  <td><input name="transport_cost#<?=$datas[1]?>" type="text" id="transport_cost#<?=$datas[1]?>" value="<?=$datas[3]?>" style="width:150px;" />  	  </td>
  <td><div id="po<?=$datas[1]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[1]?>',<?=$datas[1]?>,

document.getElementById('transport_cost#<?=$datas[1]?>').value);
" /></div></td>
  </tr>

<?

}

?></tbody></table>

<?

}









?></div>



</body>



</html>