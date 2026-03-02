<?php
session_start();
ob_start();
//header("Content-Type: text/plain");

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Damage Chalan Varification';
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
                <td><div align="right"><strong>Damage Date :</strong></div></td>
                <td><input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" style="width:150px;"/>
                  <label>                  </label></td>
                <td>-to-</td>
                <td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" style="width:150px;"/></td>
                <td rowspan="4"><label>
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
                <td><div align="right"><strong>Region Wise  : </strong></div></td>
                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <select multiple name="region_id[]" id="region_id[]" style="width:250px; height:60px;"  size='5'>if (in_array("Irix", $os))
                      <? //foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$_POST['region_id'],' 1 order by BRANCH_NAME');
					  $sql = 'select BRANCH_ID,BRANCH_NAME from branch where  1 order by BRANCH_NAME';
					  $query = db_query($sql);
					  while($info = mysqli_fetch_object($query)){
					  ?><option value="<?=$info->BRANCH_ID?>" <?=(@in_array($info->BRANCH_ID, $_POST['region_id']))?'Selected':'';?>><?=$info->BRANCH_NAME?></option>
					  <?
					  }
					  ?>
                    </select>
                </span>
				
				</div></td>
                </tr>
              <tr>
                <td><div align="right"><strong>Damage Depot : </strong></div></td>
                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                  <select name="depot_id" id="depot_id" style="width:250px;">
                    <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'use_type="SD" order by warehouse_name');?>
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
	  
      <th>DR#</th>
      <th>MS#</th>
      <th>Dealer Name</th>
      <th>Damage Date </th>
      <th>Entry By </th>
      <th>Payable Amt</th>
      <th>&nbsp;</th>
      <th>Checked?</th>
      </tr>
	  <?



if($_POST['do_date_fr']!=''){

$ix = 0;
if(!empty($_POST['region_id']))foreach ($_POST['region_id'] as $selectedOption)
{if($ix == 0)$region_id .= $selectedOption.' ';
else $region_id .= ', '.$selectedOption;$ix++;}

$i=0;
$datefr = strtotime($_POST['do_date_fr']);
$dateto = strtotime($_POST['do_date_to']);
$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));
$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));
if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];
		
		if($depot_id>0) $depot_con = 'and d.depot='.$depot_id;
		if($_POST['checked']!='') $con .= 'j.checked = "'.$_POST['checked'].'" AND';
		if($region_id!='') $con .= ' z.REGION_ID in ('.$region_id.') AND ';
		if($region_id!='') $tbl = ' ,area a,zon z ';
		if($region_id!='') $tbl_con =  ' z.ZONE_CODE = a.ZONE_ID AND d.area_code = a.AREA_CODE AND ';
		$sql="SELECT DISTINCT 
				  j.tr_no,
				  j.cr_amt as cr_amts,
				  j.jv_date,
				  j.jv_no,
				  l.ledger_name,
				  j.tr_id,
				  j.user_id,
				  j.entry_at,
				  j.checked,
				  j.jv_no,
				  j.cr_amt
				FROM
				  secondary_journal j,
				  accounts_ledger l,
				  dealer_info d,
				  warehouse_damage_receive w
				  ".$tbl."
				WHERE

		  w.or_no = j.tr_no AND  
		  d.dealer_code = w.vendor_id AND 
		  j.tr_from = 'DamageReturn' AND 
		  j.cr_amt >0 AND 
		  ".$con.$tbl_con."
		  j.jv_date  between '".$day_from."' AND '".$day_end."' AND 
		  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con." group by  j.tr_no";
	
	  $query=db_query($sql);
	  
	  while($data=mysqli_fetch_object($query)){
	  $received = $received + $data->cr_amt;
	  $damage = find_all_field('warehouse_damage_receive','manual_or_no','or_no='.$data->tr_no);
	  ?>

      <tr <?=($i%2==0)?'class="alt"':'';?>>
      <td align="center"><div align="left"><?=++$i;?></div></td>
      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>
      <td align="center"><div align="left"><?=$damage->manual_or_no;?></div></td>
      <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>
      <td align="center"><div align="left"><?=date('Y-m-d',$data->jv_date)?></div></td>
      <td align="center"><div align="left"><? echo @find_a_field('user_activity_management','fname','user_id='.$data->user_id).'-'.$data->entry_at;?></div></td>
      <td align="right"><?=number_format($data->cr_amts,2);?></td>
      <td align="center"><a target="_blank" href="damage_sec_print_view.php?jv_no=<?=$data->jv_no ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
      <td align="center"><span id="divi_<?=$data->tr_no?>">
<? 
if(($data->checked=='YES')){
?>
<input type="button" name="Button" value="YES"  onclick="window.open('damage_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style=" font-weight:bold;width:40px; height:20px;background-color:#66CC66;"/>
<?
}elseif(($data->checked=='NO')){
?>
<input type="button" name="Button" value="NO"  onclick="window.open('damage_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style="font-weight:bold;width:40px; height:20px;background-color:#FF0000;"/>
<?
}elseif(($data->checked=='PROBLEM')){
?>
<input type="button" name="Button" value="PROBLEM"  onclick="window.open('damage_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style="font-weight:bold;width:70px; height:20px;background-color:#FFFF00;"/>
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
