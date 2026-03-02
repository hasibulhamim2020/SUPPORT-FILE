<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$title='Opening Balance';
$active='opbalman';

$proj_id=$_SESSION['proj_id'];

ini_set('max_input_vars', '10000');

//echo $proj_id;

$now=time();

//do_calander('#op_date');

//var_dump($_POST);







					if($_POST['ledger_id']>0) { $ledger_name = find_a_field('accounts_ledger','ledger_name','ledger_id='.$_POST['ledger_id']);

					if(substr($_POST['ledger_id'],4,12)=='000000000000')

					$find_ledger = substr($_POST['ledger_id'],0,4);

					elseif(substr($_POST['ledger_id'],8,8)=='00000000')

					$find_ledger = substr($_POST['ledger_id'],0,8);

					elseif(substr($_POST['ledger_id'],12,4)=='0000')

					$find_ledger = substr($_POST['ledger_id'],0,12);

					else

					$find_ledger = $_POST['ledger_id'];

					}

					

$j_sql="select ledger_id,cr_amt,dr_amt from journal where tr_from='Opening' and group_for ='".$_SESSION['user']['group']."' and ledger_id like '".$find_ledger."%'";

$j_query=db_query($j_sql);

while($j_data=mysqli_fetch_row($j_query))

{

$ledger_cr[$j_data[0]]=$j_data[1];

$ledger_dr[$j_data[0]]=$j_data[2];

}

					

?>

<style type="text/css">

<!--

.style1 {

	color: #FF0000;

	font-weight: bold;

}

.style2 {

	color: #0000FF;

	font-weight: bold;

}

.style3 {

	color: #006600;

	font-weight: bold;

}

.style4 {

	color: #FF9900;

	font-weight: bold;

}

.style5 {

	color: #000033;

	font-weight: bold;

}

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

				  <td bgcolor="#FFFFCC"><span class="style4">Opening Date:</span></td>

				  <td bgcolor="#FFFFCC">



<input name="op_date" type="text" id="op_date" size="30" maxlength="100" class="required" minlength="4" style="width:130px;" readonly value="2016-12-31" /></td>

				  </tr>

				<tr>

				

				<td bgcolor="#FFCCFF"><span class="style1">Oppening Balance Diff:</span></td>

				<?

				

				if($find_ledger>0){

				$sql="select sum(j.dr_amt),sum(j.cr_amt) from journal j, accounts_ledger a where a.ledger_id=j.ledger_id and j.tr_from='Opening' and a.ledger_id like '".$find_ledger."%' ";

				$query=db_query($sql);

				$info=mysqli_fetch_row($query);

				$diff=$info[0]-$info[1];

				if($diff<0) $diff='('.$diff*(-1).')';

				}

				?>

				<td bgcolor="#FFCCFF"><input name="customer_company" type="text" id="customer_company" size="30" maxlength="100" class="required" style="width:130px;" value="<?=$diff?>" /></td>

				</tr>

				</table>

				</td>

				<td width="50%">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

				



				<tr>

				<td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

				<td bgcolor="#66CCFF" height="20px;"><span class="style2">Total Debit:</span></td>

				<td bgcolor="#66FFCC"><span class="style3">Total Credit:</span></td>

				</tr>

				<tr>

				<td bgcolor="#66CCFF"><input name="t_debit" type="text" id="t_debit" value="<?=$info[0]?>" size="30" maxlength="100" class="required" minlength="4" style="width:130px;" /></td>

				<td bgcolor="#66FFCC"><input name="t_credit" type="text" id="t_credit" value="<?=$info[1]?>" size="30" maxlength="100" class="required" minlength="4" style="width:130px;"/></td>

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

                    <td><div align="right"><span class="style5">Ledger Group : 

                    </span></div>

                      <span class="style5"><label></label>

                    </span>                      

                      <label></label><div align="right"></div></td>

                    <td>



                    <input name="ledger_id" id="ledger_id" type="text" value="<?=$_POST['ledger_id']?>" />

					

					                   </td>

                    <td>

                     <div align="left"><input type="submit" name="submitit" id="submitit" value="Set Opening Balance" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/></div></td>

                  </tr>

<? if($ledger_name!=''){?>

<tr bgcolor="#0099FF">

<td><div align="right"><b>Ledger Name :</b></div></td>

<td colspan="2"><div align="left"><?=$ledger_name?></div></td>

</tr>

<? }?> 

                </table></td>

				</tr>

				</table>

				

				

		</td>

	    </tr>

		<tr><td>&nbsp;</td></tr>

        <tr>

          <td>

          <? if($ledger_name!=''){?>

      <table cellspacing="0" class="tabledesign">

      <tbody>

      <tr>

      <th align="center">SL</th>

      <th align="center">Acc Code </th>

      <th align="center">JV Date </th>

      <th align="center">Accounts Head </th>

      <th height="20" align="center">Debit Amt</th>

      <th align="center">Credit Amt</th>

      <th align="center">Action</th>

      </tr>

	  <?





	  if($_POST['ledger_id']>0){

	  $i=0;

	  $sql="select a.ledger_id,a.ledger_name from accounts_ledger a where a.ledger_id like '".$find_ledger."%' and parent=0 and group_for ='".$_SESSION['user']['group']."' order by ledger_id";

	  $query=db_query($sql);



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

      <td align="center"><input name="jv_date_<?=$data[0]?>" type="text" id="jv_date_<?=$data[0]?>" style="width:70px;" readonly value="2016-12-31" />

	    <input name="jv_date" type="hidden" id="jv_date" value="<?=$_POST['op_date']?>" />	  </td>

      <td align="center"><div align="left"><? echo $data[1];?></div></td>

      <td align="center"><input name="dr_<?=$data[0]?>" type="text" id="dr_<?=$data[0]?>" style="width:90px;" value="<?=$dr_amt?>" /></td>

      <td align="center"><input name="cr_<?=$data[0]?>" type="text" id="cr_<?=$data[0]?>" style="width:90px;" value="<?=$cr_amt?>" /></td>

      <td align="center"><span id="divi_<?=$data[0]?>">

            <? 

			  if(($dr_amt>0)||($cr_amt>0))

			  {?>

			  <input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="1" />

			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data[0]?>)" style="width:40px; height:20px; background-color:#FF3366"/><?

			  }

			  elseif($info->id<1)

			  {

			  ?>

			  <input name="flag_<?=$data[0]?>" type="hidden" id="flag_<?=$data[0]?>" value="0" />

			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data[0]?>)" style="width:40px; height:20px;background-color:#66CC66"/><? }?>

          </span></td>

      </tr>

	  <? }}?>

  </tbody></table>	

  <? }?>	  

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>

