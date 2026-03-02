<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Voucher Verification';
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



<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>

    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

			<td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">

              <tr>

                <td width="20%"><div align="right"><strong> Date :</strong></div></td>

                <td width="12%"><input name="do_date_fr" type="text" id="do_date_fr" style="width:150px;" value="<?=$_POST['do_date_fr']?>" required /></td>

                <td width="4%"><div align="center">-to-</div></td>

                <td width="21%"><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" style="width:150px;"  required /></td>

                <td width="43%" rowspan="4"><label>

                  <input type="submit" name="submitit" id="submitit" value="Voucher View" class="btn btn-primary"/>

                </label></td>

              </tr>

              <tr>

                <td><div align="right"><strong>Checked : </strong></div></td>

                <td colspan="3"><div align="left"><span class="oe_form_group_cell">

                    <select name="checked" id="checked" style="width:250px;">

                      <option></option>

                      <option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>

                      <option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>

                    </select>

                </span></div></td>

                </tr>

              

              <tr>

                <td><div align="right"><strong>Voucher Type  :</strong></div> </td>

                <td colspan="3">


				<select name="voucher_type" id="voucher_type" style="width:250px;">
				
                  <? foreign_relation('voucher_config','voucher_type','voucher_type',$_POST['voucher_type'],'1');?>

                </select></td>

              </tr>

            </table></td>

	    </tr>

		<tr><td>&nbsp;</td></tr>

        <tr>

          <td>

      <table width="98%" align="center" cellspacing="0" class="tabledesign table-bordered">

      <tbody>

      <tr>

      <th>SL</th>

	  

      <th>TR No #</th>

      <th>JV No #</th>

      <th>JV Date </th>

      <th>TR From </th>
      <th>DR Amt </th>

      <th>CR Amt </th>
      <th>Entry By </th>

      <th>Entry At </th>

      <th>&nbsp;</th>

      <th>Checked?</th>
      </tr>

	  <?





		 if($_POST['do_date_fr']!=''){

	  $i=0;

		if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';

	 	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

		if($_POST['depot_id']>0) $depot_con = ' and w.warehouse_id="'.$_POST['depot_id'].'" ';

		if($_POST['voucher_type']!='') {$voucher_type_con=' and j.tr_from="'.$_POST['voucher_type'].'"';}
		


		 $sql=" select DISTINCT j.tr_no, j.jv_no, j.jv_date, sum(j.dr_amt) as dr_amt, sum(j.cr_amt) as cr_amt, j.tr_from, u.fname, j.entry_at, j.checked
				

				FROM

				 secondary_journal j, accounts_ledger l, user_activity_management u 
				  
			

				WHERE


				 j.entry_by = u.user_id AND
				
	

				  j.jv_date between '". $_POST['do_date_fr']."' AND  '". $_POST['do_date_to']."' AND 

				  j.ledger_id = l.ledger_id ".$group_s.$checked_con.$depot_con.$voucher_type_con." group by j.jv_no";

	  $query=db_query($sql);

	  

	  while($data=mysqli_fetch_row($query)){
$received = $received + $data[1];
	  ?>



      <tr class="alt">

      <td align="center"><div align="left">

        <?=++$i;?>

      </div></td>

      <td align="center"><div align="left"><? echo $data[0];?></div></td>

      <td align="center"><div align="left"><? echo $data[1];?></div></td>

      <td align="center"><div align="left"><?= date('d-m-Y',strtotime($data[2]));?></div></td>

      <td align="center"><? echo $data[5];?></td>
      <td align="center"><div align="left"><? echo number_format($data[3],2); $total_dr +=$data[3];?></div></td>

      <td align="center"><div align="left"><? echo number_format($data[4],2); $total_cr +=$data[4];?></div></td>
      <td align="center"><div align="left"><? echo $data[6];?></div></td>

      <td align="center"><div align="left"><? echo $data[7];?></div>        <div align="left"></div></td>

      <td align="center"><a target="_blank" href="purchase_sec_print_view.php?jv_no=<?=$data[1] ?>"><img src="../images/print.png" width="20" height="20" /></a></td>

      <td align="center"><span id="divi_<?=$data[1]?>">

            <? 

			  if(($data[8]=='YES')){

?>

<input type="button" name="Button" value="YES"  onclick="window.open('purchase_sec_print_view.php?jv_no=<?=$data[1] ?>');" style=" font-weight:bold;width:40px; height:27px;background-color:#66CC66;"/>

<?

}elseif(($data[8]=='')){

?>

<input type="button" name="Button" value="NO"  onclick="window.open('purchase_sec_print_view.php?jv_no=<?=$data[1] ?>');" style="font-weight:bold;width:40px; height:27px;background-color:#FF0000;"/>

<? }?>

          </span></td>
      </tr>

	  <? }}?>

	        <tr class="alt">

        <td align="center"><div align="left"></div></td>

        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center"><strong>Total</strong></td>
        <td align="center"><strong><?= number_format($total_dr,2);?></strong></td>
        <td align="center"><strong><?= number_format($total_cr,2);?></strong></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>

