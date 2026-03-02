<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Voucher Delete ';



$proj_id 	= $_SESSION['proj_id'];

$vtype 		= $_REQUEST['v_type'];

$active='unvou';

do_calander("#fdate");
do_calander("#tdate");



if(isset($_REQUEST['show']))

{

	$fdate=$_REQUEST["fdate"];

	$tdate=$_REQUEST['tdate'];

	$vou_no=$_REQUEST['vou_no'];

	$user_id=$_REQUEST['user_id'];

	if($user_id!='')

	$user_id = find_a_field('user_activity_management','user_id',"username='".$user_id."'");

	

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

	if($user_id>0)		{$con .= "AND user_id = '".$user_id."'";  }
	
	if($_POST['checked']!=''){ $con.=" and j.checked='".$_POST['checked']."' "; }

	echo  $sql="SELECT  

				  j.tr_no,

				  j.dr_amt,

				  j.cr_amt,

				  j.jv_date,

				  j.jv_no,

				  a.ledger_name,

				  j.tr_from

				FROM

				  secondary_journal j,

				  accounts_ledger a

				WHERE

				  1   ".$con."

				  AND j.tr_from != 'Ledger' AND j.ledger_id = a.ledger_id ".$group_s." group by j.jv_no 

				ORDER BY

				  j.tr_no ";

	//echo $sql;

}

if(isset($_REQUEST['view']))

{

	$v_no=$_REQUEST['v_no'];

}

////

?>

<script type="text/javascript">

	
function DoNav(theUrl)

{
    <? if($_POST['v_type']=='payment'){?>
	      var URL = 'debit_note.php?update=1&'+theUrl;
	<? }elseif($_POST['v_type']=='receipt'){?>
	       var URL = 'credit_note.php?update=1&'+theUrl;
	<? }elseif($_POST['v_type']=='journal'){ ?>
	       var URL = 'journal_note_new.php?update=1&'+theUrl; 
	<? }elseif($_POST['v_type']=='coutra'){ ?>
		   var URL = 'coutra_note_new.php?update=1&'+theUrl; 
	<? } ?>	   
	  //var URL = 'voucher_edit_confirm.php?'+theUrl;

	//popUp(URL);
	
	window.location.href = URL;

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



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td valign="top"><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                                      <tr>

                                        <td width="40%" align="right">

		    Voucher Type<span class="style2">*</span> : </td>

                                        <td width="60%" align="left"><select name="v_type" id="v_type" class="input1" style="width:180px;">

                                          <option value="receipt"<?php if($vtype=='receipt') echo "selected"?>>Receipt Voucher</option>

                                          <option value="payment"<?php if($vtype=='payment') echo "selected"?>>Payment Voucher</option>

                                          <option value="coutra"<?php if($vtype=='coutra') echo "selected"?>>Contra Posting</option>

                                          <option value="journal"<?php if($vtype=='journal') echo "selected"?>>Journal Voucher</option>

										  <option value="Purchase"<?php if($vtype=='Purchase') echo "selected"?>>Purchase Voucher</option>

										  <option value="Salea"<?php if($vtype=='Salea') echo "selected"?>>Salea Voucher</option>

										  <option value="Collection"<?php if($vtype=='Collection') echo "selected"?>>Collection Voucher</option>

                                        </select> </td>
                                      </tr>

                                      <tr>

                                        <td align="right">Voucher Date<span class="style2">*</span> : </td>

                                        <td align="left"><table  border="0" cellspacing="0" cellpadding="0">

                                          <tr>

                                            <td><input name="fdate" style="max-width:250px!important;" class="form-control" type="text" id="fdate" size="10" value="<?php  echo $_POST['fdate'];  ?>" /></td>

                                            <td style="width:0px!important;">--</td>

                                            <td><input name="tdate" type="text" id="tdate" size="10" value="<?php echo $_POST['tdate'];  ?>" /></td>
                                          </tr>

                                        </table>		  </td>
                                      </tr>

                                      

                                      <tr>

                                        <td align="right">User Name  :</td>

                                        <td align="left"><input name="user_id" type="text" id="user_id" value="<?=$_POST['user_id'];?>" size="10" /></td>
                                      </tr>

                                      <tr>
                                        <td align="right">Checked ? </td>
                                        <td align="left"><select name="checked">
										  <option   value=""> </option>
										    <option <? if($_POST['checked']=='NO') echo 'selected'; ?> value="NO">NO</option>
											<option <? if($_POST['checked']=='YES') echo 'selected'; ?> value="YES">Yes</option>
										</select></td>
                                      </tr>
                                      <tr>

                                        <td align="right">Voucher No : </td>

                                        <td align="left"><input name="vou_no" type="text" id="vou_no" value="<?=$vou_no?>" size="10" /></td>
                                      </tr>

                                      <tr>

                                        <td align="center"><span class="style1">* means mandetory </span></td>

                                        <td class="text-left"><input class="btn1" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>

                                      

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td style="height:3px;"> </td>

								  </tr>

								  <tr>

									<td>	  <?php if(isset($_REQUEST['view'])||isset($_REQUEST['show']))

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
								<th>Action</th>

							  </tr>

        <?php

		$query=db_query($sql);		  

		while($vno=mysqli_fetch_row($query))

		{

			$v_type = $_REQUEST['v_type'];$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

							    <!--<tr<?=$cls?> onclick="DoNav('<?php echo 'v_type='.$vno[6].'&vo_no='.$vno[4] ?>');">-->
							  <tr >
							     <td><?php echo $vno[4] ?></td>

							     <td><?php echo $vno[0] ?></td>

								 <td><?php echo  $vno[3] ?></td>

								 <td><?php echo $vno[6] ?></td>

								 <td><?php echo $vno[5] ?></td>

								 <td><?php echo $vno[1] ?></td>

								 <td><?php echo $vno[2] ?></td>
								 
								 <td><a href="voucher_print_delete.php?v_type=<?php echo $vno[6];?>&v_date=<?php echo $vno[3];?>&view=1&vo_no=<?php echo $vno[4];?>"><input type="button" class="btn btn-danger" value="View & Delete" /></a></td>

							  </tr>

	<?php }?>

							</table>

										<?php

    }

    ?>								</td>

								  </tr>

		</table>



							</div></td>

    

  </tr>

</table>

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>