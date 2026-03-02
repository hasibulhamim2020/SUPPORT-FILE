<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Ledger Group Name';

$active='legna';



$proj_id=$_SESSION['proj_id'];

//echo $proj_id;

?>

<script type="text/javascript">

function DoNav(theUrl)

{

	document.location.href = 'ledger_account2_report.php?g_id='+theUrl;

}

</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action="">

									<table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="40%" align="right">

		    Class :                                       </td>

                                        <td width="60%" align="right"><select name="group_class" id="group_class" class="form-control" style="max-width:250px;">

                                          <?php echo '<option value="'.$_REQUEST['group_class'].'">'.$_REQUEST['group_class'].'</option>';?>

                                          <option value="%">All</option>

                                          <option value="Asset">Asset</option>

                                          <option value="Expense">Expense</option>

                                          <option value="Income">Income</option>

                                          <option value="Liabilities">Liabilities</option>

                                        </select></td>

                                      </tr>

                                      <tr>

                                        <td align="right">Group name :                                         </td>

                                        <td align="right"><input name="ladger_group" style="max-width:250px;" type="text" id="ladger_group" value="<?php echo $_REQUEST['ladger_group']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td colspan="2" class="text-center"><input class="btn" name="search" type="submit" id="search" value="Show" /></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td>									<div id="reporting">

									

							<table id="grp" class="table table-bordered" width="100%" cellspacing="0" cellpadding="2" >

							  <tr>

								<th>Group ID</th>

								<th>Group Name</th>

								<th>Group Class</th>

								<th>Group Under</th>

							  </tr>

<?php

	$rrr = "select group_id,group_name,group_class,group_under from ledger_group";

	if(isset($_REQUEST['search']))

	{

		$ladger_group	= mysqli_real_escape_string($_REQUEST['ladger_group']);

		$group_class	= mysqli_real_escape_string($_REQUEST['group_class']);

	

		$rrr .= " where group_name LIKE '%$ladger_group%'";

		$rrr .= " AND group_class LIKE '%$group_class%'";	

	}

	$rrr .= " order by group_name";

	//echo $rrr;

	$report = db_query($rrr);

	while($rp=mysqli_fetch_row($report)){?>

							   <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>

								<td>&nbsp;<?=$rp[0];?></td>

								<td>&nbsp;<?=$rp[1];?></td>

								<td>&nbsp;<?=$rp[2];?></td>

								<td>&nbsp;<?=$rp[3];?></td>

							  </tr>

	<?php }?>

							</table></div>									</td>

								  </tr>

		</table>



							</div></td>

    

  </tr>

</table>9

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