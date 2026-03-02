<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require_once "../../../support/default_values.php";
//require_once ROOT_PATH."support/inc.all.php";

$title='GR Varification';
$now=time();
do_calander('#do_date_fr');
do_calander('#do_date_to');


?>
<script>

function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}

		catch(e)	{		

			try{			

				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){

				try{

				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				}

				catch(e1){

					xmlhttp=false;

				}

			}

		}

		 	

		return xmlhttp;

    }

	function update_value(id)

	{

var item_id=id; // Rent
var ra=(document.getElementById('ra_'+id).value)*1;
var flag=(document.getElementById('flag_'+id).value); 
if(ra>0){
var strURL="received_amt_ajax.php?item_id="+item_id+"&ra="+ra+"&flag="+flag;}
else
{
alert('Receive Amount Must be Greater Than Zero.');
document.getElementById('ra_'+id).value = '';
document.getElementById('ra_'+id).focus();
return false;
}

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('divi_'+id).style.display='inline';
						document.getElementById('divi_'+id).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}
			req.open("GET", strURL, true);
			req.send(null);
		}	

}

</script>
				<form id="form2" name="form2" method="post" action="">	

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td><table width="60%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">
              <tr>
                <td><div align="right"><strong>GR Date :</strong></div></td>
                <td><input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" required /></td>
                <td>-to-</td>
                <td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" style="width:150px;"  required /></td>
                <td rowspan="4"><label>
                  <input type="submit" name="submitit" id="submitit" value="View GR" style="width:100px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
                </label></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Checked : </strong></div></td>
                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <select name="checked" id="checked" style="width:250px;">
                      <option></option>
                      <option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>
                      <option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>
                    </select>
                </span></div></td>
                </tr>
              <tr>
                <td><div align="right"><strong>Chalan Depot : </strong></div></td>
                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <select name="depot_id" id="depot_id" style="width:250px;">
                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot_id'],'group_for=2 order by warehouse_name');?>
                    </select>
                </span></div></td>
                </tr>
              <tr>
                <td><div align="right"><strong>Vendor Name :</strong></div> </td>
                <td colspan="3">
				<?
				
						$sql = "select v.vendor_id,v.vendor_name from vendor v where  v.group_for='".$_SESSION['user']['group']."' order by v.vendor_name";
				?>
				<select name="vendor_id" id="vendor_id">
                  <option value="">ALL</option>
                  <? 
						foreign_relation_sql($sql,$vendor_id);?>
                </select></td>
              </tr>
            </table></td>
	    </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td>
      <table width="98%" align="center" cellspacing="0" class="tabledesign">
      <tbody>
      <tr>
      <th>SL</th>
      <th>PO#</th>
      <th>GR#</th>
      <th>Party Name</th>
      <th>Depot</th>
      <th>GR Date </th>
      <th>Payable Amt</th>
      <th>&nbsp;</th>
      <th>Checked?</th>
      </tr>
	  <?


		 if($_POST['do_date_fr']!=''){
	  $i=0;
		if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';
	 	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];
		if($_POST['depot_id']>0) $depot_con = ' and r.warehouse_id="'.$_POST['depot_id'].'" ';
		if($_POST['vendor_id']!='') {$vendor_con=' and r.vendor_id="'.$_POST['vendor_id'].'"';}
		 $sql="SELECT  
				  j.tr_no,
				  1,
				  1,
				  j.jv_date,
				  j.jv_no,
				  l.ledger_name,
				  j.tr_no,
				  1,
				  j.entry_at,
				  j.checked,
				  j.jv_no,
				  1,
				  r.po_no,
				  sum(j.cr_amt) amt

				FROM
				  secondary_journal j,
				  accounts_ledger l,
				  purchase_receive r
				WHERE
				  j.cr_amt>0 AND 
				  j.tr_id = r.id AND
				  j.tr_from = 'Purchase' AND 
				  j.jv_date between '".$_POST['do_date_fr']."' AND  '".$_POST['do_date_to']."' AND 
				  j.ledger_id = l.ledger_id ".$group_s.$checked_con.$vendor_con." 
				  group by j.tr_no order by j.jv_date";
	  $query=db_query($sql);
	  
	  while($data=mysqli_fetch_row($query)){
	  ?>

      <tr class="alt">
      <td align="center"><div align="left">
        <?=++$i;?>
      </div></td>
      <td align="center"><div align="left"><? echo $data[12];?></div></td>
      <td align="center"><div align="left"><? echo $data[6];?></div></td>
      <td align="center"><div align="left"><? echo $data[5];?></div></td>
      <td align="center"><? echo $data[11];?></td>
      <td align="center"><div align="left"><? echo (date("Y-m-d",$data[3]));?></div></td>
      <td align="right"><? $tot = $data[13]; 
	  echo number_format($tot,2);$received = $received + $tot;?></td>
      <td align="center"><a target="_blank" href="purchase_sec_print_view.php?jv_no=<?=$data[10] ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
      <td align="center"><span id="divi_<?=$data[0]?>">
            <? 
			  if(($data[9]=='YES')){
?>
<input type="button" name="Button" value="YES"  onclick="window.open('purchase_sec_print_view.php?jv_no=<?=$data[10] ?>');" style=" font-weight:bold;width:40px; height:20px;background-color:#66CC66;"/>
<?
}elseif(($data[9]=='')){
?>
<input type="button" name="Button" value="NO"  onclick="window.open('purchase_sec_print_view.php?jv_no=<?=$data[10] ?>');" style="font-weight:bold;width:40px; height:20px;background-color:#FF0000;"/>
<? }?>
          </span></td>
      </tr>
	  <? }}?>
	        <tr class="alt">
        <td colspan="6" align="center"><div align="right"><strong>Total Received: </strong></div>
          
            <div align="left"></div></td>
        <td align="right"><?=number_format($received,2);?></td>
        <td align="center">&nbsp;</td>
        <td align="center"><div align="left"></div></td>
      </tr>
  </tbody></table>		  
  </td>
	    </tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>
		<div>
                    
		<table width="100%" border="0" cellspacing="0" cellpadding="0">		
		<tr>		
		<td>
		<div style="width:380px;"></div></td>
		</tr>
		</table>
	        </div>
		</td>
		</tr>
      </table></td></tr>
</table>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
