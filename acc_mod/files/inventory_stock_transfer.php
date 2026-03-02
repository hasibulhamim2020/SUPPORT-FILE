<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Product Transfer';
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;

//end 
if(isset($_POST['transfer']))
{
$item		= $_REQUEST['item'];
$issue_warehouse	= $_REQUEST['issue_warehouse'];
$receive_warehouse	= $_REQUEST['receive_warehouse'];
$qty		= $_REQUEST['transfer_qty'];
$user_id=$_SESSION['user_id'];
$issue_date			= date("Y-m-d");

$sql="INSERT INTO  `inventory_stock_transfer` (
`item_id` ,
`issue_warehouse_id` ,
`receive_warehouse_id` ,
`qty` ,
`issue_date` ,
`user_id`
)VALUES ('$item',  '$issue_warehouse',  '$receive_warehouse',  '$qty',  '$issue_date',  '$user_id')";
$query=db_query($sql);
transfer_stock_manage($item,$issue_warehouse,$receive_warehouse,$qty);
		$type=1;
		$msg='Issue items Successfully Received.';
}

?><script type="text/javascript">
var xmlHttp
function DoNav(theUrl)
{
	document.location.href = 'inventory_stock_transfer.php?id='+theUrl;
}
function check()
{
    if (isNaN(document.getElementById("available_stock").value)||isNaN(document.getElementById("transfer_qty").value))
    {
        alert('Please Enter only numerical values.');
        return false;
    }
    if (((document.getElementById("issue_warehouse").value)*1)==((document.getElementById("receive_warehouse").value)*1))
    {
        alert('Issue and Receive Ware house can not be same.');
        return false;
    }
    if (((document.getElementById("available_stock").value)*1)<((document.getElementById("transfer_qty").value)*1))
    {
        alert('Can not transfer more than Available Stock');
        return false;
    }
    if(document.getElementById("transfer_qty").value=="")
    {
        alert("Please Enter Valid transfer Quantity.");
        return false;
    }
    return true;
}
//---------------------------------------------------------------------------------
function avail_stock()
{
    var item_id=document.getElementById("item").value;
	var issue_warehouse_id=document.getElementById("issue_warehouse").value;
	//alert(issue_warehouse_id)
	xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null)
    {
        alert ("Browser does not support HTTP Request")
        return
    }
    var url="../common/warehouse_stock.php"
    url=url+"?item_id="+item_id+"&warehouse_id="+issue_warehouse_id
    url=url+"&sid="+Math.random()
    xmlHttp.onreadystatechange = function(){
        if(xmlHttp.readyState == 4)
        { document.getElementById("cur").innerHTML=xmlHttp.responseText}
    }
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
} 
//---------------------------------------------------------------------------------
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}

</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    <td width="66%" style="padding-right:5%">
	<div class="left">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table id="grp" class="tabledesign" cellspacing="0">
              <tr>
                <th>Product</th>
                <th>Issue WH</th>
                <th>Receive WH</th>
                <th>Qty</th>
              </tr>
              <?php
	$rrr="select b.item_name, (select warehouse_name from warehouse where warehouse_id=a.issue_warehouse_id), (select warehouse_name from warehouse where warehouse_id=a.receive_warehouse_id),a. qty from inventory_stock_transfer a,item_info b where a.item_id=b.item_id  order by a.issue_date";
	//echo $rrr;
	$report=db_query($rrr);
	while($rp = mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
              <tr<?=$cls?>>
                <td><?=$rp[0];?></td>
                <td><?=$rp[1];?></td>
                <td><?=$rp[2];?></td>
                <td><?=$rp[3];?></td>
              </tr>
              <?php }?>
            </table>
              </td>
        </tr>
      </table>
    </div></td>
    <td><div class="right">  <form id="form2" name="form2" method="post" action="" onsubmit="return check()">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Product Name: </td>
                                        <td><select name="item" id="item" style="width:180px;float:left" onblur="avail_stock()"  >
                                          <?
	$led11=db_query("select item_id, item_name FROM item_info ORDER BY item_id ASC");
	if(mysqli_num_rows($led11) > 0)
	{
	  while($ledg11 = mysqli_fetch_row($led11)){
		  echo '<option value="'.$ledg11[0].'">'.$ledg11[1].'</option>';
	  }
	}
				?>
                                                                                </select></td>
                                      </tr>

                                      <tr>
                                        <td>Issue Ware House :</td>
                                        <td><select name="issue_warehouse" id="issue_warehouse" style="width:180px;float:left" onblur="avail_stock()"  >
                                          <?
	$led11=db_query("select warehouse_id, warehouse_name FROM warehouse ORDER BY warehouse_id ASC");
	if(mysqli_num_rows($led11) > 0)
	{
	  while($ledg11 = mysqli_fetch_row($led11)){
		  echo '<option value="'.$ledg11[0].'">'.$ledg11[1].'</option>';
	  }
	}
				?>
                                                                                </select></td>
                                      </tr>
                                      <tr>
                                        <td>Receive Ware House   :</td>
                                        <td><select name="receive_warehouse" id="receive_warehouse" style="width:180px;float:left"  >
                                          <?
	$led11=db_query("select warehouse_id, warehouse_name FROM warehouse ORDER BY warehouse_id ASC");
	if(mysqli_num_rows($led11) > 0)
	{
	  while($ledg11 = mysqli_fetch_row($led11)){
		  echo '<option value="'.$ledg11[0].'">'.$ledg11[1].'</option>';
	  }
	}
				?>
                                                                                </select></td>
                                      </tr>
                                      <tr>
                                        <td>Available Stock:</td>
                                        <td><span id="cur"><input name="available_stock" type="text" id="available_stock" style="width:80px;float:left" size="15" maxlength="15" value="" readonly/></span></td>
                                      </tr>
                                      <tr>
                                        <td>Transfer Quantity : </td>
                                        <td><input name="transfer_qty" type="text" id="transfer_qty" style="width:80px;float:left" size="15" maxlength="15" value="<?php echo $data[5];?>"/></td>
                                      </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td align="center"><input name="transfer" type="submit" id="transfer" value="Transfer" class="btn"/></td>
                                      <td align="center"><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='inventory_stock_transfer.php'"/></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>9
<script type="text/javascript">
	document.onkeypress=function(e){
	var e=window.event || e
	var keyunicode=e.charCode || e.keyCode
	if (keyunicode==13)
	{
		return false;
	}
}
</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>