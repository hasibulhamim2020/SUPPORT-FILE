<?php
session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='DO Bank Received Date';
$now=time();
do_calander('#f_date');
do_calander('#t_date');


$bank_head = find_a_field('config_group_class','collection_bank_head','group_for='.$_SESSION['user']['group']);
$collection_bank_head = substr($bank_head,0,12);
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
var no=(document.getElementById('no_'+id).value);
var receive_acc_head=(document.getElementById('receive_acc_head_'+id).value)*1;
var rec_date=(document.getElementById('rec_date_'+id).value);
var flag=(document.getElementById('flag_'+id).value); 

if(rec_date!='0000-00-00'){
var strURL="received_amt_ajax.php?item_id="+item_id+"&receive_acc_head="+receive_acc_head+"&rec_date="+rec_date+"&ra="+ra+"&no="+no+"&flag="+flag;}
else
{
alert('Please Set Receive Date!');
document.getElementById('rec_date_'+id).focus();
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
				



<!--Accout verify back-->
<form id="form2" name="form2" method="post" action="">
	<div class="form-container_large">

		<div class="container-fluid bg-form-titel">
			<div class="row">
				<!--left form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">

						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">DO Date :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="f_date" type="text" id="f_date" value="<?=$_POST['f_date']?>" autocomplete="off"/>
							</div>
						</div>
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">-To- :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="t_date" type="text" id="t_date" value="<?=$_POST['t_date']?>"  autocomplete="off"/> 
							</div>
						</div>



					</div>
				</div>

				<!--Right form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">


						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bank Acc :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<select  id="receive_acc_head" name="receive_acc_head">
				<option value="">ALL</option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['receive_acc_head'],' ledger_id LIKE "'.$collection_bank_head.'%" and ledger_id!="'.$bank_head.'" order by ledger_name');?>
                </select>
							</div>
						</div>
						
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Check Status :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<select  id="received_status" name="received_status">
                  <option value="">ALL</option>
				  <option value="received">CHECKED</option>
				  <option value="pending">NOT CHECKED</option>
                </select>
							</div>
						</div>






					</div>
				</div>

			</div>


			<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					 <input type="submit" name="submitit" id="submitit" value="View DO Date" class="btn1 btn1-submit-input"/>
				</div>

			</div>




		</div>






		<div class="container-fluid pt-5 p-0 ">


			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">


				<tr class="bgc-info">

					<th>SL</th>
					<th>DO#</th>
					<th>Dealer Name</th>
					<!--<th>Dealer Code</th>-->
					<th>Rec Date</th>
					<th>Bank Acc</th>
					<th>Received At</th>
					<th>Note</th>
					<th>Rec</th>
					<th>Acc Rec</th>
					<th>OK?</th>

				</tr>
				</thead>

				<tbody class="tbody1">
				<?


if($_POST['submitit']!=''){
		 
	if($_POST['receive_acc_head']!='')
	 $con .= " and a.receive_acc_head = '".$_POST['receive_acc_head']."'";
	 if($_POST['received_status']!='')
	 $con .= " and a.received_status = '".$_POST['received_status']."'";
	 if($_POST['f_date']!=''&&$_POST['t_date']!='')
	 $con .= " and a.do_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'";

/*	 if($_POST['receive_acc_head']!='')
	 $con .= " and a.receive_acc_head = '".$_POST['receive_acc_head']."'";
	 if($_POST['received_status']!='')
	 $con .= " and a.received_status = '".$_POST['received_status']."'";
	 if($_POST['f_date']!=''&&$_POST['t_date']!='')
	 $con .= " and a.do_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'";*/

		 
$i=0;
$do_release=0;
	
 $sql="select 	 
a.do_no,
a.dealer_code,
concat('<b>',d.dealer_name_e,'</b>','(',product_group,')','(',d.dealer_code,')','(',b.AREA_NAME,')','(',d.account_code,')'),
b.AREA_NAME,
concat(payment_by,'@',bank,'@',branch,':',remarks),
a.rcv_amt,
a.received_amt,
a.received_status,
d.account_code,
a.receive_acc_head,
a.final_jv_no,
a.rec_date,
a.do_date,
date(a.checked_at) as checked_at,
a.acc_note,
a.status,
a.do_file,
d.account_code
	 
from sale_do_master a, dealer_info d, area b 
where a.payment_by != 'cash' and a.dealer_type IN ('Distributor','Official') and a.status!='Manual' and b.AREA_CODE=d.area_code and a.dealer_code=d.dealer_code ".$con;
//and a.rcv_amt>0 
$query=db_query($sql);
while($data=mysqli_fetch_row($query)){
      $do_amt = find_a_field('sale_do_details','sum(total_amt)','do_no="'.$data[0].'"');
	  $received = $received + $data[6];

if($data[15]=='COMPLETED' || $data[15]=='CHECKED'){ $do_release = 1; } else { $do_release=0;}	  
	  ?>
				<tr <? /*if(++$i%2==0) echo ''; else echo 'class="alt"';*/ if($do_amt>$data[5]) echo 'style="background:#b38e8b"'; else echo 'style="background:#ccc"'?>>
				
					<td><?=++$i;?></td>
					
					<td><b><a href="../../../sales_mod/pages/wo/sales_order_print_view.php?v_no=<? echo $data[0];?>" target="_blank"><? echo $data[0];?></a></b><br /><? echo $data[12];?><br /><!--<a href="../../../assets/support/upload_view.php?name=<?=$data[16]?>&folder=do_distributor" target="_blank">Deposit Slip</a>--></td>
					
					<td><? echo $data[2];?></td>
					<!--<td><? echo $data[0];?></td>-->
					
					<td><?
	  do_calander('#rec_date_'.$data[0]);
	  ?>
	  <input name="rec_date_<?=$data[0]?>" type="text" id="rec_date_<?=$data[0]?>" 
	  value="<? if($data[11]!='0000-00-00'){ echo $data[11];}else{ echo date('Y-m-d');}?>"  /></td>
					
					<td><select  id="receive_acc_head_<?=$data[0]?>" name="receive_acc_head_<?=$data[0]?>">
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$data[9],'ledger_id="'.$data[9].'"');?>
        </select></td>
					
					<td><? echo $data[4];?></td>
					
					<td><input name="no_<?=$data[0]?>" type="text" id="no_<?=$data[0]?>"  value="<?=$data[14]?>" /></td>
					
					<td><? echo number_format($data[5],2); $rcv_total = $rcv_total +$data[5];?></td>
					
					<td><input name="ra_<?=$data[0]?>" type="text" id="ra_<?=$data[0]?>"  value="<?=$data[6]?>" /></td>
					
					<td><span id="divi_<?=$data[0]?>">
            <? 
			if(($data[17]>0)){
			  if(($data[10]>0))
			  {?>
<input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="1" />
<input type="button" name="Button" value="OK" class="btn1 btn1-bg-submit" />
<?
			  }
			  else
			  {
			  ?>
<input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="0" />
<?=$do_release>0?'DO Released':'';?>
<input type="button" name="Button" value="NO"  onclick="update_value(<?=$data[0]?>)" class="btn1 btn1-bg-cancel" /><? }}else echo 'Set ACC CODE';?>
          </span></td>
				</tr>
				
				<? }}?>
	        <tr class="alt">
        <td colspan="7" align="center"><div align="right"><strong>Total Received: </strong></div></td>
        <td align="center"><div align="right">
          <?=number_format($rcv_total,2)?>
        </div></td>
        <td align="center">
          
              <div align="right">
                <?=number_format($received,2);?>
                </div></td>
        <td align="center"><div align="left"></div></td>
      </tr>


				</tbody>
			</table>





		</div>



	</div>

</form>









<?php /*?><form id="form2" name="form2" method="post" action="">	

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td><table width="50%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">
              <tr>
                <td><div align="left"><strong>DO Date :</strong></div></td>
                <td><input name="f_date" type="text" id="f_date" value="<?=$_POST['f_date']?>" style="width:75px;" autocomplete="off"/></td>
                <td><input name="t_date" type="text" id="t_date" value="<?=$_POST['t_date']?>" style="width:75px;" autocomplete="off"/>                                </td>
                <td rowspan="3">                  <input type="submit" name="submitit" id="submitit" value="View DO Date" class="btn1 btn1-submit-input"/>                </td>
              </tr>
              <tr>
                <td><div align="left"><strong>Bank Acc: </strong></div></td>
                <td colspan="2"><select style="width:155px;" id="receive_acc_head" name="receive_acc_head">
				<option value="">ALL</option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['receive_acc_head'],' ledger_id LIKE "'.$collection_bank_head.'%" and ledger_id!="'.$bank_head.'" order by ledger_name');?>
                </select></td>
                </tr>
              <tr>
                <td><div align="left"><strong>Check Status: </strong></div></td>
                <td colspan="2"><select style="width:155px;" id="received_status" name="received_status">
                  <option value="">ALL</option>
				  <option value="received">CHECKED</option>
				  <option value="pending">NOT CHECKED</option>
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
      <th>DO# </th>
      <th>Dealer Name  </th>
      <th>Rec Date </th>
      <th>Bank Acc </th>
      <th>Received At </th>
      <th>Note</th>
      <th height="20">Rec</th>
      <th>Acc Rec</th>
      <th>OK?</th>
      </tr>
	  <?


if($_POST['submitit']!=''){
		 
	if($_POST['receive_acc_head']!='')
	 $con .= " and a.receive_acc_head = '".$_POST['receive_acc_head']."'";
	 if($_POST['received_status']!='')
	 $con .= " and a.received_status = '".$_POST['received_status']."'";
	 if($_POST['f_date']!=''&&$_POST['t_date']!='')
	 $con .= " and a.do_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'";


		 
$i=0;
$do_release=0;
	
 $sql="select 	 
a.do_no,
a.dealer_code,
concat('<b>',d.dealer_name_e,'</b>','(',product_group,')','(',d.dealer_code,')','(',b.AREA_NAME,')','(',d.account_code,')'),
b.AREA_NAME,
concat(payment_by,'@',bank,'@',branch,':',remarks),
a.rcv_amt,
a.received_amt,
a.received_status,
d.account_code,
a.receive_acc_head,
a.final_jv_no,
a.rec_date,
a.do_date,
date(a.checked_at) as checked_at,
a.acc_note,
a.status
	 
from sale_do_master a, dealer_info d, area b 
where a.payment_by != 'cash' and a.status!='Manual' and b.AREA_CODE=d.area_code and a.dealer_code=d.dealer_code and d.dealer_type='Distributor' ".$con;

$query=db_query($sql);
while($data=mysqli_fetch_row($query)){
	  $received = $received + $data[6];

if($data[15]=='COMPLETED' || $data[15]=='CHECKED'){ $do_release = 1; } else { $do_release=0;}	  
	  ?>

      <tr <? if(++$i%2==0) echo ''; else echo ' class="alt"';?>>
      <td align="center"><div align="left"><?=$i;?></div></td>
	  
      <td align="center"><div align="left"><b><a href="../../sales_mod/pages/do_temp/do_check.php?do_no=<? echo $data[0];?>" target="_blank"><? echo $data[0];?></a></b><br /><? echo $data[12];?></div></td>
	  
      <td align="center"><div align="left"><? echo $data[2];?></div></td>
	  
      <td align="center">
	  <?
	  do_calander('#rec_date_'.$data[0]);
	  ?>
	  <input name="rec_date_<?=$data[0]?>" type="text" id="rec_date_<?=$data[0]?>" 
	  value="<? if($data[11]!='0000-00-00'){ echo $data[11];}else{ echo date('Y-m-d');}?>" style="width:70px;" /></td>
	  
      <td align="center"><div align="left">

        <select style="width:155px;" id="receive_acc_head_<?=$data[0]?>" name="receive_acc_head_<?=$data[0]?>">
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$data[9],' ledger_id LIKE "'.$collection_bank_head.'%" and ledger_id!="'.$bank_head.'" order by ledger_name');?>
        </select>
      </div></td>
	  
      <td align="center"><div align="left"><? echo $data[4];?></div></td>
	  
      <td align="center"><input name="no_<?=$data[0]?>" type="text" id="no_<?=$data[0]?>" style="width:80px; text-align:right" value="<?=$data[14]?>" /></td>
	  
      <td align="right"><? echo number_format($data[5],2); $rcv_total = $rcv_total +$data[5];?></td>
	  
      <td align="right">
        <div align="right">
          <input name="ra_<?=$data[0]?>" type="text" id="ra_<?=$data[0]?>" style="width:80px; text-align:right" value="<?=$data[6]?>" />
          </div></td>
		  
      <td align="center"><span id="divi_<?=$data[0]?>">
            <? 
			if(($data[8]>0)){
			  if(($data[10]>0))
			  {?>
<input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="1" />
<input type="button" name="Button" value="OK" class="btn1 btn1-bg-submit" />
<?
			  }
			  else
			  {
			  ?>
<input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="0" />
<?=$do_release>0?'DO Released':'';?>
<input type="button" name="Button" value="NO"  onclick="update_value(<?=$data[0]?>)" class="btn1 btn1-bg-cancel" /><? }}else echo 'Set ACC CODE';?>
          </span></td>
      </tr>
	  <? }}?>
	        <tr class="alt">
        <td colspan="7" align="center"><div align="right"><strong>Total Received: </strong></div></td>
        <td align="center"><div align="right">
          <?=number_format($rcv_total,2)?>
        </div></td>
        <td align="center">
          
              <div align="right">
                <?=number_format($received,2);?>
                </div></td>
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
</form><?php */?>
<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>