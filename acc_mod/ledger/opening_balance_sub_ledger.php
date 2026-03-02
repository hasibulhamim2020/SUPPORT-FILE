<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander("#op_date");

$title='Opening Balance';

//do_calander('#op_date');

$proj_id=$_SESSION['proj_id'];
$active='opbal';

ini_set('max_input_vars', '10000');

$now=time();
$j_sql="select ledger_id,cr_amt,dr_amt,narration,sub_ledger from journal where tr_from='Opening' and group_for ='".$_SESSION['user']['group']."' ";
$j_query=db_query($j_sql);
while($j_data=mysqli_fetch_row($j_query))
{

/*$ledger_cr[$j_data[0]][$j_data[4]]=$j_data[1];

$ledger_dr[$j_data[0]][$j_data[4]]=$j_data[2];

$narration[$j_data[0]][$j_data[4]]=$j_data[3];*/

$ledger_cr[$j_data[4]]=$j_data[1];

$ledger_dr[$j_data[4]]=$j_data[2];

$narration[$j_data[4]]=$j_data[3];

}

?>

<style type="text/css">

<!--

.style2 {

	color: #0000FF;

	font-weight: bold;

}

.style3 {

	color: #006600;

	font-weight: bold;

}

.style4 {

	color: #FFFFFF;

	font-weight: bold;

}

.style5 {

	color: #000033;

	font-weight: bold;

}
.style6 {color: #FFFFFF}

-->

</style>

<script>



function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
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



function update_value(ledger,sub_ledger){

//var ledger_id=ledger;
var sub_ledger_id=sub_ledger;

var cr=(document.getElementById('cr_'+sub_ledger_id).value)*1; 

var dr=(document.getElementById('dr_'+sub_ledger_id).value)*1; 

var ledger=(document.getElementById('ledger_id'+sub_ledger_id).value);
var ledger_id = encodeURIComponent(ledger);

var opdate=(document.getElementById('op_date').value);


var narration=(document.getElementById('narration_'+sub_ledger_id).value); 

var flag=(document.getElementById('flag_'+sub_ledger_id).value); 



var strURL="opening_balance_sub_ledger_ajax.php?ledger_id="+ledger_id+"&cr="+cr+"&dr="+dr+"&opdate="+opdate+"&narration="+narration+"&flag="+flag+"&sub_ledger="+sub_ledger_id;

		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('divi_'+sub_ledger_id).style.display='inline';
						document.getElementById('divi_'+sub_ledger_id).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}
			req.open("GET", strURL, true);
			req.send(null);
		}	
}

function subLedgerBalance(ledgerID, subLedgerID) {
    var strURL = "opening_balance_subLedger_ajax.php?ledgerID=" + ledgerID + "&subLedgerID=" + subLedgerID;

    var req = getXMLHTTP();
    if (req) {
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"
                if (req.status == 200) {
                   
                    const response = JSON.parse(req.response);
                    const crAmt = response.cr_amt; // "0.00"
                    const drAmt = response.dr_amt; // "5000.00"
                    
                     document.getElementById('dr_'+ledgerID).value = drAmt;
                     document.getElementById('cr_'+ledgerID).value = crAmt;

                   
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


<script>
function filterTable() {
    var input = document.getElementById("searchBox");
    var filter = input.value.toLowerCase();
    var table = document.getElementById("openingBalanceTable");
    var rows = table.getElementsByTagName("tr");

    for (var i = 1; i < rows.length; i++) { // skip header row
        var rowText = rows[i].textContent.toLowerCase();
        rows[i].style.display = rowText.indexOf(filter) > -1 ? "" : "none";
    }
}
</script>






<div class="form-container_large">
	<form id="form2" name="form2" method="post" action="">
		<div class="container-fluid bgc-yello1">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
					<div class="form-group row m-0 pb-1 pt-1">
						<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Opening Date</label>
						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
							<input name="op_date" type="text" class="required " id="op_date"  
value="<?=$_POST['op_date']?>"  required autocomplete="off"/>
						</div>
					</div>

					<div class="form-group row m-0 pb-1 pt-1">
						<?

								if($_POST['group_id']>0){
				
								$sql="select sum(j.dr_amt),sum(j.cr_amt) from journal j, accounts_ledger a where a.ledger_id=j.ledger_id and j.tr_from='Opening' and a.ledger_group_id = '".$_POST['group_id']."' ";
				
								$query=db_query($sql);
				
								$info=mysqli_fetch_row($query);
				
								$diff=$info[0]-$info[1];
				
								if($diff<0) $diff='('.$diff*(-1).')';
				
								}
				
						?>
						<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Opening Balance Differ</label>
						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
							<input name="customer_company" type="text" class="required " id="customer_company" value="<?=$diff?>" />
						</div>
					</div>

				</div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-2 pb-3 bgc-violate">
					<h4 class="text-center bold">Total Debit </h4>
					<input name="t_debit" type="text" id="t_debit" value="<?=$info[0]?>" class="required"  />
				</div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-2 pb-3 bgc-light-green">
					<h4 class="text-center bold">Total Credit </h4>
					<input name="t_credit" type="text" id="t_credit" value="<?=$info[1]?>" class="required" minlength="4"/>
				</div>

			</div>
		</div>



		<div class="container-fluid bg-form-titel mt-2">
			<div class="row">
				
				<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
					<div class="form-group row m-0">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Ledger Group</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
								<input type="text" name="group_id" id="group_id" list="ledgerList" value="<? if(isset($_POST['group_id'])) echo find_a_field('ledger_group','concat(group_name,"->",group_id)','group_id='.end(explode("->",$_POST['group_id'])))?>" required>
					    <datalist id="ledgerList">
					    
                       
						
						
						<?

						foreign_relation('ledger_group','concat(group_name,"->",group_id)','""',$_POST['group_id'],'1');

?>
						</datalist>
                      
						</div>
					</div>
				</div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
					<input type="submit" name="submitit" id="submitit" value="Set Opening Balance" class="btn1 btn1-submit-input"/>
				</div>

			</div>
		</div>
		
		
		
				<div style="text-align: right; margin: 10px 0;">
    <input type="text" id="searchBox" placeholder="Search here..." 
       style="margin-bottom:10px; padding:6px; width:250px;" 
       onkeyup="filterTable()">

		</div>






		<div class="container-fluid pt-5 p-0 ">

			<table class="table1  table-striped table-bordered table-hover table-sm" id="openingBalanceTable">
				<thead class="thead1">
				<tr class="bgc-info">
					<th>SL</th>
					<th>Sub Leder Code</th>
					
					<th>Sub Ledger</th>
					<th>Ledger Name</th>

					<th width="12%">Debit Amt</th>
					<th width="12%">Credit Amt</th>
					<th>Details</th>

					<th>Action</th>
				</tr>
				</thead>

				<tbody class="tbody1">
					 <?

					
							 if(isset($_POST['submitit'])){
					
						  $i=0;
						  
						  if($_POST['group_id']!=''){
						  $only_ledger_id = end(explode("->",$_POST['group_id']));
						  $ledger_con .=' and j.ledger_group_id = "'.$only_ledger_id.'"';
						  }
					
					
						$sql="select a.sub_ledger_id,a.sub_ledger_name,a.ledger_id, j.ledger_id,j.ledger_group_id 
						from general_sub_ledger a, accounts_ledger j
						where a.ledger_id=j.ledger_id ".$ledger_con." order by a.ledger_id";
						
					
						  $query=db_query($sql);
					
						  //echo $cooo+= mysqli_num_rows($query);
					
						  while($data=mysqli_fetch_row($query)){
					
						  $i++;
					
					
					
					
					
					/*$dr_amt=$ledger_dr[$data[2]][$data[0]];
					
					$cr_amt=$ledger_cr[$data[2]][$data[0]];
					
					$narrations=$narration[$data[2]][$data[0]];*/
					
					$dr_amt=$ledger_dr[$data[0]];
					
					$cr_amt=$ledger_cr[$data[0]];
					
					$narrations=$narration[$data[0]];
					
					//if($opening>0)
					
					//$jv->cr_amt = $opening;
					
					//else
					
					//$jv->dr_amt = $opening;
					
					
					
			  ?>

				<tr>
					<td><?=$i++?></td>
					<td><?=$data[0]?></td>
					
					<td style="text-align:left"><input name="jv_date" type="hidden" id="jv_date" value="<?=$_POST['op_date']?>" />
	  <? echo $data[1];?></td>
	  
	  <td ><input type="text" name="ledger_id<?=$data[0]?>" id="ledger_id<?=$data[0]?>" list="subledgerList" value="" >
						 <datalist id="subledgerList">
						<? foreign_relation('accounts_ledger','concat(ledger_name,"->",ledger_id)','""',$_POST['ledger_id'],'1');?>
						</datalist>
						</td>

	  		

					<td><input name="dr_<?=$data[0]?>" type="text" id="dr_<?=$data[0]?>" value="<?=$dr_amt?>" /></td>
					<td><input name="cr_<?=$data[0]?>" type="text" id="cr_<?=$data[0]?>" value="<?=$cr_amt?>" /></td>
					<td><input type="text" name="narration_<?=$data[0]?>" id="narration_<?=$data[0]?>" value="<? if($narrations!='') echo $narrations; else echo 'Opening Balance';?>" /></td>
					

					<td>
							<span id="divi_<?=$data[0]?>">

            <? 

					  if(($dr_amt>0)||($cr_amt>0))
		
					  {?>
		
					  <input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="1" />
		
					  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data[2]?>,<?=$data[0]?>)" class="btn1 btn1-bg-update"/><?
		
					  }
		
					  elseif($info->id<1)
		
					  {
		
					  ?>
		
					  <input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="0" />
		
					  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data[2]?>,<?=$data[0]?>)" class="btn1 btn1-bg-submit" /><? }?>
		
				  </span>
					
					
					</td>

				</tr>


				<? }  } ?>
				</tbody>
			</table>





		</div>
	</form>
</div>






<br /><br />

				<!--<form id="form2" name="form2" method="post" action="">	



<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>

    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

				<td>

		

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

				

				<tr>

				

				<td><div class="box" style="width:100%;">

				<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#666666">

				<tr>

				<td width="50%" align="center" valign="middle">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

				  <td bgcolor="#45777B"><span class="style4">Opening Date:</span></td>

				  <td bgcolor="#45777B">



<input name="op_date" type="text" class="required " id="op_date" style="width:130px;" 
value="<?=$_POST['op_date']?>" size="30" maxlength="100" required /></td>
				  </tr>

				<tr>

				

				<td bgcolor="#45777B"><span class="style4">Oppening Balance Differ:</span></td>

				<?

				if($_POST['group_id']>0){

				$sql="select sum(j.dr_amt),sum(j.cr_amt) from journal j, accounts_ledger a where a.ledger_id=j.ledger_id and j.tr_from='Opening' and a.ledger_group_id = '".$_POST['group_id']."' ";

				$query=db_query($sql);

				$info=mysqli_fetch_row($query);

				$diff=$info[0]-$info[1];

				if($diff<0) $diff='('.$diff*(-1).')';

				}

				?>

				<td bgcolor="#45777B"><input name="customer_company" type="text" class="required " id="customer_company" style="width:130px;" value="<?=$diff?>" size="30" maxlength="100" /></td>
				</tr>
				</table>

				</td>

				<td width="50%">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

				



				<tr>

				<td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

				<td bgcolor="#66CCFF" height="20px;"><div align="center"><span class="style2">Total Debit:</span></div></td>

				<td bgcolor="#66FFCC"><div align="center"><span class="style3">Total Credit:</span></div></td>

				</tr>

				<tr>

				<td bgcolor="#66CCFF"><div align="center">
				  <input name="t_debit" type="text" id="t_debit" value="<?=$info[0]?>" size="30" maxlength="100" class="required" minlength="4" style="width:130px;" />
				  </div></td>

				<td bgcolor="#66FFCC"><div align="center">
				  <input name="t_credit" type="text" id="t_credit" value="<?=$info[1]?>" size="30" maxlength="100" class="required" minlength="4" style="width:130px;"/>
				  </div></td>

				</tr>

				</table></td>

				</tr>

				</table>

				</td>

				</tr>

				</table>

				

				

				</div></td>

				</tr>

				

				<tr>

				

				<td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">

                  <tr>
                    <td bgcolor="#99CCCC"><div align="right"><span class="style5">&nbsp;</span></div></td>
                    <td bgcolor="#99CCCC"><div align="center">
                      <!--<select name="warehouse_id" id="warehouse_id" style="width:400px; font-size:12px; font-weight:bold;">
					  <option></option>
                        <?php /*?><?

						foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');

						?>
                      </select>-->
                    </div></td>
                    <td rowspan="2" bgcolor="#99CCCC"><input type="submit" name="submitit" id="submitit" value="Set Opening Balance" class="btn1 btn1-submit-input"/></td>
                  </tr>
                  <tr>
                    <td bgcolor="#99CCCC"><div align="right"><span class="style5">Ledger Group:</span></div></td>
                    <td bgcolor="#99CCCC"><div align="center">
                      <select name="group_id" id="group_id" required style="width:400px; font-size:12px; font-weight:bold;">
					  
					     <option></option>
                        <?

foreign_relation('ledger_group','group_id','group_name',$_POST['group_id'],'group_for="'.$_SESSION['user']['group'].'" and group_id not in ("10203")');

?>
                      </select>
                    </div></td>
                    </tr>
                  

                </table></td>

				</tr>

				</table>

				

				

		</td>

	    </tr>

		<tr><td>&nbsp;</td></tr>

        <tr>

          <td>

      <table cellspacing="0" class="table table-bordered">

      <tbody>

      <tr>

      <th align="center" bgcolor="#45777B"><span class="style6">SL</span></th>

      <th align="center" bgcolor="#45777B"><span class="style6">Acc Code </span></th>

      <th align="center" bgcolor="#45777B"><span class="style6">Accounts Head </span></th>-->

      <!--<th align="center" bgcolor="#45777B"><span class="style6">Address</span></th>-->
      <th height="20" align="center" bgcolor="#45777B"><span class="style6">Debit Amt</span></th>

      <th align="center" bgcolor="#45777B"><span class="style6">Credit Amt</span></th>

      <th align="center" bgcolor="#45777B"><span class="style6">Action</span></th>
      </tr>

	  <?





		 if($_POST['group_id']>0){

	  $i=0;
	  
	  if($_POST['warehouse_id']!='')
	  $warehouse_con.=' and d.depot = "'.$_POST['warehouse_id'].'"';


	 	 $sql="select a.ledger_id,a.ledger_name from accounts_ledger a, dealer_info d
		  where a.ledger_id=d.account_code and a.ledger_group_id='".$_POST['group_id']."' 
		  and parent=0 ".$warehouse_con." order by ledger_id";

	  $query=db_query($sql);

	  //echo $cooo+= mysqli_num_rows($query);

	  while($data=mysqli_fetch_row($query)){

	  $i++;





$dr_amt=$ledger_dr[$data[0]];

$cr_amt=$ledger_cr[$data[0]];<?php */?>

//if($opening>0)

//$jv->cr_amt = $opening;

//else

//$jv->dr_amt = $opening;



	  ?>

      <tr class="alt">

      <td align="center"><div align="left">

        <?=$i;?>

      </div></td>

      <td align="center"><div align="left"><? echo $data[0];?></div></td>

      <td align="center"><div align="left">
	   <input name="jv_date" type="hidden" id="jv_date" value="<?=$_POST['op_date']?>" />
	  <? echo $data[1];?></div></td>

      <!--<td align="center"><?=find_a_field('dealer_info','address_e','account_code='.$data[0]);?></td>-->
      <?php /*?><td align="center"><input name="dr_<?=$data[0]?>" type="text" id="dr_<?=$data[0]?>" style="width:90px;" value="<?=$dr_amt?>" /></td>

      <td align="center"><input name="cr_<?=$data[0]?>" type="text" id="cr_<?=$data[0]?>" style="width:90px;" value="<?=$cr_amt?>" /></td>

      <td align="center"><span id="divi_<?=$data[0]?>">

            <? 

			  if(($dr_amt>0)||($cr_amt>0))

			  {?>

			  <input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="1" />

			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data[0]?>)" class="btn1 btn1-bg-update"/><?

			  }

			  elseif($info->id<1)

			  {

			  ?>

			  <input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="0" />

			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data[0]?>)" class="btn1 btn1-bg-submit" /><? }?>

          </span></td>
      </tr>

	  <? }}?>
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>

