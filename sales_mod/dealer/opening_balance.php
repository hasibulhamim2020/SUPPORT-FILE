<?php

session_start();

ob_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander("#op_date");


error_reporting(E_ERROR | E_WARNING | E_PARSE);

$title='Opening Balance';

//do_calander('#op_date');

$proj_id=$_SESSION['proj_id'];
$active='opbal';

ini_set('max_input_vars', '10000');

//echo $proj_id;

$now=time();

//do_calander('#op_date');

//var_dump($_POST);



$j_sql="select ledger_id,cr_amt,dr_amt from journal where tr_from='Opening' and group_for ='".$_SESSION['user']['group']."' and ledger_id like '1%' or ledger_id like '2%'";

$j_query=db_query($j_sql);

while($j_data=mysqli_fetch_row($j_query))

{

$ledger_cr[$j_data[0]]=$j_data[1];

$ledger_dr[$j_data[0]]=$j_data[2];

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

var cr=(document.getElementById('cr_'+id).value)*1; 

var dr=(document.getElementById('dr_'+id).value)*1; 

var opdate=(document.getElementById('op_date').value); 

var flag=(document.getElementById('flag_'+id).value); 



var strURL="opening_balance_ajax.php?item_id="+item_id+"&cr="+cr+"&dr="+dr+"&opdate="+opdate+"&flag="+flag;



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












<div class="form-container_large">
	<form id="form2" name="form2" method="post" action="">
		<div class="container-fluid bgc-yello1">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
					<div class="form-group row m-0 pb-1 pt-1">
						<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Opening Date:</label>
						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

							<input name="op_date" type="text" class="required " id="op_date"  value="<?=$_POST['op_date']?>" size="30" maxlength="100" />
						</div>
					</div>

					<div class="form-group row m-0 pb-1 pt-1">
						<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Oppening Balance Differ:</label>
						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

							<?

							if($_POST['group_id']>0){

								$sql="select sum(j.dr_amt),sum(j.cr_amt) from journal j, accounts_ledger a where a.ledger_id=j.ledger_id and j.tr_from='Opening' and a.ledger_group_id = '".$_POST['group_id']."' ";

								$query=db_query($sql);

								$info=mysqli_fetch_row($query);

								$diff=$info[0]-$info[1];

								if($diff<0) $diff='('.$diff*(-1).')';

							}

							?>

							<input name="customer_company" type="text" class="required " id="customer_company" value="<?=$diff?>" size="30" maxlength="100" />

						</div>
					</div>

				</div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-2 pb-3 bgc-violate">
					<h4 class="text-center bold">Total Debit </h4>
					<input name="t_debit" type="text" id="t_debit" value="<?=$info[0]?>" size="30" maxlength="100" class="required" minlength="4" />
				</div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-2 pb-3 bgc-light-green">
					<h4 class="text-center bold">Total Credit </h4>
					<input name="t_credit" type="text" id="t_credit" value="<?=$info[1]?>" size="30" maxlength="100" class="required" minlength="4" />
				</div>

			</div>
		</div>



		<div class="container-fluid bg-form-titel mt-2">
			<div class="row">
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
					<div class="form-group row m-0">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<select name="warehouse_id" id="warehouse_id">
								<option></option>
								<?

								foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');

								?>
							</select>
						</div>
					</div>

				</div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
					<div class="form-group row m-0">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Ledger Group</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<select name="group_id" id="group_id" required >

								<?

								//foreign_relation('ledger_group','group_id','group_name',$_POST['group_id'],'group_for="'.$_SESSION['user']['group'].'" and group_id="10203" ');
								foreign_relation('ledger_group','group_id','group_name',$_POST['group_id'],'1');

								?>
							</select>

						</div>
					</div>
				</div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
					<input type="submit" name="submitit" id="submitit" value="Set Opening Balance" class="btn1 btn1-submit-input" />
				</div>

			</div>
		</div>






		<div class="container-fluid pt-5 p-0 ">

			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th>SL</th>
					<th>Acc Code</th>
					<th>Accounts Head</th>

					<th>Address</th>
					<th width="12%">Debit Amt</th>
					<th width="12%">Credit Amt</th>

					<th>Action</th>
				</tr>
				</thead>

				<tbody class="tbody1">


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

						$cr_amt=$ledger_cr[$data[0]];

//if($opening>0)

//$jv->cr_amt = $opening;

//else

//$jv->dr_amt = $opening;



						?>

						<tr>

							<td>
								<?=$i;?>
							</td>

							<td><? echo $data[0];?></td>

							<td style="text-align:left">
								<input name="jv_date" type="hidden" id="jv_date" value="<?=$_POST['op_date']?>" />
								<? echo $data[1];?>
							</td>

							<td style="text-align:left"><?=find_a_field('dealer_info','address_e','account_code='.$data[0]);?></td>

							<td><input name="dr_<?=$data[0]?>" type="text" id="dr_<?=$data[0]?>" value="<?=$dr_amt?>" /></td>

							<td><input name="cr_<?=$data[0]?>" type="text" id="cr_<?=$data[0]?>" value="<?=$cr_amt?>" /></td>

							<td>
								<span id="divi_<?=$data[0]?>">

            <?

			if(($dr_amt>0)||($cr_amt>0))

			{?>

				<input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="1" />

				<input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data[0]?>)" class="btn1 btn1-bg-update" /><?

			}

			elseif($info->id<1)

			{

				?>

				<input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="0" />

				<input type="button" name="Button" value="Save"  onclick="update_value(<?=$data[0]?>)" class="btn1 btn1-bg-submit" /><? }?>

          </span>
							</td>
						</tr>

					<? }}?>



				</tbody>
			</table>


		</div>
	</form>
</div>


















<?php /*>
<form id="form2" name="form2" method="post" action="">



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
value="<?=$_POST['op_date']?>" size="30" maxlength="100" />

				  </td>
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

				<td bgcolor="#45777B">
					<input name="customer_company" type="text" class="required " id="customer_company" style="width:130px;" value="<?=$diff?>" size="30" maxlength="100" />
				</td>
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
                    <td bgcolor="#99CCCC"><div align="right"><span class="style5">Warehouse:</span></div></td>
                    <td bgcolor="#99CCCC"><div align="center">
                      <select name="warehouse_id" id="warehouse_id" style="width:400px; font-size:12px; font-weight:bold;">
					  <option></option>
                        <?

						foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');

						?>
                      </select>

                    </div>
					</td>
                    <td rowspan="2" bgcolor="#99CCCC">
						<input type="submit" name="submitit" id="submitit" value="Set Opening Balance" class="btn1 btn1-submit-input" />
					</td>
                  </tr>
                  <tr>
                    <td bgcolor="#99CCCC"><div align="right"><span class="style5">Ledger Group:</span></div></td>
                    <td bgcolor="#99CCCC"><div align="center">
                      <select name="group_id" id="group_id" required style="width:400px; font-size:12px; font-weight:bold;">
					  
					  
                        <?

foreign_relation('ledger_group','group_id','group_name',$_POST['group_id'],'group_for="'.$_SESSION['user']['group'].'" and group_id="10203" ');

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

      <th align="center" bgcolor="#45777B"><span class="style6">Accounts Head </span></th>

      <th align="center" bgcolor="#45777B"><span class="style6">Address</span></th>
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

$cr_amt=$ledger_cr[$data[0]];

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

      <td align="center"><?=find_a_field('dealer_info','address_e','account_code='.$data[0]);?></td>
      <td align="center"><input name="dr_<?=$data[0]?>" type="text" id="dr_<?=$data[0]?>" style="width:90px;" value="<?=$dr_amt?>" /></td>

      <td align="center"><input name="cr_<?=$data[0]?>" type="text" id="cr_<?=$data[0]?>" style="width:90px;" value="<?=$cr_amt?>" /></td>

      <td align="center"><span id="divi_<?=$data[0]?>">

            <? 

			  if(($dr_amt>0)||($cr_amt>0))

			  {?>

			  <input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="1" />

			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data[0]?>)" class="btn1 btn1-bg-update" /><?

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

</form>
<*/?>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

