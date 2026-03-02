<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";

$title='Voucher Recheck Status';



$proj_id 	= $_SESSION['proj_id'];

$vtype 		= $_REQUEST['v_type'];



do_calander("#fdate");
do_calander("#tdate");



if(isset($_REQUEST['show']))

{

	$fdate=$_REQUEST["fdate"];

	$tdate=$_REQUEST['tdate'];

	$vou_no=$_REQUEST['vou_no'];

	$user_id=$_REQUEST['user_id'];

	if($user_id!='')

	$user_id = $user_id;
	$tr_type="Edit";

	

}



if(isset($_REQUEST['show'])||isset($_REQUEST['view']))

{

	if($vtype=='Contra'||$vtype=='contra'||$vtype=='coutra')

	{

		$vtype='coutra';

		$vo_type='contra';

	}

	else $vo_type=$vtype;

	

	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

	if($_POST['vou_no']>0)	{$vou_no = $_POST['vou_no']; if($vou_no>201400000000) $con .= ' and jv_no like "%'.$vou_no.'%"'; else $con .= ' and tr_no like "%'.$vou_no.'%"'; }

	if($fdate>0&&$tdate>0)	{$con .= 'AND jv_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" ';  }

	if($vo_type!='')		{$con .= "AND tr_from = '".$vo_type."'";  }

	if($user_id>0)		{$con .= "AND j.entry_by = '".$user_id."'";  }
	
	if($_POST['checked']!=''){ $con.=" and j.checked='".$_POST['checked']."' "; }

	     $sql="SELECT  

				  j.tr_no,

				  sum(j.dr_amt) as dr_amt,

				  sum(j.cr_amt) as cr_amt,

				  j.jv_date,

				  j.jv_no,

				  a.ledger_name,

				  j.tr_from,
				  j.entry_by

				FROM

				  secondary_journal j,

				  accounts_ledger a

				WHERE

				  1   ".$con."

				  AND j.tr_from != 'Ledger' AND j.ledger_id = a.ledger_id ".$group_s." group by j.jv_no 

				ORDER BY

				  j.tr_no ";
				  
				  
				  $amt_sql='select sum(dr_amt) as tot_debit_amt,sum(cr_amt) as tot_credit_amt,jv_no from secondary_journal where 1 group by jv_no';
				  $amt_query=db_query($amt_sql);
				  while($row=mysqli_fetch_object($amt_query)){
				  	$total_debit_amt[$row->jv_no]=$row->tot_debit_amt;
					$total_credit_amt[$row->jv_no]=$row->tot_credit_amt;
				  }
				  

	//echo $sql;

}

if(isset($_REQUEST['view']))

{

	$v_no=$_REQUEST['v_no'];

}

////

?>

<script type="text/javascript">

	
 
function DoNav(theUrl) {
    <?php if ($_POST['v_type'] == 'payment') { ?>
        var URL = 'debit_note_edit_update.php?update=1&' + theUrl;
    <?php } elseif ($_POST['v_type'] == 'receipt') { ?>
        var URL = 'credit_note_edit_update.php?update=1&' + theUrl;
    <?php } elseif ($_POST['v_type'] == 'journal') { ?>
        var URL = 'journal_note_edit_update.php?update=1&' + theUrl;
    <?php } elseif ($_POST['v_type'] == 'coutra') { ?>
        var URL = 'coutra_note_edit_update.php?update=1&' + theUrl;
    <?php } else { ?>
        var URL = ''; // Handle cases where v_type doesn't match any option
    <?php } ?>

    if (URL) {
        window.open(URL, "_blank"); // Open the URL in a new tab
    } else {
        console.error("Invalid or missing URL for navigation.");
    }
}
 



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}



function loadinparent(url)

{

	self.opener.location = url;

	self.blur(); 

}

</script>

<style type="text/css">

<!--

.style1 {

	color: #FF0000;

	font-size: 10px;

}

.style2 {color: #FF0000}

-->

</style>




	<!--new colde-->

	<div class="d-flex justify-content-center">
		<form class="n-form1 fo-width1 pt-4" id="form1" name="form1" method="post" action="">

			<div class="container-fluid">



				<div class="form-group row m-0 mb-1 pl-3 pr-3">
					<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">Voucher Type :</label>
					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
						<select name="v_type" id="v_type" class="form-control">

							<option value="receipt"<?php if($vtype=='receipt') echo "selected"?>>Receipt Voucher</option>

							<option value="payment"<?php if($vtype=='payment') echo "selected"?>>Payment Voucher</option>

							<option value="coutra"<?php if($vtype=='coutra') echo "selected"?>>Contra Voucher</option>

							<option value="journal"<?php if($vtype=='journal') echo "selected"?>>Journal Voucher</option>

							

						</select>
					</div>
				</div>

				<div class="form-group row m-0 mb-1 pl-3 pr-3">
					<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text ">Voucher Date :</label>
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0">
						<input name="fdate" style="max-width:250px!important;" class="form-control" type="text" id="fdate" size="10" value="<?php  echo $_POST['fdate'];  ?>" autocomplete="off"/>
					</div>

	<label for="group_for" class="col-sm-1 col-md-1 col-lg-1 col-xl-1 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> To :</label>
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0">
						<input name="tdate" style="max-width:250px!important;" class="form-control" type="text" id="tdate" size="10" value="<?php  echo $_POST['fdate'];  ?>" autocomplete="off"/>
					</div>
				</div>



				<div class="form-group row m-0 mb-1 pl-3 pr-3">
					<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">User Name :</label>
					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
						 
							<select name="user_id" id="user_id" class="form-control">
								<option value="<?=$_POST['user_id'];?>"><?php echo find_a_field('user_activity_management','fname','user_id="'.$_POST['user_id'].'"'); ?> </option>
							<option></option>
							<?php 
							$sql2='select * from user_activity_management';
							$query2=db_query($sql2);
							while($row2=mysqli_fetch_object($query2)){
							?>
							<option   value="<?=$row2->user_id?>"><?=$row2->fname?></option>
						 <?php } ?>
						</select>
					</div>
				</div>




				<div class="form-group row m-0 mb-1 pl-3 pr-3">
					<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Checked :</label>
					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

						<select name="checked" class="form-control">
							<option></option>
							<option <? if($_POST['checked']=='NO') echo 'selected'; ?> value="NO">NO</option>
							<option <? if($_POST['checked']=='YES') echo 'selected'; ?> value="YES">Yes</option>
						</select>


					</div>
				</div>




				<div class="form-group row m-0 mb-1 pl-3 pr-3">
					<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Voucher No :</label>
					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
						<input name="vou_no" type="text" id="vou_no" value="<?=$vou_no?>" size="10"  class="form-control" />
					</div>
				</div>




				<div class="n-form-btn-class">
					<span class="style1">* means mandetory </span>
					<input class="btn1 btn1-bg-submit" name="show" type="submit" id="show" value="Show" />
				</div>

			</div>
		</form>
	</div>


	<div class="form-container_large">
		<div class="container_fluid">

			<?php if(isset($_REQUEST['view'])||isset($_REQUEST['show']))

			{

				?>

				<table class="table1  table-striped table-bordered table-hover table-sm" id="grp">

					<thead class="thead1">
						<tr class="bgc-info">
							<th>JV No</th>
							<th>Vou. No</th>
							<th>Voucher Date</th>
							<th>Transection</th>
							<th>Acc Head</th>
							<th>Dt. Amnt</th>
							<th>Cr. Amnt</th>
							<th>Entry By</th>
						</tr>
					</thead>

					<tbody class="tbody1">
					<?php
					$query=db_query($sql);
					while($vno=mysqli_fetch_row($query))
					{

						$v_type = $_REQUEST['v_type'];$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

						<!--<tr<?=$cls?> onclick="DoNav('<?php echo 'v_type='.$vno[6].'&vo_no='.$vno[4] ?>');">-->
						<tr<?=$cls?> onclick="DoNav('<?php echo 'v_type='.$vno[6].'&tr_no='.$vno[0].'&jv_no='.$vno[4] ?>');">
							<td><?php echo $vno[4] ?></td>

							<td><?php echo $vno[0] ?></td>

							<td><?php echo  $vno[3] ?></td>

							<td><?php echo $vno[6] ?></td>

							<td><?php echo $vno[5] ?></td>

							<td><?php echo $total_debit_amt[$vno[4]]; ?></td>

							<td><?php echo $total_credit_amt[$vno[4]]; ?></td>
							<td><?php echo find_a_field('user_activity_management','fname','user_id="'.$vno[7].'"'); ?></td>

						</tr>

					<?php }?>

					</tbody>

				</table>

				<?php

			}

			?>

		</div>
	</div>





<?/*>
<br>
<br>
<br>
<br>
<br>


<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top">
		<div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td valign="top"><div class="box">

											<form id="form1" name="form1" method="post" action="">
												<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                                     <tr>

                                        <td width="40%" align="right">

		    Voucher Type<span class="style2">*</span> : </td>

                                        <td width="60%" align="left">

											<select name="v_type" id="v_type" class="form-control" style="width:280px;">

                                          <option value="receipt"<?php if($vtype=='receipt') echo "selected"?>>Receipt Voucher</option>

                                          <option value="payment"<?php if($vtype=='payment') echo "selected"?>>Payment Voucher</option>

                                          <option value="coutra"<?php if($vtype=='coutra') echo "selected"?>>Contra Voucher</option>

                                          <option value="journal"<?php if($vtype=='journal') echo "selected"?>>Journal Voucher</option>


<!--												<option value="Purchase"--><?php //if($vtype=='Purchase') echo "selected"?><!-->Purchase Voucher</option>-->
<!---->
<!--										  <option value="Salea"--><?php //if($vtype=='Salea') echo "selected"?><!-->Salea Voucher</option>-->
<!---->
<!--										  <option value="Collection"--><?php //if($vtype=='Collection') echo "selected"?><!-->Collection Voucher</option>-->


                                        </select>

										</td>
                                      </tr>

                                      <tr>

                                        <td align="right">Voucher Date<span class="style2">*</span> : </td>

                                        <td align="left"><table  border="0" cellspacing="0" cellpadding="0">

                                          <tr>

                                            <td>
												<input name="fdate" style="max-width:250px!important;" class="form-control" type="text" id="fdate" size="10" value="<?php  echo $_POST['fdate'];  ?>" />

											</td>

                                            <td style="width:0px!important;">--</td>

                                            <td><input name="tdate" type="text" id="tdate" size="10" value="<?php echo $_POST['tdate'];  ?>" class="form-control"/></td>
                                          </tr>

                                        </table>		  </td>
                                      </tr>

                                      

                                      <tr>

                                        <td align="right">User Name  :</td>

                                        <td align="left">
											<input name="user_id" type="text" id="user_id" value="<?=$_POST['user_id'];?>" size="10" style=" width:280px" class="form-control"/>
										</td>
                                      </tr>

                                      <tr>
                                        <td align="right">Checked : </td>
                                        <td align="left">
											<select name="checked"  style=" width:280px" class="form-control">
										<option></option>
										    <option <? if($_POST['checked']=='NO') echo 'selected'; ?> value="NO">NO</option>
											<option <? if($_POST['checked']=='YES') echo 'selected'; ?> value="YES">Yes</option>
										</select>

										</td>
                                      </tr>
                                      <tr>

                                        <td align="right">Voucher No : </td>

                                        <td align="left">
											<input name="vou_no" type="text" id="vou_no" value="<?=$vou_no?>" size="10"  style=" width:280px" class="form-control" />

										</td>
                                      </tr>

                                      <tr>

                                        <td align="center"><span class="style1">* means mandetory </span></td>

                                        <td class="text-left"><input class="btn1 btn1-bg-submit" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>

                                      

                                    </table>

								    </form>
										</div>
									</td>

						      </tr>

								  <tr>

									<td style="height:3px;"> </td>

								  </tr>

								  <tr>

									<td>

										<?php if(isset($_REQUEST['view'])||isset($_REQUEST['show']))

	  {	  

	  ?>

									<table align="center" cellspacing="0" class="tabledesign" id="grp">

							  <tr>

							    <th>JV No</th>

							    <th>Vou. No</th>

								<th>Voucher Date</th>

								<th>Transection</th>

								<th>Acc Head</th>

								<th>Dt. Amnt</th>

								<th>Cr. Amnt</th>

							  </tr>

        <?php

		$query=db_query($sql);		  

		while($vno=mysqli_fetch_row($query))

		{

			$v_type = $_REQUEST['v_type'];$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

							    <!--<tr<?=$cls?> onclick="DoNav('<?php echo 'v_type='.$vno[6].'&vo_no='.$vno[4] ?>');">-->
							  <tr<?=$cls?> onclick="DoNav('<?php echo 'v_type='.$vno[6].'&tr_no='.$vno[0].'&jv_no='.$vno[4] ?>');">
							     <td><?php echo $vno[4] ?></td>

							     <td><?php echo $vno[0] ?></td>

								 <td><?php echo  $vno[3] ?></td>

								 <td><?php echo $vno[6] ?></td>

								 <td><?php echo $vno[5] ?></td>

								 <td><?php echo $vno[1] ?></td>

								 <td><?php echo $vno[2] ?></td>

							  </tr>

	<?php }?>

							</table>

										<?php

    }

    ?>

									</td>

								  </tr>

		</table>



							</div>
	</td>

    

  </tr>

</table>


	<*/?>





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
$page_name='Voucher Recheck Status';
require_once SERVER_CORE."routing/layout.bottom.php";

?>