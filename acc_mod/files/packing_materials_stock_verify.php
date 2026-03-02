<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Packing Materials Received Journal Verification';

$now=time();

do_calander('#do_date_fr');

do_calander('#do_date_to');

$depot_id = $_POST['depot_id'];

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

			<td><table width="50%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">

              <tr>

<td><div align="right"><strong>Chalan Date :</strong></div></td>

<td><input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" style="width:150px;"/></td>

<td>-to-</td>

<td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" style="width:150px;"/></td>

<td rowspan="4"><input type="submit" name="submitit" id="submitit" value="View Entry" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>

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

              

              <tr>

                <td><div align="right"><strong>Chalan Depot : </strong></div></td>

                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                  <select name="depot_id" id="depot_id" style="width:250px;">

                    <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'warehouse_id="5" order by warehouse_name');?>

                  </select>

                </span></div></td>

                </tr>

				             <tr>

                <!-- <td><div align="right"><strong>Dealer Group: </strong></div></td>

                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                  <select name="dealer_group" id="dealer_group" style="width:250px;">

                   <option value="<?=$_POST['dealer_group']?>"><?=$_POST['dealer_group']?></option>

				   <option value=""></option>

				   <option value="A">A</option>

				   <option value="B">B</option>

				   <option value="C">C</option>

				   <option value="D">D</option>

				   <option value="M">M</option>

                  </select>

                </span></div></td>-->

                </tr>

              

            </table></td>

	    </tr>

		<tr><td>&nbsp;</td></tr>

        <tr>

          <td>

		  <? if($_POST['do_date_fr']!=''){

		  



$i=0;



$datefr = strtotime($_POST['do_date_fr']);

$dateto = strtotime($_POST['do_date_to']);

$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));

$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));

if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];



		if($_POST['depot_id']>0) $depot_con = ' and w.warehouse_id="'.$_POST['depot_id'].'" ';

		if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';

		if($_POST['dealer_type']=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';}

		if($_POST['dealer_type']=='Corporate') {$dealer_type_con=' and d.dealer_type!="Distributor"';}

		if($_POST['dealer_group']!='') {$dealer_group_con=' and d.product_group="'.$_POST['dealer_group'].'"';}

		 $sql="SELECT DISTINCT 

		

				  j.tr_no,

				  sum(j.dr_amt) as dr_amt,

				  sum(j.cr_amt) as cr_amt,

				  j.jv_date,

				  j.jv_no,

				  l.ledger_name,

				  j.tr_id,

				  j.user_id,

				  j.entry_at,

				  j.checked,

				  j.jv_no,

				  u.fname



				FROM

				  secondary_journal j,

				  accounts_ledger l,

				  warehouse w,

				  user_activity_management u,

				  purchase_receive m

				WHERE

				  j.ledger_id = 1106000200000000 and 

				  j.user_id=u.user_id and

				  w.raw_material_ledger_id = l.ledger_id and 

				  j.tr_from = 'PM Stock' AND 

				  j.tr_no = m.pr_no and w.warehouse_id=m.warehouse_id and 

				  j.jv_date between '".$day_from."' AND '".$day_end."'  ".$group_s." ".$depot_con.$checked_con.$dealer_type_con.$dealer_group_con." 

				group by  j.tr_no";

	  $query=db_query($sql);

	  

		  ?>

      <table width="98%" align="center" cellspacing="0" class="tabledesign">

      <tbody>

      <tr>

      <th>SL</th>

	  
      <th>CH#</th>

      <th>Depot Ledger</th>

      <th>Chalan At</th>

      <th>Chalan By </th>

      <th>Receivable Amt </th>

      <th>Chalan Amt</th>

      <th>&nbsp;</th>

      <th>Checked?</th>
      </tr>

	  <?





	  

	  while($data=mysqli_fetch_object($query)){

	  $received = $received + ($data->cr_amt);

	  ?>



      <tr <?=($i%2==0)?'class="alt"':'';?>>

      <td align="center"><div align="left"><?=++$i;?></div></td>

      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>

      <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>

      <td align="center"><div align="left"><? echo $data->entry_at;?></div></td>

      <td align="center"><div align="left"><?=$data->fname;?></div></td>

      <td align="center"><div align="right">

<?=number_format(($data->cr_amt-$data->dr_amt),2);?>

      </div></td>

      <td align="right"><?=number_format(($data->cr_amt),2);?></td>

      <td align="center"><a target="_blank" href="packing_materials_stock_verify_print_view.php?jv_no=<?=$data->jv_no ?>">

<input name="radio_<?=$data->jv_no;?>" type="radio" value="" <?=($data->checked=='YES')?'checked="checked"':'';?>  style="width:20px;" />

      </a></td>

      <td align="center"><span id="divi_<?=$data->tr_no?>">

<? 

if(($data->checked=='YES')){

?>

<input type="button" name="Button" value="YES"  onclick="window.open('packing_materials_stock_verify_print_view.php?jv_no=<?=$data->jv_no;?>');" style=" font-weight:bold;width:40px; height:20px;background-color:#66CC66;"/>

<?

}elseif(($data->checked=='NO')){

?>

<input type="button" name="Button" value="NO"  onclick="window.open('packing_materials_stock_verify_print_view.php?jv_no=<?=$data->jv_no;?>');" style="font-weight:bold;width:40px; height:20px;background-color:#FF0000;"/>

<? }?>

          </span></td>
      </tr>

	  <? }?>

	        <tr class="alt">

        <td colspan="6" align="center"><div align="right"><strong>Total Amt : </strong></div>

          

            <div align="left"></div></td>

        <td align="right"><?=number_format($received,2);?></td>

        <td align="center">&nbsp;</td>

        <td align="center"><div align="left"></div></td>
      </tr>
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

