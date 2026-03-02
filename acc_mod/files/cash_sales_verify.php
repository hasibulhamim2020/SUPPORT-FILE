<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Cash Sales Verification';
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
	<div class="form-container_large">

		<div class="container-fluid bg-form-titel">
			<div class="row">
				<!--left form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">

						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">CS Date :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="do_date_fr" class="form-control" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" required autocomplete="off" />
							</div>
						</div>
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> -To-</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" class="form-control"  required autocomplete="off" />
							</div>
						</div>
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Checked :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<span class="oe_form_group_cell">

										<select name="checked" id="checked" class="form-control">

											<option></option>

											<option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>

											<option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>

										</select>

									</span>
							</div>
						</div>




					</div>
				</div>

				<!--Right form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">


						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan Depot : </label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<span class="oe_form_group_cell" >

										<select name="depot_id" id="depot_id" class="form-control">

											<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot_id'],'use_type="SD" order by warehouse_id');?>

										</select>

									</span>
							</div>
						</div>
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Party Name :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<?
									$sql = "select v.vendor_id,v.vendor_name from vendor v where  v.group_for='".$_SESSION['user']['group']."'order by v.vendor_name";
									?>

									<select name="vendor_id" id="vendor_id" class="form-control">

										<option></option>

										<?

										foreign_relation_sql($sql,$vendor_id);?>

									</select>
							</div>
						</div>






					</div>
				</div>

			</div>


			<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input type="submit" name="submitit" id="submitit" value="View LS" class="btn1 btn1-submit-input "/>
				</div>

			</div>




		</div>






		<div class="container-fluid pt-5 p-0 ">


			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">


				<tr class="bgc-info">
					<th>SL</th>
					<th>LP#</th>
					<th>Narration</th>
					<th>Party Name</th>
					<th>Warehouse</th>
					<th>Create At</th>
					<th>Create By </th>
					<th>Payable Amt</th>
					<th>&nbsp;</th>
					<th>Checked?</th>

				</tr>
				</thead>

				<tbody class="tbody1">


				<?





				if($_POST['do_date_fr']!=''){

					$i=0;

					if($_POST['checked']!=''){ $checked_con = ' and j.checked="'.$_POST['checked'].'" ';}

					if($_SESSION['user']['group']>1){ $group_s='AND j.group_for='.$_SESSION['user']['group'];}

					if($_POST['depot_id']>0){ $depot_con = ' and w.warehouse_id="'.$_POST['depot_id'].'" ';}

					if($_POST['vendor_id']!='') {$vendor_con=' and r.vendor_id="'.$_POST['vendor_id'].'"';}

				 	$sql="SELECT DISTINCT

				  j.tr_no,


				  cr_amt,

				  1,

				  j.jv_date,

				  j.jv_no,

				  l.ledger_name,

				  j.narration,

				  u.fname,

				  j.entry_at,

				  j.checked,

				  j.jv_no,



				  w.warehouse_name,

				  r.oi_no

				FROM

				  secondary_journal j,

				  accounts_ledger l,

				  warehouse_other_issue_detail r,

				  warehouse w,

				  user_activity_management u



				WHERE
j.cr_amt>0 and



				  w.warehouse_id=r.warehouse_id AND

				  j.tr_no = r.oi_no AND

				  j.tr_from = 'CASH Sales' AND

				  j.entry_by = u.user_id AND

				  j.jv_date between '". $_POST['do_date_fr']."' AND  '". $_POST['do_date_to']."' AND

				  j.ledger_id = l.ledger_id ".$group_s.$checked_con.$depot_con." group by j.jv_no";

					$query=db_query($sql);



					while($data=mysqli_fetch_row($query)){
						$received = $received + $data[1];
						?>



						<tr>

							<td><?=++$i;?></td>

							<td><? echo $data[12];?></td>

							<td><? echo $data[6];?></td>

							<td><? echo $data[5];?></td>

							<td><? echo $data[11];?></td>

							<td><? echo $data[8];?></td>

							<td><? echo $data[7];?></td>

							<td><?=number_format($data[1],2)?></td>

							<td><a target="_blank" href="cash_sales_print.php?jv_no=<?=$data[10] ?>"><img src="../images/print.png" width="20" height="20" /></a></td>

							<td>
								<span id="divi_<?=$data[0]?>">

									<?

									if(($data[9]=='YES')){

										?>

										<input type="button" name="Button" value="YES"  onclick="window.open('cash_sales_print.php?jv_no=<?=$data[10] ?>');" class="btn btn-success" />

										<?

									}elseif(($data[9]=='NO' || $data[9]=='')){

										?>

										<input type="button" name="Button" value="NO"  onclick="window.open('cash_sales_print.php?jv_no=<?=$data[10] ?>');" class="btn btn-danger" />

									<? }?>

								  </span>
							</td>

						</tr>

					<? }}?>

				<tr>

					<td colspan="7" align="center"><div align="right"><strong>Total Received: </strong></div>
					</td>

					<td align="right"><?=number_format($received,2);?></td>

					<td></td>

					<td></td>

				</tr>

				</tbody>
			</table>


		</div>



	</div>

</form>








<?/*>
<br>
<br>
<br>
<br>
<br>
				<form id="form2" name="form2" method="post" action="">



<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>

    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

			<td>
				<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">

              <tr>

                <td width="20%"><div align="right"><strong>LS Date :</strong></div></td>

                <td width="20%"><input name="do_date_fr" class="form-control" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" required /></td>

                <td width="4%"><div align="center">-to-</div></td>

                <td width="20%"><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" class="form-control"  required /></td>

                <td width="20%" rowspan="4"><label>

                  <input type="submit" name="submitit" id="submitit" value="View LS" class="btn1 btn1-submit-input "/>

                </label></td>

              </tr>

              <tr>

                <td><div align="right"><strong>Checked : </strong></div></td>

                <td colspan="3"><div align="left">
						<span class="oe_form_group_cell">

                    <select name="checked" id="checked" class="form-control">

                      <option></option>

                      <option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>

                      <option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>

                    </select>

                </span>
					</div></td>

                </tr>

              <tr>

                <td><div align="right"><strong>Chalan Depot : </strong></div></td>

                <td colspan="3"><div align="left">
						<span class="oe_form_group_cell" >

                    <select name="depot_id" id="depot_id" class="form-control">

                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot_id'],'use_type="SD" order by warehouse_id');?>

                    </select>

                </span>
					</div></td>

                </tr>

              <tr>

                <td><div align="right"><strong>Party Name :</strong></div> </td>

                <td colspan="3">

				<?

				

						$sql = "select v.vendor_id,v.vendor_name from vendor v where  v.group_for='".$_SESSION['user']['group']."'order by v.vendor_name";

				?>

				<select name="vendor_id" id="vendor_id" class="form-control">

                  <option></option>

                  <? 

						foreign_relation_sql($sql,$vendor_id);?>

                </select>
				</td>

              </tr>

            </table>
			</td>

	    </tr>

		<tr><td>&nbsp;</td></tr>

        <tr>

          <td>

      <table width="98%" align="center" cellspacing="0" class="tabledesign table-bordered">

      <tbody>

      <tr>

      <th>SL</th>

	  

      <th>LP#</th>

      <th>Narration</th>

      <th>Party Name</th>

      <th>Warehouse</th>

      <th>Create At</th>

      <th>Create By </th>

      <th>Payable Amt</th>

      <th>&nbsp;</th>

      <th>Checked?</th>

      </tr>

	  <?





		 if($_POST['do_date_fr']!=''){

	  $i=0;

		if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';

	 	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

		if($_POST['depot_id']>0) $depot_con = ' and w.warehouse_id="'.$_POST['depot_id'].'" ';

		if($_POST['vendor_id']!='') {$vendor_con=' and r.vendor_id="'.$_POST['vendor_id'].'"';}

	    $sql="SELECT DISTINCT 

				  j.tr_no,


				  cr_amt,

				  1,

				  j.jv_date,

				  j.jv_no,

				  l.ledger_name,

				  j.narration,

				  u.fname,

				  j.entry_at,

				  j.checked,

				  j.jv_no,
				  
				  

				  w.warehouse_name,

				  r.oi_no

				FROM

				  secondary_journal j,

				  accounts_ledger l,

				  warehouse_other_issue_detail r,

				  warehouse w,

				  user_activity_management u
				  
			

				WHERE
j.cr_amt>0 and 

				
				
				  w.warehouse_id=r.warehouse_id AND

				  j.tr_no = r.oi_no AND

				  j.tr_from = 'LocalSales' AND 

				  j.entry_by = u.user_id AND 

				  j.jv_date between '". $_POST['do_date_fr']."' AND  '". $_POST['do_date_to']."' AND 

				  j.ledger_id = l.ledger_id ".$group_s.$checked_con.$depot_con." group by j.jv_no";

	  $query=db_query($sql);

	  

	  while($data=mysqli_fetch_row($query)){
$received = $received + $data[1];
	  ?>



      <tr class="alt">

      <td align="center"><div align="left">

        <?=++$i;?>

      </div></td>

      <td align="center"><div align="left"><? echo $data[12];?></div></td>

      <td align="center"><div align="left"><? echo $data[6];?></div></td>

      <td align="center"><div align="left"><? echo $data[5];?></div></td>

      <td align="center"><div align="left"><? echo $data[11];?></div></td>

      <td align="center"><div align="left"><? echo $data[8];?></div></td>

      <td align="center"><div align="left"><? echo $data[7];?></div>        <div align="left"></div></td>

      <td align="right"><?=number_format($data[1],2)?></td>

      <td align="center"><a target="_blank" href="local_sales_print.php?jv_no=<?=$data[10] ?>"><img src="../images/print.png" width="20" height="20" /></a></td>

      <td align="center"><span id="divi_<?=$data[0]?>">

            <? 

			  if(($data[9]=='YES')){

?>

<input type="button" name="Button" value="YES"  onclick="window.open('local_sales_print.php?jv_no=<?=$data[10] ?>');" class="btn btn-success" />

<?

}elseif(($data[9]=='NO' || $data[9]=='')){

?>

<input type="button" name="Button" value="NO"  onclick="window.open('local_sales_print.php?jv_no=<?=$data[10] ?>');" class="btn btn-danger" />

<? }?>

          </span></td>

      </tr>

	  <? }}?>

	        <tr class="alt">

        <td colspan="7" align="center"><div align="right"><strong>Total Received: </strong></div>

          

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

<*/?>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

