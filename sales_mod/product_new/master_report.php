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




$sql="select 

a.group_name,

s.sub_group_name,

i.item_id as product_code,
 
i.item_name as product_name,

i.product_nature,

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



case 888:

				$report="Product Information (Rate Changable)";

				break;
				
				
				
				
case 889:

				$report="Product Mesh Size Information";

				break;
				
				
				
							
				
case 8888:

				$report="Product Information";

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



<link href="../../../css_js/css/report.css" type="text/css" rel="stylesheet" />

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



</head>



<body>



<div align="center" id="pr">



<input type="button" value="Print" onclick="hide();window.print();"/>



</div>



<div class="main">



<?



		$str 	.= '<div class="header">';



		//if(isset($_SESSION['company_name'])) 

		//$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		
		if(isset($group_for)) 

		$str 	.= '<img src="<?=SERVER_ROOT?>public/uploads/logo/'.$group_for.'.png" width="300" />';



		if(isset($report)) 



		$str 	.= '<h2>'.$report.'</h2>';
		
		
		


		
		if(isset($group_for)) 

		$str 	.= '<h2>Concern Name : ' .find_a_field('user_group','group_name','id='.$group_for).'</h2>';
		
		if(isset($item_sub_group)) 

		$str 	.= '<h2>Sub Group : ' .find_a_field('item_sub_group','sub_group_name','sub_group_id='.$item_sub_group).'</h2>';
		
		

		if(isset($t_date)) 



		$str 	.= '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



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

?><table width="100%" cellspacing="0" cellpadding="2" border="0">

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

  $sql="select g.group_name, s.sub_group_name, i.item_id, i.item_name,  i.sku_code, i.unit_name,  i.pack_size, 
    i.m_price, i.d_price, i.t_price, i.f_price, i.status
		from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id ".$item_sub_group_con.$item_name_con.$product_nature.$group_for_con.$group_id_con;

$query = db_query($sql);

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><td style="border:0px;" colspan="12"><?=$str?></td></tr>

<tr><th rowspan="2">S/L</th>

  <th rowspan="2">Product Code </th>
<th rowspan="2">Product Name </th>

<th rowspan="2">Product Group </th>
<th rowspan="2">Unit  </th>
<th rowspan="2">Units in CTN </th>
<th colspan="4" bgcolor="#5390F5"><div align="center">Product Price</div></th>
<th rowspan="2" bgcolor="#FF0000">Status</th>
<th rowspan="2" bgcolor="#FF0000">Submit</th>
</tr>
<tr>
  <th bgcolor="#99FFFF">MRP Price</th>
  <th bgcolor="#FFCCFF"> Dealer Price </th>
  <th bgcolor="#FFFFCC">Trade Price </th>
  <th bgcolor="#CCFFFF">Production Price </th>
  </tr>
</thead>

<tbody>

<?

$ajax_page = "rate_change_update_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

  <td><?=$datas[4]?></td>
  <td><?=$datas[3]?> </td>
  <td><?=$datas[1]?></td>
  <td><?=$datas[5]?></td>
  <td>
  <?=$datas[12]?>
  <input name="pack_size#<?=$datas[2]?>" type="hidden" id="pack_size#<?=$datas[2]?>" value="<?=$datas[6]?>"  style="width:50px;" />  </td>
  <td bgcolor="#99FFFF"><input name="m_price#<?=$datas[2]?>" type="text" id="m_price#<?=$datas[2]?>" value="<?=$datas[7]?>"  style="width:70px;" /></td>
  <td bgcolor="#FFCCFF"><input name="d_price#<?=$datas[2]?>" type="text" id="d_price#<?=$datas[2]?>" value="<?=$datas[8]?>"  style="width:70px;" /></td>
  <td bgcolor="#FFFFCC"><input name="t_price#<?=$datas[2]?>" type="text" id="t_price#<?=$datas[2]?>" value="<?=$datas[9]?>"  style="width:70px;" /></td>
  <td bgcolor="#CCFFFF"><input name="f_price#<?=$datas[2]?>" type="text" id="f_price#<?=$datas[2]?>" value="<?=$datas[10]?>"  style="width:70px;" /></td>
  <td>
  
  <select name="status#<?=$datas[2]?>" id="status#<?=$datas[2]?>" style="width:70px;">

    <option <?=($datas[11]=='Active')?'selected':'';?>>Active</option>
    <option <?=($datas[11]=='Inactive')?'selected':'';?>>Inactive</option>
  </select>
  <input type="hidden" name="item_id#<?=$datas[2]?>" id="item_id#<?=$datas[2]?>" value="<?=$datas[2]?>" />  </td>
  <td><div id="po<?=$datas[2]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[2]?>',<?=$datas[2]?>,

document.getElementById('pack_size#<?=$datas[2]?>').value+'#'+
document.getElementById('m_price#<?=$datas[2]?>').value+'#'+
document.getElementById('d_price#<?=$datas[2]?>').value+'#'+
document.getElementById('t_price#<?=$datas[2]?>').value+'#'+
document.getElementById('f_price#<?=$datas[2]?>').value+'#'+
document.getElementById('status#<?=$datas[2]?>').value);
" /></div></td>
  </tr>

<?

}

?></tbody></table>


<?

}





if($_POST['report']==888811) 

{


          $sql="select g.group_name, s.sub_group_name, i.item_id, i.item_name, i.unit_name, i.item_short_name,  i.d_price,  i.status, i.finish_goods_code, i.recommended_name, i.cost_price, i.sale_price  from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id and i.item_type='Turky Item' ".$item_sub_group_con.$item_name_con.$product_nature.$group_for_con.$group_id_con;

$query = db_query($sql);

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><td style="border:0px;" colspan="8"><?=$str?></td></tr>

<tr><th rowspan="2">S/L</th>

  <th rowspan="2">Item Code </th>
<th rowspan="2">Item Name </th>

<th rowspan="2">Recommended English Name</th>
<th rowspan="2">Item Group </th>
<th rowspan="2">Unit  </th>
<th colspan="2" bgcolor="#5390F5"><div align="center">Product Price </div></th>
</tr>
<tr>
  <th bgcolor="#5390F5">Cost Price</th>
  <th bgcolor="#5390F5">Sale Price</th>
  </tr>
</thead>

<tbody>

<?

$ajax_page = "rate_change_update_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

  <td><?=$datas[8]?></td>
  <td><?=$datas[3]?> </td>
  <td><?=$datas[9]?></td>
  <td><?=$datas[1]?></td>
  <td><?=$datas[4]?></td>
  <td><?=$datas[10]?><input name="cost_price#<?=$datas[2]?>" type="hidden" id="cost_price#<?=$datas[2]?>" value="<?=$datas[14]?>"  style="width:50px;" /></td>
  <td><?=$datas[11]?><input name="sale_price#<?=$datas[2]?>" type="hidden" id="sale_price#<?=$datas[2]?>" value="<?=$datas[15]?>"  style="width:50px;" /></td>
  </tr>

<?

}

?></tbody></table>


<?

}




if($_POST['report']==888822) 

{


          $sql="select g.group_name, s.sub_group_name, i.item_id, i.item_name, i.unit_name, i.item_short_name,  i.d_price,  i.status, i.finish_goods_code, i.recommended_name, i.pack_size, i.item_meserment, i.weight, i.weight_unit, i.color_detail, i.cost_price, i.sale_price  from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id and i.item_type='Zadi Item' ".$item_sub_group_con.$item_name_con.$product_nature.$group_for_con.$group_id_con;

$query = db_query($sql);

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr><td style="border:0px;" colspan="12"><?=$str?></td></tr>

<tr>
  <th rowspan="2">S/L</th>

  <th rowspan="2">Item Code </th>
<th rowspan="2">Item Name </th>

<th rowspan="2">Recommended English Name</th>
<th rowspan="2">Unit  </th>
<th rowspan="2">CTN</th>
<th rowspan="2">Size</th>
<th rowspan="2">Weight</th>
<th rowspan="2">Colors</th>
<th colspan="3" bgcolor="#5390F5"><div align="center">Product Price </div></th>
</tr>
<tr>
  <th bgcolor="#5390F5">Unit Price</th>
  <th bgcolor="#5390F5"> Price/Dozon</th>
  <th bgcolor="#5390F5">Price/CTN/BALA</th>
  </tr>
</thead>

<tbody>

<?

$ajax_page = "rate_change_update_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

  <td><?=$datas[8]?></td>
  <td><?=$datas[3]?> </td>
  <td><?=$datas[9]?></td>
  <td><?=$datas[4]?></td>
  <td><?=$datas[10]?></td>
  <td><?=$datas[11]?></td>
  <td><?=$datas[12]?> <?=$datas[13]?></td>
  <td><?=$datas[14]?></td>
  <td><?=$datas[16]?><input name="cost_price#<?=$datas[2]?>" type="hidden" id="cost_price#<?=$datas[2]?>" value="<?=$datas[14]?>"  style="width:50px;" /></td>
  <td><?=$price_dozon= $datas[16]*12;?></td>
  <td><?=$price_ctn= $datas[16]*$datas[10];?><input name="sale_price#<?=$datas[2]?>" type="hidden" id="sale_price#<?=$datas[2]?>" value="<?=$datas[15]?>"  style="width:50px;" /></td>
  </tr>

<?

}

?></tbody></table>


<?

}






if($_POST['report']==888833) 

{


           $sql="select g.group_name, s.sub_group_name, i.item_id, i.item_name, i.unit_name, i.item_short_name,  i.d_price,  i.status, i.finish_goods_code, i.recommended_name, i.cost_price, i.sale_price , i.color_detail from item_group g, item_sub_group s, item_info i where g.group_id=s.group_id and s.sub_group_id=i.sub_group_id and i.item_type='Minwal Carpet' ".$item_sub_group_con.$item_name_con.$product_nature.$group_for_con.$group_id_con;

$query = db_query($sql);

?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>
<tr><td style="border:0px; text-align:center;" colspan="9"><img src="<?=SERVER_ROOT?>public/uploads/logo/80.png" width="300" /></td></tr>
<tr><td style="border:0px;" colspan="9"><?=$str?></td></tr>


<tr><th rowspan="2">S/L</th>

  <th rowspan="2">Item Code </th>
<th rowspan="2">Item Name </th>

<th rowspan="2">Item Group </th>
<th rowspan="2">Recommended English Name</th>
<th rowspan="2">Color</th>
<th rowspan="2">Unit  </th>
<th colspan="2" bgcolor="#5390F5"><div align="center">Product Price </div></th>
</tr>
<tr>
  <th bgcolor="#5390F5">Cost Price</th>
  <th bgcolor="#5390F5">Sale Price</th>
  </tr>
</thead>

<tbody>

<?

$ajax_page = "rate_change_update_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

  <td><?=$datas[8]?></td>
  <td><?=$datas[5]?> </td>
  <td><?=$datas[1]?></td>
  <td><?=$datas[9]?></td>
  <td><?=$datas[12]?></td>
  <td><?=$datas[4]?></td>
  <td><?=$datas[10]?><input name="cost_price#<?=$datas[2]?>" type="hidden" id="cost_price#<?=$datas[2]?>" value="<?=$datas[14]?>"  style="width:50px;" /></td>
  <td><?=$datas[11]?><input name="sale_price#<?=$datas[2]?>" type="hidden" id="sale_price#<?=$datas[2]?>" value="<?=$datas[15]?>"  style="width:50px;" /></td>
  </tr>

<?

}

?></tbody></table>


<?

}




if($_POST['report']==888898) 

{


         $sql="select warehouse_id, warehouse_name , assign_warehouse  from warehouse where  use_type='WH'";

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead><tr><td style="border:0px;" colspan="5"><?=$str?></td></tr>

<tr>
  <th>S/L</th>

<th>Warehouse ID </th>

<th>Warehouse Name </th>

<th>Assign Warehouse </th>
<th>Submit</th>
</tr></thead>

<tbody>

<?

$ajax_page = "warehouse_update_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

<td><?=$datas[0]?></td>

<td><?=$datas[1]?></td>

  <td>
  
  <select name="assign_warehouse#<?=$datas[0]?>" id="assign_warehouse#<?=$datas[0]?>" style="width:60px;">
	<option <?=($datas[2]=='No')?'selected':'';?>>No</option>
    <option <?=($datas[2]=='Yes')?'selected':'';?>>Yes</option>
  </select>  
   <input type="hidden" name="warehouse_id#<?=$datas[0]?>" id="warehouse_id#<?=$datas[0]?>" value="<?=$datas[0]?>" />  </td>
  <td><div id="po<?=$datas[0]?>"><input type="button" name="Change" value="Change" onclick="getData2('<?=$ajax_page?>', 'po<?=$datas[0]?>',<?=$datas[0]?>,
document.getElementById('assign_warehouse#<?=$datas[0]?>').value);
" /></div></td>
  </tr>

<?

}

?></tbody></table>

<?

}





if($_POST['report']==8889) 

{



if($_POST['f_date']!=''&&$_POST['t_date']!='')

$date_con .= ' and i.change_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';




           $sql="SELECT s.`sub_group_name`, i.`finish_goods_code`, i.`item_name`, i.`unit_name`, i.`previous_s_price`, i.`previous_a_price`, i.`running_s_price`, i.`running_a_price`, i.`change_date`, u.fname, i.entry_at as change_at FROM `item_info_backup` i, `item_sub_group` s, `user_activity_management` u WHERE i.`sub_group_id`=s.`sub_group_id` and i.`entry_by`=u.`user_id` ".$item_sub_group_con.$zon_id_con.$product_nature.$group_for_con.$group_id_con.$date_con." order by i.`change_date` desc";

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0" style="font-size:14px;">

<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>

<tr><th>S/L</th>

<th>Sub Group Name </th>

<th>Product Name </th>

<th>Unit Name </th>
<th>Previous Sale Rate</th>

<th>Previous Advance Sale Rate</th>
<th>Update Sale Rate</th>
<th>Update Advance Sale Rate</th>
<th>Change Date </th>
<th>Change By </th>
<th>Change At </th>
</tr></thead>

<tbody>

<?

$ajax_page = "rd_issue_ajax.php";

while($datas=mysqli_fetch_row($query)){$s++;

?>

<tr><td><?=$s?></td>

<td><?=$datas[0]?></td>

  <td><?=$datas[2]?></td>

  <td><?=$datas[3]?></td>
  <td>

       <?=$datas[4]?> </td>

  <td><?=$datas[5]?></td>
  <td><?=$datas[6]?></td>
  <td><?=$datas[7]?></td>
  <td><?=$datas[8]?></td>
  <td><?=$datas[9]?></td>
  <td><?=$datas[10]?></td>
</tr>

<?

}

?></tbody></table>

<?

}







if($_POST['report']==8890) 

{


         $sql="select z.ZONE_NAME, a.AREA_CODE, a.AREA_NAME, a.transport_cost as transport_charges  from zon z, area a where z.ZONE_CODE=a.ZONE_ID";

$query = db_query($sql);

?><table width="100%" cellspacing="0" cellpadding="2" border="0">

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