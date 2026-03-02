<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Chalan Varification';
$now=time();
do_calander('#do_date_fr');
do_calander('#do_date_to');

$depot_id = $_POST['depot_id'];
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
			<td><table width="75%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">
              <tr>
                <td><div align="right"><strong>Chalan Date :</strong></div></td>
                <td><label>
                  <div align="left">
                    <input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" style="width:150px;"/>
                  </div>
                </label></td>
                <td>-to-</td>
                <td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" style="width:150px;"/></td>
                <td rowspan="3"><label>
                  <input type="submit" name="submitit" id="submitit" value="View Chalan" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
                </label></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Checked : </strong></div></td>
                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <select name="checked" id="checked" style="width:250px;">
                      <option></option>
                      <option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>
                      <option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>
                      <option <?=($_POST['checked']=='PROBLEM')?'Selected':'';?>>PROBLEM</option>
                    </select>
                </span></div></td>
                </tr>
              <tr>
                <td><div align="right"><strong>Chalan To : </strong></div></td>
                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                  <select name="center_id" id="center_id" style="width:250px;">
                    <? foreign_relation('cost_center','id','center_name',$_POST['center_id'],'1');?>
                  </select>
                </span></div></td>
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
	  
      <th>Date</th>
      <th>CH#</th>
      <th>From  </th>
      <th>Entry At</th>
      <th>Chalan By </th>
      <th>Chalan Amt</th>
      <th>&nbsp;</th>
      <th>Checked?</th>
      </tr>
	  <?


		 if($_POST['do_date_fr']!=''){
	  $i=0;
if($_POST['checked']!='') $con .= 'j.checked = "'.$_POST['checked'].'" AND';
	 	if($_SESSION['user']['group']>1) $group_s.=' AND j.group_for='.$_SESSION['user']['group'].' ';
		if($_POST['center_id']>0) $group_s.='AND j.cc_code='.$_POST['center_id'].' ';
		if($depot_id>0) $depot_con = 'and l.ledger_id='.$depot_id;
	$sql="SELECT DISTINCT 
				  j.tr_no,
				  sum(1) as co,
				  sum(j.cr_amt) as dr_amts,
				  j.jv_date,
				  j.jv_no,
				  l.ledger_name,
				  j.tr_id,
				  j.user_id,
				  j.entry_at,
				  j.checked,
				  j.jv_no,
				  j.dr_amt,
				  p.warehouse_from warehouse
				FROM
				  secondary_journal j,
				  accounts_ledger l,
				  production_issue_master p
				WHERE
				  j.tr_no=p.pi_no AND 
				  ".$con." 
				  j.tr_from = 'StoreReceived' AND 
				  j.cr_amt >0 AND 
				  j.jv_date between '". strtotime($_POST['do_date_fr'])."' AND  '". strtotime($_POST['do_date_to'])."' AND 
				  j.ledger_id = l.ledger_id ".$group_s." 
				group by  j.tr_no";
	  $query=db_query($sql);
	  
	  while($data=mysqli_fetch_object($query)){
	  $received = $received + $data->dr_amts;
	  ?>

      <tr <?=($i%2==0)?'class="alt"':'';?>>
      <td align="center"><div align="left"><?=++$i;?></div></td>
      <td align="center"><div align="left"><? echo date('Y-m-d',$data->jv_date);?></div></td>
      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>
      <td align="center"><div align="left"><? echo find_a_field('warehouse','warehouse_name','warehouse_id='.$data->warehouse);	;?></div></td>
      <td align="center"><div align="left"><? echo $data->entry_at;?></div></td>
      <td align="center"><div align="left"><? echo @find_a_field('user_activity_management','fname','user_id='.$data->user_id);?></div></td>
      <td align="right"><?=number_format($data->dr_amts,2);?></td>
      <td align="center"><a target="_blank" href="sc_rec_transfer_sec_print_view.php?jv_no=<?=$data->jv_no ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
      <td align="center"><span id="divi_<?=$data->tr_no?>">
<? 
if(($data->checked=='YES')){
?>
<input type="button" name="Button" value="YES"  onclick="window.open('sc_rec_transfer_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style=" font-weight:bold;width:40px; height:20px;background-color:#66CC66;"/>
<?
}elseif(($data->checked=='NO')){
?>
<input type="button" name="Button" value="NO"  onclick="window.open('sc_rec_transfer_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style="font-weight:bold;width:40px; height:20px;background-color:#FF0000;"/>
<? }?>
          </span></td>
      </tr>
	  <? }}?>
	        <tr class="alt">
        <td colspan="6" align="center"><div align="right"><strong>Total Amt : </strong></div>
          
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
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>
