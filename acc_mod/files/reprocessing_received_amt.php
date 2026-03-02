<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Reprocessing Receive Verification';

$now=time();

do_calander('#do_date_fr');

do_calander('#do_date_to');

$depot_id = $_POST['depot_id'];

$group_for = $_SESSION['user']['group'];

?>

<script>



function getXMLHTTP() {



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












<div class="form-container_large">
	<form id="form2" name="form2" method="post" action="">

		<div class="container-fluid bg-form-titel">
			<div class="row">

				<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7">
					<div class="row">

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group row m-0">
								<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return Date :</label>
								<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
									<input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" autocomplete="off"/>
								</div>
							</div>
						</div>


						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group row m-0">
		<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> To Date: </label>
								<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
									<input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" autocomplete="off"/>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
					<div class="form-group row m-0">
						<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Checked :</label>
						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
							<select name="checked" id="checked">
								<option></option>
								<option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>
								<option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>
							</select>

						</div>
					</div>
				</div>

				<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
					<input type="submit" name="submitit" id="submitit" value="VIEW RETURN" class="btn1 btn1-submit-input" />
				</div>

			</div>
		</div>




		<!--Table start-->
		<div class="container-fluid pt-5 p-0 ">

			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">

				<tr class="bgc-info">
					<th>SL</th>
					<th>RR</th>
					<th>Accounts Head</th>
					<th>Date</th>
					<th>CC</th>
					<th>Entry By </th>
					<th> Amount</th>
					<th>&nbsp;</th>
					<th>Checked?</th>
				</tr>

				</thead>

				<tbody class="tbody1">


				<?

				if($_POST['do_date_fr']!=''){

					$i=0;

					$day_from = $_POST['do_date_fr'];

					$day_end =  $_POST['do_date_to'];



					if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

					if($_POST['dealer_type']!='') 	 $depot_con .= ' AND d.dealer_type="'.$_POST['dealer_type'].'"';

					if($depot_id>0) 				 $depot_con .= 'and j.cc_code='.$depot_id;



					if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';



					$sql="SELECT

				  j.tr_no,

				  sum(1) as co,

				  sum(j.dr_amt) as dr_amts,

				  j.jv_date,

				  j.jv_no,

				  l.ledger_name,

				  j.tr_id,

				  u.fname,

				  j.entry_at,

				  j.checked,

				  j.jv_no,

				  j.dr_amt,j.cc_code

				FROM

				  secondary_journal j,

				  accounts_ledger l,

				  user_activity_management u

				WHERE

				  j.entry_by = u.user_id and

				  j.tr_from = 'Reprocess Receive' AND

				  j.dr_amt >0 AND

				  j.jv_date  between '".$day_from."' AND '".$day_end."' AND

				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con.$checked_con."

				group by  j.tr_no";

					$query=db_query($sql);



					while($data=mysqli_fetch_object($query)){

						$received = $received + $data->dr_amts;

						?>



						<tr <?=($i%2==0)?'class="alt"':'';?>>

							<td align="center"><div align="left"><?=++$i;?></div></td>

							<td align="center"><div align="left"><? echo $data->tr_no;?></div></td>

							<td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>

							<td align="center"><div align="left"><? echo date('Y-m-d',$data->jv_date);?></div></td>

							<td align="center"><? echo $data->cc_code;?></td>

							<td align="center"><div align="left"><? echo $data->fname;?></div></td>

							<td align="right"><?=number_format($data->dr_amts,2);?></td>

							<td align="center"><a target="_blank" href="reprocess_receive_sec_print_view.php?jv_no=<?=$data->jv_no ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>

							<td align="center"><span id="divi_<?=$data->tr_no?>">

<?

if(($data->checked=='YES')){

	?>

	<input type="button" name="Button" value="YES"  onclick="window.open('reprocess_receive_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style=" font-weight:bold;width:40px; height:20px;background-color:#66CC66;"/>

	<?

}elseif(($data->checked=='NO' || $data->checked=='')){

	?>

	<input type="button" name="Button" value="NO"  onclick="window.open('reprocess_receive_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style="font-weight:bold;width:40px; height:20px;background-color:#FF0000;"/>

<? }?>

          </span></td>

						</tr>

					<? }}?>

				<tr class="alt">
					<td colspan="6" align="center"><div align="right"><strong>Total Amt : </strong></div><div align="left"></div></td>
					<td align="right"><?=number_format($received,2);?></td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>



				</tbody>
			</table>



		</div>
	</form>
</div>






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

			<td><table width="75%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">

              <tr>

                <td><div align="right"><strong>Return Date :</strong></div></td>

                <td><input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" style="width:150px;"/>

                  <label>                  </label></td>

                <td>-to-</td>

                <td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" style="width:150px;"/></td>

                <td rowspan="4"><label>

                  <input type="submit" name="submitit" id="submitit" value="View Return" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

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

              

 

              

            </table></td>

	    </tr>

		<tr><td>&nbsp;</td></tr>

        <tr>

          <td>

      <table width="98%" align="center" cellspacing="0" class="tabledesign">

      <tbody>

      <tr>

      <th>SL</th>
      <th>RR</th>

      <th>Accounts Head </th>

      <th>Date</th>

      <th>CC</th>

      <th>Entry By </th>

      <th> Amount</th>

      <th>&nbsp;</th>

      <th>Checked?</th>

      </tr>

	  <?

	if($_POST['do_date_fr']!=''){

$i=0;

$day_from = $_POST['do_date_fr'];

$day_end =  $_POST['do_date_to'];



	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

	if($_POST['dealer_type']!='') 	 $depot_con .= ' AND d.dealer_type="'.$_POST['dealer_type'].'"';

	if($depot_id>0) 				 $depot_con .= 'and j.cc_code='.$depot_id;

	

	if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';

	

	 $sql="SELECT

				  j.tr_no,

				  sum(1) as co,

				  sum(j.dr_amt) as dr_amts,

				  j.jv_date,

				  j.jv_no,

				  l.ledger_name,

				  j.tr_id,

				  u.fname,

				  j.entry_at,

				  j.checked,

				  j.jv_no,

				  j.dr_amt,j.cc_code

				FROM

				  secondary_journal j,

				  accounts_ledger l,

				  user_activity_management u

				WHERE

				  j.entry_by = u.user_id and 

				  j.tr_from = 'Reprocess Receive' AND 

				  j.dr_amt >0 AND 

				  j.jv_date  between '".$day_from."' AND '".$day_end."' AND 

				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con.$checked_con."

				group by  j.tr_no";

	  $query=db_query($sql);

	  

	  while($data=mysqli_fetch_object($query)){

	  $received = $received + $data->dr_amts;

	  ?>



      <tr <?=($i%2==0)?'class="alt"':'';?>>

      <td align="center"><div align="left"><?=++$i;?></div></td>

      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>

      <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>

      <td align="center"><div align="left"><? echo date('Y-m-d',$data->jv_date);?></div></td>

      <td align="center"><? echo $data->cc_code;?></td>

      <td align="center"><div align="left"><? echo $data->fname;?></div></td>

      <td align="right"><?=number_format($data->dr_amts,2);?></td>

      <td align="center"><a target="_blank" href="reprocess_receive_sec_print_view.php?jv_no=<?=$data->jv_no ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>

      <td align="center"><span id="divi_<?=$data->tr_no?>">

<? 

if(($data->checked=='YES')){

?>

<input type="button" name="Button" value="YES"  onclick="window.open('reprocess_receive_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style=" font-weight:bold;width:40px; height:20px;background-color:#66CC66;"/>

<?

}elseif(($data->checked=='NO' || $data->checked=='')){

?>

<input type="button" name="Button" value="NO"  onclick="window.open('reprocess_receive_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style="font-weight:bold;width:40px; height:20px;background-color:#FF0000;"/>

<? }?>

          </span></td>

      </tr>

	  <? }}?>

	  <tr class="alt">
        <td colspan="6" align="center"><div align="right"><strong>Total Amt : </strong></div><div align="left"></div></td>
        <td align="right"><?=number_format($received,2);?></td>
        <td align="center">&nbsp;</td>
      </tr>

  </tbody>

	  </table>

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

